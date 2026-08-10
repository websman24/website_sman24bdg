@extends('layouts.admin.app')

@section('title', 'Edit Ekstrakurikuler - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Ekstrakurikuler')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Data Ekstrakurikuler</h2>
        <a href="{{ route('admin.extracurriculars.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Daftar Ekskul</a>
    </div>

    <form action="{{ route('admin.extracurriculars.update', $extracurricular) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Ekstrakurikuler</label>
                <input type="text" id="name" name="name" value="{{ old('name', $extracurricular->name) }}" required placeholder="contoh: Paskibra, Pramuka, PMR, Tim Futsal..." class="form-input-custom">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Ekskul</label>
                <input type="text" id="category" name="category" value="{{ old('category', $extracurricular->category) }}" required placeholder="contoh: Bela Negara, Olahraga, Seni & Budaya, Keagamaan" class="form-input-custom">
                @error('category')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="mentor_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Pembina / Pelatih</label>
                <input type="text" id="mentor_name" name="mentor_name" value="{{ old('mentor_name', $extracurricular->mentor_name) }}" placeholder="Nama pembina atau pelatih..." class="form-input-custom">
            </div>

            <div>
                <label for="schedule" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jadwal Latihan</label>
                <input type="text" id="schedule" name="schedule" value="{{ old('schedule', $extracurricular->schedule) }}" placeholder="contoh: Setiap Jumat 15:30 WIB" class="form-input-custom">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="logo_or_photo_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Logo / Foto Kegiatan (JPG/PNG/WEBP, Max 2MB)</label>
                @if($extracurricular->logo_or_photo)
                    <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <img src="{{ asset($extracurricular->logo_or_photo) }}" alt="{{ $extracurricular->name }}" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                        <div class="text-xs text-slate-600">
                            <span class="font-bold text-slate-800 block">Logo Saat Ini</span>
                            <span class="text-[11px] text-slate-500 font-mono">{{ asset($extracurricular->logo_or_photo) }}</span>
                        </div>
                    </div>
                @endif
                <input type="file" id="logo_or_photo_file" name="logo_or_photo_file" accept="image/*" class="form-input-custom bg-white">
                @error('logo_or_photo_file')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center pt-6">
                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $extracurricular->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Status Aktif (Tampilkan di Publik)</span>
                </label>
            </div>
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Ekstrakurikuler</label>
            <textarea id="description" name="description" rows="4" placeholder="Jelaskan profil, visi, dan aktivitas ekstrakurikuler..." class="form-input-custom">{{ old('description', $extracurricular->description) }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.extracurriculars.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
