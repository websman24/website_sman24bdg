@extends('layouts.admin.app')

@section('title', 'Edit Pengumuman - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Pengumuman Resmi</h2>
        <a href="{{ route('admin.announcements.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Pengumuman
        </a>
    </div>

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Pengumuman</label>
            <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required
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
                    <option value="published" {{ old('status', $announcement->status) === 'published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                    <option value="draft" {{ old('status', $announcement->status) === 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                </select>
            </div>

            <div class="flex items-center pt-6">
                <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $announcement->is_pinned) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                    <span>Sematkan Pengumuman (Pinned di Atas)</span>
                </label>
            </div>
        </div>

        <div>
            <label for="attachment_file_input" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Berkas Lampiran (PDF / DOC / Image, Max 5MB)</label>
            @if($announcement->attachment_file)
                <div class="mb-3 flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">📎</span>
                        <div class="text-xs text-slate-600">
                            <span class="font-bold text-slate-800 block">Berkas Lampiran Aktif</span>
                            <span class="text-[11px] text-slate-500 font-mono">{{ asset($announcement->attachment_file) }}</span>
                        </div>
                    </div>
                    <a href="{{ asset($announcement->attachment_file) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 font-bold text-xs hover:bg-sky-100">
                        Lihat Berkas
                    </a>
                </div>
            @endif
            <input type="file" id="attachment_file_input" name="attachment_file_input" class="form-input-custom bg-white">
            @error('attachment_file_input')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Pengumuman</label>
            <input id="content" type="hidden" name="content" value="{{ old('content', $announcement->content) }}">
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
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
