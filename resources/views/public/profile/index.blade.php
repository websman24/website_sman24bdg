@extends('layouts.public.app')

@section('title', 'Profil Sekolah - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-10 sm:py-14 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Profil Sekolah' => '']" />
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">Profil {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}</h1>
        <p class="text-slate-300 text-xs sm:text-sm md:text-base max-w-2xl leading-relaxed">Mengenal lebih dekat sejarah, visi misi, serta sambutan pimpinan SMA Negeri 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8 sm:space-y-12">

    <!-- Sambutan Kepala Sekolah Card -->
    <div class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-slate-950 text-white rounded-3xl p-6 sm:p-8 lg:p-10 space-y-6 shadow-xl border border-emerald-800/80" x-data="{ expanded: false }">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6 border-b border-emerald-800/80 pb-6 text-center sm:text-left">
            @if(\App\Models\Setting::getValue('principal_photo'))
                <img src="{{ asset(\App\Models\Setting::getValue('principal_photo')) }}" alt="{{ \App\Models\Setting::getValue('principal_name', 'Kepala Sekolah') }}" class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl object-cover border-4 border-amber-400 shadow-lg shrink-0">
            @else
                <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-emerald-800 flex items-center justify-center text-amber-400 font-extrabold text-3xl sm:text-4xl border-4 border-amber-400 shadow-lg shrink-0">
                    👔
                </div>
            @endif
            <div class="space-y-2">
                <span class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider bg-amber-400 text-emerald-950 inline-block shadow-sm">Sambutan Pimpinan</span>
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white">{{ \App\Models\Setting::getValue('principal_name', 'Drs. H. Solihin, M.Pd.') }}</h2>
                <p class="text-xs sm:text-sm text-emerald-200 font-medium">{{ \App\Models\Setting::getValue('principal_title', 'Kepala SMA Negeri 24 Bandung') }}</p>
            </div>
        </div>

        <div class="relative space-y-4">
            <div class="bg-emerald-900/40 p-5 sm:p-7 rounded-2xl border border-emerald-700/50">
                <div class="prose prose-invert max-w-none text-slate-100 text-sm sm:text-base leading-relaxed italic space-y-4 transition-all duration-300 [&_p]:text-slate-100 [&_p]:leading-relaxed [&_span]:!text-slate-100 [&_strong]:text-amber-300 [&_h1]:text-white [&_h2]:text-white [&_h3]:text-white [&_h4]:text-white [&_ul]:text-slate-100 [&_ol]:text-slate-100 [&_li]:text-slate-100 [&_a]:text-amber-300 [&_a]:underline"
                     :class="expanded ? '' : 'line-clamp-4'">
                    {!! clean($profiles['sambutan_kepala_sekolah']->content ?? 'Selamat datang di website resmi SMA Negeri 24 Bandung. Kami berkomitmen untuk terus meningkatkan mutu pendidikan, membangun karakter peserta didik yang berakhlak mulia, cerdas, dan siap bersaing di tingkat global.') !!}
                </div>
            </div>

            <!-- Read More Toggle Button -->
            <div class="pt-2 flex items-center justify-between">
                <button @click="expanded = !expanded" 
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-emerald-950 font-black text-xs sm:text-sm transition-all shadow-md cursor-pointer">
                    <span x-text="expanded ? 'Tampilkan Lebih Sedikit &uarr;' : 'Baca Selengkapnya &rarr;'"></span>
                </button>
                <span class="text-xs text-slate-300 font-mono hidden sm:inline">Pimpinan SMAN 24 Bandung</span>
            </div>
        </div>
    </div>

    <!-- Sejarah / Identity Card -->
    <x-card :hover="false" class="p-6 sm:p-8 space-y-4" x-data="{ expanded: false }">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
            <span class="text-2xl sm:text-3xl">🏛️</span>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Sejarah Singkat SMAN 24 Bandung</h2>
        </div>
        <div class="relative">
            <div class="prose prose-slate prose-emerald max-w-none text-slate-800 text-sm sm:text-base leading-relaxed transition-all duration-300"
                 :class="expanded ? '' : 'line-clamp-4'">
                {!! clean($profiles['sejarah']->content ?? 'SMA Negeri 24 Bandung berlokasi di ' . \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') . '. Sekolah ini berkomitmen mencetak generasi unggul yang cerdas, santun, dan berdaya saing tinggi di era global.') !!}
            </div>
            <div class="pt-4 border-t border-slate-100 mt-4 flex items-center justify-between">
                <button @click="expanded = !expanded" 
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs sm:text-sm transition-all shadow-sm">
                    <span x-text="expanded ? 'Tampilkan Lebih Sedikit &uarr;' : 'Baca Selengkapnya &rarr;'"></span>
                </button>
            </div>
        </div>
    </x-card>

    <!-- Visi Misi Card -->
    <x-card :hover="false" class="bg-slate-50 p-6 sm:p-8 space-y-4 border border-slate-200" x-data="{ expanded: false }">
        <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
            <span class="text-2xl sm:text-3xl">🎯</span>
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Visi & Misi Sekolah</h2>
        </div>
        <div class="relative">
            <div class="prose prose-slate prose-emerald max-w-none text-slate-800 text-sm sm:text-base leading-relaxed transition-all duration-300"
                 :class="expanded ? '' : 'line-clamp-4'">
                {!! clean($profiles['visi_misi']->content ?? "Visi:\nTerwujudnya sekolah berkarakter, unggul dalam prestasi akademik dan non-akademik, serta berwawasan global.") !!}
            </div>
            <div class="pt-4 border-t border-slate-200 mt-4 flex items-center justify-between">
                <button @click="expanded = !expanded" 
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs sm:text-sm transition-all shadow-sm">
                    <span x-text="expanded ? 'Tampilkan Lebih Sedikit &uarr;' : 'Baca Selengkapnya &rarr;'"></span>
                </button>
            </div>
        </div>
    </x-card>
</div>
@endsection

