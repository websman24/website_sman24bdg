@extends('layouts.public.app')

@section('title', 'SMA Negeri 24 Bandung - Official Website')

@section('content')
<div class="space-y-0">
    
    <!-- Hero Section: Dynamic Alpine.js Slider OR Fallback Hero Banner -->
    @if(isset($sliders) && $sliders->count() > 0)
        <section class="relative bg-slate-950 text-white overflow-hidden border-b border-emerald-800/80"
                 x-data="{
                    activeSlide: 0,
                    slidesCount: {{ $sliders->count() }},
                    timer: null,
                    startAutoplay() {
                        this.timer = setInterval(() => {
                            this.nextSlide();
                        }, 5000);
                    },
                    stopAutoplay() {
                        clearInterval(this.timer);
                    },
                    nextSlide() {
                        this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
                    },
                    prevSlide() {
                        this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount;
                    }
                 }"
                 x-init="startAutoplay()"
                 @mouseenter="stopAutoplay()"
                 @mouseleave="startAutoplay()">
            
            <!-- Slides Container -->
            <div class="relative h-[480px] sm:h-[560px] lg:h-[620px] w-full">
                @foreach($sliders as $index => $slide)
                    <div x-show="activeSlide === {{ $index }}"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 scale-105"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute inset-0 w-full h-full">
                        
                        <!-- Background Image with Dark Gradient Overlay -->
                        <img src="{{ asset($slide->image_path) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/85 to-emerald-950/75"></div>

                        <!-- Content Overlay -->
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl space-y-4">
                                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-900/90 border border-amber-400/50 text-amber-400 text-xs font-extrabold shadow-lg">
                                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                                        INFORMASI UNGGULAN
                                    </div>
                                    <h2 class="text-3xl sm:text-5xl font-black text-white leading-tight tracking-tight drop-shadow-lg">
                                        {{ $slide->title }}
                                    </h2>
                                    @if($slide->subtitle)
                                        <p class="text-sm sm:text-base text-slate-200 leading-relaxed max-w-xl drop-shadow">
                                            {{ $slide->subtitle }}
                                        </p>
                                    @endif
                                    @if($slide->button_text)
                                        <div class="pt-2">
                                            <x-button href="{{ $slide->button_url ?? route('profile') }}" variant="secondary" class="shadow-xl">
                                                {{ $slide->button_text }} &rarr;
                                            </x-button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Controls (Prev/Next) -->
            <button @click="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-slate-900/60 hover:bg-emerald-800 text-white transition-all backdrop-blur-md border border-white/20 z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full bg-slate-900/60 hover:bg-emerald-800 text-white transition-all backdrop-blur-md border border-white/20 z-20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>

            <!-- Dots Indicators -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2.5 z-20">
                @foreach($sliders as $index => $slide)
                    <button @click="activeSlide = {{ $index }}"
                            class="h-2.5 rounded-full transition-all duration-300"
                            :class="activeSlide === {{ $index }} ? 'w-8 bg-amber-400' : 'w-2.5 bg-white/40 hover:bg-white/70'"></button>
                @endforeach
            </div>
        </section>
    @else
        <!-- Hero Section (Fallback Banner) -->
        <section class="relative hero-gradient hero-pattern-bg text-white py-20 lg:py-28 overflow-hidden border-b border-emerald-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Hero Text & Search -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-950/80 border border-emerald-600/80 text-amber-400 text-xs font-extrabold shadow-inner">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                            PORTAL RESMI SEKOLAH
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                            SMA Negeri 24 <br class="hidden sm:inline">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-300 to-yellow-200">Bandung</span>
                        </h1>

                        <p class="text-xs sm:text-base text-slate-200 max-w-2xl leading-relaxed">
                            {{ $schoolInfo['motto'] }}. Mewujudkan generasi unggul, berkarakter mulia, cerdas, dan berdaya saing global di era teknologi modern.
                        </p>

                        <!-- Quick News Search Bar -->
                        <form action="{{ route('news.index') }}" method="GET" class="glass-panel p-2.5 rounded-2xl max-w-xl flex items-center gap-2 shadow-2xl">
                            <svg class="w-5 h-5 text-emerald-800 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" placeholder="Cari berita, kegiatan, atau pengumuman sekolah..." class="w-full bg-transparent border-0 text-xs sm:text-sm text-slate-800 focus:outline-none placeholder-slate-400">
                            <x-button type="submit" variant="primary" class="shrink-0 font-extrabold text-xs">
                                Cari
                            </x-button>
                        </form>

                        <!-- Quick Action Buttons -->
                        <div class="flex flex-wrap gap-4 pt-2">
                            <x-button href="{{ route('profile') }}" variant="secondary" class="shadow-lg">
                                Jelajahi Profil Sekolah &rarr;
                            </x-button>
                            <x-button href="{{ route('spmb.pendaftar') }}" variant="outline" class="bg-emerald-950/60 border-emerald-600/80 text-white hover:bg-emerald-900 shadow-lg">
                                Layanan SPMB
                            </x-button>
                        </div>
                    </div>

                    <!-- Hero Dynamic Principal Greeting Card -->
                    <div class="lg:col-span-5">
                        <div class="glass-card-emerald p-8 rounded-3xl space-y-5 shadow-2xl glow-emerald">
                            <div class="flex items-center justify-between border-b border-emerald-700/60 pb-4">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-amber-400">Sambutan Pimpinan</span>
                                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold bg-amber-500/20 text-amber-300 border border-amber-400/40">
                                    Akreditasi {{ $schoolInfo['accreditation'] }}
                                </span>
                            </div>

                            <div class="flex items-center gap-4">
                                @if(!empty($schoolInfo['principal_photo']))
                                    <img src="{{ asset($schoolInfo['principal_photo']) }}" alt="{{ $schoolInfo['principal_name'] }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-amber-400 shadow-md">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-emerald-800 flex items-center justify-center text-amber-400 font-black text-2xl border-2 border-amber-400 shadow-md">
                                        👔
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-extrabold text-white text-base leading-tight">{{ $schoolInfo['principal_name'] }}</h3>
                                    <p class="text-xs text-emerald-200 mt-0.5">{{ $schoolInfo['principal_title'] }}</p>
                                </div>
                            </div>

                            <p class="text-xs sm:text-sm text-slate-200 leading-relaxed italic border-t border-emerald-800/80 pt-4">
                                "{{ $profiles['sambutan_kepala_sekolah']->content ?? 'Selamat datang di website resmi SMA Negeri 24 Bandung. Kami berkomitmen untuk terus meningkatkan mutu pendidikan, membangun karakter peserta didik yang berakhlak mulia, cerdas, dan siap bersaing di tingkat global.' }}"
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

    <!-- High-Contrast Stat Counter Container (Dark Emerald Glass Overlay) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-emerald-800/80 glow-emerald">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-emerald-800/60">
                <div class="space-y-1 p-2">
                    <div class="text-3xl sm:text-4xl font-black text-amber-400">1.000+</div>
                    <div class="text-xs text-slate-300 font-bold uppercase tracking-wider">Peserta Didik</div>
                </div>
                <div class="space-y-1 p-2">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-400">60+</div>
                    <div class="text-xs text-slate-300 font-bold uppercase tracking-wider">Guru & Pendidik</div>
                </div>
                <div class="space-y-1 p-2">
                    <div class="text-3xl sm:text-4xl font-black text-amber-400">A (Unggul)</div>
                    <div class="text-xs text-slate-300 font-bold uppercase tracking-wider">Akreditasi BAN-S/M</div>
                </div>
                <div class="space-y-1 p-2">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-400">50+</div>
                    <div class="text-xs text-slate-300 font-bold uppercase tracking-wider">Prestasi Terdaftar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Sambutan Pimpinan & Visi Misi Sekolah -->
    <section id="profil" class="py-16 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto">
                <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300 uppercase tracking-widest inline-block mb-2">Identitas Sekolah</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900">{{ $schoolInfo['name'] }}</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2 font-medium">{{ $schoolInfo['address'] }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                
                <!-- Sambutan Kepala Sekolah Card (Left 6 Cols) -->
                <div class="lg:col-span-6 bg-gradient-to-br from-emerald-950 via-emerald-900 to-slate-950 text-white rounded-3xl p-8 space-y-6 shadow-xl border border-emerald-800/80 flex flex-col justify-between">
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 border-b border-emerald-800/80 pb-5">
                            @if(!empty($schoolInfo['principal_photo']))
                                <img src="{{ asset($schoolInfo['principal_photo']) }}" alt="{{ $schoolInfo['principal_name'] }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-amber-400 shadow-md">
                            @else
                                <div class="w-20 h-20 rounded-2xl bg-emerald-800 flex items-center justify-center text-amber-400 font-black text-3xl border-2 border-amber-400 shadow-md">
                                    👔
                                </div>
                            @endif
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-400 block">Sambutan Pimpinan</span>
                                <h3 class="font-black text-white text-lg sm:text-xl leading-tight">{{ $schoolInfo['principal_name'] }}</h3>
                                <p class="text-xs text-emerald-200 mt-1 font-medium">{{ $schoolInfo['principal_title'] }}</p>
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm text-slate-200 leading-relaxed italic">
                            "{{ $profiles['sambutan_kepala_sekolah']->content ?? 'Selamat datang di website resmi SMA Negeri 24 Bandung. Kami berkomitmen untuk terus meningkatkan mutu pendidikan, membangun karakter peserta didik yang berakhlak mulia, cerdas, dan siap bersaing di tingkat global.' }}"
                        </p>
                    </div>

                    <div class="pt-4 border-t border-emerald-800/60 flex items-center justify-between text-xs">
                        <span class="text-amber-400 font-extrabold">SMAN 24 Bandung</span>
                        <a href="{{ route('profile') }}" class="font-extrabold text-white hover:text-amber-300 underline">Profil Lengkap &rarr;</a>
                    </div>
                </div>

                <!-- Sejarah & Visi Misi Card (Right 6 Cols) -->
                <div class="lg:col-span-6 space-y-6 flex flex-col justify-between">
                    <!-- Sejarah Card -->
                    <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
                        <div class="flex items-center gap-3 text-emerald-800 font-bold text-base border-b border-slate-100 pb-3">
                            <span class="text-2xl">🏛️</span>
                            <h3 class="font-extrabold text-slate-900">Sejarah Singkat Sekolah</h3>
                        </div>
                        <p class="text-slate-700 text-xs sm:text-sm leading-relaxed">
                            {{ $profiles['sejarah']->content ?? 'SMA Negeri 24 Bandung berlokasi di Jl. A.H. Nasution No. 27, Kota Bandung. Sekolah ini berkomitmen mencetak generasi unggul yang cerdas, santun, dan berdaya saing tinggi di era global.' }}
                        </p>
                    </div>

                    <!-- Visi & Misi Card -->
                    <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
                        <div class="flex items-center gap-3 text-emerald-800 font-bold text-base border-b border-slate-100 pb-3">
                            <span class="text-2xl">🎯</span>
                            <h3 class="font-extrabold text-slate-900">{{ $profiles['visi_misi']->title ?? 'Visi dan Misi Sekolah' }}</h3>
                        </div>
                        <p class="text-slate-700 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                            {{ $profiles['visi_misi']->content ?? 'Terwujudnya sekolah berkarakter, unggul dalam prestasi akademik dan non-akademik, serta berwawasan global.' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Section: Berita Terbaru & Pengumuman -->
    <section id="informasi" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-300 uppercase tracking-widest inline-block mb-2">Kabar Sekolah</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900">Berita & Pengumuman Terbaru</h2>
                </div>
                <a href="{{ route('news.index') }}" class="text-xs font-extrabold text-emerald-800 hover:text-emerald-950 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 transition-colors">
                    Lihat Semua Berita &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Berita Grid (2 Columns) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @forelse($latestNews as $news)
                            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between card-hover-effect">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="px-3 py-1 rounded-full font-bold bg-emerald-800 text-white text-[10px] uppercase shadow-xs">
                                            {{ $news->category->name ?? 'Umum' }}
                                        </span>
                                        <span class="text-slate-400 text-[11px] font-mono">{{ $news->published_at?->format('d M Y') }}</span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-base leading-snug line-clamp-2">
                                        <a href="{{ route('news.show', $news->slug) }}" class="hover:text-emerald-800 transition-colors">
                                            {{ $news->title }}
                                        </a>
                                    </h4>
                                    <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">{{ $news->excerpt }}</p>
                                </div>
                                <div class="pt-4 mt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                                    <span class="text-slate-400 text-[11px]">👁️ {{ $news->views_count }} views</span>
                                    <a href="{{ route('news.show', $news->slug) }}" class="font-bold text-emerald-800 hover:underline">Baca &rarr;</a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 bg-slate-50 p-8 rounded-2xl border border-slate-200 text-center text-xs text-slate-400">
                                Belum ada berita dipublikasikan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pengumuman Pinned (1 Column) -->
                <div class="space-y-4">
                    <h3 class="text-xs font-extrabold text-amber-700 uppercase tracking-wider">Pengumuman Tersemat</h3>
                    <div class="space-y-3">
                        @forelse($pinnedAnnouncements as $ann)
                            <div class="bg-amber-50/70 p-5 rounded-2xl border border-amber-200/90 space-y-2 card-hover-effect">
                                <span class="px-2.5 py-0.5 rounded text-[9px] font-extrabold bg-amber-500 text-emerald-950 uppercase shadow-xs">Penting</span>
                                <h4 class="font-bold text-slate-900 text-xs sm:text-sm leading-snug">{{ $ann->title }}</h4>
                                <p class="text-slate-600 text-[11px] line-clamp-2 leading-relaxed">{{ $ann->content }}</p>
                            </div>
                        @empty
                            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 text-center text-xs text-slate-400">
                                Belum ada pengumuman tersemat.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Section: Direktori Guru -->
    <section id="akademik" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-200 pb-4">
                <div>
                    <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300 uppercase tracking-widest inline-block mb-2">Tenaga Pendidik</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900">Direktori Guru {{ $schoolInfo['name'] }}</h2>
                </div>
                <a href="{{ route('academic.teachers') }}" class="text-xs font-extrabold text-emerald-800 hover:text-emerald-950 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-slate-200 transition-colors">
                    Lihat Semua Guru &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($teachers as $teacher)
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm text-center space-y-3 card-hover-effect">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-800 text-white font-black text-xl flex items-center justify-center shadow-md border-2 border-amber-400/40">
                            {{ strtoupper(substr($teacher->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $teacher->full_name }}</h4>
                            <span class="inline-block mt-1.5 px-3 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                                {{ $teacher->subject }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-8 text-xs text-slate-400">Belum ada data guru terdaftar.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Dynamic SPMB Section -->
    <section id="spmb" class="py-16 bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-950 text-white border-b border-emerald-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-amber-500 text-emerald-950 inline-block shadow-md">Layanan SPMB</span>
                <h2 class="text-2xl sm:text-4xl font-black">Seleksi Penerimaan Murid Baru (SPMB)</h2>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    Pusat layanan pendaftaran dan verifikasi daftar ulang siswa baru {{ $schoolInfo['name'] }}.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card 1: Pendaftar -->
                <div class="glass-card-emerald p-8 rounded-3xl space-y-4 flex flex-col justify-between shadow-2xl">
                    <div>
                        <h3 class="text-xl font-black text-amber-400">Informasi Pendaftar</h3>
                        <p class="text-xs text-slate-200 mt-2 leading-relaxed">
                            Unduh panduan pendaftaran, alur seleksi, dan formulir pendaftaran murid baru.
                        </p>
                    </div>
                    <div class="pt-4">
                        <x-button href="{{ route('spmb.pendaftar') }}" variant="secondary" class="w-full">
                            Buka Layanan Pendaftar &rarr;
                        </x-button>
                    </div>
                </div>

                <!-- Card 2: Daftar Ulang -->
                <div class="glass-card-emerald p-8 rounded-3xl space-y-4 flex flex-col justify-between shadow-2xl">
                    <div>
                        <h3 class="text-xl font-black text-amber-400">Daftar Ulang SPMB</h3>
                        <p class="text-xs text-slate-200 mt-2 leading-relaxed">
                            Verifikasi berkas fisik bagi calon peserta didik yang telah diterima di {{ $schoolInfo['name'] }}.
                        </p>
                    </div>
                    <div class="pt-4">
                        <x-button href="{{ route('spmb.daftar_ulang') }}" variant="outline" class="w-full bg-white/10 text-white hover:bg-white/20 border-white/30">
                            Info Daftar Ulang &rarr;
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location & Contact Section -->
    <section id="kontak" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-slate-900 to-emerald-950 rounded-3xl p-8 sm:p-12 text-white shadow-2xl border border-emerald-800/80">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="space-y-4">
                        <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-amber-500 text-emerald-950">Kontak Sekolah</span>
                        <h3 class="text-2xl sm:text-3xl font-black">{{ $schoolInfo['name'] }}</h3>
                        <div class="space-y-2 text-xs sm:text-sm text-slate-300 pt-2">
                            <p><strong>Alamat:</strong> {{ $schoolInfo['address'] }}</p>
                            <p><strong>Telepon:</strong> {{ $schoolInfo['phone'] }}</p>
                            <p><strong>Email:</strong> {{ $schoolInfo['email'] }}</p>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 p-6 rounded-2xl border border-slate-700 text-center space-y-3">
                        <div class="text-3xl">🏫</div>
                        <h4 class="text-base font-bold text-white">Portal Admin Website</h4>
                        <p class="text-xs text-slate-400">Masuk untuk mengelola publikasi berita, data pendidik, dan dokumen sekolah.</p>
                        <x-button href="{{ route('admin.login') }}" variant="secondary">
                            Masuk Portal Admin
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
