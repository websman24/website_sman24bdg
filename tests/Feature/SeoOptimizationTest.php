<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoOptimizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_renders_correctly(): void
    {
        $category = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik']);
        $author = User::create([
            'name' => 'Humas SMAN 24',
            'email' => 'humas@sman24bdg.sch.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $news = News::create([
            'category_id' => $category->id,
            'author_id' => $author->id,
            'title' => 'Pengumuman Kelulusan Siswa 2026',
            'slug' => 'pengumuman-kelulusan-siswa-2026',
            'excerpt' => 'Rincian pengumuman kelulusan siswa...',
            'content' => 'Isi berita lengkap kelulusan...',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $response->assertSee(route('home'), false);
        $response->assertSee(route('news.show', $news->slug), false);
    }

    public function test_robots_txt_renders_correctly(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('User-agent: *');
        $response->assertSee('Disallow: /admin');
        $response->assertSee('Sitemap: '.route('sitemap'), false);
    }

    public function test_public_homepage_renders_seo_tags_and_schema(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<title>', false);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('<meta name="keywords"', false);
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee('<meta property="og:title"', false);
        $response->assertSee('EducationalOrganization', false);
    }

    public function test_news_detail_renders_article_schema_and_meta(): void
    {
        $category = NewsCategory::create(['name' => 'Umum', 'slug' => 'umum']);
        $author = User::create([
            'name' => 'Editor SMAN 24',
            'email' => 'editor@sman24bdg.sch.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $news = News::create([
            'category_id' => $category->id,
            'author_id' => $author->id,
            'title' => 'Prestasi Olimpas Sains 2026',
            'slug' => 'prestasi-olimpas-sains-2026',
            'excerpt' => 'Ringkasan prestasi siswa SMAN 24...',
            'content' => 'Konten berita prestasi sains...',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/berita/'.$news->slug);

        $response->assertStatus(200);
        $response->assertSee('Prestasi Olimpas Sains 2026');
        $response->assertSee('NewsArticle', false);
        $response->assertSee('<meta property="og:type" content="article"', false);
    }

    public function test_event_detail_renders_event_schema(): void
    {
        $author = User::create([
            'name' => 'OSIS SMAN 24',
            'email' => 'osis@sman24bdg.sch.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $event = Event::create([
            'author_id' => $author->id,
            'title' => 'Pensi Tahunan SMAN 24 Bandung',
            'slug' => 'pensi-tahunan-sman-24-bandung',
            'description' => 'Pentas seni tahunan spektakuler...',
            'location' => 'Aula Utama SMAN 24',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(5)->addHours(8),
            'status' => 'upcoming',
        ]);

        $response = $this->get('/agenda/'.$event->slug);

        $response->assertStatus(200);
        $response->assertSee('Pensi Tahunan SMAN 24 Bandung');
        $response->assertSee('Schema.org', false);
        $response->assertSee('"@type": "Event"', false);
    }
}
