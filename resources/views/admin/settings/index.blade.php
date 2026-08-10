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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="school_accreditation" class="block text-xs font-bold text-slate-700 mb-1">Akreditasi</label>
                    <input type="text" id="school_accreditation" name="school_accreditation" value="{{ $settings['school_accreditation']->value ?? 'A (Unggul)' }}" required class="form-input-custom">
                </div>

                <div>
                    <label for="school_motto" class="block text-xs font-bold text-slate-700 mb-1">Motto Sekolah</label>
                    <input type="text" id="school_motto" name="school_motto" value="{{ $settings['school_motto']->value ?? 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global' }}" required class="form-input-custom">
                </div>
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

        <div class="pt-4 flex justify-end">
            <x-button type="submit" variant="primary">
                Simpan Perubahan Pengaturan Website
            </x-button>
        </div>
    </form>
</div>
@endsection
