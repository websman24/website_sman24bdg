@extends('layouts.public.app')

@section('title', 'Ekstrakurikuler - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Kesiswaan' => '', 'Ekstrakurikuler' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Ekstrakurikuler Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Wadah pengembangan minat, bakat, kepemimpinan, dan karakter siswa {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($extracurriculars as $extra)
            <x-card :hover="true" class="space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                            {{ $extra->category }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-medium font-mono">{{ $extra->schedule ?? 'Jadwal Rutin' }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg">{{ $extra->name }}</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $extra->description }}</p>
                    </div>
                </div>
                @if($extra->mentor_name)
                    <div class="pt-3 border-t border-slate-100 text-xs text-slate-500">
                        Pembina: <strong>{{ $extra->mentor_name }}</strong>
                    </div>
                @endif
            </x-card>
        @empty
            <div class="col-span-3 py-12 text-center text-slate-400 text-xs">
                Belum ada data ekstrakurikuler terdaftar.
            </div>
        @endforelse
    </div>
</div>
@endsection
