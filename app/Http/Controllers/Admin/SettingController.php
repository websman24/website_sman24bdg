<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display Website Settings page.
     */
    public function index(): View
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update Website Settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $inputs = $request->except('_token', '_method');

        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'label' => ucfirst(str_replace('_', ' ', $key))]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
