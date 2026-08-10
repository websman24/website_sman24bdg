@extends('layouts.public.app')

@section('title', 'Direktori Guru & Tendik - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Direktori Guru & Tenaga Kependidikan</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Daftar tenaga pengajar profesional SMA Negeri 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($teachers as $teacher)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center space-y-3 card-hover-effect">
                <div class="w-20 h-20 mx-auto rounded-full bg-emerald-800 text-white font-extrabold text-2xl flex items-center justify-center shadow-md">
                    {{ strtoupper(substr($teacher->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">{{ $teacher->full_name }}</h3>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">NIP: {{ $teacher->nip ?? '-' }}</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                        {{ $teacher->subject }}
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-4 py-12 text-center text-slate-400 text-xs">
                Belum ada data guru terdaftar.
            </div>
        @endforelse
    </div>

    @if($teachers->hasPages())
        <div class="pt-8">
            {{ $teachers->links() }}
        </div>
    @endif
</div>
@endsection
