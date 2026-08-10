<?php

namespace Tests\Feature;

use App\Models\SchoolProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCmsSuiteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test all admin CMS suite modules render 200 OK for authenticated admin.
     */
    public function test_all_admin_cms_modules_function_correctly(): void
    {
        $admin = User::create([
            'name' => 'Admin SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // 1. Dashboard Metrics
        $dashboardResponse = $this->get('/admin');
        $dashboardResponse->assertStatus(200);

        // 2. Settings Update
        $settingsResponse = $this->get('/admin/settings');
        $settingsResponse->assertStatus(200);

        $principalPhoto = \Illuminate\Http\UploadedFile::fake()->image('principal.jpg', 600, 600);

        $updateSettings = $this->post('/admin/settings', [
            'school_name' => 'SMA Negeri 24 Bandung Custom',
            'school_phone' => '(022) 7800540-UPDATED',
            'principal_name' => 'Drs. H. Solihin, M.Pd.',
            'principal_title' => 'Kepala SMAN 24 Bandung',
            'principal_photo_file' => $principalPhoto,
        ]);
        $updateSettings->assertRedirect(route('admin.settings.index'));
        $this->assertEquals('(022) 7800540-UPDATED', \App\Models\Setting::getValue('school_phone'));
        $this->assertEquals('Drs. H. Solihin, M.Pd.', \App\Models\Setting::getValue('principal_name'));

        $publicHome = $this->get('/');
        $publicHome->assertSee('(022) 7800540-UPDATED');
        $publicHome->assertSee('Drs. H. Solihin, M.Pd.');

        // 3. Profiles Update
        $profile = SchoolProfile::create([
            'key' => 'visi_misi',
            'title' => 'Visi Misi SMAN 24',
            'content' => 'Content visi misi',
        ]);
        $profileResponse = $this->get('/admin/profiles');
        $profileResponse->assertStatus(200);

        $updateProfile = $this->put("/admin/profiles/{$profile->id}", [
            'title' => 'Visi Misi SMAN 24 Updated',
            'content' => 'Content visi misi updated',
        ]);
        $updateProfile->assertRedirect(route('admin.profiles.index'));

        // 4. Events Store
        $eventStore = $this->post('/admin/events', [
            'title' => 'Upacara HUT RI SMAN 24',
            'location' => 'Lapangan Utama',
            'start_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'status' => 'upcoming',
        ]);
        $eventStore->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['title' => 'Upacara HUT RI SMAN 24']);

        // 5. Achievements Store
        $achStore = $this->post('/admin/achievements', [
            'title' => 'Juara 1 Lomba Band Kota Bandung',
            'category' => 'non_akademik',
            'level' => 'kota',
            'winner_name' => 'Band SMAN 24',
            'event_name' => 'Festival Musik Band',
            'achievement_year' => 2026,
        ]);
        $achStore->assertRedirect(route('admin.achievements.index'));
        $this->assertDatabaseHas('achievements', ['title' => 'Juara 1 Lomba Band Kota Bandung']);

        // 6. Extracurricular Store
        $extraStore = $this->post('/admin/extracurriculars', [
            'name' => 'PMR SMAN 24',
            'category' => 'Kesehatan',
            'mentor_name' => 'Siti Nurhaliza',
        ]);
        $extraStore->assertRedirect(route('admin.extracurriculars.index'));
        $this->assertDatabaseHas('extracurriculars', ['name' => 'PMR SMAN 24']);

        // 7. Gallery Store
        $galStore = $this->post('/admin/galleries', [
            'title' => 'Album Purna Krida 2026',
            'description' => 'Dokumentasi acara pelepasan siswa',
        ]);
        $galStore->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', ['title' => 'Album Purna Krida 2026']);

        // 8. Video Store
        $vidStore = $this->post('/admin/videos', [
            'title' => 'Video Profil SMAN 24 2026',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);
        $vidStore->assertRedirect(route('admin.videos.index'));
        $this->assertDatabaseHas('videos', ['title' => 'Video Profil SMAN 24 2026']);
    }
}
