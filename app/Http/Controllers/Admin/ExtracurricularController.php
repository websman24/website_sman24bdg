<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExtracurricularController extends Controller
{
    public function index(): View
    {
        $extracurriculars = Extracurricular::paginate(10);
        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create(): View
    {
        return view('admin.extracurriculars.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'mentor_name' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        Extracurricular::create($validated);

        return redirect()->route('admin.extracurriculars.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function destroy(Extracurricular $extracurricular): RedirectResponse
    {
        $extracurricular->delete();
        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
