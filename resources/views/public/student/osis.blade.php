@extends('layouts.public.app')

@section('title', 'OSIS & MPK - ' . ($profile->cabinet_name ?? 'Kabinet Cakra Baskara') . ' - SMAN 24 Bandung')
@section('meta_description', 'Profil resmi OSIS SMAN 24 Bandung, ' . ($profile->cabinet_name ?? 'Kabinet Cakra Baskara') . ' periode ' . ($profile->period ?? '2025/2026') . '. Struktur pengurus BPH, Sekbid 1-10, visi misi, dan kegiatan kesiswaan.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-950 text-white py-16 sm:py-24 overflow-hidden border-b border-indigo-900/40">
    <!-- Ambient glowing lights -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb Navigation -->
        <div class="mb-6">
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-300">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-slate-400">Kesiswaan</span>
                <span>/</span>
                <span class="text-amber-400 font-bold">OSIS & MPK</span>
            </nav>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">
            <div class="space-y-5 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-indigo-900/80 to-indigo-800/80 border border-indigo-500/40 text-amber-300 text-xs font-extrabold shadow-inner">
                    <span>🏛️</span>
                    <span>ORGANISASI SISWA INTRA SEKOLAH & MPK</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                    {{ $profile->cabinet_name ?? 'Kabinet Cakra Baskara' }}
                </h1>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3.5 py-1 rounded-xl bg-amber-500 text-emerald-950 text-xs sm:text-sm font-black shadow-md">
                        Periode {{ $profile->period ?? '2025/2026' }}
                    </span>
                    <span class="text-xs sm:text-sm text-slate-300 font-semibold italic">
                        "{{ $profile->tagline ?? 'Bersinergi, Berkarakter, Menginspirasi' }}"
                    </span>
                </div>

                <p class="text-slate-300 text-xs sm:text-sm md:text-base leading-relaxed">
                    Wadah resmi aspirasi, kepemimpinan, dan pengembangan karakter seluruh peserta didik {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="#pengurus" class="px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-400 hover:from-amber-400 hover:to-amber-300 text-emerald-950 font-black text-xs shadow-lg shadow-amber-500/20 transition-all hover:scale-105">
                        👥 Struktur Pengurus
                    </a>
                    <a href="#visi-misi" class="px-6 py-3 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition-all">
                        🎯 Visi & Misi
                    </a>
                </div>
            </div>

            <!-- Banner / Cabinet Logo Frame -->
            <div class="w-full lg:w-96 shrink-0">
                <div class="relative rounded-3xl p-1 bg-gradient-to-tr from-amber-400 via-indigo-500 to-emerald-400 shadow-2xl shadow-indigo-950/50">
                    <div class="bg-slate-900 rounded-[22px] p-6 text-center space-y-4">
                        @if($profile->cabinet_logo)
                            <img src="{{ asset($profile->cabinet_logo) }}" alt="Logo Kabinet" class="w-28 h-28 mx-auto object-contain drop-shadow-xl">
                        @else
                            <div class="w-24 h-24 mx-auto rounded-2xl bg-gradient-to-tr from-indigo-800 to-indigo-600 flex items-center justify-center text-4xl shadow-lg border border-indigo-400/40">
                                🏛️
                            </div>
                        @endif
                        <div>
                            <div class="text-xs font-bold uppercase tracking-wider text-amber-400">SMAN 24 Bandung</div>
                            <div class="text-lg font-black text-white">{{ $profile->cabinet_name ?? 'Kabinet Cakra Baskara' }}</div>
                            <div class="text-xs text-slate-400 mt-1">Masa Bakti {{ $profile->period ?? '2025/2026' }}</div>
                        </div>

                        <!-- Social Media Links -->
                        <div class="pt-3 border-t border-slate-800 flex items-center justify-center gap-3">
                            @if($profile->instagram_url)
                                <a href="{{ $profile->instagram_url }}" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-gradient-to-tr hover:from-purple-600 hover:to-pink-600 text-white flex items-center justify-center text-sm transition-all shadow-sm" title="Instagram">
                                    📸
                                </a>
                            @endif
                            @if($profile->tiktok_url)
                                <a href="{{ $profile->tiktok_url }}" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-black text-white flex items-center justify-center text-sm transition-all shadow-sm" title="TikTok">
                                    🎵
                                </a>
                            @endif
                            @if($profile->youtube_url)
                                <a href="{{ $profile->youtube_url }}" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-rose-600 text-white flex items-center justify-center text-sm transition-all shadow-sm" title="YouTube">
                                    ▶️
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi & Misi Section -->
<section id="visi-misi" class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-indigo-100 text-indigo-800 border border-indigo-200 uppercase tracking-widest inline-block">
                Arah & Tujuan Organisasi
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                Visi & Misi Kepengurusan
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Fondasi komitmen dan langkah strategis OSIS SMAN 24 Bandung dalam mewujudkan lingkungan sekolah yang dinamis dan berprestasi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Visi Card -->
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-5 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-2xl font-bold shadow-inner">
                    🎯
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 block mb-1">Visi Utama</span>
                    <h3 class="text-xl font-bold text-slate-900">Visi Kabinet</h3>
                </div>
                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50 p-5 rounded-2xl border border-slate-100 font-medium">
                    {!! nl2br(e($profile->vision ?? 'Mewujudkan OSIS SMAN 24 Bandung sebagai wadah aspirasi dan pengembangan potensi siswa yang berakhlak mulia, cerdas, kreatif, dan berwawasan global.')) !!}
                </div>
            </div>

            <!-- Misi Card -->
            <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm space-y-5 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl font-bold shadow-inner">
                    🚀
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-1">Langkah Nyata</span>
                    <h3 class="text-xl font-bold text-slate-900">Misi Organisasi</h3>
                </div>
                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50 p-5 rounded-2xl border border-slate-100 font-medium space-y-2">
                    {!! nl2br(e($profile->mission ?? "1. Menumbuhkan keimanan dan ketaqwaan kepada Tuhan YME.\n2. Mendorong prestasi akademik dan non-akademik siswa.\n3. Mengembangkan kreativitas dan jiwa kepemimpinan siswa.\n4. Menjalin hubungan harmonis antara siswa, guru, dan masyarakat.")) !!}
                </div>
            </div>
        </div>

        <!-- Sambutan Ketua OSIS Banner -->
        @if($profile->leader_welcome || $profile->leader_name)
        <div class="bg-gradient-to-br from-indigo-900 via-indigo-950 to-slate-950 rounded-3xl p-8 sm:p-12 text-white border border-indigo-800 shadow-xl relative overflow-hidden">
            <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl overflow-hidden shrink-0 border-4 border-amber-400/80 shadow-2xl bg-slate-800 flex items-center justify-center">
                    @if($profile->leader_photo)
                        <img src="{{ asset($profile->leader_photo) }}" alt="{{ $profile->leader_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-4xl font-black text-amber-400">👑</div>
                    @endif
                </div>
                <div class="space-y-3 text-center md:text-left flex-1">
                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-amber-500 text-emerald-950 uppercase tracking-wider inline-block">
                        Pesan Ketua OSIS
                    </span>
                    <h3 class="text-xl sm:text-2xl font-black text-white">
                        {{ $profile->leader_name ?? 'Muhammad Rizky Pratama' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-indigo-100 leading-relaxed italic">
                        "{!! nl2br(e($profile->leader_welcome ?? 'Selamat datang di portal resmi OSIS SMAN 24 Bandung. Mari bersama-sama berkarya, bersinergi, dan mengharumkan nama sekolah tercinta.')) !!}"
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Struktur Pengurus & BPH / Sekbid Section -->
<section id="pengurus" class="py-16 sm:py-24 bg-white" x-data="{ selectedCategory: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-slate-200 pb-8">
            <div class="space-y-2 max-w-xl">
                <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-300 uppercase tracking-widest inline-block">
                    Susunan Organisasi
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Struktur Pengurus OSIS & MPK
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Mengenal para perwakilan siswa yang berdedikasi mengabdi dalam BPH, Seksi Bidang 1 s/d 10, dan MPK.
                </p>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap gap-2">
                <button type="button" 
                        @click="selectedCategory = 'all'"
                        :class="selectedCategory === 'all' ? 'bg-indigo-800 text-white shadow-sm font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition-all">
                    Semua ({{ $members->count() }})
                </button>
                <button type="button" 
                        @click="selectedCategory = 'bph'"
                        :class="selectedCategory === 'bph' ? 'bg-indigo-800 text-white shadow-sm font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition-all">
                    🏛️ BPH ({{ $bphMembers->count() }})
                </button>
                <button type="button" 
                        @click="selectedCategory = 'sekbid'"
                        :class="selectedCategory === 'sekbid' ? 'bg-indigo-800 text-white shadow-sm font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition-all">
                    🎯 Seksi Bidang ({{ $sekbidMembers->count() }})
                </button>
                <button type="button" 
                        @click="selectedCategory = 'mpk'"
                        :class="selectedCategory === 'mpk' ? 'bg-indigo-800 text-white shadow-sm font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition-all">
                    ⚖️ MPK ({{ $mpkMembers->count() }})
                </button>
            </div>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($members as $member)
                <div x-show="selectedCategory === 'all' || 
                             (selectedCategory === 'bph' && '{{ $member->department }}' === 'bph') ||
                             (selectedCategory === 'sekbid' && '{{ $member->department }}'.startsWith('sekbid_')) ||
                             (selectedCategory === 'mpk' && '{{ $member->department }}' === 'mpk')"
                     class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between space-y-4 group">
                    
                    <div class="space-y-4">
                        <!-- Photo & Avatar -->
                        <div class="relative">
                            @if($member->photo)
                                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="w-full h-48 sm:h-52 object-cover rounded-2xl border border-slate-200 shadow-xs group-hover:scale-[1.02] transition-transform">
                            @else
                                <div class="w-full h-48 sm:h-52 rounded-2xl bg-gradient-to-tr from-indigo-900 via-indigo-700 to-indigo-500 text-white flex flex-col items-center justify-center text-center p-4 shadow-xs">
                                    <span class="text-4xl font-black uppercase">{{ substr($member->name, 0, 1) }}</span>
                                    <span class="text-[11px] font-medium text-indigo-200 mt-2">OSIS 24 Bandung</span>
                                </div>
                            @endif

                            @if($member->class_grade)
                                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-xl text-[10px] font-black bg-slate-900/80 text-amber-400 backdrop-blur-sm shadow-sm">
                                    {{ $member->class_grade }}
                                </span>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="space-y-1.5">
                            <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold {{ $member->department === 'bph' ? 'bg-indigo-100 text-indigo-800 border border-indigo-200' : ($member->department === 'mpk' ? 'bg-amber-100 text-amber-900 border border-amber-200' : 'bg-emerald-50 text-emerald-800 border border-emerald-200') }}">
                                {{ $member->department_label }}
                            </span>
                            <h3 class="text-base font-black text-slate-900 group-hover:text-indigo-700 transition-colors leading-snug">
                                {{ $member->name }}
                            </h3>
                            <div class="text-xs font-bold text-slate-600">
                                {{ $member->position }}
                            </div>
                        </div>

                        @if($member->motto)
                            <p class="text-[11px] text-slate-500 italic leading-relaxed border-t border-slate-100 pt-2">
                                "{{ $member->motto }}"
                            </p>
                        @endif
                    </div>

                    <!-- Instagram Link -->
                    @if($member->instagram)
                        <div class="pt-3 border-t border-slate-100">
                            <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                                <span>📸</span> <span>{{ $member->instagram }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400">
                    Belum ada data pengurus OSIS yang dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Call To Action: Connect With OSIS -->
<section class="py-16 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white border-t border-indigo-900/60">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center space-y-6">
        <span class="px-4 py-1 rounded-full text-xs font-extrabold bg-amber-400 text-emerald-950 uppercase tracking-widest inline-block">
            Ikuti Perkembangan Kegiatan Siswa
        </span>
        <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
            Terhubung Bersama OSIS SMAN 24 Bandung
        </h2>
        <p class="text-xs sm:text-sm text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Dapatkan informasi terkini mengenai event, perlombaan antar-kelas, bakti sosial, dan dokumentasi keseruan murid SMAN 24 Bandung langsung di media sosial resmi kami.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
            @if($profile->instagram_url)
                <a href="{{ $profile->instagram_url }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-bold text-xs shadow-lg transition-all hover:scale-105">
                    <span>📸</span> Follow @osis24bdg
                </a>
            @endif
            <a href="{{ route('student.extracurriculars') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-lg transition-all">
                <span>⚽</span> Lihat Ekstrakurikuler
            </a>
            <a href="{{ route('student.achievements') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-amber-500 hover:bg-amber-400 text-emerald-950 font-black text-xs shadow-lg transition-all">
                <span>🏆</span> Prestasi Siswa
            </a>
        </div>
    </div>
</section>
@endsection
