@extends('layouts.admin.app')

@section('title', 'Edit Album Foto - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Album')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Album Galeri Foto</h2>
        <a href="{{ route('admin.galleries.show', $gallery) }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Foto Album</a>
    </div>

    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Album Galeri</label>
            <input type="text" id="title" name="title" value="{{ old('title', $gallery->title) }}" required placeholder="contoh: Dokumentasi Upacara HUT RI Ke-81, Pentas Seni..." class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="cover_image_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Sampul / Cover Album (JPG/PNG/WEBP, Max 3MB)</label>
            @if($gallery->cover_image)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ asset($gallery->cover_image) }}" alt="{{ $gallery->title }}" class="w-16 h-12 object-cover rounded-lg border border-slate-200">
                    <div class="text-xs text-slate-600">
                        <span class="font-bold text-slate-800 block">Cover Album Saat Ini</span>
                        <span class="text-[11px] text-slate-500 font-mono">{{ asset($gallery->cover_image) }}</span>
                    </div>
                </div>
            @endif
            <input type="file" id="cover_image_file" name="cover_image_file" accept="image/*" class="form-input-custom bg-white">
            @error('cover_image_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Album (Opsional)</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan singkat mengenai album foto..." class="form-input-custom">{{ old('description', $gallery->description) }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.galleries.show', $gallery) }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
