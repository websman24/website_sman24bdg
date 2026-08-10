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

    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Dokumen</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="contoh: Formulir Pendaftaran SPMB 2026/2027..."
                   class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Dokumen</label>
            <select id="category" name="category" required class="form-input-custom bg-white">
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
            <label for="document_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Berkas Dokumen (PDF/DOCX/XLSX/ZIP, Max 10MB)</label>
            <input type="file" id="document_file" name="document_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="form-input-custom bg-white">
            @error('document_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Dokumen (Opsional)</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan singkat mengenai dokumen ini..." class="form-input-custom">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.documents.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Dokumen
            </x-button>
        </div>
    </form>
</div>
@endsection
