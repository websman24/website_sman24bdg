<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SMA Negeri 24 Bandung - Official Website')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Official Website SMA Negeri 24 Bandung - Jl. A.H. Nasution No. 27, Kota Bandung. Sekolah Berakreditasi A, Unggul, Berkarakter, Berbudaya, dan Berwawasan Global.">
    <meta name="keywords" content="SMAN 24 Bandung, SMA Negeri 24 Bandung, Sekolah Bandung, Pendidikan, SMA Bandung, SMAN24, SPMB">

    <!-- Fonts & Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased font-sans">

    <!-- Top Info Bar -->
    <div class="bg-emerald-950 text-emerald-200 text-xs py-2 px-4 border-b border-emerald-900 hidden sm:block">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Jl. A.H. Nasution No. 27, Kota Bandung
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/></svg>
                    (022) 7800540
                </span>
            </div>
            <div class="flex items-center gap-4">
                <span>NPSN: 20219736</span>
                <span class="text-amber-400 font-semibold">Akreditasi A</span>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header x-data="{ mobileMenuOpen: false, scrolled: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="{ 'glass-panel shadow-md py-2.5': scrolled, 'bg-emerald-900 text-white py-3.5': !scrolled }"
            class="sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                <!-- Brand Logo & Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center font-extrabold text-emerald-950 text-xl shadow-lg group-hover:scale-105 transition-transform duration-200">
                        24
                    </div>
                    <div>
                        <span class="block text-base sm:text-lg font-extrabold tracking-tight" :class="{ 'text-emerald-950': scrolled, 'text-white': !scrolled }">
                            SMAN 24 BANDUNG
                        </span>
                        <span class="block text-[11px] font-medium opacity-80" :class="{ 'text-slate-600': scrolled, 'text-emerald-200': !scrolled }">
                            Kota Bandung, Jawa Barat
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav (Includes SPMB Dropdown with Pendaftar & Daftar Ulang) -->
                <nav class="hidden lg:flex items-center space-x-5 font-semibold text-xs">
                    <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors py-1 text-amber-400 border-b-2 border-amber-400">Beranda</a>
                    <a href="#profil" class="hover:text-amber-400 transition-colors py-1" :class="{ 'text-slate-700': scrolled, 'text-slate-200': !scrolled }">Profil</a>
                    <a href="#akademik" class="hover:text-amber-400 transition-colors py-1" :class="{ 'text-slate-700': scrolled, 'text-slate-200': !scrolled }">Akademik</a>
                    <a href="#kesiswaan" class="hover:text-amber-400 transition-colors py-1" :class="{ 'text-slate-700': scrolled, 'text-slate-200': !scrolled }">Kesiswaan</a>
                    <a href="#informasi" class="hover:text-amber-400 transition-colors py-1" :class="{ 'text-slate-700': scrolled, 'text-slate-200': !scrolled }">Informasi</a>
                    <a href="#galeri" class="hover:text-amber-400 transition-colors py-1" :class="{ 'text-slate-700': scrolled, 'text-slate-200': !scrolled }">Galeri</a>
                    <a href="#download" class="hover:text-amber-400 transition-colors py-1" :class="{ 'text-slate-700': scrolled, 'text-slate-200': !scrolled }">Download</a>
                    
                    <!-- SPMB Dropdown -->
                    <div x-data="{ spmbOpen: false }" @click.away="spmbOpen = false" class="relative">
                        <button @click="spmbOpen = !spmbOpen" 
                                class="hover:text-amber-400 transition-colors py-1 text-amber-300 font-bold inline-flex items-center gap-1 focus:outline-none"
                                :class="{ 'text-amber-600': scrolled }">
                            <span>SPMB</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': spmbOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="spmbOpen" x-collapse 
                             class="absolute left-0 mt-2 w-44 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-200 py-1.5 z-50 text-xs">
                            <a href="#spmb-pendaftar" @click="spmbOpen = false" class="flex items-center gap-2 px-3.5 py-2 hover:bg-emerald-50 hover:text-emerald-800 font-semibold transition-colors">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Pendaftar
                            </a>
                            <a href="#spmb-daftar-ulang" @click="spmbOpen = false" class="flex items-center gap-2 px-3.5 py-2 hover:bg-emerald-50 hover:text-emerald-800 font-semibold transition-colors border-t border-slate-100">
                                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Daftar Ulang
                            </a>
                        </div>
                    </div>

                    <a href="#kontak" class="hover:text-amber-400 transition-colors py-1" :class="{ 'text-slate-700': scrolled, 'text-slate-200': !scrolled }">Kontak</a>
                </nav>

                <!-- Action Button / Login -->
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold rounded-xl bg-amber-500 text-emerald-950 hover:bg-amber-400 transition-all shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white transition-all shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Login Portal
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-emerald-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-collapse class="lg:hidden bg-emerald-950 border-t border-emerald-800 px-4 pt-3 pb-6 space-y-2 text-white text-xs font-medium">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg bg-emerald-900 text-amber-400 font-bold">Beranda</a>
            <a href="#profil" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg hover:bg-emerald-900">Profil</a>
            <a href="#akademik" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg hover:bg-emerald-900">Akademik</a>
            <a href="#kesiswaan" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg hover:bg-emerald-900">Kesiswaan</a>
            <a href="#informasi" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg hover:bg-emerald-900">Informasi</a>
            <a href="#galeri" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg hover:bg-emerald-900">Galeri</a>
            <a href="#download" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg hover:bg-emerald-900">Download</a>
            
            <!-- Mobile SPMB Accordion -->
            <div x-data="{ mobileSpmbOpen: false }" class="space-y-1">
                <button @click="mobileSpmbOpen = !mobileSpmbOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-emerald-900 text-amber-300 font-bold">
                    <span>SPMB</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': mobileSpmbOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="mobileSpmbOpen" x-collapse class="pl-4 space-y-1 text-slate-300">
                    <a href="#spmb-pendaftar" @click="mobileMenuOpen = false" class="block px-3 py-1.5 rounded-lg hover:bg-emerald-900 text-xs">Pendaftar</a>
                    <a href="#spmb-daftar-ulang" @click="mobileMenuOpen = false" class="block px-3 py-1.5 rounded-lg hover:bg-emerald-900 text-xs">Daftar Ulang</a>
                </div>
            </div>

            <a href="#kontak" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-lg hover:bg-emerald-900">Kontak</a>
            <div class="pt-3 border-t border-emerald-800">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-amber-500 text-emerald-950 font-bold">Dashboard Admin</a>
                @else
                    <a href="{{ route('admin.login') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-emerald-700 text-white font-bold">Login Portal</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="p-4 mb-4 text-xs text-emerald-800 rounded-xl bg-emerald-100 border border-emerald-200 flex items-center gap-3" role="alert">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 mb-4 text-xs text-sky-800 rounded-xl bg-sky-100 border border-sky-200 flex items-center gap-3" role="alert">
                <svg class="w-4 h-4 text-sky-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @if(session('warning'))
            <div class="p-4 mb-4 text-xs text-amber-800 rounded-xl bg-amber-100 border border-amber-200 flex items-center gap-3" role="alert">
                <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>{{ session('warning') }}</span>
            </div>
        @endif
    </div>

    <!-- Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                
                <!-- Col 1: School Identity -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center font-extrabold text-emerald-950 text-lg">
                            24
                        </div>
                        <span class="text-lg font-bold text-white tracking-tight">SMAN 24 Bandung</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Sekolah Menengah Atas Negeri 24 Bandung melahirkan generasi berkarakter, berbudaya, dan berwawasan global.
                    </p>
                    <div class="flex items-center gap-2 pt-1">
                        <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-emerald-950 text-emerald-400 border border-emerald-700/60">
                            Akreditasi A
                        </span>
                        <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-amber-950 text-amber-400 border border-amber-700/60">
                            Sekolah Penggerak
                        </span>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Navigasi Utama</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Beranda</a></li>
                        <li><a href="#profil" class="hover:text-amber-400 transition-colors">Profil Sekolah</a></li>
                        <li><a href="#akademik" class="hover:text-amber-400 transition-colors">Akademik & Fasilitas</a></li>
                        <li><a href="#kesiswaan" class="hover:text-amber-400 transition-colors">Kesiswaan & Ekstrakurikuler</a></li>
                        <li><a href="#informasi" class="hover:text-amber-400 transition-colors">Informasi & Pengumuman</a></li>
                    </ul>
                </div>

                <!-- Col 3: Media & SPMB Links -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Layanan SPMB & Publikasi</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#spmb-pendaftar" class="hover:text-amber-400 transition-colors text-amber-300 font-semibold">Pendaftaran SPMB</a></li>
                        <li><a href="#spmb-daftar-ulang" class="hover:text-amber-400 transition-colors text-amber-300 font-semibold">Daftar Ulang SPMB</a></li>
                        <li><a href="#galeri" class="hover:text-amber-400 transition-colors">Galeri Foto Dokumentasi</a></li>
                        <li><a href="#download" class="hover:text-amber-400 transition-colors">Pusat Unduhan Dokumen</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-amber-400 transition-colors">Login Admin Portal</a></li>
                    </ul>
                </div>

                <!-- Col 4: School Address -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Alamat Sekolah</h3>
                    <div class="space-y-3 text-xs">
                        <p class="flex items-start gap-2 text-slate-300">
                            <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614</span>
                        </p>
                        <p class="flex items-center gap-2 text-slate-300">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/></svg>
                            <span>(022) 7800540</span>
                        </p>
                        <p class="flex items-center gap-2 text-slate-300">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>info@sman24bdg.sch.id</span>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} SMA Negeri 24 Bandung. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <span>Jl. A.H. Nasution No. 27, Kota Bandung</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
