<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsComment;
use Illuminate\Http\RedirectResponse;
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
     * Display a single news detail article with comments.
     */
    public function show(string $slug): View
    {
        $news = News::with(['category', 'author', 'comments'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views count safely
        $news->increment('views_count');

        $relatedQuery = News::with(['category', 'author'])
            ->where('id', '!=', $news->id)
            ->where('status', 'published');

        if ($news->category_id) {
            $relatedQuery->where('category_id', $news->category_id);
        }

        $relatedNews = $relatedQuery->latest('published_at')
            ->take(4)
            ->get();

        $latestNews = News::with(['category', 'author'])
            ->where('id', '!=', $news->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $categories = NewsCategory::withCount(['news' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        return view('public.news.show', compact('news', 'relatedNews', 'latestNews', 'categories'));
    }

    /**
     * Store reader comment on a news article.
     */
    public function storeComment(Request $request, string $slug): RedirectResponse
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150'],
            'comment' => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.email' => 'Format email tidak valid.',
            'comment.required' => 'Isi komentar wajib diisi.',
            'comment.min' => 'Komentar minimal 3 karakter.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        $validated['news_id'] = $news->id;
        $validated['is_approved'] = true;
        $validated['comment'] = strip_tags($validated['comment']);

        NewsComment::create($validated);

        return redirect()->to(route('news.show', $news->slug).'#comments')
            ->with('comment_success', 'Komentar Anda berhasil dikirim dan dipublikasikan.');
    }
}
