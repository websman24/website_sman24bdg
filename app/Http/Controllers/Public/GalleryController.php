<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Video;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display Photo & Video Gallery.
     */
    public function index(): View
    {
        $galleries = Gallery::withCount('items')
            ->latest('published_at')
            ->paginate(6);

        $videos = Video::latest()->get();

        return view('public.gallery.index', compact('galleries', 'videos'));
    }

    /**
     * Display single gallery photo album.
     */
    public function show(string $slug): View
    {
        $gallery = Gallery::with('items')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.gallery.show', compact('gallery'));
    }
}
