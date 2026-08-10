@extends('layouts.public.app')

@section('title', 'Berita & Informasi - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Berita & Informasi' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Berita & Informasi Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Dapatkan publikasi informasi dan kearsipan berita terkini SMA Negeri 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Filter & Search Bar -->
    <form action="{{ route('news.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau kata kunci berita..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        <div class="flex gap-2 items-center overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('news.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap {{ !request('category') ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('news.index', ['category' => $cat->slug]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap {{ request('category') === $cat->slug ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $cat->name }} ({{ $cat->news_count }})
                </a>
            @endforeach
        </div>
    </form>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($newsList as $news)
            <x-card :hover="true" class="flex flex-col justify-between p-0 overflow-hidden">
                @if($news->thumbnail)
                    <div class="w-full h-48 overflow-hidden bg-slate-100 relative group">
                        <img src="{{ asset($news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                @endif
                <div class="p-6 space-y-3 flex-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="px-2.5 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800 text-[10px]">
                            {{ $news->category->name ?? 'Umum' }}
                        </span>
                        <span class="text-slate-400 text-[11px]">{{ $news->published_at?->format('d M Y') }}</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-2">
                        <a href="{{ route('news.show', $news->slug) }}" class="hover:text-emerald-800 transition-colors">
                            {{ $news->title }}
                        </a>
                    </h3>
                    <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">{{ $news->excerpt }}</p>
                </div>
                <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>👁️ {{ $news->views_count }} views</span>
                    <a href="{{ route('news.show', $news->slug) }}" class="font-bold text-emerald-800 hover:underline">Baca Selengkapnya &rarr;</a>
                </div>
            </x-card>
        @empty
            <div class="col-span-3 py-12 text-center text-slate-400 text-xs">
                Tidak ada berita ditemukan.
            </div>
        @endforelse
    </div>

    @if($newsList->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $newsList->links() }}
        </div>
    @endif
</div>
@endsection
