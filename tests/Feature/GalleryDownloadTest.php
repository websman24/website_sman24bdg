<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_public_gallery_video_and_download_center(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Humas & IT SMAN 24',
            'email' => 'it@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // 1. Gallery Album & Photo Items Management
        $coverPhoto = UploadedFile::fake()->image('cover_album.jpg', 800, 600);

        $createGallery = $this->post('/admin/galleries', [
            'title' => 'Dokumentasi Pentas Seni SMAN 24 Bandung 2026',
            'description' => 'Foto-foto kegiatan pentas seni dan kreasi siswa.',
            'cover_image_file' => $coverPhoto,
        ]);
        $this->assertDatabaseHas('galleries', [
            'title' => 'Dokumentasi Pentas Seni SMAN 24 Bandung 2026',
        ]);

        $gallery = Gallery::where('title', 'Dokumentasi Pentas Seni SMAN 24 Bandung 2026')->first();
        $createGallery->assertRedirect(route('admin.galleries.show', $gallery));

        // Add photo item to gallery album
        $itemPhoto = UploadedFile::fake()->image('pensi_1.jpg', 800, 600);
        $addItem = $this->post("/admin/galleries/{$gallery->id}/items", [
            'photo_file' => $itemPhoto,
            'caption' => 'Penampilan Band Siswa SMAN 24',
        ]);
        $addItem->assertRedirect(route('admin.galleries.show', $gallery));
        $this->assertDatabaseHas('gallery_items', [
            'gallery_id' => $gallery->id,
            'caption' => 'Penampilan Band Siswa SMAN 24',
        ]);

        $item = $gallery->items()->first();

        // Set photo cover
        $setCover = $this->post("/admin/galleries/{$gallery->id}/items/{$item->id}/cover");
        $setCover->assertRedirect(route('admin.galleries.show', $gallery));

        // Admin Search Gallery
        $searchGallery = $this->get('/admin/galleries?search=Pentas');
        $searchGallery->assertStatus(200);
        $searchGallery->assertSee('Dokumentasi Pentas Seni');

        // Public Gallery List (/galeri) & Detail (/galeri/{slug})
        $publicGalleryList = $this->get('/galeri');
        $publicGalleryList->assertStatus(200);
        $publicGalleryList->assertSee('Dokumentasi Pentas Seni');

        $publicGalleryShow = $this->get("/galeri/{$gallery->slug}");
        $publicGalleryShow->assertStatus(200);
        $publicGalleryShow->assertSee('Penampilan Band Siswa SMAN 24');

        // 2. Video YouTube Management
        $createVideo = $this->post('/admin/videos', [
            'title' => 'Profil Resmi SMAN 24 Bandung',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'description' => 'Video profil lengkap fasilitas dan fasilitas sekolah.',
            'is_featured' => 1,
        ]);
        $createVideo->assertRedirect(route('admin.videos.index'));
        $this->assertDatabaseHas('videos', [
            'title' => 'Profil Resmi SMAN 24 Bandung',
            'youtube_id' => 'dQw4w9WgXcQ',
        ]);

        // Admin Search Video
        $searchVideo = $this->get('/admin/videos?search=Profil');
        $searchVideo->assertStatus(200);
        $searchVideo->assertSee('Profil Resmi SMAN 24 Bandung');

        // 3. Document Download Center Management (PDF, DOCX, XLSX)
        $docFile = UploadedFile::fake()->create('formulir_spmb.pdf', 2048, 'application/pdf');

        $createDoc = $this->post('/admin/documents', [
            'title' => 'Formulir Pendaftaran SPMB 2026/2027',
            'category' => 'SPMB',
            'description' => 'Berkas pendaftaran ulang peserta didik baru.',
            'document_file' => $docFile,
        ]);
        $createDoc->assertRedirect(route('admin.documents.index'));
        $this->assertDatabaseHas('documents', [
            'title' => 'Formulir Pendaftaran SPMB 2026/2027',
            'category' => 'SPMB',
            'file_type' => 'pdf',
        ]);

        $document = Document::where('title', 'Formulir Pendaftaran SPMB 2026/2027')->first();

        // Public Download List (/download) & Download File Action (/download/{document})
        $publicDownload = $this->get('/download');
        $publicDownload->assertStatus(200);
        $publicDownload->assertSee('Formulir Pendaftaran SPMB 2026/2027');

        $initialDownloads = $document->download_count;
        $triggerDownload = $this->post("/download/{$document->id}");
        $this->assertEquals($initialDownloads + 1, $document->fresh()->download_count);

        // Delete Operations
        $deleteItem = $this->delete("/admin/galleries/{$gallery->id}/items/{$item->id}");
        $deleteItem->assertRedirect(route('admin.galleries.show', $gallery));

        $deleteGallery = $this->delete("/admin/galleries/{$gallery->id}");
        $deleteGallery->assertRedirect(route('admin.galleries.index'));

        $deleteDoc = $this->delete("/admin/documents/{$document->id}");
        $deleteDoc->assertRedirect(route('admin.documents.index'));
    }
}
