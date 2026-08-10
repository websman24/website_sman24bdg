@extends('layouts.admin.app')

@section('title', 'Tambah Album Foto - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Album')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Buat Album Foto Baru</h2>
        <a href="{{ route('admin.galleries.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Galeri</a>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Album Galeri</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="contoh: Dokumentasi Upacara HUT RI Ke-81, Pentas Seni..." class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="cover_image_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Sampul / Cover Album (JPG/PNG/WEBP, Max 3MB)</label>
            <input type="file" id="cover_image_file" name="cover_image_file" accept="image/*" class="form-input-custom bg-white">
            @error('cover_image_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Album (Opsional)</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan singkat mengenai album foto..." class="form-input-custom">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.galleries.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan & Kelola Foto Album &rarr;
            </x-button>
        </div>
    </form>
</div>
@endsection
