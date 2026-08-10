<?php

namespace Tests\Feature;

use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CmsModulesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can access CMS module index pages and store new records.
     */
    public function test_admin_can_manage_cms_modules(): void
    {
        $admin = User::create([
            'name' => 'Administrator SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // 1. News Index & Create
        $response = $this->get('/admin/news');
        $response->assertStatus(200);

        $category = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik']);

        $storeNewsResponse = $this->post('/admin/news', [
            'category_id' => $category->id,
            'title' => 'Ujian Akhir Semester SMAN 24',
            'excerpt' => 'Pelaksanaan UAS Tahun 2026',
            'content' => 'Detail jadwal pelaksanaan UAS 2026.',
            'status' => 'published',
        ]);
        $storeNewsResponse->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', ['title' => 'Ujian Akhir Semester SMAN 24']);

        // 2. Announcement Store
        $storeAnnResponse = $this->post('/admin/announcements', [
            'title' => 'Pengumuman Libur Nasional',
            'content' => 'Informasi libur nasional untuk seluruh siswa.',
            'status' => 'published',
            'is_pinned' => 1,
        ]);
        $storeAnnResponse->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseHas('announcements', ['title' => 'Pengumuman Libur Nasional']);

        // 3. Teacher Store
        $storeTeacherResponse = $this->post('/admin/teachers', [
            'name' => 'Bambang Wijaya',
            'nip' => '198203152009021004',
            'subject' => 'Biologi',
            'gender' => 'L',
        ]);
        $storeTeacherResponse->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers', ['name' => 'Bambang Wijaya']);

        // 4. Document Store
        $storeDocResponse = $this->post('/admin/documents', [
            'title' => 'Formulir Pendaftaran SPMB 2026',
            'category' => 'SPMB',
            'description' => 'Formulir verifikasi pendaftaran murid baru.',
        ]);
        $storeDocResponse->assertRedirect(route('admin.documents.index'));
        $this->assertDatabaseHas('documents', ['title' => 'Formulir Pendaftaran SPMB 2026']);

        // 5. Test Edit & Update for News, Announcement, Event
        $news = \App\Models\News::first();
        $editNewsPage = $this->get("/admin/news/{$news->id}/edit");
        $editNewsPage->assertStatus(200);

        $updateNewsResponse = $this->put("/admin/news/{$news->id}", [
            'category_id' => $category->id,
            'title' => 'Ujian Akhir Semester SMAN 24 Updated',
            'excerpt' => 'Pelaksanaan UAS Tahun 2026 Updated',
            'content' => 'Detail jadwal pelaksanaan UAS 2026 Updated.',
            'status' => 'published',
        ]);
        $updateNewsResponse->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', ['title' => 'Ujian Akhir Semester SMAN 24 Updated']);

        $announcement = \App\Models\Announcement::first();
        $editAnnPage = $this->get("/admin/announcements/{$announcement->id}/edit");
        $editAnnPage->assertStatus(200);

        $updateAnnResponse = $this->put("/admin/announcements/{$announcement->id}", [
            'title' => 'Pengumuman Libur Nasional Updated',
            'content' => 'Informasi libur nasional updated.',
            'status' => 'published',
            'is_pinned' => 0,
        ]);
        $updateAnnResponse->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseHas('announcements', ['title' => 'Pengumuman Libur Nasional Updated']);

        $event = \App\Models\Event::create([
            'author_id' => $admin->id,
            'title' => 'Rapat Guru SMAN 24',
            'slug' => 'rapat-guru-sman-24',
            'location' => 'Ruang Rapat',
            'start_date' => now()->addDays(3),
            'status' => 'upcoming',
        ]);
        $editEventPage = $this->get("/admin/events/{$event->id}/edit");
        $editEventPage->assertStatus(200);

        $updateEventResponse = $this->put("/admin/events/{$event->id}", [
            'title' => 'Rapat Guru SMAN 24 Updated',
            'location' => 'Ruang Multimedia',
            'start_date' => now()->addDays(4)->format('Y-m-d H:i:s'),
            'status' => 'ongoing',
        ]);
        $updateEventResponse->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['title' => 'Rapat Guru SMAN 24 Updated', 'location' => 'Ruang Multimedia']);

        // 6. Test Public Homepage renders dynamic data
        $publicResponse = $this->get('/');
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Ujian Akhir Semester SMAN 24 Updated');
        $publicResponse->assertSee('Pengumuman Libur Nasional Updated');
        $publicResponse->assertSee('Bambang Wijaya');
    }
}
