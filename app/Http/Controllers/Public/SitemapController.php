<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML Sitemap for search engines.
     */
    public function index(): Response
    {
        $urls = [];

        // Static core routes
        $staticRoutes = [
            'home' => 1.0,
            'profile' => 0.9,
            'news.index' => 0.9,
            'announcements.index' => 0.8,
            'events.index' => 0.8,
            'academic.teachers' => 0.7,
            'academic.calendar' => 0.7,
            'student.extracurriculars' => 0.7,
            'student.achievements' => 0.7,
            'gallery.index' => 0.7,
            'download.index' => 0.6,
            'spmb.pendaftar' => 0.8,
            'spmb.daftar_ulang' => 0.8,
            'contact' => 0.8,
        ];

        foreach ($staticRoutes as $routeName => $priority) {
            $urls[] = [
                'loc' => route($routeName),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => number_format($priority, 1),
            ];
        }

        // Dynamic Published News
        $newsList = News::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        foreach ($newsList as $item) {
            $urls[] = [
                'loc' => route('news.show', $item->slug),
                'lastmod' => ($item->updated_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Dynamic Published Announcements
        $announcements = Announcement::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        foreach ($announcements as $item) {
            $urls[] = [
                'loc' => route('announcements.show', $item->slug),
                'lastmod' => ($item->updated_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Dynamic Active Events
        $events = Event::where('status', '!=', 'cancelled')->orderBy('updated_at', 'desc')->get();
        foreach ($events as $item) {
            $urls[] = [
                'loc' => route('events.show', $item->slug),
                'lastmod' => ($item->updated_at ?? now())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Dynamic Galleries
        if (class_exists(Gallery::class)) {
            $galleries = Gallery::orderBy('updated_at', 'desc')->get();
            foreach ($galleries as $item) {
                if ($item->slug) {
                    $urls[] = [
                        'loc' => route('gallery.show', $item->slug),
                        'lastmod' => ($item->updated_at ?? now())->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.6',
                    ];
                }
            }
        }

        return response()
            ->view('public.sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }

    /**
     * Generate robots.txt dynamically.
     */
    public function robots(): Response
    {
        $sitemapUrl = route('sitemap');
        $content = "User-agent: *\n"
            ."Allow: /\n"
            ."Disallow: /admin/\n"
            ."Disallow: /admin\n\n"
            ."Sitemap: {$sitemapUrl}\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
