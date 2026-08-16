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
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display real-time statistics, 4 main cards, and recent activity on Admin Dashboard.
     */
    public function index(): View
    {
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

        // Recent Activity Items Combined
        $recentNews = News::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Berita',
            'icon' => '📰',
            'title' => $item->title,
            'author' => $item->author->name ?? 'Admin',
            'time' => $item->created_at,
            'status' => $item->status === 'published' ? 'Published' : 'Draft',
            'url' => route('admin.news.edit', $item),
        ]);

        $recentAnnouncements = Announcement::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Pengumuman',
            'icon' => '📢',
            'title' => $item->title,
            'author' => $item->author->name ?? 'Humas',
            'time' => $item->created_at,
            'status' => $item->status === 'published' ? 'Published' : 'Draft',
            'url' => route('admin.announcements.edit', $item),
        ]);

        $recentEvents = Event::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Agenda',
            'icon' => '📅',
            'title' => $item->title,
            'author' => $item->author->name ?? 'Panitia',
            'time' => $item->created_at,
            'status' => strtoupper($item->status),
            'url' => route('admin.events.edit', $item),
        ]);

        $recentGalleries = Gallery::with('author')->latest()->take(3)->get()->map(fn ($item) => [
            'type' => 'Galeri Foto',
            'icon' => '🖼️',
            'title' => $item->title,
            'author' => $item->author->name ?? 'Admin',
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

        return view('admin.dashboard', compact('stats', 'recentActivities', 'latestNews', 'latestAnnouncements'));
    }
}
