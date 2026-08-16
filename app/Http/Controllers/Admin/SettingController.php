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
    /**
     * Allowlist of setting keys that are permitted to be updated via the web form.
     *
     * This whitelist prevents arbitrary key injection into the settings table.
     * Any key not in this list will be silently ignored.
     *
     * @var list<string>
     */
    private const ALLOWED_SETTING_KEYS = [
        'school_name',
        'school_address',
        'school_phone',
        'school_email',
        'school_fax',
        'school_npsn',
        'school_accreditation',
        'school_website',
        'school_motto',
        'school_vision',
        'school_mission',
        'total_students',
        'spmb_quote',
        'principal_name',
        'principal_title',
        'principal_nip',
        'principal_photo',
        'school_logo',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'tiktok_url',
        'twitter_url',
        'meta_description',
        'meta_keywords',
        'footer_text',
        'contact_maps_embed',
    ];

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
     *
     * Only keys present in ALLOWED_SETTING_KEYS will be processed.
     * File uploads are validated for type and size before storing.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'principal_photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'school_logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'principal_photo_file.image' => 'Foto Kepala Sekolah harus berupa berkas gambar.',
            'principal_photo_file.mimes' => 'Format foto yang diperbolehkan: JPG, JPEG, PNG, WEBP.',
            'school_logo_file.image' => 'Logo Sekolah harus berupa berkas gambar.',
            'school_logo_file.mimes' => 'Format logo yang diperbolehkan: JPG, JPEG, PNG, WEBP.',
        ]);

        // Filter input to only allowed keys — prevents arbitrary key injection
        $rawInputs = $request->except('_token', '_method', 'principal_photo_file', 'school_logo_file');
        $inputs = array_intersect_key($rawInputs, array_flip(self::ALLOWED_SETTING_KEYS));

        if ($request->hasFile('principal_photo_file')) {
            $oldPhoto = Setting::getValue('principal_photo');
            if ($oldPhoto) {
                $this->fileStorageService->deleteFile($oldPhoto);
            }
            $photoPath = $this->fileStorageService->uploadImage($request->file('principal_photo_file'), 'principal');
            $inputs['principal_photo'] = $photoPath;
        }

        if ($request->hasFile('school_logo_file')) {
            $oldLogo = Setting::getValue('school_logo');
            if ($oldLogo) {
                $this->fileStorageService->deleteFile($oldLogo);
            }
            $logoPath = $this->fileStorageService->uploadImage($request->file('school_logo_file'), 'settings');
            $inputs['school_logo'] = $logoPath;
        }

        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'label' => ucfirst(str_replace('_', ' ', $key))]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan website, logo sekolah, dan foto Kepala Sekolah berhasil diperbarui.');
    }
}
