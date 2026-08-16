<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    /**
     * Display public listing of published announcements.
     */
    public function index(Request $request): View
    {
        $query = Announcement::with('author')
            ->where('status', 'published');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $pinnedAnnouncements = (clone $query)
            ->where('is_pinned', true)
            ->latest('published_at')
            ->get();

        $announcements = $query->orderBy('is_pinned', 'desc')
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('public.announcements.index', compact('announcements', 'pinnedAnnouncements'));
    }

    /**
     * Display public detail page for single announcement.
     */
    public function show(string $slug): View
    {
        $announcement = Announcement::with('author')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $recentAnnouncements = Announcement::where('id', '!=', $announcement->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('public.announcements.show', compact('announcement', 'recentAnnouncements'));
    }
}
