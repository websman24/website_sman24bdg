<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Services\GalleryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(
        protected GalleryService $galleryService
    ) {}

    /**
     * Display listing of photo gallery albums.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $galleries = $this->galleryService->getPaginatedGalleries(10, $search);

        return view('admin.galleries.index', compact('galleries', 'search'));
    }

    /**
     * Show form to create gallery album.
     */
    public function create(): View
    {
        return view('admin.galleries.create');
    }

    /**
     * Store gallery album.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ], [
            'title.required' => 'Judul album galeri wajib diisi.',
            'cover_image_file.image' => 'Cover album harus berupa berkas gambar.',
        ]);

        $gallery = $this->galleryService->createGallery($validated, auth()->id());

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Album galeri berhasil dibuat. Silakan tambahkan foto-foto kegiatan ke dalam album ini.');
    }

    /**
     * Show gallery album and photo items manager.
     */
    public function show(Gallery $gallery): View
    {
        $gallery->load(['items' => fn($q) => $q->orderBy('order_position', 'asc')->latest()]);
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show form to edit gallery album.
     */
    public function edit(Gallery $gallery): View
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update gallery album.
     */
    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ], [
            'title.required' => 'Judul album galeri wajib diisi.',
            'cover_image_file.image' => 'Cover album harus berupa berkas gambar.',
        ]);

        $this->galleryService->updateGallery($gallery, $validated);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Informasi album galeri berhasil diperbarui.');
    }

    /**
     * Destroy gallery album.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->galleryService->deleteGallery($gallery);

        return redirect()->route('admin.galleries.index')->with('success', 'Album galeri beserta seluruh foto di dalamnya berhasil dihapus.');
    }

    /**
     * Upload and add new photo item to gallery.
     */
    public function addItem(Request $request, Gallery $gallery): RedirectResponse
    {
        $request->validate([
            'photo_file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:255'],
        ], [
            'photo_file.required' => 'Pilih berkas foto yang ingin diunggah.',
            'photo_file.image' => 'Berkas foto harus berupa gambar.',
        ]);

        $this->galleryService->addPhotoItem($gallery, $request->file('photo_file'), $request->caption);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Foto baru berhasil ditambahkan ke dalam album.');
    }

    /**
     * Delete photo item from gallery.
     */
    public function deleteItem(Gallery $gallery, GalleryItem $item): RedirectResponse
    {
        $this->galleryService->deletePhotoItem($item);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Foto berhasil dihapus dari album.');
    }

    /**
     * Set photo item as gallery album cover.
     */
    public function setCover(Gallery $gallery, GalleryItem $item): RedirectResponse
    {
        $gallery->update(['cover_image' => $item->image_path]);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Foto berhasil dijadikan sebagai cover album.');
    }
}
