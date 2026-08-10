@extends('layouts.public.app')

@section('title', 'Prestasi Siswa - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Kesiswaan' => '', 'Prestasi Siswa' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Prestasi Siswa & Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Capaian membanggakan siswa {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }} di tingkat Kota, Provinsi, Nasional, dan Internasional.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($achievements as $ach)
            <x-card :hover="true" class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300 uppercase">
                        Tingkat {{ $ach->level }}
                    </span>
                    <span class="text-xs font-bold text-slate-400 font-mono">{{ $ach->achievement_year }}</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base leading-snug">{{ $ach->title }}</h3>
                <p class="text-xs text-slate-600">Pemenang: <strong>{{ $ach->winner_name }}</strong> ({{ $ach->event_name }})</p>
            </x-card>
        @empty
            <div class="col-span-2 py-8 text-center text-xs text-slate-400">Belum ada data prestasi terdaftar.</div>
        @endforelse
    </div>
</div>
@endsection
