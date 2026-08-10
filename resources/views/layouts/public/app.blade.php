<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SMA Negeri 24 Bandung - Official Website')</title>
    <meta name="description" content="@yield('meta_description', 'Official Website ' . \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') . ' - ' . \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') . '.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Premium Topbar Contact & Announcement Info -->
    <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-950 text-emerald-100 text-xs py-2.5 px-4 border-b border-emerald-900/60 shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-5">
                <span class="flex items-center gap-1.5 hover:text-amber-300 transition-colors">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}
                </span>
                <span class="hidden md:flex items-center gap-1.5 hover:text-amber-300 transition-colors">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ \App\Models\Setting::getValue('school_phone', '(022) 7800540') }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-900/90 text-amber-400 font-extrabold text-[10px] border border-amber-400/30">
                    NPSN: {{ \App\Models\Setting::getValue('school_npsn', '20219736') }}
                </span>
                <span class="text-slate-300 text-[11px]">Akreditasi: <strong class="text-amber-400 font-extrabold">{{ \App\Models\Setting::getValue('school_accreditation', 'A (Unggul)') }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Main Glassmorphism Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg border-b border-slate-200/80 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- School Logo & Title -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-950 via-emerald-800 to-emerald-700 flex items-center justify-center text-amber-400 font-black text-xl shadow-md group-hover:scale-105 transition-transform border border-amber-400/40">
                        24
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-slate-900 text-base sm:text-lg tracking-tight group-hover:text-emerald-800 transition-colors uppercase font-sans">
                            {{ \App\Models\Setting::getValue('school_name', 'SMAN 24 BANDUNG') }}
                        </span>
                        <span class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">
                            Official School Portal
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-6 text-xs font-bold text-slate-700">
                    <a href="{{ route('home') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('home') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Beranda</a>
                    <a href="{{ route('profile') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('profile') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Profil</a>
                    <a href="{{ route('academic.teachers') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('academic.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Akademik</a>
                    <a href="{{ route('student.extracurriculars') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('student.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Kesiswaan</a>
                    <a href="{{ route('news.index') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('news.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Informasi</a>
                    <a href="{{ route('gallery.index') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('gallery.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Galeri</a>
                    <a href="{{ route('download.index') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('download.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Download</a>
                    
                    <!-- SPMB Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1 hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('spmb.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">
                            <span>SPMB</span>
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute left-0 mt-0 w-48 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 z-50">
                            <a href="{{ route('spmb.pendaftar') }}" class="block px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors">
                                📝 Pendaftar
                            </a>
                            <a href="{{ route('spmb.daftar_ulang') }}" class="block px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors">
                                🎓 Daftar Ulang
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('contact') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Kontak</a>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold text-xs shadow-md transition-all">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-emerald-950 font-black text-xs shadow-md transition-all">
                            Login Portal
                        </a>
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="mobileMenuOpen" class="lg:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block py-2 text-sm font-bold text-slate-800 border-b border-slate-100">Beranda</a>
            <a href="{{ route('profile') }}" class="block py-2 text-sm font-bold text-slate-800 border-b border-slate-100">Profil</a>
            <a href="{{ route('academic.teachers') }}" class="block py-2 text-sm font-bold text-slate-800 border-b border-slate-100">Akademik</a>
            <a href="{{ route('student.extracurriculars') }}" class="block py-2 text-sm font-bold text-slate-800 border-b border-slate-100">Kesiswaan</a>
            <a href="{{ route('news.index') }}" class="block py-2 text-sm font-bold text-slate-800 border-b border-slate-100">Informasi</a>
            <a href="{{ route('gallery.index') }}" class="block py-2 text-sm font-bold text-slate-800 border-b border-slate-100">Galeri</a>
            <a href="{{ route('download.index') }}" class="block py-2 text-sm font-bold text-slate-800 border-b border-slate-100">Download</a>
            <div class="py-2 border-b border-slate-100 space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 block">SPMB</span>
                <a href="{{ route('spmb.pendaftar') }}" class="block pl-4 py-1 text-sm font-semibold text-slate-700">Pendaftar</a>
                <a href="{{ route('spmb.daftar_ulang') }}" class="block pl-4 py-1 text-sm font-semibold text-slate-700">Daftar Ulang</a>
            </div>
            <a href="{{ route('contact') }}" class="block py-2 text-sm font-bold text-slate-800">Kontak</a>
            <div class="pt-2">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-emerald-800 text-white font-bold text-xs">Dashboard Admin</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-amber-500 text-emerald-950 font-bold text-xs">Login Portal</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Page Content Container -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Premium Footer -->
    <footer class="bg-gradient-to-b from-slate-950 via-emerald-950 to-slate-950 text-slate-300 border-t border-emerald-900/60 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Col 1: Identity -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-amber-500 flex items-center justify-center text-emerald-950 font-black text-xl shadow-lg border border-amber-400">
                            24
                        </div>
                        <span class="font-black text-white text-xl tracking-tight uppercase">
                            {{ \App\Models\Setting::getValue('school_name', 'SMA NEGERI 24 BANDUNG') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                        {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614') }}. Sekolah berkarakter, unggul dalam prestasi akademik & non-akademik, serta berwawasan global.
                    </p>
                    <div class="pt-2 flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-900/80 text-emerald-300 border border-emerald-700">
                            NPSN: {{ \App\Models\Setting::getValue('school_npsn', '20219736') }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-400/30">
                            Akreditasi {{ \App\Models\Setting::getValue('school_accreditation', 'A (Unggul)') }}
                        </span>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-amber-400 mb-4 border-b border-emerald-900/80 pb-2">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('profile') }}" class="hover:text-amber-400 transition-colors">Profil Sekolah</a></li>
                        <li><a href="{{ route('academic.teachers') }}" class="hover:text-amber-400 transition-colors">Guru & Pendidik</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-amber-400 transition-colors">Berita & Informasi</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-amber-400 transition-colors">Galeri Foto & Video</a></li>
                    </ul>
                </div>

                <!-- Col 3: SPMB & Access -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-amber-400 mb-4 border-b border-emerald-900/80 pb-2">Layanan SPMB</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('spmb.pendaftar') }}" class="hover:text-amber-400 transition-colors">Pendaftar SPMB</a></li>
                        <li><a href="{{ route('spmb.daftar_ulang') }}" class="hover:text-amber-400 transition-colors">Daftar Ulang SPMB</a></li>
                        <li><a href="{{ route('download.index') }}" class="hover:text-amber-400 transition-colors">Pusat Unduhan Dokumen</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-amber-400 transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-emerald-900/80 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-3">
                <p>&copy; {{ date('Y') }} <strong>{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}</strong>. All rights reserved.</p>
                <p class="text-[11px] text-slate-400 font-mono">Designed with Laravel 12 & Tailwind CSS v4</p>
            </div>
        </div>
    </footer>

</body>
</html>
