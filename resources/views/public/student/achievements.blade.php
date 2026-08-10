@extends('layouts.public.app')

@section('title', 'Prestasi Siswa - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Prestasi Siswa & Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Capaian membanggakan siswa SMAN 24 Bandung di tingkat Kota, Provinsi, Nasional, & Internasional.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($achievements as $ach)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300 uppercase">
                        Tingkat {{ $ach->level }}
                    </span>
                    <span class="text-xs font-bold text-slate-400 font-mono">{{ $ach->achievement_year }}</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base leading-snug">{{ $ach->title }}</h3>
                <p class="text-xs text-slate-600">Pemenang: <strong>{{ $ach->winner_name }}</strong> ({{ $ach->event_name }})</p>
            </div>
        @empty
            <div class="col-span-2 py-8 text-center text-xs text-slate-400">Belum ada data prestasi terdaftar.</div>
        @endforelse
    </div>
</div>
@endsection
