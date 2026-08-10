<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SMA Negeri 24 Bandung - Official Website')</title>
    <meta name="description" content="@yield('meta_description', 'Official Website SMA Negeri 24 Bandung - Jl. A.H. Nasution No. 27, Kota Bandung.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Topbar Contact & Announcement Info -->
    <div class="bg-emerald-950 text-emerald-100 text-xs py-2 px-4 border-b border-emerald-900">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}
                </span>
                <span class="hidden md:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ \App\Models\Setting::getValue('school_phone', '(022) 7800540') }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-2 py-0.5 rounded bg-emerald-900 text-amber-300 font-semibold text-[10px]">
                    NPSN: {{ \App\Models\Setting::getValue('school_npsn', '20219736') }}
                </span>
                <span class="text-slate-300 text-[11px]">Akreditasi: <strong>{{ \App\Models\Setting::getValue('school_accreditation', 'A (Unggul)') }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- School Logo & Title -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-800 flex items-center justify-center text-amber-400 font-extrabold text-lg shadow-md group-hover:bg-emerald-900 transition-colors">
                        24
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-slate-900 text-base tracking-tight group-hover:text-emerald-800 transition-colors uppercase">
                            {{ \App\Models\Setting::getValue('school_name', 'SMAN 24 BANDUNG') }}
                        </span>
                        <span class="text-[10px] text-slate-500 font-medium tracking-wide">
                            Official School Portal
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-6 text-xs font-bold text-slate-700">
                    <a href="{{ route('home') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('home') ? 'text-emerald-800 font-extrabold' : '' }}">Beranda</a>
                    <a href="{{ route('profile') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('profile') ? 'text-emerald-800 font-extrabold' : '' }}">Profil</a>
                    <a href="{{ route('academic.teachers') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('academic.*') ? 'text-emerald-800 font-extrabold' : '' }}">Akademik</a>
                    <a href="{{ route('student.extracurriculars') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('student.*') ? 'text-emerald-800 font-extrabold' : '' }}">Kesiswaan</a>
                    <a href="{{ route('news.index') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('news.*') ? 'text-emerald-800 font-extrabold' : '' }}">Informasi</a>
                    <a href="{{ route('gallery.index') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('gallery.*') ? 'text-emerald-800 font-extrabold' : '' }}">Galeri</a>
                    <a href="{{ route('download.index') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('download.*') ? 'text-emerald-800 font-extrabold' : '' }}">Download</a>
                    
                    <!-- SPMB Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="flex items-center gap-1 hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('spmb.*') ? 'text-emerald-800 font-extrabold' : '' }}">
                            <span>SPMB</span>
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute left-0 mt-0 w-44 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50">
                            <a href="{{ route('spmb.pendaftar') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800">
                                Pendaftar
                            </a>
                            <a href="{{ route('spmb.daftar_ulang') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800">
                                Daftar Ulang
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="hover:text-emerald-800 transition-colors {{ request()->routeIs('contact') ? 'text-emerald-800 font-extrabold' : '' }}">Kontak</a>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs shadow-sm transition-all">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold text-xs shadow-sm transition-all">
                            Login Portal
                        </a>
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100">
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
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">SPMB</span>
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

    <!-- Global Footer -->
    <footer class="bg-emerald-950 text-slate-300 border-t border-emerald-900 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Col 1: Identity -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-emerald-950 font-extrabold text-lg">
                            24
                        </div>
                        <span class="font-extrabold text-white text-lg tracking-tight uppercase">
                            {{ \App\Models\Setting::getValue('school_name', 'SMA NEGERI 24 BANDUNG') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                        {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614') }}. Sekolah berkarakter, unggul dalam prestasi akademik & non-akademik.
                    </p>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400">Beranda</a></li>
                        <li><a href="{{ route('profile') }}" class="hover:text-amber-400">Profil Sekolah</a></li>
                        <li><a href="{{ route('academic.teachers') }}" class="hover:text-amber-400">Guru & Pendidik</a></li>
                        <li><a href="{{ route('news.index') }}" class="hover:text-amber-400">Berita & Informasi</a></li>
                    </ul>
                </div>

                <!-- Col 3: SPMB & Access -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 mb-4">Layanan SPMB</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('spmb.pendaftar') }}" class="hover:text-amber-400">Pendaftar SPMB</a></li>
                        <li><a href="{{ route('spmb.daftar_ulang') }}" class="hover:text-amber-400">Daftar Ulang SPMB</a></li>
                        <li><a href="{{ route('download.index') }}" class="hover:text-amber-400">Pusat Unduhan Dokumen</a></li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-emerald-900 mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-2">
                <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}. All rights reserved.</p>
                <p class="text-[11px]">Designed with Laravel 12 & Tailwind CSS v4</p>
            </div>
        </div>
    </footer>

</body>
</html>
