<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\User;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display real-time statistics, visitor chart analytics, and recent activity on Admin Dashboard.
     */
    public function index(): View
    {
        $today = now()->toDateString();
        $sevenDaysAgo = now()->subDays(6)->toDateString();
        $thirtyDaysAgo = now()->subDays(29)->toDateString();

        $stats = [
            'total_news' => News::count(),
            'published_news' => News::where('status', 'published')->count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('status', 'upcoming')->count(),
            'total_teachers' => Teacher::count(),
            'total_staff' => Staff::count(),
            'total_galleries' => Gallery::count(),
            'total_photos' => GalleryItem::count(),
            'total_announcements' => Announcement::count(),
            'total_achievements' => Achievement::count(),
            'total_documents' => Document::count(),
            'total_users' => User::count(),
        ];

        // 1. Visitor Metrics
        $todayViews = VisitorLog::where('visit_date', $today)->count();
        $todayUnique = VisitorLog::where('visit_date', $today)->distinct('ip_address')->count('ip_address');
        $weekViews = VisitorLog::where('visit_date', '>=', $sevenDaysAgo)->count();
        $monthViews = VisitorLog::where('visit_date', '>=', $thirtyDaysAgo)->count();
        $totalViews = VisitorLog::count();

        $visitorStats = [
            'today_views' => $todayViews,
            'today_unique' => $todayUnique,
            'week_views' => $weekViews,
            'month_views' => $monthViews,
            'total_views' => $totalViews,
        ];

        // 2. Chart Analytics (Last 14 Days)
        $chartLabels = [];
        $chartViewsData = [];
        $chartUniqueData = [];

        for ($i = 13; $i >= 0; $i--) {
            $dateObj = now()->subDays($i);
            $dString = $dateObj->toDateString();
            $label = $dateObj->translatedFormat('d M');

            $viewsCount = VisitorLog::where('visit_date', $dString)->count();
            $uniqueCount = VisitorLog::where('visit_date', $dString)->distinct('ip_address')->count('ip_address');

            $chartLabels[] = $label;
            $chartViewsData[] = $viewsCount;
            $chartUniqueData[] = $uniqueCount;
        }

        // 3. Top Visited Pages
        $topPages = VisitorLog::select('page_url', DB::raw('count(*) as total_views'), DB::raw('count(distinct ip_address) as unique_visitors'))
            ->groupBy('page_url')
            ->orderByDesc('total_views')
            ->take(5)
            ->get();

        // 4. Recent Activity Items Combined
        $recentNews = News::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Berita',
            'icon' => '📰',
            'title' => $item->title,
            'author' => $item->author?->name ?? 'Admin',
            'time' => $item->created_at,
            'status' => $item->status === 'published' ? 'Published' : 'Draft',
            'url' => route('admin.news.edit', $item),
        ]);

        $recentAnnouncements = Announcement::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Pengumuman',
            'icon' => '📢',
            'title' => $item->title,
            'author' => $item->author?->name ?? 'Humas',
            'time' => $item->created_at,
            'status' => $item->status === 'published' ? 'Published' : 'Draft',
            'url' => route('admin.announcements.edit', $item),
        ]);

        $recentEvents = Event::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Agenda',
            'icon' => '📅',
            'title' => $item->title,
            'author' => $item->author?->name ?? 'Panitia',
            'time' => $item->created_at,
            'status' => strtoupper($item->status),
            'url' => route('admin.events.edit', $item),
        ]);

        $recentGalleries = Gallery::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Galeri Foto',
            'icon' => '🖼️',
            'title' => $item->title,
            'author' => $item->author?->name ?? 'Admin',
            'time' => $item->created_at,
            'status' => 'Album',
            'url' => route('admin.galleries.show', $item),
        ]);

        $recentActivities = collect()
            ->concat($recentNews)
            ->concat($recentAnnouncements)
            ->concat($recentEvents)
            ->concat($recentGalleries)
            ->sortByDesc('time')
            ->take(8);

        $latestNews = News::with('category')->latest()->take(5)->get();
        $latestAnnouncements = Announcement::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'visitorStats',
            'chartLabels',
            'chartViewsData',
            'chartUniqueData',
            'topPages',
            'recentActivities',
            'latestNews',
            'latestAnnouncements'
        ));
    }
}
