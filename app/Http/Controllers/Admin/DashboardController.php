<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\News;
use App\Models\Teacher;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display real-time statistics on Admin Dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_news' => News::count(),
            'total_announcements' => Announcement::count(),
            'total_teachers' => Teacher::count(),
            'total_documents' => Document::count(),
            'total_events' => Event::count(),
            'total_achievements' => Achievement::count(),
        ];

        $latestNews = News::latest()->take(5)->get();
        $latestAnnouncements = Announcement::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestNews', 'latestAnnouncements'));
    }
}
