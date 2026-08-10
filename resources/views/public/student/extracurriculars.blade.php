@extends('layouts.public.app')

@section('title', 'Ekstrakurikuler - SMA Negeri 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Ekstrakurikuler Sekolah</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Wadah pengembangan minat, bakat, dan karakter siswa SMAN 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($extracurriculars as $extra)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 card-hover-effect">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                        {{ $extra->category }}
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">{{ $extra->schedule ?? 'Jadwal Rutin' }}</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-lg">{{ $extra->name }}</h3>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $extra->description }}</p>
                </div>
                @if($extra->mentor_name)
                    <div class="pt-3 border-t border-slate-100 text-xs text-slate-500">
                        Pembina: <strong>{{ $extra->mentor_name }}</strong>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-3 py-12 text-center text-slate-400 text-xs">
                Belum ada data ekstrakurikuler terdaftar.
            </div>
        @endforelse
    </div>
</div>
@endsection
