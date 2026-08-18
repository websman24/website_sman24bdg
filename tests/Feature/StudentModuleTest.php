<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_public_extracurriculars_and_achievements_management(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Kesiswaan SMAN 24',
            'email' => 'kesiswaan@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // 1. Ekstrakurikuler CRUD & Logo Upload
        $ekskulLogo = UploadedFile::fake()->image('paskibra_logo.jpg', 300, 300);

        $createEkskul = $this->post('/admin/extracurriculars', [
            'name' => 'Paskibra Pasheman 24',
            'category' => 'Bela Negara',
            'mentor_name' => 'Drs. Supriatna',
            'schedule' => 'Setiap Rabu & Sabtu 15:30 WIB',
            'description' => 'Pasukan Pengibar Bendera SMA Negeri 24 Bandung.',
            'is_active' => 1,
            'logo_or_photo_file' => $ekskulLogo,
        ]);
        $createEkskul->assertRedirect(route('admin.extracurriculars.index'));
        $this->assertDatabaseHas('extracurriculars', [
            'name' => 'Paskibra Pasheman 24',
            'category' => 'Bela Negara',
        ]);

        $ekskul = Extracurricular::where('name', 'Paskibra Pasheman 24')->first();

        // Admin Search & Filter Ekskul
        $searchEkskul = $this->get('/admin/extracurriculars?search=Pasheman&category=Bela+Negara');
        $searchEkskul->assertStatus(200);
        $searchEkskul->assertSee('Paskibra Pasheman 24');

        // Public Ekstrakurikuler List (/kesiswaan/ekstrakurikuler)
        $publicEkskul = $this->get('/kesiswaan/ekstrakurikuler');
        $publicEkskul->assertStatus(200);
        $publicEkskul->assertSee('Paskibra Pasheman 24');
        $publicEkskul->assertSee('Setiap Rabu & Sabtu 15:30 WIB');

        // Update Ekskul
        $updateEkskul = $this->put("/admin/extracurriculars/{$ekskul->id}", [
            'name' => 'Paskibra Pasheman 24 Updated',
            'category' => 'Bela Negara',
            'mentor_name' => 'Drs. Supriatna M.Pd',
            'schedule' => 'Setiap Sabtu 08:00 WIB',
            'is_active' => 1,
        ]);
        $updateEkskul->assertRedirect(route('admin.extracurriculars.index'));
        $this->assertDatabaseHas('extracurriculars', ['name' => 'Paskibra Pasheman 24 Updated']);

        // 2. Prestasi CRUD & Photo Upload
        $trophyPhoto = UploadedFile::fake()->image('trophy_ksn.jpg', 600, 400);

        $createAchievement = $this->post('/admin/achievements', [
            'title' => 'Juara 1 Olimpiade Sains Matematika',
            'category' => 'akademik',
            'level' => 'provinsi',
            'winner_name' => 'Ahmad Fauzi & Tim',
            'event_name' => 'KSN Provinsi Jawa Barat 2026',
            'achievement_year' => 2026,
            'description' => 'Meraih medali emas kategori teori dan analisis numerik.',
            'photo_file' => $trophyPhoto,
        ]);
        $createAchievement->assertRedirect(route('admin.achievements.index'));
        $this->assertDatabaseHas('achievements', [
            'title' => 'Juara 1 Olimpiade Sains Matematika',
            'winner_name' => 'Ahmad Fauzi & Tim',
            'level' => 'provinsi',
        ]);

        $achievement = Achievement::where('title', 'Juara 1 Olimpiade Sains Matematika')->first();

        // Admin Search & Filter Achievements
        $searchAchievement = $this->get('/admin/achievements?search=Ahmad&category=akademik&level=provinsi');
        $searchAchievement->assertStatus(200);
        $searchAchievement->assertSee('Juara 1 Olimpiade Sains Matematika');

        // Public Achievements List (/kesiswaan/prestasi)
        $publicAchievement = $this->get('/kesiswaan/prestasi');
        $publicAchievement->assertStatus(200);
        $publicAchievement->assertSee('Juara 1 Olimpiade Sains Matematika');
        $publicAchievement->assertSee('Ahmad Fauzi & Tim');

        // 3. OSIS Admin Page
        $osisResponse = $this->get('/admin/osis');
        $osisResponse->assertStatus(200);
        $osisResponse->assertSee('Manajemen OSIS & MPK', false);

        // Delete Operations
        $deleteEkskul = $this->delete("/admin/extracurriculars/{$ekskul->id}");
        $deleteEkskul->assertRedirect(route('admin.extracurriculars.index'));

        $deleteAchievement = $this->delete("/admin/achievements/{$achievement->id}");
        $deleteAchievement->assertRedirect(route('admin.achievements.index'));
    }
}
