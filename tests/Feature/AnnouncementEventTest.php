<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AnnouncementEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_public_announcements_and_agenda_events_management(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Humas SMAN 24',
            'email' => 'humas@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // 1. Announcements CRUD & Attachment Upload
        $announcementDoc = UploadedFile::fake()->create('edaran_mpls.pdf', 1000, 'application/pdf');

        $createAnnounce = $this->post('/admin/announcements', [
            'title' => 'Pengumuman Resmi Masa Pengenalan Lingkungan Sekolah (MPLS) 2026',
            'content' => 'Berikut adalah jadwal dan ketentuan pakaian selama kegiatan MPLS berlangsung.',
            'is_pinned' => 1,
            'status' => 'published',
            'attachment_file_input' => $announcementDoc,
        ]);
        $createAnnounce->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseHas('announcements', [
            'title' => 'Pengumuman Resmi Masa Pengenalan Lingkungan Sekolah (MPLS) 2026',
            'is_pinned' => 1,
            'status' => 'published',
        ]);

        $announcement = Announcement::where('is_pinned', true)->first();

        // Admin Search & Filter Announcements
        $searchAnnounce = $this->get('/admin/announcements?search=MPLS&status=published');
        $searchAnnounce->assertStatus(200);
        $searchAnnounce->assertSee('Pengumuman Resmi Masa Pengenalan Lingkungan Sekolah');

        // Public Announcements List (/pengumuman) & Detail (/pengumuman/{slug})
        $publicAnnounceList = $this->get('/pengumuman');
        $publicAnnounceList->assertStatus(200);
        $publicAnnounceList->assertSee('Pengumuman Resmi Masa Pengenalan Lingkungan Sekolah');

        $publicAnnounceShow = $this->get("/pengumuman/{$announcement->slug}");
        $publicAnnounceShow->assertStatus(200);
        $publicAnnounceShow->assertSee('Berikut adalah jadwal dan ketentuan pakaian');
        $publicAnnounceShow->assertSee('Unduh Berkas Lampiran');

        // 2. Agenda Events CRUD, Location, Date, Jam & Banner Upload
        $eventBanner = UploadedFile::fake()->image('banner_mpls.jpg', 800, 400);

        $createEvent = $this->post('/admin/events', [
            'title' => 'Kegiatan MPLS SMA Negeri 24 Bandung',
            'location' => 'Aula Utama SMAN 24',
            'start_date' => '2026-07-15 07:30:00',
            'end_date' => '2026-07-17 14:00:00',
            'description' => 'Kegiatan pengenalan lingkungan sekolah untuk peserta didik baru.',
            'status' => 'upcoming',
            'banner_file' => $eventBanner,
        ]);
        $createEvent->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', [
            'title' => 'Kegiatan MPLS SMA Negeri 24 Bandung',
            'location' => 'Aula Utama SMAN 24',
            'status' => 'upcoming',
        ]);

        $event = Event::where('location', 'Aula Utama SMAN 24')->first();

        // Admin Search & Filter Agenda Events
        $searchEvent = $this->get('/admin/events?search=MPLS&status=upcoming');
        $searchEvent->assertStatus(200);
        $searchEvent->assertSee('Kegiatan MPLS SMA Negeri 24 Bandung');

        // Public Agenda Events List (/agenda) & Detail (/agenda/{slug})
        $publicEventList = $this->get('/agenda');
        $publicEventList->assertStatus(200);
        $publicEventList->assertSee('Kegiatan MPLS SMA Negeri 24 Bandung');
        $publicEventList->assertSee('Aula Utama SMAN 24');

        $publicEventShow = $this->get("/agenda/{$event->slug}");
        $publicEventShow->assertStatus(200);
        $publicEventShow->assertSee('Kegiatan pengenalan lingkungan sekolah untuk peserta didik baru.');
        $publicEventShow->assertSee('Aula Utama SMAN 24');

        // 3. Edit & Delete Agenda Event
        $updateEvent = $this->put("/admin/events/{$event->id}", [
            'title' => 'Kegiatan MPLS SMA Negeri 24 Bandung Updated',
            'location' => 'Lapangan Utama SMAN 24',
            'start_date' => '2026-07-15 07:30:00',
            'status' => 'ongoing',
        ]);
        $updateEvent->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['location' => 'Lapangan Utama SMAN 24', 'status' => 'ongoing']);

        $deleteEvent = $this->delete("/admin/events/{$event->id}");
        $deleteEvent->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
