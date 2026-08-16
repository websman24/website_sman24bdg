<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Display a listing of hero sliders.
     */
    public function index(): View
    {
        $sliders = Slider::orderBy('order_position', 'asc')->paginate(10);

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show form to create a new slider.
     */
    public function create(): View
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created slider.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul slide wajib diisi.',
            'image_file.required' => 'Gambar slide wajib diunggah.',
            'image_file.image' => 'Berkas harus berupa gambar (JPG, PNG, WEBP).',
        ]);

        $imagePath = $this->fileStorageService->uploadImage($request->file('image_file'), 'sliders');
        $validated['image_path'] = $imagePath;
        $validated['is_active'] = $request->has('is_active');
        $validated['order_position'] = $validated['order_position'] ?? 0;
        unset($validated['image_file']);

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero Image Slider baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit the specified slider.
     */
    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     */
    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'order_position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Judul slide wajib diisi.',
            'image_file.image' => 'Berkas harus berupa gambar (JPG, PNG, WEBP).',
        ]);

        if ($request->hasFile('image_file')) {
            if ($slider->image_path) {
                $this->fileStorageService->deleteFile($slider->image_path);
            }
            $validated['image_path'] = $this->fileStorageService->uploadImage($request->file('image_file'), 'sliders');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order_position'] = $validated['order_position'] ?? 0;
        unset($validated['image_file']);

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Hero Image Slider berhasil diperbarui.');
    }

    /**
     * Delete the specified slider.
     */
    public function destroy(Slider $slider): RedirectResponse
    {
        if ($slider->image_path) {
            $this->fileStorageService->deleteFile($slider->image_path);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
