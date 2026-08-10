@extends('layouts.public.app')

@section('title', $news->title . ' - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <x-breadcrumb :items="['Berita & Informasi' => route('news.index'), Str::limit($news->title, 25) => '']" />
        <div class="flex flex-wrap items-center gap-3 text-xs pt-1">
            <span class="px-3 py-1 rounded-full font-extrabold bg-amber-500 text-emerald-950 text-[10px] uppercase">
                {{ $news->category->name ?? 'Umum' }}
            </span>
            <span class="text-slate-300 font-mono">{{ $news->published_at?->format('d M Y, H:i') }} WIB</span>
            <span class="text-slate-400 font-mono">&bull; 👁️ {{ number_format($news->views_count) }} views</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-extrabold leading-tight text-white">{{ $news->title }}</h1>
        <div class="text-xs text-slate-300 flex items-center gap-2">
            <span>Dipublikasikan oleh:</span>
            <span class="font-bold text-amber-400 bg-white/10 px-2.5 py-0.5 rounded-lg border border-white/20">{{ $news->author->name ?? 'Admin SMAN 24' }}</span>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <x-card :hover="false" class="p-6 sm:p-10 space-y-8 text-slate-800 text-sm leading-relaxed">
        @if($news->thumbnail)
            <div class="w-full max-h-[450px] rounded-2xl overflow-hidden shadow-lg border border-slate-200">
                <img src="{{ asset($news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        @if($news->excerpt)
            <div class="p-4 bg-emerald-50/80 rounded-2xl border-l-4 border-emerald-700 text-emerald-900 text-sm font-semibold italic leading-relaxed">
                "{{ $news->excerpt }}"
            </div>
        @endif

        <div class="prose prose-emerald max-w-none text-slate-700 leading-relaxed space-y-4 text-base whitespace-pre-line">
            {{ $news->content }}
        </div>

        <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                &larr; Kembali ke Berita & Informasi
            </a>
            <div class="text-xs text-slate-400 font-mono">
                Bagikan: SMA Negeri 24 Bandung
            </div>
        </div>
    </x-card>

    @if($relatedNews->isNotEmpty())
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-bold text-slate-900">Artikel Berita Terkait</h3>
                <a href="{{ route('news.index') }}" class="text-xs font-bold text-emerald-800 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedNews as $rel)
                    <x-card :hover="true" class="p-5 space-y-3 flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-[10px] font-extrabold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200 inline-block">
                                {{ $rel->category->name ?? 'Umum' }}
                            </span>
                            <h4 class="font-bold text-slate-900 text-xs line-clamp-2 leading-snug">
                                <a href="{{ route('news.show', $rel->slug) }}" class="hover:text-emerald-800 transition-colors">
                                    {{ $rel->title }}
                                </a>
                            </h4>
                        </div>
                        <div class="text-[11px] text-slate-400 font-mono pt-2 border-t border-slate-100">
                            {{ $rel->published_at?->format('d M Y') }}
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
