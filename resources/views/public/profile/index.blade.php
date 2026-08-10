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
