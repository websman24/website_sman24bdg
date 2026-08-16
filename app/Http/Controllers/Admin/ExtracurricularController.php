<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExtracurricularController extends Controller
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Display a listing of extracurriculars with search and filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $query = Extracurricular::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mentor_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        $extracurriculars = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        $categories = Extracurricular::select('category')->distinct()->pluck('category');

        return view('admin.extracurriculars.index', compact('extracurriculars', 'categories', 'search', 'category'));
    }

    /**
     * Show form to create extracurricular.
     */
    public function create(): View
    {
        return view('admin.extracurriculars.create');
    }

    /**
     * Store extracurricular.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'mentor_name' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'logo_or_photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama ekstrakurikuler wajib diisi.',
            'category.required' => 'Kategori ekstrakurikuler wajib diisi.',
            'logo_or_photo_file.image' => 'Logo / Foto harus berupa gambar.',
        ]);

        $validated['slug'] = Str::slug($validated['name']).'-'.Str::random(5);
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        if ($request->hasFile('logo_or_photo_file')) {
            $validated['logo_or_photo'] = $this->fileStorageService->uploadImage($request->file('logo_or_photo_file'), 'extracurriculars');
            unset($validated['logo_or_photo_file']);
        }

        Extracurricular::create($validated);

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Ekstrakurikuler baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit extracurricular.
     */
    public function edit(Extracurricular $extracurricular): View
    {
        return view('admin.extracurriculars.edit', compact('extracurricular'));
    }

    /**
     * Update extracurricular.
     */
    public function update(Request $request, Extracurricular $extracurricular): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'mentor_name' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'logo_or_photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama ekstrakurikuler wajib diisi.',
            'category.required' => 'Kategori ekstrakurikuler wajib diisi.',
            'logo_or_photo_file.image' => 'Logo / Foto harus berupa gambar.',
        ]);

        if ($validated['name'] !== $extracurricular->name) {
            $validated['slug'] = Str::slug($validated['name']).'-'.Str::random(5);
        }

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false;

        if ($request->hasFile('logo_or_photo_file')) {
            if ($extracurricular->logo_or_photo) {
                $this->fileStorageService->deleteFile($extracurricular->logo_or_photo);
            }
            $validated['logo_or_photo'] = $this->fileStorageService->uploadImage($request->file('logo_or_photo_file'), 'extracurriculars');
            unset($validated['logo_or_photo_file']);
        }

        $extracurricular->update($validated);

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Data ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Destroy extracurricular.
     */
    public function destroy(Extracurricular $extracurricular): RedirectResponse
    {
        if ($extracurricular->logo_or_photo) {
            $this->fileStorageService->deleteFile($extracurricular->logo_or_photo);
        }

        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
