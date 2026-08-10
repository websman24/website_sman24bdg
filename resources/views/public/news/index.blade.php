@extends('layouts.public.app')

@section('title', 'Berita & Informasi - SMA Negeri 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Berita & Informasi Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Dapatkan informasi terkini seputar kegiatan dan prestasi SMAN 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Filter & Search Bar -->
    <form action="{{ route('news.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between">
        <div class="flex-1 flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-800 text-white font-bold text-xs hover:bg-emerald-900 transition-colors">Cari</button>
        </div>
        <div class="flex gap-2 items-center overflow-x-auto pb-2 md:pb-0">
            <a href="{{ route('news.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ !request('category') ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('news.index', ['category' => $cat->slug]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request('category') === $cat->slug ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $cat->name }} ({{ $cat->news_count }})
                </a>
            @endforeach
        </div>
    </form>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($newsList as $news)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between overflow-hidden card-hover-effect">
                <div class="p-6 space-y-3">
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
            </div>
        @empty
            <div class="col-span-3 py-12 text-center text-slate-400 text-xs">
                Tidak ada berita ditemukan.
            </div>
        @endforelse
    </div>

    @if($newsList->hasPages())
        <div class="pt-4">
            {{ $newsList->links() }}
        </div>
    @endif
</div>
@endsection
