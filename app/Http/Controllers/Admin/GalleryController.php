<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::withCount('items')->latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['published_at'] = now();

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Album galeri foto berhasil ditambahkan.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Album galeri berhasil dihapus.');
    }
}
