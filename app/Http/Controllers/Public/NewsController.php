<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Display listing of public news with search and category filtering.
     */
    public function index(Request $request): View
    {
        $categories = NewsCategory::withCount('news')->get();

        $query = News::with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $newsList = $query->paginate(9);

        return view('public.news.index', compact('newsList', 'categories'));
    }

    /**
     * Display a single news detail article.
     */
    public function show(string $slug): View
    {
        $news = News::with(['category', 'author'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views count
        $news->increment('views_count');

        $relatedNews = News::where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.news.show', compact('news', 'relatedNews'));
    }
}
