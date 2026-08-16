@extends('layouts.admin.app')

@section('title', 'Tambah Berita Baru - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Berita')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Berita Baru</h2>
        <a href="{{ route('admin.news.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Berita
        </a>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Berita</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="Masukkan judul berita..."
                   class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Kategori Berita</label>
                    <a href="{{ route('admin.news-categories.index') }}" target="_blank" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-900 underline">+ Kelola Kategori</a>
                </div>
                <select id="category_id" name="category_id" required class="form-input-custom bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Publikasi</label>
                <select id="status" name="status" required class="form-input-custom bg-white">
                    <option value="published">Published (Publikasikan)</option>
                    <option value="draft">Draft (Simpan Sementara)</option>
                </select>
            </div>
        </div>

        <div>
            <label for="thumbnail_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Thumbnail (JPG/PNG/WEBP, Max 2MB)</label>
            <input type="file" id="thumbnail_file" name="thumbnail_file" accept="image/*" class="form-input-custom bg-white">
            @error('thumbnail_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Ringkasan Berita (Excerpt)</label>
            <textarea id="excerpt" name="excerpt" rows="2" placeholder="Ringkasan singkat berita..." class="form-input-custom">{{ old('excerpt') }}</textarea>
        </div>

        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Konten Berita</label>
            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
            <trix-editor input="content" class="trix-content form-input-custom min-h-[150px]"></trix-editor>
            @error('content')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.news.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Berita
            </x-button>
        </div>
    </form>
</div>
@endsection
