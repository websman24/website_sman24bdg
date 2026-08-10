<?php

namespace Tests\Feature;

use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test file upload functionality for news thumbnail, teacher photo, and SPMB documents.
     */
    public function test_admin_can_upload_files_successfully(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $category = NewsCategory::create([
            'name' => 'Pengumuman Resmi',
            'slug' => 'pengumuman-resmi',
        ]);

        $this->actingAs($admin);

        // 1. Upload News Thumbnail
        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg', 800, 600);
        $newsResponse = $this->post('/admin/news', [
            'category_id' => $category->id,
            'title' => 'Berita Dengan Thumbnail Unggulan',
            'excerpt' => 'Ringkasan berita thumbnail',
            'content' => 'Isi berita thumbnail lengkap',
            'status' => 'published',
            'thumbnail_file' => $thumbnail,
        ]);

        $newsResponse->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', ['title' => 'Berita Dengan Thumbnail Unggulan']);

        // 2. Upload Teacher Photo
        $photo = UploadedFile::fake()->image('teacher.png', 400, 400);
        $teacherResponse = $this->post('/admin/teachers', [
            'name' => 'Budi Santoso',
            'nip' => '198501012010011001',
            'subject' => 'Fisika',
            'gender' => 'L',
            'photo_file' => $photo,
        ]);

        $teacherResponse->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers', ['name' => 'Budi Santoso']);

        // 3. Upload SPMB Document File
        $pdfFile = UploadedFile::fake()->create('spmb_guide.pdf', 1500, 'application/pdf');
        $docResponse = $this->post('/admin/documents', [
            'title' => 'Panduan Pendaftaran SPMB 2026/2027',
            'category' => 'SPMB',
            'description' => 'Berkas PDF panduan pendaftaran',
            'document_file' => $pdfFile,
        ]);

        $docResponse->assertRedirect(route('admin.documents.index'));
        $this->assertDatabaseHas('documents', ['title' => 'Panduan Pendaftaran SPMB 2026/2027']);

        // 4. Upload School Logo Setting
        $logoFile = UploadedFile::fake()->image('school_logo.png', 300, 300);
        $settingResponse = $this->post('/admin/settings', [
            'school_name' => 'SMA Negeri 24 Bandung',
            'school_motto' => 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global',
            'school_logo_file' => $logoFile,
        ]);

        $settingResponse->assertRedirect(route('admin.settings.index'));
        $this->assertDatabaseHas('settings', ['key' => 'school_logo']);
        $this->assertDatabaseHas('settings', ['key' => 'school_motto', 'value' => 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global']);
    }
}
