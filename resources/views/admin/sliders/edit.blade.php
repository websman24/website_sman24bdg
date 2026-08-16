@extends('layouts.admin.app')

@section('title', 'Edit Hero Slider - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Slider')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Hero Image Slider</h2>
        <a href="{{ route('admin.sliders.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Slider
        </a>
    </div>

    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Slide</label>
            <input type="text" id="title" name="title" value="{{ old('title', $slider->title) }}" required placeholder="contoh: Selamat Datang di SMA Negeri 24 Bandung..." class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="subtitle" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Subjudul / Deskripsi Singkat</label>
            <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" placeholder="contoh: Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global..." class="form-input-custom">
            @error('subtitle')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Background Hero</label>
            @if($slider->image_path)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                    <img src="{{ asset($slider->image_path) }}" alt="{{ $slider->title }}" class="w-32 h-20 object-cover rounded-lg border border-slate-200 shadow-sm">
                    <div>
                        <p class="text-xs font-semibold text-slate-700">Gambar Saat Ini</p>
                        <p class="text-[11px] text-slate-500">Pilih berkas baru di bawah ini jika ingin mengganti gambar background hero.</p>
                    </div>
                </div>
            @endif
            <input type="file" id="image_file" name="image_file" accept="image/*" class="form-input-custom bg-white">
            <p class="text-[11px] text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar background (JPG/PNG/WEBP, Max 3MB).</p>
            @error('image_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="button_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Teks Tombol Aksi (Opsional)</label>
                <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $slider->button_text) }}" placeholder="contoh: Jelajahi Profil" class="form-input-custom">
            </div>

            <div>
                <label for="button_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Link / URL Tombol</label>
                <input type="text" id="button_url" name="button_url" value="{{ old('button_url', $slider->button_url) }}" placeholder="contoh: /profil" class="form-input-custom">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="order_position" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Urutan Tampil (Order Position)</label>
                <input type="number" id="order_position" name="order_position" value="{{ old('order_position', $slider->order_position) }}" min="0" class="form-input-custom">
            </div>

            <div class="flex items-center pt-6">
                <label class="inline-flex items-center cursor-pointer gap-3">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-800 focus:ring-emerald-700">
                    <span class="text-xs font-bold text-slate-700">Aktifkan Slide di Beranda Publik</span>
                </label>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.sliders.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Perbarui Hero Slider
            </x-button>
        </div>
    </form>
</div>
@endsection
