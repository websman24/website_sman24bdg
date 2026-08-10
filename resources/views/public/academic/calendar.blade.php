@extends('layouts.public.app')

@section('title', 'Kalender Akademik - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Kalender Akademik Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Jadwal kegiatan pembelajaran dan ujian SMAN 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="space-y-4">
            @forelse($calendars as $cal)
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 bg-slate-50">
                    <div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 uppercase">{{ $cal->academic_year }} - Semester {{ ucfirst($cal->semester) }}</span>
                        <h3 class="font-bold text-slate-900 text-sm mt-1">{{ $cal->title }}</h3>
                        <p class="text-xs text-slate-500">{{ $cal->description }}</p>
                    </div>
                    <div class="text-right text-xs font-bold text-emerald-800">
                        {{ $cal->start_date?->format('d M Y') }}
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-xs text-slate-400">Belum ada kalender akademik terdaftar.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
