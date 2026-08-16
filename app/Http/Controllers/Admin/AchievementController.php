<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AchievementController extends Controller
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

    /**
     * Display a listing of achievements with search and filter.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $level = $request->query('level');

        $query = Achievement::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('winner_name', 'like', "%{$search}%")
                    ->orWhere('event_name', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($level) {
            $query->where('level', $level);
        }

        $achievements = $query->orderBy('achievement_year', 'desc')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.achievements.index', compact('achievements', 'search', 'category', 'level'));
    }

    /**
     * Show form to create achievement.
     */
    public function create(): View
    {
        return view('admin.achievements.create');
    }

    /**
     * Store achievement.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:akademik,non_akademik'],
            'level' => ['required', 'in:kota,provinsi,nasional,internasional'],
            'winner_name' => ['required', 'string', 'max:255'],
            'event_name' => ['required', 'string', 'max:255'],
            'achievement_year' => ['required', 'integer', 'min:2000', 'max:2099'],
            'description' => ['nullable', 'string'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul prestasi wajib diisi.',
            'winner_name.required' => 'Nama siswa / tim peraih prestasi wajib diisi.',
            'event_name.required' => 'Nama perlombaan / event wajib diisi.',
            'photo_file.image' => 'Foto dokumentasi harus berupa gambar.',
        ]);

        if ($request->hasFile('photo_file')) {
            $validated['photo'] = $this->fileStorageService->uploadImage($request->file('photo_file'), 'achievements');
            unset($validated['photo_file']);
        }

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Data prestasi baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit achievement.
     */
    public function edit(Achievement $achievement): View
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update achievement.
     */
    public function update(Request $request, Achievement $achievement): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:akademik,non_akademik'],
            'level' => ['required', 'in:kota,provinsi,nasional,internasional'],
            'winner_name' => ['required', 'string', 'max:255'],
            'event_name' => ['required', 'string', 'max:255'],
            'achievement_year' => ['required', 'integer', 'min:2000', 'max:2099'],
            'description' => ['nullable', 'string'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul prestasi wajib diisi.',
            'winner_name.required' => 'Nama siswa / tim peraih prestasi wajib diisi.',
            'event_name.required' => 'Nama perlombaan / event wajib diisi.',
            'photo_file.image' => 'Foto dokumentasi harus berupa gambar.',
        ]);

        if ($request->hasFile('photo_file')) {
            if ($achievement->photo) {
                $this->fileStorageService->deleteFile($achievement->photo);
            }
            $validated['photo'] = $this->fileStorageService->uploadImage($request->file('photo_file'), 'achievements');
            unset($validated['photo_file']);
        }

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Data prestasi berhasil diperbarui.');
    }

    /**
     * Destroy achievement.
     */
    public function destroy(Achievement $achievement): RedirectResponse
    {
        if ($achievement->photo) {
            $this->fileStorageService->deleteFile($achievement->photo);
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
