@extends('layouts.admin.app')

@section('title', 'Edit Kategori Berita - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Kategori Berita')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Jenis Kategori Berita</h2>
        <a href="{{ route('admin.news-categories.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Kategori
        </a>
    </div>

    <form action="{{ route('admin.news-categories.update', $newsCategory) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Kategori Berita</label>
            <input type="text" id="name" name="name" value="{{ old('name', $newsCategory->name) }}" required
                   placeholder="Masukkan nama kategori berita..."
                   class="form-input-custom">
            @error('name')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Kategori (Opsional)</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan singkat tentang kategori ini..." class="form-input-custom">{{ old('description', $newsCategory->description) }}</textarea>
            @error('description')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.news-categories.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
