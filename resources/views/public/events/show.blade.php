@extends('layouts.public.app')

@section('title', $event->title . ' - Agenda SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <x-breadcrumb :items="['Agenda Sekolah' => route('events.index'), Str::limit($event->title, 25) => '']" />
        <div class="flex flex-wrap items-center gap-3 text-xs pt-1">
            <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase border
                @if($event->status === 'upcoming') bg-sky-100 text-sky-800 border-sky-300
                @elseif($event->status === 'ongoing') bg-amber-100 text-amber-900 border-amber-300
                @elseif($event->status === 'completed') bg-slate-100 text-slate-600 border-slate-300
                @else bg-rose-100 text-rose-800 border-rose-300 @endif">
                {{ $event->status === 'upcoming' ? 'Mendatang' : ($event->status === 'ongoing' ? 'Berlangsung' : ($event->status === 'completed' ? 'Selesai' : 'Dibatalkan')) }}
            </span>
            <span class="text-amber-400 font-bold">📍 {{ $event->location }}</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-extrabold leading-tight text-white">{{ $event->title }}</h1>
        <div class="text-xs text-slate-300">Penyelenggara: <strong class="text-amber-400 font-bold">{{ $event->author->name ?? 'Panitia SMAN 24 Bandung' }}</strong></div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <x-card :hover="false" class="p-6 sm:p-10 space-y-8 text-slate-800 text-sm leading-relaxed">
        @if($event->banner)
            <div class="w-full max-h-[400px] rounded-2xl overflow-hidden shadow-lg border border-slate-200">
                <img src="{{ asset($event->banner) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Details Grid Card -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-200">
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Tanggal & Waktu Mulai</span>
                <p class="font-bold text-slate-900 text-sm">📅 {{ $event->start_date?->format('d M Y, H:i') }} WIB</p>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Tanggal Selesai</span>
                <p class="font-bold text-slate-900 text-sm">
                    @if($event->end_date)
                        🏁 {{ $event->end_date->format('d M Y, H:i') }} WIB
                    @else
                        Selesai pada hari yang sama
                    @endif
                </p>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider">Lokasi Kegiatan</span>
                <p class="font-bold text-emerald-800 text-sm">📍 {{ $event->location }}</p>
            </div>
        </div>

        @if($event->description)
            <div class="space-y-3">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-200 pb-2">Deskripsi & Rincian Kegiatan</h3>
                <div class="prose prose-emerald max-w-none text-slate-700 leading-relaxed space-y-4 text-sm sm:text-base whitespace-pre-line">
                    {{ $event->description }}
                </div>
            </div>
        @endif

        <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                &larr; Kembali ke Agenda Sekolah
            </a>
        </div>
    </x-card>

    @if($upcomingEvents->isNotEmpty())
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-slate-900">Agenda Mendatang Lainnya</h3>
                <a href="{{ route('events.index') }}" class="text-xs font-bold text-emerald-800 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($upcomingEvents as $upcoming)
                    <x-card :hover="true" class="p-5 space-y-3 flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold text-sky-800 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 inline-block">
                                📅 {{ $upcoming->start_date?->format('d M Y') }}
                            </span>
                            <h4 class="font-bold text-slate-900 text-xs line-clamp-2 leading-snug">
                                <a href="{{ route('events.show', $upcoming->slug) }}" class="hover:text-emerald-800 transition-colors">
                                    {{ $upcoming->title }}
                                </a>
                            </h4>
                        </div>
                        <div class="text-[11px] text-slate-500 font-medium">
                            📍 {{ $upcoming->location }}
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
