@extends('layouts.public.app')

@section('title', $news->title . ' - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Berita & Informasi' => route('news.index'), Str::limit($news->title, 25) => '']" />
        <div class="flex items-center gap-3 text-xs pt-1">
            <span class="px-2.5 py-0.5 rounded-full font-bold bg-amber-500 text-emerald-950 text-[10px]">
                {{ $news->category->name ?? 'Umum' }}
            </span>
            <span class="text-slate-300">{{ $news->published_at?->format('d M Y, H:i') }} WIB</span>
            <span class="text-slate-400">&bull; 👁️ {{ $news->views_count }} views</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-extrabold leading-tight">{{ $news->title }}</h1>
        <div class="text-xs text-slate-300">Oleh: <strong>{{ $news->author->name ?? 'Admin SMAN 24' }}</strong></div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <x-card :hover="false" class="p-6 sm:p-8 space-y-6 text-slate-800 text-sm leading-relaxed">
        @if($news->thumbnail)
            <div class="w-full max-h-96 rounded-2xl overflow-hidden shadow-md border border-slate-200">
                <img src="{{ asset($news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="whitespace-pre-line leading-relaxed text-slate-700 text-sm sm:text-base">
            {{ $news->content }}
        </div>
    </x-card>

    @if($relatedNews->isNotEmpty())
        <div class="space-y-4">
            <h3 class="text-base font-bold text-slate-900">Berita Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedNews as $rel)
                    <x-card :hover="true" class="p-5 space-y-2">
                        <a href="{{ route('news.show', $rel->slug) }}" class="block space-y-2">
                            <span class="text-[10px] font-bold text-emerald-800 block">{{ $rel->category->name ?? 'Umum' }}</span>
                            <h4 class="font-bold text-slate-900 text-xs line-clamp-2">{{ $rel->title }}</h4>
                        </a>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
