@extends('layouts.admin.app')

@section('title', 'Edit Berita - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Berita')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Berita / Artikel</h2>
        <a href="{{ route('admin.news.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Berita
        </a>
    </div>

    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Berita</label>
            <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                   placeholder="Masukkan judul berita..."
                   class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Berita</label>
                <select id="category_id" name="category_id" required class="form-input-custom bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $news->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Publikasi</label>
                <select id="status" name="status" required class="form-input-custom bg-white">
                    <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                    <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                </select>
            </div>
        </div>

        <div>
            <label for="thumbnail_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Thumbnail (JPG/PNG/WEBP, Max 2MB)</label>
            @if($news->thumbnail)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ asset($news->thumbnail) }}" alt="Thumbnail" class="w-16 h-16 object-cover rounded-lg border border-slate-200">
                    <div class="text-xs text-slate-600">
                        <span class="font-bold text-slate-800 block">Thumbnail Saat Ini</span>
                        <span class="text-[11px] text-slate-500 font-mono">{{ asset($news->thumbnail) }}</span>
                    </div>
                </div>
            @endif
            <input type="file" id="thumbnail_file" name="thumbnail_file" accept="image/*" class="form-input-custom bg-white">
            @error('thumbnail_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Ringkasan Berita (Excerpt)</label>
            <textarea id="excerpt" name="excerpt" rows="2" placeholder="Ringkasan singkat berita..." class="form-input-custom">{{ old('excerpt', $news->excerpt) }}</textarea>
        </div>

        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Konten Berita</label>
            <textarea id="content" name="content" rows="6" required placeholder="Tulis isi berita lengkap di sini..." class="form-input-custom">{{ old('content', $news->content) }}</textarea>
            @error('content')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.news.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
