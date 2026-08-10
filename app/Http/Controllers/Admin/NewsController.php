<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct(
        protected NewsService $newsService
    ) {}

    /**
     * Display a listing of the news.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $categoryId = $request->query('category_id') ? (int)$request->query('category_id') : null;

        $newsList = $this->newsService->getPaginatedNews(10, $search, $status, $categoryId);
        $categories = NewsCategory::all();

        return view('admin.news.index', compact('newsList', 'categories', 'search', 'status', 'categoryId'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create(): View
    {
        $categories = NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created news article.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'category_id.required' => 'Kategori berita wajib dipilih.',
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'thumbnail_file.image' => 'Berkas thumbnail harus berupa gambar.',
        ]);

        $this->newsService->createNews($validated, auth()->id());

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news): View
    {
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified news article.
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'category_id.required' => 'Kategori berita wajib dipilih.',
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'thumbnail_file.image' => 'Berkas thumbnail harus berupa gambar.',
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $validated['thumbnail_file'] = $request->file('thumbnail_file');
        }

        $this->newsService->updateNews($news, $validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news article.
     */
    public function destroy(News $news): RedirectResponse
    {
        $this->newsService->deleteNews($news);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Bulk delete selected news articles.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->route('admin.news.index')->with('error', 'Tidak ada data berita yang dipilih.');
        }

        $newsItems = News::whereIn('id', $ids)->get();
        foreach ($newsItems as $news) {
            $this->newsService->deleteNews($news);
        }

        return redirect()->route('admin.news.index')
            ->with('success', count($newsItems) . ' berita berhasil dihapus secara massal.');
    }
}
