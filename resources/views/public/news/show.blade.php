@extends('layouts.public.app')

@section('title', $news->title . ' - SMA Negeri 24 Bandung')
@section('meta_description', Str::limit(strip_tags($news->excerpt ?? $news->content), 160))
@section('og_title', $news->title)
@section('og_description', Str::limit(strip_tags($news->excerpt ?? $news->content), 160))
@section('og_image', asset($news->thumbnail ?? \App\Models\Setting::getValue('school_logo', 'storage/uploads/settings/school_logo.png')))
@section('og_type', 'article')

@section('extra_json_ld')
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "{{ '@type' }}": "NewsArticle",
  "headline": "{{ addslashes($news->title) }}",
  "image": [
    "{{ asset($news->thumbnail ?? \App\Models\Setting::getValue('school_logo', 'storage/uploads/settings/school_logo.png')) }}"
  ],
  "datePublished": "{{ $news->published_at?->toIso8601String() ?? $news->created_at->toIso8601String() }}",
  "dateModified": "{{ $news->updated_at->toIso8601String() }}",
  "author": [{
      "{{ '@type' }}": "Person",
      "name": "{{ addslashes($news->author->name ?? 'Admin SMAN 24') }}"
  }],
  "publisher": {
    "{{ '@type' }}": "Organization",
    "name": "{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}",
    "logo": {
      "{{ '@type' }}": "ImageObject",
      "url": "{{ asset(\App\Models\Setting::getValue('school_logo', 'storage/uploads/settings/school_logo.png')) }}"
    }
  },
  "description": "{{ addslashes(Str::limit(strip_tags($news->excerpt ?? $news->content), 200)) }}"
}
</script>
@endsection

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-10 sm:py-14 border-b border-emerald-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <x-breadcrumb :items="['Berita & Informasi' => route('news.index'), Str::limit($news->title, 25) => '']" />
        <div class="flex flex-wrap items-center gap-2.5 text-xs pt-1">
            <span class="px-3 py-1 rounded-full font-extrabold bg-amber-500 text-emerald-950 text-[10px] sm:text-xs uppercase shadow-sm">
                {{ $news->category->name ?? 'Umum' }}
            </span>
            <span class="text-slate-300 font-mono text-xs">{{ $news->published_at?->format('d M Y, H:i') }} WIB</span>
            <span class="text-slate-400 font-mono text-xs">&bull; 👁️ {{ number_format($news->views_count) }} views</span>
        </div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight text-white tracking-tight">{{ $news->title }}</h1>
        <div class="text-xs sm:text-sm text-slate-300 flex flex-wrap items-center gap-2">
            <span>Dipublikasikan oleh:</span>
            <span class="font-bold text-amber-400 bg-white/10 px-2.5 py-0.5 rounded-lg border border-white/20">{{ $news->author->name ?? 'Admin SMAN 24' }}</span>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">
    <x-card :hover="false" class="p-5 sm:p-8 lg:p-10 space-y-6 sm:space-y-8 text-slate-800">
        @if($news->thumbnail)
            <div class="w-full max-h-[480px] rounded-2xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100">
                <img src="{{ asset($news->thumbnail) }}" alt="{{ $news->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
            </div>
        @endif

        @if($news->excerpt)
            <div class="p-4 sm:p-5 bg-emerald-50/90 rounded-2xl border-l-4 border-emerald-700 text-emerald-950 text-sm sm:text-base font-medium italic leading-relaxed">
                "{{ $news->excerpt }}"
            </div>
        @endif

        <div class="prose prose-slate prose-emerald max-w-none text-slate-800 leading-relaxed text-sm sm:text-base">
            {!! clean($news->content) !!}
        </div>

        <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ route('news.index') }}" class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm transition-colors">
                &larr; Kembali ke Berita & Informasi
            </a>
            <div class="text-xs text-slate-400 font-mono text-center sm:text-right">
                Publikasi Resmi SMA Negeri 24 Bandung
            </div>
        </div>
    </x-card>

    @if($relatedNews->isNotEmpty())
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg sm:text-xl font-bold text-slate-900">Artikel Berita Terkait</h3>
                <a href="{{ route('news.index') }}" class="text-xs sm:text-sm font-bold text-emerald-800 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedNews as $rel)
                    <x-card :hover="true" class="p-5 space-y-3 flex flex-col justify-between overflow-hidden">
                        <div class="space-y-2.5">
                            @if($rel->thumbnail)
                                <div class="w-full aspect-video rounded-xl overflow-hidden bg-slate-100 mb-2">
                                    <img src="{{ asset($rel->thumbnail) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <span class="text-[10px] font-extrabold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200 inline-block">
                                {{ $rel->category->name ?? 'Umum' }}
                            </span>
                            <h4 class="font-bold text-slate-900 text-sm line-clamp-2 leading-snug">
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
