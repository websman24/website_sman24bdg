@extends('layouts.admin.app')

@section('title', 'Tambah Pengumuman - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Pengumuman Baru</h2>
        <a href="{{ route('admin.announcements.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Pengumuman
        </a>
    </div>

    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Pengumuman</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   placeholder="Masukkan judul pengumuman..."
                   class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Publikasi</label>
                <select id="status" name="status" required class="form-input-custom bg-white">
                    <option value="published">Published (Publikasikan)</option>
                    <option value="draft">Draft (Simpan Sementara)</option>
                </select>
            </div>

            <div class="flex items-center pt-6">
                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                    <span>Sematkan Pengumuman (Pinned di Atas)</span>
                </label>
            </div>
        </div>

        <div>
            <label for="attachment_file_input" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Berkas Lampiran (PDF / DOC / Image, Max 5MB)</label>
            <input type="file" id="attachment_file_input" name="attachment_file_input" class="form-input-custom bg-white">
            @error('attachment_file_input')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Pengumuman</label>
            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
            <trix-editor input="content" class="trix-content form-input-custom min-h-[150px]"></trix-editor>
            @error('content')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.announcements.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Pengumuman
            </x-button>
        </div>
    </form>
</div>
@endsection
