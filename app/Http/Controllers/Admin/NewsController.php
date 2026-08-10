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
    public function index(): View
    {
        $newsList = $this->newsService->getPaginatedNews(10);
        return view('admin.news.index', compact('newsList'));
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
     * Remove the specified news article.
     */
    public function destroy(News $news): RedirectResponse
    {
        $this->newsService->deleteNews($news);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
