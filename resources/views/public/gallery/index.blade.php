@extends('layouts.public.app')

@section('title', 'Galeri Foto & Video - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Galeri Foto & Video' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Galeri Foto & Video Kegiatan</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Dokumentasi momen berharga, acara penting, dan kegiatan resmi {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Album Foto -->
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-3">Album Foto Kegiatan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($galleries as $gal)
                <x-card :hover="true" class="space-y-4">
                    <div class="w-full h-40 bg-slate-100 rounded-xl flex items-center justify-center text-4xl text-slate-300">
                        🖼️
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block font-mono">
                            {{ $gal->items_count }} Foto dalam Album
                        </span>
                        <h3 class="font-bold text-slate-900 text-base mt-1">{{ $gal->title }}</h3>
                        <p class="text-xs text-slate-600 mt-1 line-clamp-2">{{ $gal->description }}</p>
                    </div>
                </x-card>
            @empty
                <div class="col-span-3 py-8 text-center text-slate-400 text-xs">
                    Belum ada album galeri dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Video YouTube -->
    @if($videos->isNotEmpty())
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-3">Galeri Video Resmi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($videos as $vid)
                    <x-card :hover="true" class="space-y-3">
                        <div class="aspect-video bg-slate-900 rounded-xl flex items-center justify-center text-white text-3xl font-bold">
                            ▶️ YouTube Video ({{ $vid->youtube_id }})
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">{{ $vid->title }}</h3>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
