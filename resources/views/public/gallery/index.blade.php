@extends('layouts.public.app')

@section('title', 'Galeri Foto & Video - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Galeri Foto & Video' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Galeri Dokumentasi & Video</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Dokumentasi momen berharga, album foto kegiatan, dan video resmi {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10" x-data="{ activeTab: 'photos' }">
    <!-- Navigation Tabs Switcher -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div class="flex gap-3">
            <button @click="activeTab = 'photos'" :class="activeTab === 'photos' ? 'bg-emerald-800 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2">
                <span>🖼️ Album Foto</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-950/40 text-amber-300">{{ $galleries->total() }}</span>
            </button>
            <button @click="activeTab = 'videos'" :class="activeTab === 'videos' ? 'bg-emerald-800 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2">
                <span>🎥 Video Dokumentasi (YouTube)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-950/40 text-amber-300">{{ $videos->count() }}</span>
            </button>
        </div>
    </div>

    <!-- TAB 1: ALBUM FOTO -->
    <div x-show="activeTab === 'photos'" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($galleries as $gal)
                <x-card :hover="true" class="p-0 overflow-hidden space-y-0 flex flex-col justify-between group">
                    <div>
                        <div class="w-full h-48 bg-slate-100 overflow-hidden relative">
                            @if($gal->cover_image)
                                <img src="{{ asset($gal->cover_image) }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-900 to-slate-900 flex items-center justify-center text-4xl text-amber-400">
                                    🖼️
                                </div>
                            @endif
                            <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-[10px] font-extrabold bg-emerald-950/80 text-amber-300 backdrop-blur-sm border border-emerald-700">
                                📸 {{ $gal->items_count }} Foto
                            </span>
                        </div>

                        <div class="p-6 space-y-3">
                            <span class="text-[11px] font-mono text-slate-400">
                                {{ $gal->published_at?->format('d M Y') ?? $gal->created_at->format('d M Y') }}
                            </span>
                            <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-emerald-800 transition-colors">
                                <a href="{{ route('gallery.show', $gal->slug) }}">
                                    {{ $gal->title }}
                                </a>
                            </h3>
                            @if($gal->description)
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">{{ $gal->description }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Oleh: {{ $gal->author->name ?? 'Tim Humas SMAN 24' }}</span>
                        <a href="{{ route('gallery.show', $gal->slug) }}" class="font-extrabold text-emerald-800 hover:underline flex items-center gap-1">
                            <span>Lihat Album</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </x-card>
            @empty
                <div class="col-span-3 py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                    <div class="text-4xl">🖼️</div>
                    <h3 class="text-base font-bold text-slate-800">Belum ada album foto dipublikasikan</h3>
                    <p class="text-xs text-slate-500">Dokumentasi kegiatan sekolah akan segera diperbarui.</p>
                </div>
            @endforelse
        </div>

        @if($galleries->hasPages())
            <div class="pt-4 flex justify-center">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>

    <!-- TAB 2: VIDEO YOUTUBE EMBED -->
    <div x-show="activeTab === 'videos'" class="space-y-8" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($videos as $vid)
                <x-card :hover="false" class="p-0 overflow-hidden space-y-0">
                    <div class="aspect-video w-full bg-slate-900 border-b border-slate-200">
                        <iframe src="https://www.youtube.com/embed/{{ $vid->youtube_id }}" title="{{ $vid->title }}" class="w-full h-full" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="p-6 space-y-2">
                        @if($vid->is_featured)
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-amber-100 text-amber-900 border border-amber-300 uppercase">
                                ⭐ Video Utama
                            </span>
                        @endif
                        <h3 class="font-bold text-slate-900 text-base leading-snug">{{ $vid->title }}</h3>
                        @if($vid->description)
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $vid->description }}</p>
                        @endif
                    </div>
                </x-card>
            @empty
                <div class="col-span-2 py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                    <div class="text-4xl">🎬</div>
                    <h3 class="text-base font-bold text-slate-800">Belum ada video dokumentasi</h3>
                    <p class="text-xs text-slate-500">Video resmi SMAN 24 Bandung akan ditampilkan di halaman ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
