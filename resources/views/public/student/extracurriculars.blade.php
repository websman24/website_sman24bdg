@extends('layouts.public.app')

@section('title', 'Ekstrakurikuler - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Kesiswaan' => '', 'Ekstrakurikuler' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Kegiatan Ekstrakurikuler</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Wadah pengembangan minat, bakat, kepemimpinan, dan karakter siswa {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Search & Filter Bar -->
    <form action="{{ route('student.extracurriculars') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama ekskul, pembina, atau kegiatan..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        <div class="flex gap-2 items-center overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('student.extracurriculars') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ !request('category') ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Semua Kategori</a>
            @foreach($categories as $cat)
                <a href="{{ route('student.extracurriculars', ['category' => $cat]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('category') === $cat ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </form>

    <!-- Extracurriculars Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($extracurriculars as $extra)
            <x-card :hover="true" class="p-6 space-y-5 flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        @if($extra->logo_or_photo)
                            <img src="{{ asset($extra->logo_or_photo) }}" alt="{{ $extra->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-800/40 shadow-md group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-800 to-slate-900 text-amber-400 font-black text-2xl flex items-center justify-center border-2 border-amber-400/40 shadow-md">
                                🏆
                            </div>
                        @endif

                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            {{ $extra->category }}
                        </span>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900 text-lg leading-snug group-hover:text-emerald-800 transition-colors">{{ $extra->name }}</h3>
                        @if($extra->schedule)
                            <p class="text-xs font-mono text-emerald-800 font-bold mt-1 flex items-center gap-1">
                                🕒 {{ $extra->schedule }}
                            </p>
                        @endif
                        @if($extra->description)
                            <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">{{ $extra->description }}</p>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Pembina: <strong>{{ $extra->mentor_name ?? 'Tim Kesiswaan SMAN 24' }}</strong></span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">Aktif</span>
                </div>
            </x-card>
        @empty
            <div class="col-span-3 py-16 bg-white rounded-3xl border border-slate-200 text-center space-y-3">
                <div class="text-4xl">🏆</div>
                <h3 class="text-base font-bold text-slate-800">Belum ada data ekstrakurikuler</h3>
                <p class="text-xs text-slate-500">Daftar ekstrakurikuler akan ditampilkan di halaman ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
