<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display public listing of school agenda events.
     */
    public function index(Request $request): View
    {
        $query = Event::with('author');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->orderBy('start_date', 'asc')
            ->paginate(9)
            ->withQueryString();

        $upcomingCount = Event::where('status', 'upcoming')->count();
        $ongoingCount = Event::where('status', 'ongoing')->count();
        $completedCount = Event::where('status', 'completed')->count();

        return view('public.events.index', compact('events', 'upcomingCount', 'ongoingCount', 'completedCount'));
    }

    /**
     * Display public detail page for single agenda event.
     */
    public function show(string $slug): View
    {
        $event = Event::with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        $upcomingEvents = Event::where('id', '!=', $event->id)
            ->where('status', 'upcoming')
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return view('public.events.show', compact('event', 'upcomingEvents'));
    }
}
