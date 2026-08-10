<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        protected FileStorageService $fileStorageService
    ) {}

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
        $request->validate([
            'principal_photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'principal_photo_file.image' => 'Foto Kepala Sekolah harus berupa berkas gambar.',
        ]);

        $inputs = $request->except('_token', '_method', 'principal_photo_file');

        if ($request->hasFile('principal_photo_file')) {
            $oldPhoto = Setting::getValue('principal_photo');
            if ($oldPhoto) {
                $this->fileStorageService->deleteFile($oldPhoto);
            }
            $photoPath = $this->fileStorageService->uploadImage($request->file('principal_photo_file'), 'principal');
            $inputs['principal_photo'] = $photoPath;
        }

        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'label' => ucfirst(str_replace('_', ' ', $key))]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website dan foto Kepala Sekolah berhasil diperbarui.');
    }
}
