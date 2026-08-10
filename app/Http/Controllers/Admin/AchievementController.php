<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AchievementController extends Controller
{
    public function index(): View
    {
        $achievements = Achievement::orderBy('achievement_year', 'desc')->paginate(10);
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create(): View
    {
        return view('admin.achievements.create');
    }

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
        ]);

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Data prestasi berhasil ditambahkan.');
    }

    public function destroy(Achievement $achievement): RedirectResponse
    {
        $achievement->delete();
        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
