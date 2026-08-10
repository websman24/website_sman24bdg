<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of news categories.
     */
    public function index(): View
    {
        $categories = NewsCategory::withCount('news')->orderBy('name')->paginate(10);
        return view('admin.news_categories.index', compact('categories'));
    }

    /**
     * Store a newly created news category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:news_categories,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama kategori berita wajib diisi.',
            'name.unique' => 'Nama kategori berita sudah ada.',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        NewsCategory::create($validated);

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'Kategori berita baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit news category.
     */
    public function edit(NewsCategory $newsCategory): View
    {
        return view('admin.news_categories.edit', compact('newsCategory'));
    }

    /**
     * Update the specified news category.
     */
    public function update(Request $request, NewsCategory $newsCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:news_categories,name,' . $newsCategory->id],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama kategori berita wajib diisi.',
            'name.unique' => 'Nama kategori berita sudah digunakan.',
        ]);

        if ($validated['name'] !== $newsCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $newsCategory->update($validated);

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'Kategori berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news category.
     */
    public function destroy(NewsCategory $newsCategory): RedirectResponse
    {
        if ($newsCategory->news()->count() > 0) {
            return redirect()->route('admin.news-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $newsCategory->news()->count() . ' berita.');
        }

        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'Kategori berita berhasil dihapus.');
    }
}
