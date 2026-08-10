<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolProfileController extends Controller
{
    /**
     * Display School Profiles index.
     */
    public function index(): View
    {
        $profiles = SchoolProfile::all();
        return view('admin.profiles.index', compact('profiles'));
    }

    /**
     * Update School Profile record.
     */
    public function update(Request $request, SchoolProfile $profile): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $profile->update($validated);

        return redirect()->route('admin.profiles.index')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
