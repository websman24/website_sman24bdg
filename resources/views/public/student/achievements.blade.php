@extends('layouts.public.app')

@section('title', 'Prestasi Siswa & Sekolah - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Kesiswaan' => '', 'Prestasi Siswa' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Prestasi & Gemilang Siswa</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Rekam jejak dan capaian membanggakan siswa {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }} di tingkat Kota, Provinsi, Nasional, dan Internasional.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Search & Filter Bar -->
    <form action="{{ route('student.achievements') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pemenang, judul prestasi, atau nama lomba..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        <div class="flex flex-wrap md:flex-nowrap gap-2 items-center w-full md:w-auto">
            <a href="{{ route('student.achievements') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ !request('category') && !request('level') ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Semua Prestasi</a>
            <a href="{{ route('student.achievements', ['category' => 'akademik']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('category') === 'akademik' ? 'bg-sky-700 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Akademik</a>
            <a href="{{ route('student.achievements', ['category' => 'non_akademik']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('category') === 'non_akademik' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Non-Akademik</a>
        </div>
    </form>

    <!-- Achievements Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($achievements as $ach)
            <x-card :hover="true" class="p-0 overflow-hidden space-y-0 flex flex-col justify-between group">
                <div>
                    @if($ach->photo)
                        <div class="w-full h-48 overflow-hidden bg-slate-100 relative">
                            <img src="{{ asset($ach->photo) }}" alt="{{ $ach->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="w-full h-28 bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 p-6 flex items-center justify-between text-white relative">
                            <div class="space-y-1">
                                <span class="text-xs text-amber-400 font-extrabold uppercase">Prestasi SMAN 24</span>
                                <h4 class="font-bold text-sm line-clamp-1">{{ $ach->winner_name }}</h4>
                            </div>
                            <span class="text-3xl">🥇</span>
                        </div>
                    @endif

                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase bg-amber-500/20 text-amber-900 border border-amber-300">
                                🏆 Tingkat {{ strtoupper($ach->level) }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase {{ $ach->category === 'akademik' ? 'bg-sky-50 text-sky-800 border border-sky-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200' }}">
                                {{ $ach->category === 'akademik' ? 'Akademik' : 'Non-Akademik' }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-emerald-800 transition-colors">
                                {{ $ach->title }}
                            </h3>
                            <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                👤 Pemenang: <strong class="text-slate-800">{{ $ach->winner_name }}</strong>
                            </p>
                            <p class="text-xs text-slate-500">
                                🎪 Event: {{ $ach->event_name }}
                            </p>
                        </div>

                        @if($ach->description)
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed pt-1 border-t border-slate-100">
                                {{ $ach->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Tahun Perolehan:</span>
                    <span class="font-mono font-black text-emerald-800 text-xs">{{ $ach->achievement_year }}</span>
                </div>
            </x-card>
        @empty
            <div class="col-span-3 py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                <div class="text-4xl">🏅</div>
                <h3 class="text-base font-bold text-slate-800">Belum ada data prestasi</h3>
                <p class="text-xs text-slate-500">Capaian prestasi siswa akan ditampilkan di halaman ini.</p>
            </div>
        @endforelse
    </div>

    @if($achievements->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $achievements->links() }}
        </div>
    @endif
</div>
@endsection
