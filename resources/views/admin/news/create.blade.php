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

    <form action="{{ route('admin.news.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Berita</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="Masukkan judul berita..."
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Berita</label>
                <select id="category_id" name="category_id" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none bg-white">
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
                <select id="status" name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none bg-white">
                    <option value="published">Published (Publikasikan)</option>
                    <option value="draft">Draft (Simpan Sementara)</option>
                </select>
            </div>
        </div>

        <div>
            <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Ringkasan Berita (Excerpt)</label>
            <textarea id="excerpt" name="excerpt" rows="2" placeholder="Ringkasan singkat berita..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">{{ old('excerpt') }}</textarea>
        </div>

        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Konten Berita</label>
            <textarea id="content" name="content" rows="6" required placeholder="Tulis isi berita lengkap di sini..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.news.index') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold text-xs hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-md transition-all">
                Simpan Berita
            </button>
        </div>
    </form>
</div>
@endsection
