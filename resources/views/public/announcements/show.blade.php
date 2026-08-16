@extends('layouts.public.app')

@section('title', $announcement->title . ' - Pengumuman SMAN 24 Bandung')
@section('meta_description', Str::limit(strip_tags($announcement->content), 160))
@section('og_title', $announcement->title)
@section('og_description', Str::limit(strip_tags($announcement->content), 160))

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-10 sm:py-14 border-b border-emerald-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <x-breadcrumb :items="['Pengumuman' => route('announcements.index'), Str::limit($announcement->title, 25) => '']" />
        <div class="flex flex-wrap items-center gap-2.5 text-xs pt-1">
            @if($announcement->is_pinned)
                <span class="px-3 py-1 rounded-full font-extrabold bg-amber-500 text-emerald-950 text-[10px] sm:text-xs uppercase shadow-sm">
                    📌 Pinned
                </span>
            @endif
            <span class="px-3 py-1 rounded-full font-extrabold bg-emerald-800 text-emerald-100 text-[10px] sm:text-xs uppercase">
                Pengumuman Resmi
            </span>
            <span class="text-slate-300 font-mono text-xs">{{ $announcement->published_at?->format('d M Y, H:i') ?? $announcement->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight text-white tracking-tight">{{ $announcement->title }}</h1>
        <div class="text-xs sm:text-sm text-slate-300">Dipublikasikan oleh: <strong class="text-amber-400 font-bold">{{ $announcement->author->name ?? 'Tim Humas SMAN 24' }}</strong></div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">
    <x-card :hover="false" class="p-5 sm:p-8 lg:p-10 space-y-6 sm:space-y-8 text-slate-800">
        <div class="prose prose-slate prose-emerald max-w-none text-slate-800 leading-relaxed text-sm sm:text-base">
            {!! clean($announcement->content) !!}
        </div>

        @if($announcement->attachment_file)
            <div class="p-4 sm:p-5 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl shrink-0">
                        📎
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-slate-900 text-xs sm:text-sm">Berkas Lampiran Pengumuman</h4>
                        <p class="text-[11px] text-slate-500 font-mono truncate max-w-[200px] sm:max-w-md">{{ basename($announcement->attachment_file) }}</p>
                    </div>
                </div>
                <a href="{{ asset($announcement->attachment_file) }}" target="_blank" download class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all whitespace-nowrap">
                    ⬇️ Unduh Berkas Lampiran
                </a>
            </div>
        @endif

        <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ route('announcements.index') }}" class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm transition-colors">
                &larr; Kembali ke Daftar Pengumuman
            </a>
            <div class="text-xs text-slate-400 font-mono text-center sm:text-right">
                Humas SMA Negeri 24 Bandung
            </div>
        </div>
    </x-card>

    @if($recentAnnouncements->isNotEmpty())
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg sm:text-xl font-bold text-slate-900">Pengumuman Lainnya</h3>
                <a href="{{ route('announcements.index') }}" class="text-xs sm:text-sm font-bold text-emerald-800 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($recentAnnouncements as $recent)
                    <x-card :hover="true" class="p-5 space-y-3 flex flex-col justify-between">
                        <div class="text-[11px] text-slate-400 font-mono">
                            {{ $recent->published_at?->format('d M Y') }}
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm line-clamp-2 leading-snug">
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
