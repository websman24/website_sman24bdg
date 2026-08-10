@extends('layouts.admin.app')

@section('title', 'Edit Dokumen - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Dokumen')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Dokumen Publik</h2>
        <a href="{{ route('admin.documents.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Dokumen
        </a>
    </div>

    <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Dokumen</label>
            <input type="text" id="title" name="title" value="{{ old('title', $document->title) }}" required
                   placeholder="contoh: Juknis SPMB 2026/2027, Kalender Pendidikan, Jadwal Ujian..."
                   class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Dokumen</label>
            <select id="category" name="category" required class="form-input-custom bg-white">
                <option value="SPMB" {{ old('category', $document->category) === 'SPMB' ? 'selected' : '' }}>SPMB (Seleksi Penerimaan Murid Baru)</option>
                <option value="Kurikulum" {{ old('category', $document->category) === 'Kurikulum' ? 'selected' : '' }}>Kurikulum & Akademik</option>
                <option value="Surat Edaran" {{ old('category', $document->category) === 'Surat Edaran' ? 'selected' : '' }}>Surat Edaran & Pemberitahuan</option>
                <option value="Formulir" {{ old('category', $document->category) === 'Formulir' ? 'selected' : '' }}>Formulir & Template</option>
                <option value="Panduan" {{ old('category', $document->category) === 'Panduan' ? 'selected' : '' }}>Panduan & Tata Tertib</option>
                <option value="Lainnya" {{ old('category', $document->category) === 'Lainnya' ? 'selected' : '' }}>Lain-Lain</option>
            </select>
            @error('category')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="document_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Ganti Berkas Dokumen (Opsional: PDF, DOC/DOCX, XLS/XLSX, ZIP)</label>
            @if($document->file_path)
                <div class="mb-3 flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">📄</span>
                        <div class="text-xs text-slate-600">
                            <span class="font-bold text-slate-800 block">Berkas Dokumen Aktif</span>
                            <span class="text-[11px] text-slate-500 font-mono">{{ asset($document->file_path) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('download.file', $document) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 font-bold text-xs hover:bg-sky-100">
                        Unduh Berkas
                    </a>
                </div>
            @endif
            <input type="file" id="document_file" name="document_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="form-input-custom bg-white">
            @error('document_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Dokumen (Opsional)</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan singkat mengenai isi dokumen ini..." class="form-input-custom">{{ old('description', $document->description) }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.documents.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
