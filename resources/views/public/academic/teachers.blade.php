@extends('layouts.public.app')

@section('title', 'Direktori Guru & Tendik - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-10 sm:py-14 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Akademik' => '', 'Guru & Tendik' => '']" />
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">Direktori Guru & Tenaga Kependidikan</h1>
        <p class="text-slate-300 text-xs sm:text-sm md:text-base max-w-2xl leading-relaxed">Daftar profil tenaga pengajar dan staf kependidikan profesional {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8 sm:space-y-12" x-data="{ activeTab: 'teachers' }">
    
    <!-- Tab Controls (Responsive flex-wrap) -->
    <div class="flex justify-center border-b border-slate-200 pb-1">
        <div class="flex flex-wrap justify-center gap-2 sm:gap-4 w-full sm:w-auto">
            <button @click="activeTab = 'teachers'" 
                    :class="activeTab === 'teachers' ? 'border-emerald-800 text-emerald-800 font-extrabold bg-emerald-50/60' : 'border-transparent text-slate-500 hover:text-slate-800'" 
                    class="py-2.5 sm:py-3 px-4 sm:px-6 text-xs sm:text-sm rounded-t-xl border-b-2 transition-all flex items-center gap-2">
                <span>👨‍🏫 Guru & Pendidik</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs bg-emerald-100 text-emerald-800 font-bold">{{ $teachers->count() }}</span>
            </button>
            <button @click="activeTab = 'staff'" 
                    :class="activeTab === 'staff' ? 'border-emerald-800 text-emerald-800 font-extrabold bg-amber-50/60' : 'border-transparent text-slate-500 hover:text-slate-800'" 
                    class="py-2.5 sm:py-3 px-4 sm:px-6 text-xs sm:text-sm rounded-t-xl border-b-2 transition-all flex items-center gap-2">
                <span>👔 Tenaga Kependidikan</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs bg-amber-100 text-amber-900 font-bold">{{ $staffMembers->count() }}</span>
            </button>
        </div>
    </div>

    <!-- Tab 1: Teachers Grid -->
    <div x-show="activeTab === 'teachers'" class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @forelse($teachers as $teacher)
                <x-card :hover="true" class="text-center space-y-4 p-5 sm:p-6 flex flex-col justify-between">
                    <div class="space-y-3">
                        @if($teacher->photo)
                            <img src="{{ asset($teacher->photo) }}" alt="{{ $teacher->full_name }}" class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-2xl object-cover border-2 border-emerald-800 shadow-md">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-2xl bg-emerald-800 text-amber-400 font-black text-2xl sm:text-3xl flex items-center justify-center border-2 border-amber-400 shadow-md">
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug">{{ $teacher->full_name }}</h3>
                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIP: {{ $teacher->nip ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                            📚 {{ $teacher->subject }}
                        </span>
                    </div>
                </x-card>
            @empty
                <div class="col-span-4 py-12 text-center text-slate-400 text-xs sm:text-sm">
                    Belum ada data guru terdaftar.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tab 2: Staff Grid -->
    <div x-show="activeTab === 'staff'" class="space-y-6" style="display: none;">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @forelse($staffMembers as $staff)
                <x-card :hover="true" class="text-center space-y-4 p-5 sm:p-6 flex flex-col justify-between">
                    <div class="space-y-3">
                        @if($staff->photo)
                            <img src="{{ asset($staff->photo) }}" alt="{{ $staff->name }}" class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-2xl object-cover border-2 border-amber-500 shadow-md">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-2xl bg-amber-500 text-emerald-950 font-black text-2xl sm:text-3xl flex items-center justify-center border-2 border-amber-400 shadow-md">
                                {{ strtoupper(substr($staff->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug">{{ $staff->name }}</h3>
                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">NIP: {{ $staff->nip ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            👔 {{ $staff->position }}
                        </span>
                    </div>
                </x-card>
            @empty
                <div class="col-span-4 py-12 text-center text-slate-400 text-xs sm:text-sm">
                    Belum ada data tenaga kependidikan terdaftar.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

