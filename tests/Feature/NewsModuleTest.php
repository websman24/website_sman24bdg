<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_news_draft_and_publish_workflow_thumbnail_upload_and_public_views(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Editor Berita',
            'email' => 'editor@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $category = NewsCategory::create([
            'name' => 'Akademik & Kurikulum',
            'slug' => 'akademik-kurikulum',
        ]);

        $this->actingAs($admin);

        // 1. Admin Index Page
        $indexResp = $this->get('/admin/news');
        $indexResp->assertStatus(200);

        // 2. Create News as DRAFT
        $draftThumbnail = UploadedFile::fake()->image('draft_thumb.jpg', 600, 400);

        $createDraftResp = $this->post('/admin/news', [
            'title' => 'Rencana Pelaksanaan KSN 2026 SMAN 24',
            'category_id' => $category->id,
            'excerpt' => 'Ringkasan persiapan KSN 2026',
            'content' => 'Konten lengkap mengenai rencana pelaksanaan KSN 2026 yang masih berupa draf.',
            'status' => 'draft',
            'thumbnail_file' => $draftThumbnail,
        ]);
        $createDraftResp->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', ['title' => 'Rencana Pelaksanaan KSN 2026 SMAN 24', 'status' => 'draft']);

        $draftArticle = News::where('title', 'Rencana Pelaksanaan KSN 2026 SMAN 24')->first();

        // 3. Verify DRAFT article does NOT appear in Public Index /berita
        $publicIndex = $this->get('/berita');
        $publicIndex->assertStatus(200);
        $publicIndex->assertDontSee('Rencana Pelaksanaan KSN 2026 SMAN 24');

        // 4. Create News as PUBLISHED
        $pubThumbnail = UploadedFile::fake()->image('pub_thumb.jpg', 800, 600);

        $createPubResp = $this->post('/admin/news', [
            'title' => 'Prestasi Gemilang Olimpiade Sains Nasional 2026',
            'category_id' => $category->id,
            'excerpt' => 'Siswa SMAN 24 Bandung meraih medali emas KSN.',
            'content' => 'Isi berita lengkap mengenai prestasi gemilang olimpiade sains nasional.',
            'status' => 'published',
            'thumbnail_file' => $pubThumbnail,
        ]);
        $createPubResp->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', ['title' => 'Prestasi Gemilang Olimpiade Sains Nasional 2026', 'status' => 'published']);

        $publishedArticle = News::where('title', 'Prestasi Gemilang Olimpiade Sains Nasional 2026')->first();

        // 5. Verify PUBLISHED article appears in Public Index /berita
        $publicIndex2 = $this->get('/berita');
        $publicIndex2->assertStatus(200);
        $publicIndex2->assertSee('Prestasi Gemilang Olimpiade Sains Nasional 2026');

        // 6. Test Public Detail Page /berita/{slug} & Views Count Increment
        $initialViews = $publishedArticle->views_count;
        $publicDetail = $this->get("/berita/{$publishedArticle->slug}");
        $publicDetail->assertStatus(200);
        $publicDetail->assertSee('Prestasi Gemilang Olimpiade Sains Nasional 2026');
        $publicDetail->assertSee('Isi berita lengkap mengenai prestasi gemilang olimpiade sains nasional.');

        $this->assertEquals($initialViews + 1, $publishedArticle->fresh()->views_count);

        // 7. Test Admin Filter by Status (Draft & Published)
        $filterDraft = $this->get('/admin/news?status=draft');
        $filterDraft->assertStatus(200);
        $filterDraft->assertSee('Rencana Pelaksanaan KSN 2026 SMAN 24');
        $filterDraft->assertDontSee('Prestasi Gemilang Olimpiade Sains Nasional 2026');

        $filterPub = $this->get('/admin/news?status=published');
        $filterPub->assertStatus(200);
        $filterPub->assertSee('Prestasi Gemilang Olimpiade Sains Nasional 2026');

        // 8. Update DRAFT to PUBLISHED
        $updateResp = $this->put("/admin/news/{$draftArticle->id}", [
            'title' => 'Rencana Pelaksanaan KSN 2026 SMAN 24 Official',
            'category_id' => $category->id,
            'excerpt' => 'Ringkasan resmi KSN 2026',
            'content' => 'Konten lengkap yang telah dipublikasikan resmi.',
            'status' => 'published',
        ]);
        $updateResp->assertRedirect(route('admin.news.index'));

        $publicIndex3 = $this->get('/berita');
        $publicIndex3->assertSee('Rencana Pelaksanaan KSN 2026 SMAN 24 Official');

        // 9. Delete News
        $deleteResp = $this->delete("/admin/news/{$draftArticle->id}");
        $deleteResp->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseMissing('news', ['id' => $draftArticle->id]);
    }
}
