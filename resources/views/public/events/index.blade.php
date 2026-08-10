@extends('layouts.public.app')

@section('title', 'Agenda Kegiatan Sekolah - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Agenda Sekolah' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Agenda & Jadwal Kegiatan Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Jadwal kegiatan akademik & kesiswaan SMAN 24 Bandung (MPLS, Ujian, Rapat, Upacara, Kegiatan Siswa, Libur).</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Filter & Search Bar -->
    <form action="{{ route('events.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama agenda, lokasi, atau deskripsi..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        <div class="flex gap-2 items-center overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('events.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ !request('status') ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Semua Agenda</a>
            <a href="{{ route('events.index', ['status' => 'upcoming']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('status') === 'upcoming' ? 'bg-sky-700 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Mendatang ({{ $upcomingCount }})
            </a>
            <a href="{{ route('events.index', ['status' => 'ongoing']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('status') === 'ongoing' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Berlangsung ({{ $ongoingCount }})
            </a>
            <a href="{{ route('events.index', ['status' => 'completed']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('status') === 'completed' ? 'bg-slate-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Selesai ({{ $completedCount }})
            </a>
        </div>
    </form>

    <!-- Agenda Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($events as $event)
            <x-card :hover="true" class="flex flex-col justify-between p-0 overflow-hidden group">
                <div>
                    @if($event->banner)
                        <div class="w-full h-44 overflow-hidden bg-slate-100 relative">
                            <img src="{{ asset($event->banner) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="w-full h-28 bg-gradient-to-r from-emerald-900 to-slate-900 p-6 flex items-center justify-between text-white relative">
                            <div class="space-y-1">
                                <span class="text-xs text-amber-400 font-extrabold uppercase">Agenda SMAN 24</span>
                                <h4 class="font-bold text-sm line-clamp-1">{{ $event->title }}</h4>
                            </div>
                            <span class="text-3xl">📅</span>
                        </div>
                    @endif

                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="px-3 py-1 rounded-full font-extrabold text-[10px] uppercase border
                                @if($event->status === 'upcoming') bg-sky-100 text-sky-800 border-sky-300
                                @elseif($event->status === 'ongoing') bg-amber-100 text-amber-900 border-amber-300
                                @elseif($event->status === 'completed') bg-slate-100 text-slate-600 border-slate-300
                                @else bg-rose-100 text-rose-800 border-rose-300 @endif">
                                {{ $event->status === 'upcoming' ? 'Mendatang' : ($event->status === 'ongoing' ? 'Berlangsung' : ($event->status === 'completed' ? 'Selesai' : 'Dibatalkan')) }}
                            </span>
                            <span class="text-slate-500 font-bold text-xs flex items-center gap-1">
                                🕒 {{ $event->start_date?->format('H:i') }} WIB
                            </span>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="bg-emerald-50 text-emerald-900 rounded-2xl p-3 text-center min-w-[64px] border border-emerald-200">
                                <span class="block text-[10px] font-extrabold uppercase text-emerald-700 tracking-wider">
                                    {{ $event->start_date?->format('M') }}
                                </span>
                                <span class="block text-2xl font-black text-emerald-950">
                                    {{ $event->start_date?->format('d') }}
                                </span>
                                <span class="block text-[9px] font-bold text-slate-500">
                                    {{ $event->start_date?->format('Y') }}
                                </span>
                            </div>

                            <div class="space-y-1.5 flex-1 min-w-0">
                                <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-2">
                                    <a href="{{ route('events.show', $event->slug) }}" class="hover:text-emerald-800 transition-colors">
                                        {{ $event->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                    📍 {{ $event->location }}
                                </p>
                            </div>
                        </div>

                        @if($event->description)
                            <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed pt-1">
                                {{ Str::limit(strip_tags($event->description), 120) }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-mono text-[11px]">
                        @if($event->end_date)
                            s.d. {{ $event->end_date->format('d M Y') }}
                        @else
                            1 Hari Kegiatan
                        @endif
                    </span>
                    <a href="{{ route('events.show', $event->slug) }}" class="font-extrabold text-emerald-800 hover:underline flex items-center gap-1">
                        <span>Detail Agenda</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </x-card>
        @empty
            <div class="col-span-3 py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                <div class="text-4xl">🗓️</div>
                <h3 class="text-base font-bold text-slate-800">Belum ada agenda kegiatan</h3>
                <p class="text-xs text-slate-500">Agenda kegiatan sekolah akan segera diperbarui di halaman ini.</p>
                <a href="{{ route('events.index') }}" class="inline-block mt-2 px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700">
                    Lihat Semua Agenda
                </a>
            </div>
        @endforelse
    </div>

    @if($events->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection
