@extends('layouts.public.app')

@section('title', $announcement->title . ' - Pengumuman SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <x-breadcrumb :items="['Pengumuman' => route('announcements.index'), Str::limit($announcement->title, 25) => '']" />
        <div class="flex flex-wrap items-center gap-3 text-xs pt-1">
            @if($announcement->is_pinned)
                <span class="px-3 py-1 rounded-full font-extrabold bg-amber-500 text-emerald-950 text-[10px] uppercase">
                    📌 Pinned
                </span>
            @endif
            <span class="px-3 py-1 rounded-full font-extrabold bg-emerald-800 text-emerald-100 text-[10px] uppercase">
                Pengumuman Resmi
            </span>
            <span class="text-slate-300 font-mono">{{ $announcement->published_at?->format('d M Y, H:i') ?? $announcement->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-extrabold leading-tight text-white">{{ $announcement->title }}</h1>
        <div class="text-xs text-slate-300">Dipublikasikan oleh: <strong class="text-amber-400 font-bold">{{ $announcement->author->name ?? 'Tim Humas SMAN 24' }}</strong></div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <x-card :hover="false" class="p-6 sm:p-10 space-y-8 text-slate-800 text-sm leading-relaxed">
        <div class="prose prose-emerald max-w-none text-slate-700 leading-relaxed space-y-4 text-base whitespace-pre-line">
            {{ $announcement->content }}
        </div>

        @if($announcement->attachment_file)
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl">
                        📎
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs sm:text-sm">Berkas Lampiran Pengumuman</h4>
                        <p class="text-[11px] text-slate-500 font-mono">{{ asset($announcement->attachment_file) }}</p>
                    </div>
                </div>
                <a href="{{ asset($announcement->attachment_file) }}" target="_blank" download class="px-4 py-2.5 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all whitespace-nowrap">
                    ⬇️ Unduh Berkas Lampiran
                </a>
            </div>
        @endif

        <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
            <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                &larr; Kembali ke Daftar Pengumuman
            </a>
        </div>
    </x-card>

    @if($recentAnnouncements->isNotEmpty())
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-slate-900">Pengumuman Lainnya</h3>
                <a href="{{ route('announcements.index') }}" class="text-xs font-bold text-emerald-800 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($recentAnnouncements as $recent)
                    <x-card :hover="true" class="p-5 space-y-3">
                        <div class="text-[11px] text-slate-400 font-mono">
                            {{ $recent->published_at?->format('d M Y') }}
                        </div>
                        <h4 class="font-bold text-slate-900 text-xs line-clamp-2 leading-snug">
                            <a href="{{ route('announcements.show', $recent->slug) }}" class="hover:text-emerald-800 transition-colors">
                                {{ $recent->title }}
                            </a>
                        </h4>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
