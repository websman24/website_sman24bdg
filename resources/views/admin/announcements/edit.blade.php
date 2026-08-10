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

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Pengumuman</label>
            <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required
                   placeholder="Masukkan judul pengumuman..."
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Publikasi</label>
                <select id="status" name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none bg-white">
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
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Pengumuman</label>
            <textarea id="content" name="content" rows="6" required placeholder="Tulis isi pengumuman lengkap..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">{{ old('content', $announcement->content) }}</textarea>
            @error('content')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.announcements.index') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold text-xs hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-md transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
