@extends('layouts.public.app')

@section('title', 'Kalender Akademik - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Akademik' => '', 'Kalender Akademik' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Kalender Akademik Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Jadwal kegiatan pembelajaran, penilaian semester, dan libur akademik {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <x-card :hover="false" class="space-y-4">
        <div class="space-y-4">
            @forelse($calendars as $cal)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-slate-200 bg-slate-50 gap-2">
                    <div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 uppercase">{{ $cal->academic_year }} - Semester {{ ucfirst($cal->semester) }}</span>
                        <h3 class="font-bold text-slate-900 text-sm mt-1">{{ $cal->title }}</h3>
                        <p class="text-xs text-slate-500">{{ $cal->description }}</p>
                    </div>
                    <div class="text-left sm:text-right text-xs font-bold text-emerald-800 font-mono">
                        {{ $cal->start_date?->format('d M Y') }}
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-xs text-slate-400">Belum ada agenda kalender akademik terdaftar.</div>
            @endforelse
        </div>
    </x-card>
</div>
@endsection
