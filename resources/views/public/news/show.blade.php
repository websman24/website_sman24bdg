@extends('layouts.public.app')

@section('title', $news->title . ' - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <div class="flex items-center gap-3 text-xs">
            <span class="px-2.5 py-0.5 rounded-full font-bold bg-amber-500 text-emerald-950">
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
    <article class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6 text-slate-800 text-sm leading-relaxed whitespace-pre-line">
        {{ $news->content }}
    </article>

    @if($relatedNews->isNotEmpty())
        <div class="space-y-4">
            <h3 class="text-base font-bold text-slate-900">Berita Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedNews as $rel)
                    <a href="{{ route('news.show', $rel->slug) }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-700 transition-all space-y-2">
                        <span class="text-[10px] font-bold text-emerald-800">{{ $rel->category->name ?? 'Umum' }}</span>
                        <h4 class="font-bold text-slate-900 text-xs line-clamp-2">{{ $rel->title }}</h4>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
