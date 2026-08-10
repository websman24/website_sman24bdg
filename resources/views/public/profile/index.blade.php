@extends('layouts.public.app')

@section('title', 'Profil Sekolah - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Profil Sekolah' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Profil {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Mengenal lebih dekat sejarah, visi misi, serta sambutan pimpinan SMA Negeri 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- Sambutan Kepala Sekolah Card -->
    <x-card :hover="false" class="bg-gradient-to-br from-emerald-900 to-slate-900 text-white space-y-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 border-b border-emerald-800/80 pb-6">
            @if(\App\Models\Setting::getValue('principal_photo'))
                <img src="{{ asset(\App\Models\Setting::getValue('principal_photo')) }}" alt="{{ \App\Models\Setting::getValue('principal_name', 'Kepala Sekolah') }}" class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl object-cover border-4 border-amber-400 shadow-lg flex-shrink-0">
            @else
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl bg-emerald-800 flex items-center justify-center text-amber-400 font-extrabold text-4xl border-4 border-amber-400 shadow-lg flex-shrink-0">
                    👔
                </div>
            @endif
            <div class="space-y-2 text-center sm:text-left">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-400 text-emerald-950 inline-block">Sambutan Pimpinan</span>
                <h2 class="text-2xl font-extrabold text-white">{{ \App\Models\Setting::getValue('principal_name', 'Drs. H. Solihin, M.Pd.') }}</h2>
                <p class="text-xs text-emerald-200 font-medium">{{ \App\Models\Setting::getValue('principal_title', 'Kepala SMA Negeri 24 Bandung') }}</p>
            </div>
        </div>
        <div class="text-xs sm:text-sm text-slate-200 leading-relaxed italic space-y-3">
            <p>
                "{{ $profiles['sambutan_kepala_sekolah']->content ?? 'Selamat datang di website resmi SMA Negeri 24 Bandung. Kami berkomitmen untuk terus meningkatkan mutu pendidikan, membangun karakter peserta didik yang berakhlak mulia, cerdas, dan siap bersaing di tingkat global.' }}"
            </p>
        </div>
    </x-card>

    <!-- Sejarah / Identity Card -->
    <x-card :hover="false" class="space-y-4">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
            <span class="text-2xl">🏛️</span>
            <h2 class="text-xl font-bold text-slate-900">Sejarah Singkat SMAN 24 Bandung</h2>
        </div>
        <p class="text-slate-700 text-sm leading-relaxed">
            {{ $profiles['sejarah']->content ?? 'SMA Negeri 24 Bandung berlokasi di ' . \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') . '. Sekolah ini berkomitmen mencetak generasi unggul yang cerdas, santun, dan berdaya saing tinggi di era global.' }}
        </p>
    </x-card>

    <!-- Visi Misi Card -->
    <x-card :hover="false" class="bg-slate-50 space-y-4">
        <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
            <span class="text-2xl">🎯</span>
            <h2 class="text-xl font-bold text-slate-900">Visi & Misi Sekolah</h2>
        </div>
        <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
            {{ $profiles['visi_misi']->content ?? "Visi:\nTerwujudnya sekolah berkarakter, unggul dalam prestasi akademik dan non-akademik, serta berwawasan global." }}
        </div>
    </x-card>
</div>
@endsection
