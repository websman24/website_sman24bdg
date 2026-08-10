@extends('layouts.admin.app')

@section('title', 'Tambah Dokumen - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Dokumen')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Dokumen Publik / SPMB</h2>
        <a href="{{ route('admin.documents.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Dokumen
        </a>
    </div>

    <form action="{{ route('admin.documents.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Dokumen</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="contoh: Formulir Pendaftaran SPMB 2026/2027..."
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Dokumen</label>
            <select id="category" name="category" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none bg-white">
                <option value="SPMB">SPMB (Seleksi Penerimaan Murid Baru)</option>
                <option value="Kurikulum">Kurikulum & Akademik</option>
                <option value="Panduan">Panduan & Tata Tertib</option>
                <option value="Formulir">Formulir Umum</option>
            </select>
            @error('category')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Dokumen (Opsional)</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan singkat mengenai dokumen ini..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.documents.index') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold text-xs hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-md transition-all">
                Simpan Dokumen
            </button>
        </div>
    </form>
</div>
@endsection
