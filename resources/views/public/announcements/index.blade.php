@extends('layouts.public.app')

@section('title', 'Pengumuman Resmi - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Pengumuman Resmi' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Pengumuman & Informasi Resmi</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Pemberitahuan resmi dan instruksi akademik bagi seluruh civitas akademika SMA Negeri 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Search Bar -->
    <form action="{{ route('announcements.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi pengumuman..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        @if(request('search'))
            <a href="{{ route('announcements.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                Reset Pencarian
            </a>
        @endif
    </form>

    <!-- Announcements Cards List -->
    <div class="space-y-6">
        @forelse($announcements as $item)
            <x-card :hover="true" class="p-6 sm:p-8 space-y-4 border-l-4 {{ $item->is_pinned ? 'border-l-amber-500 bg-amber-50/30' : 'border-l-emerald-700 bg-white' }}">
                <div class="flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2">
                        @if($item->is_pinned)
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-amber-500 text-emerald-950 uppercase tracking-wider">
                                📌 Pengumuman Penting (Pinned)
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                📢 Info Resmi
                            </span>
                        @endif
                        <span class="text-slate-400 font-mono text-[11px]">
                            {{ $item->published_at?->format('d M Y, H:i') ?? $item->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>

                    @if($item->attachment_file)
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200 flex items-center gap-1">
                            📎 Terdapat Lampiran Berkas
                        </span>
                    @endif
                </div>

                <h3 class="text-xl font-bold text-slate-900 leading-snug">
                    <a href="{{ route('announcements.show', $item->slug) }}" class="hover:text-emerald-800 transition-colors">
                        {{ $item->title }}
                    </a>
                </h3>

                <p class="text-slate-600 text-xs sm:text-sm line-clamp-3 leading-relaxed">
                    {{ Str::limit(strip_tags($item->content), 200) }}
                </p>

                <div class="pt-2 flex items-center justify-between border-t border-slate-100 text-xs">
                    <span class="text-slate-500">Oleh: <strong>{{ $item->author->name ?? 'Tim Humas SMAN 24' }}</strong></span>
                    <a href="{{ route('announcements.show', $item->slug) }}" class="font-extrabold text-emerald-800 hover:underline flex items-center gap-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </x-card>
        @empty
            <div class="py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                <div class="text-4xl">📢</div>
                <h3 class="text-base font-bold text-slate-800">Belum ada pengumuman terbit</h3>
                <p class="text-xs text-slate-500">Pengumuman resmi sekolah akan ditampilkan di halaman ini.</p>
            </div>
        @endforelse
    </div>

    @if($announcements->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection
