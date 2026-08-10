@extends('layouts.admin.app')

@section('title', 'Tambah Video YouTube - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Video')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Video YouTube Baru</h2>
        <a href="{{ route('admin.videos.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.videos.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold text-slate-700 mb-1">Judul Video</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="contoh: Profil SMA Negeri 24 Bandung 2026..." class="form-input-custom">
        </div>

        <div>
            <label for="youtube_url" class="block text-xs font-bold text-slate-700 mb-1">URL Video YouTube</label>
            <input type="url" id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}" required placeholder="https://www.youtube.com/watch?v=..." class="form-input-custom">
        </div>

        <div>
            <label for="description" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Video (Opsional)</label>
            <textarea id="description" name="description" rows="3" placeholder="Keterangan singkat video..." class="form-input-custom">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end">
            <x-button type="submit" variant="primary">Simpan Video YouTube</x-button>
        </div>
    </form>
</div>
@endsection
