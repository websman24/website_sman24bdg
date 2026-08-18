<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test all public pages render successfully.
     */
    public function test_all_public_pages_render_successfully(): void
    {
        $admin = User::create([
            'name' => 'Admin SMAN 24',
            'email' => 'admin@sman24bdg.sch.id',
            'password' => Hash::make('Password24!'),
            'role' => 'admin',
        ]);

        $category = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik']);

        $news = News::create([
            'category_id' => $category->id,
            'author_id' => $admin->id,
            'title' => 'Berita Pengujian Public Page',
            'slug' => 'berita-pengujian-public-page',
            'excerpt' => 'Excerpt berita',
            'content' => 'Content berita',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $urls = [
            '/',
            '/profil',
            '/berita',
            '/berita/berita-pengujian-public-page',
            '/akademik/guru',
            '/akademik/kalender',
            '/kesiswaan/osis',
            '/kesiswaan/ekstrakurikuler',
            '/kesiswaan/prestasi',
            '/galeri',
            '/download',
            '/spmb/pendaftar',
            '/spmb/daftar-ulang',
            '/kontak',
        ];

        foreach ($urls as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }
}
