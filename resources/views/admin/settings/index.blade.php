@extends('layouts.admin.app')

@section('title', 'Pengaturan Website - SMAN 24 Bandung')
@section('breadcrumb', 'Pengaturan Website')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Pengaturan Website Resmi</h2>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi identitas sekolah, foto Kepala Sekolah, informasi kontak, dan atribut umum.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <!-- Section: Identitas & Kepala Sekolah -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">Kepala Sekolah & Pimpinan</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="principal_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Kepala Sekolah</label>
                    <input type="text" id="principal_name" name="principal_name" value="{{ $settings['principal_name']->value ?? 'Drs. H. Solihin, M.Pd.' }}" required class="form-input-custom">
                </div>

                <div>
                    <label for="principal_title" class="block text-xs font-bold text-slate-700 mb-1">Jabatan / Gelar</label>
                    <input type="text" id="principal_title" name="principal_title" value="{{ $settings['principal_title']->value ?? 'Kepala SMA Negeri 24 Bandung' }}" required class="form-input-custom">
                </div>
            </div>

            <div>
                <label for="principal_photo_file" class="block text-xs font-bold text-slate-700 mb-1">Foto Kepala Sekolah (JPG/PNG/WEBP, Max 2MB)</label>
                @if(isset($settings['principal_photo']) && $settings['principal_photo']->value)
                    <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <img src="{{ asset($settings['principal_photo']->value) }}" alt="Foto Kepala Sekolah" class="w-16 h-16 object-cover rounded-xl border border-emerald-800 shadow-sm">
                        <div class="text-xs text-slate-600">
                            <span class="font-bold text-slate-800 block">Foto Aktif Kepala Sekolah</span>
                            <span class="text-[11px] text-slate-500 font-mono">{{ asset($settings['principal_photo']->value) }}</span>
                        </div>
                    </div>
                @endif
                <input type="file" id="principal_photo_file" name="principal_photo_file" accept="image/*" class="form-input-custom bg-white">
                @error('principal_photo_file')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">Identitas & Informasi Umum</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="school_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah</label>
                    <input type="text" id="school_name" name="school_name" value="{{ $settings['school_name']->value ?? 'SMA Negeri 24 Bandung' }}" required class="form-input-custom">
                </div>

                <div>
                    <label for="school_npsn" class="block text-xs font-bold text-slate-700 mb-1">NPSN Sekolah</label>
                    <input type="text" id="school_npsn" name="school_npsn" value="{{ $settings['school_npsn']->value ?? '20219736' }}" required class="form-input-custom">
                </div>
            </div>

            <div>
                <label for="school_logo_file" class="block text-xs font-bold text-slate-700 mb-1">Logo Sekolah (PNG/JPG/WEBP/SVG, Max 2MB)</label>
                @if(isset($settings['school_logo']) && $settings['school_logo']->value)
                    <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <img src="{{ asset($settings['school_logo']->value) }}" alt="Logo Sekolah" class="w-14 h-14 object-contain rounded-lg p-1 bg-white border border-slate-200 shadow-sm">
                        <div class="text-xs text-slate-600">
                            <span class="font-bold text-slate-800 block">Logo Sekolah Aktif</span>
                            <span class="text-[11px] text-slate-500 font-mono">{{ asset($settings['school_logo']->value) }}</span>
                        </div>
                    </div>
                @endif
                <input type="file" id="school_logo_file" name="school_logo_file" accept="image/*" class="form-input-custom bg-white">
                @error('school_logo_file')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="school_accreditation" class="block text-xs font-bold text-slate-700 mb-1">Akreditasi</label>
                    <input type="text" id="school_accreditation" name="school_accreditation" value="{{ $settings['school_accreditation']->value ?? 'A (Unggul)' }}" required class="form-input-custom">
                </div>

                <div>
                    <label for="total_students" class="block text-xs font-bold text-slate-700 mb-1">Total Peserta Didik (Statistik Beranda)</label>
                    <input type="text" id="total_students" name="total_students" value="{{ $settings['total_students']->value ?? '1.000+' }}" required class="form-input-custom">
                </div>
            </div>

            <div>
                <label for="school_motto" class="block text-xs font-bold text-slate-700 mb-1">Motto Sekolah</label>
                <input type="text" id="school_motto" name="school_motto" value="{{ $settings['school_motto']->value ?? 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global' }}" required class="form-input-custom">
            </div>

            <div>
                <label for="spmb_quote" class="block text-xs font-bold text-slate-700 mb-1">Kata-Kata Bijak (Running Text Layanan SPMB)</label>
                <input type="text" id="spmb_quote" name="spmb_quote" value="{{ $settings['spmb_quote']->value ?? 'Pendidikan adalah tiket ke masa depan, hari esok dimiliki oleh orang-orang yang mempersiapkannya hari ini. — SMAN 24 Bandung' }}" required class="form-input-custom">
            </div>

            <div>
                <label for="school_address" class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap Sekolah</label>
                <input type="text" id="school_address" name="school_address" value="{{ $settings['school_address']->value ?? 'Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614' }}" required class="form-input-custom">
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Kontak & Komunikasi</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="school_phone" class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" id="school_phone" name="school_phone" value="{{ $settings['school_phone']->value ?? '(022) 7800540' }}" required class="form-input-custom">
                </div>
                <div>
                    <label for="school_email" class="block text-xs font-bold text-slate-700 mb-1">Email Resmi</label>
                    <input type="email" id="school_email" name="school_email" value="{{ $settings['school_email']->value ?? 'info@sman24bdg.sch.id' }}" required class="form-input-custom">
                </div>
            </div>
        </div>

        <!-- Section: Media Sosial & Saluran Komunikasi -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Tautan Media Sosial Resmi</h3>
                <span class="text-[11px] text-slate-400 font-medium">Ditampilkan di Header / Topbar Website</span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Instagram -->
                <div>
                    <label for="instagram_url" class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-1">
                        <span class="w-5 h-5 rounded-md bg-gradient-to-tr from-yellow-500 via-pink-500 to-purple-600 flex items-center justify-center text-white text-[10px]">📸</span>
                        <span>Instagram URL</span>
                    </label>
                    <input type="url" id="instagram_url" name="instagram_url" value="{{ $settings['instagram_url']->value ?? '' }}" placeholder="https://www.instagram.com/sman24bdg" class="form-input-custom">
                    <p class="text-[11px] text-slate-400 mt-1">Contoh: https://www.instagram.com/sman24bdg</p>
                </div>

                <!-- Facebook -->
                <div>
                    <label for="facebook_url" class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-1">
                        <span class="w-5 h-5 rounded-md bg-blue-600 flex items-center justify-center text-white text-[10px] font-bold">f</span>
                        <span>Facebook URL</span>
                    </label>
                    <input type="url" id="facebook_url" name="facebook_url" value="{{ $settings['facebook_url']->value ?? '' }}" placeholder="https://www.facebook.com/sman24bandung" class="form-input-custom">
                    <p class="text-[11px] text-slate-400 mt-1">Contoh: https://www.facebook.com/sman24bandung</p>
                </div>

                <!-- YouTube -->
                <div>
                    <label for="youtube_url" class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-1">
                        <span class="w-5 h-5 rounded-md bg-red-600 flex items-center justify-center text-white text-[10px]">▶</span>
                        <span>YouTube URL</span>
                    </label>
                    <input type="url" id="youtube_url" name="youtube_url" value="{{ $settings['youtube_url']->value ?? '' }}" placeholder="https://www.youtube.com/@sman24bandung" class="form-input-custom">
                    <p class="text-[11px] text-slate-400 mt-1">Contoh: https://www.youtube.com/@sman24bandung</p>
                </div>

                <!-- TikTok -->
                <div>
                    <label for="tiktok_url" class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-1">
                        <span class="w-5 h-5 rounded-md bg-slate-900 flex items-center justify-center text-cyan-400 text-[10px] font-black">♪</span>
                        <span>TikTok URL</span>
                    </label>
                    <input type="url" id="tiktok_url" name="tiktok_url" value="{{ $settings['tiktok_url']->value ?? '' }}" placeholder="https://www.tiktok.com/@sman24bdg" class="form-input-custom">
                    <p class="text-[11px] text-slate-400 mt-1">Contoh: https://www.tiktok.com/@sman24bdg</p>
                </div>

                <!-- Twitter / X -->
                <div class="sm:col-span-2">
                    <label for="twitter_url" class="flex items-center gap-2 text-xs font-bold text-slate-700 mb-1">
                        <span class="w-5 h-5 rounded-md bg-black flex items-center justify-center text-white text-[10px] font-bold">𝕏</span>
                        <span>Twitter / X URL (Opsional)</span>
                    </label>
                    <input type="url" id="twitter_url" name="twitter_url" value="{{ $settings['twitter_url']->value ?? '' }}" placeholder="https://x.com/sman24bdg" class="form-input-custom">
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <x-button type="submit" variant="primary">
                Simpan Perubahan Pengaturan Website
            </x-button>
        </div>
    </form>
</div>
@endsection
