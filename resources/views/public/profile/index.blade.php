@extends('layouts.public.app')

@section('title', 'Profil Sekolah - SMA Negeri 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Profil SMA Negeri 24 Bandung</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Mengenal lebih dekat sejarah, visi misi, dan fasilitas sekolah.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Sejarah / Identity -->
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-3">Sejarah Singkat SMAN 24 Bandung</h2>
        <p class="text-slate-700 text-sm leading-relaxed">
            {{ $profiles['sejarah']->content ?? 'SMA Negeri 24 Bandung berlokasi di Jl. A.H. Nasution No. 27, Kota Bandung. Sekolah ini berkomitmen mencetak generasi unggul yang cerdas, santun, dan berdaya saing tinggi di era global.' }}
        </p>
    </div>

    <!-- Visi Misi -->
    <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-3">Visi & Misi</h2>
        <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
            {{ $profiles['visi_misi']->content ?? "Visi:\nTerwujudnya sekolah berkarakter, unggul dalam prestasi akademik dan non-akademik, serta berwawasan global." }}
        </p>
    </div>
</div>
@endsection
