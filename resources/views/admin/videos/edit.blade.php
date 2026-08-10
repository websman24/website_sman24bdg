@extends('layouts.admin.app')

@section('title', 'Edit Video YouTube - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Video')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Video YouTube</h2>
        <a href="{{ route('admin.videos.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Daftar Video</a>
    </div>

    <form action="{{ route('admin.videos.update', $video) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Video Dokumentasi</label>
            <input type="text" id="title" name="title" value="{{ old('title', $video->title) }}" required placeholder="contoh: Video Profil SMA Negeri 24 Bandung 2026, Profil Ekstrakurikuler..." class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="youtube_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tautan / Link Video YouTube</label>
            <input type="url" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" required placeholder="https://www.youtube.com/watch?v=XXXXX atau https://youtu.be/XXXXX" class="form-input-custom">
            @error('youtube_url')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        @if($video->youtube_id)
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <span class="text-xs font-bold text-slate-700 block">Pratinjau Video YouTube Saat Ini</span>
                <div class="aspect-video w-full max-w-md rounded-xl overflow-hidden shadow-sm border border-slate-300">
                    <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}" class="w-full h-full" allowfullscreen></iframe>
                </div>
            </div>
        @endif

        <div class="flex items-center">
            <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $video->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Jadikan Video Utama / Featured Video</span>
            </label>
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Video (Opsional)</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan singkat mengenai isi video dokumentasi..." class="form-input-custom">{{ old('description', $video->description) }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.videos.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
