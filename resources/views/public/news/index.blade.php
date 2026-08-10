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
            <a href="{{ route('news.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ !request('category') ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Semua Kategori</a>
            @foreach($categories as $cat)
                <a href="{{ route('news.index', ['category' => $cat->slug]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('category') === $cat->slug ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $cat->name }} ({{ $cat->news_count }})
                </a>
            @endforeach
        </div>
    </form>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($newsList as $news)
            <x-card :hover="true" class="flex flex-col justify-between p-0 overflow-hidden group">
                <div>
                    @if($news->thumbnail)
                        <div class="w-full h-52 overflow-hidden bg-slate-100 relative">
                            <img src="{{ asset($news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="w-full h-52 bg-gradient-to-br from-emerald-900 via-emerald-800 to-slate-900 flex items-center justify-center relative p-6 text-center">
                            <span class="text-4xl opacity-80">📰</span>
                        </div>
                    @endif
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="px-3 py-1 rounded-full font-extrabold bg-amber-100 text-amber-900 text-[10px] border border-amber-200">
                                {{ $news->category->name ?? 'Umum' }}
                            </span>
                            <span class="text-slate-400 text-[11px] font-medium">{{ $news->published_at?->format('d M Y') }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-2">
                            <a href="{{ route('news.show', $news->slug) }}" class="hover:text-emerald-800 transition-colors">
                                {{ $news->title }}
                            </a>
                        </h3>
                        <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">{{ $news->excerpt }}</p>
                    </div>
                </div>
                <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span class="font-mono text-[11px]">👁️ {{ number_format($news->views_count) }} views</span>
                    <a href="{{ route('news.show', $news->slug) }}" class="font-bold text-emerald-800 hover:underline flex items-center gap-1">
                        <span>Baca Berita</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </x-card>
        @empty
            <div class="col-span-3 py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                <div class="text-4xl">📰</div>
                <h3 class="text-base font-bold text-slate-800">Tidak ada berita ditemukan</h3>
                <p class="text-xs text-slate-500">Silakan gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('news.index') }}" class="inline-block mt-2 px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700">
                    Lihat Semua Berita
                </a>
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
