@extends('layouts.public.app')

@section('title', $gallery->title . ' - Album Galeri SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Galeri Foto' => route('gallery.index'), Str::limit($gallery->title, 25) => '']" />
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase bg-amber-500 text-emerald-950">
                📸 {{ $gallery->items->count() }} Foto Dokumentasi
            </span>
            <span class="text-xs font-mono text-slate-300">{{ $gallery->published_at?->format('d M Y') ?? $gallery->created_at->format('d M Y') }}</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">{{ $gallery->title }}</h1>
        @if($gallery->description)
            <p class="text-slate-300 text-xs sm:text-sm max-w-3xl leading-relaxed">{{ $gallery->description }}</p>
        @endif
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8" x-data="{ activeModal: false, activeImg: '', activeCaption: '' }">
    <div class="flex items-center justify-between border-b border-slate-200 pb-3">
        <h2 class="text-lg font-bold text-slate-900">Dokumentasi Foto Kegiatan</h2>
        <a href="{{ route('gallery.index') }}" class="text-xs font-bold text-emerald-800 hover:underline inline-flex items-center gap-1">
            &larr; Kembali ke Indeks Galeri
        </a>
    </div>

    <!-- Photo Masonry / Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($gallery->items as $item)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between group cursor-pointer"
                 @click="activeModal = true; activeImg = '{{ asset($item->image_path) }}'; activeCaption = '{{ addslashes($item->caption ?? $gallery->title) }}'">
                <div class="relative w-full h-56 bg-slate-100 overflow-hidden">
                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->caption ?? $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-emerald-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white font-bold text-xs">
                        <span>🔍 Klik untuk Perbesar</span>
                    </div>
                </div>
                @if($item->caption)
                    <div class="p-4 bg-white border-t border-slate-100">
                        <p class="text-xs text-slate-700 leading-snug line-clamp-2">{{ $item->caption }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-4 py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                <div class="text-4xl">📷</div>
                <h3 class="text-base font-bold text-slate-800">Belum ada foto di dalam album ini</h3>
                <p class="text-xs text-slate-500">Foto kegiatan akan segera diperbarui oleh pengelola galeri.</p>
            </div>
        @endforelse
    </div>

    <!-- Lightbox Zoom Modal -->
    <div x-show="activeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-sm"
         @keydown.escape.window="activeModal = false">
        <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-slate-800 space-y-3 p-4" @click.away="activeModal = false">
            <div class="flex items-center justify-between px-2 text-white">
                <span class="text-xs font-bold text-slate-300" x-text="activeCaption"></span>
                <button @click="activeModal = false" class="w-8 h-8 rounded-full bg-slate-800 text-white font-bold hover:bg-slate-700 flex items-center justify-center text-sm">
                    ✕
                </button>
            </div>
            <div class="max-h-[75vh] overflow-hidden rounded-2xl flex items-center justify-center bg-black">
                <img :src="activeImg" class="max-h-[75vh] w-auto object-contain">
            </div>
        </div>
    </div>
</div>
@endsection
