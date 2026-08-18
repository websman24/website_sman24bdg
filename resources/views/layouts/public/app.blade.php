<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    
    <title>@yield('title', \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') . ' - Official Website')</title>
    <meta name="description" content="@yield('meta_description', 'Official Website ' . \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') . ' - ' . \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') . '. Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global.')">
    <meta name="keywords" content="@yield('meta_keywords', 'SMAN 24 Bandung, SMA Negeri 24 Bandung, Sekolah Bandung, SPMB SMAN 24, PPDB SMAN 24, Ekstrakurikuler SMAN 24, Alumni SMAN 24')">
    <!-- Favicon & App Icon -->
    @if(\App\Models\Setting::getValue('school_logo'))
        <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::getValue('school_logo')) }}">
        <link rel="apple-touch-icon" href="{{ asset(\App\Models\Setting::getValue('school_logo')) }}">
    @endif
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#064e3b">

    <!-- Canonical Link -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung'))">
    <meta property="og:description" content="@yield('og_description', \App\Models\Setting::getValue('school_motto', 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global') . ' - ' . \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung'))">
    <meta property="og:image" content="@yield('og_image', asset(\App\Models\Setting::getValue('school_logo', 'storage/uploads/settings/school_logo.png')))">
    <meta property="og:site_name" content="{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung'))">
    <meta name="twitter:description" content="@yield('og_description', \App\Models\Setting::getValue('school_motto', 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global'))">
    <meta name="twitter:image" content="@yield('og_image', asset(\App\Models\Setting::getValue('school_logo', 'storage/uploads/settings/school_logo.png')))">

    <!-- Structured Data JSON-LD (Schema.org) -->
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "{{ '@type' }}": "EducationalOrganization",
      "name": "{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}",
      "url": "{{ url('/') }}",
      "logo": "{{ asset(\App\Models\Setting::getValue('school_logo', 'storage/uploads/settings/school_logo.png')) }}",
      "address": {
        "{{ '@type' }}": "PostalAddress",
        "streetAddress": "{{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27') }}",
        "addressLocality": "Bandung",
        "addressRegion": "Jawa Barat",
        "postalCode": "40614",
        "addressCountry": "ID"
      },
      "telephone": "{{ \App\Models\Setting::getValue('school_phone', '(022) 7800540') }}",
      "email": "{{ \App\Models\Setting::getValue('school_email', 'info@sman24bdg.sch.id') }}"
    }
    </script>
    @yield('extra_json_ld')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Fixed Header (Topbar + Glassmorphism Navigation Bar) -->
    <header class="fixed top-0 inset-x-0 z-50 w-full shadow-md bg-white" x-data="{ mobileMenuOpen: false }">
        
        <!-- Premium Topbar Contact & Announcement Info -->
        <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-950 text-emerald-100 text-xs py-2 px-4 border-b border-emerald-900/60 shadow-inner">
            <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
                <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-[11px] sm:text-xs">
                    <span class="flex items-center gap-1.5 hover:text-amber-300 transition-colors">
                        <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="truncate max-w-[280px] sm:max-w-none">{{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}</span>
                    </span>
                    <span class="hidden md:flex items-center gap-1.5 hover:text-amber-300 transition-colors">
                        <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ \App\Models\Setting::getValue('school_phone', '(022) 7800540') }}
                    </span>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 text-[11px]">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-900/90 text-amber-400 font-extrabold text-[10px] sm:text-[11px] border border-amber-400/30 shadow-sm">
                        NPSN: {{ \App\Models\Setting::getValue('school_npsn', '20219736') }}
                    </span>
                    <span class="text-slate-300 hidden xs:inline">Akreditasi: <strong class="text-amber-400 font-extrabold">{{ \App\Models\Setting::getValue('school_accreditation', 'A (Unggul)') }}</strong></span>

                    @php
                        $igUrl = \App\Models\Setting::getValue('instagram_url');
                        $fbUrl = \App\Models\Setting::getValue('facebook_url');
                        $ytUrl = \App\Models\Setting::getValue('youtube_url');
                        $tiktokUrl = \App\Models\Setting::getValue('tiktok_url');
                        $xUrl = \App\Models\Setting::getValue('twitter_url');
                    @endphp
                    @if($igUrl || $fbUrl || $ytUrl || $tiktokUrl || $xUrl)
                        <div class="flex items-center gap-1 border-l border-emerald-800/80 pl-2 ml-1">
                            @if($igUrl)
                                <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer" class="p-1 rounded-md text-emerald-200 hover:text-amber-400 hover:bg-emerald-900/80 transition-all" title="Instagram Resmi" aria-label="Instagram">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.13-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($fbUrl)
                                <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer" class="p-1 rounded-md text-emerald-200 hover:text-amber-400 hover:bg-emerald-900/80 transition-all" title="Facebook Resmi" aria-label="Facebook">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($ytUrl)
                                <a href="{{ $ytUrl }}" target="_blank" rel="noopener noreferrer" class="p-1 rounded-md text-emerald-200 hover:text-amber-400 hover:bg-emerald-900/80 transition-all" title="YouTube Resmi" aria-label="YouTube">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if($tiktokUrl)
                                <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="p-1 rounded-md text-emerald-200 hover:text-amber-400 hover:bg-emerald-900/80 transition-all" title="TikTok Resmi" aria-label="TikTok">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                </a>
                            @endif
                            @if($xUrl)
                                <a href="{{ $xUrl }}" target="_blank" rel="noopener noreferrer" class="p-1 rounded-md text-emerald-200 hover:text-amber-400 hover:bg-emerald-900/80 transition-all" title="Twitter / X Resmi" aria-label="Twitter / X">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Glassmorphism Navigation Bar -->
        <div class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    
                    <!-- School Logo & Title -->
                    <a href="{{ route('home') }}" class="flex items-center gap-3 sm:gap-3.5 group min-w-0">
                        @if(\App\Models\Setting::getValue('school_logo'))
                            <img src="{{ asset(\App\Models\Setting::getValue('school_logo')) }}" alt="Logo {{ \App\Models\Setting::getValue('school_name', 'SMAN 24 BANDUNG') }}" class="w-10 h-10 sm:w-12 sm:h-12 object-contain group-hover:scale-105 transition-transform shrink-0">
                        @else
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-emerald-950 via-emerald-800 to-emerald-700 flex items-center justify-center text-amber-400 font-black text-lg sm:text-xl shadow-md group-hover:scale-105 transition-transform border border-amber-400/40 shrink-0">
                                24
                            </div>
                        @endif
                        <div class="flex flex-col min-w-0">
                            <span class="font-black text-slate-900 text-sm sm:text-lg tracking-tight group-hover:text-emerald-800 transition-colors uppercase font-sans truncate">
                                {{ \App\Models\Setting::getValue('school_name', 'SMAN 24 BANDUNG') }}
                            </span>
                            <span class="text-[9px] sm:text-[10px] text-slate-500 font-bold tracking-wider uppercase truncate">
                                {{ \App\Models\Setting::getValue('school_motto', 'Cerdas, Berkarakter, Berbudaya, dan Berwawasan Global') }}
                            </span>
                        </div>
                    </a>

                    <!-- Desktop Navigation Links -->
                    <nav class="hidden lg:flex items-center gap-5 xl:gap-6 text-xs font-bold text-slate-700">
                        <a href="{{ route('home') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('home') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Beranda</a>
                        <a href="{{ route('profile') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('profile') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Profil</a>
                        <!-- Kesiswaan Dropdown Menu -->
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button class="flex items-center gap-1 hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('student.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">
                                <span>Kesiswaan</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute left-0 mt-0 w-52 bg-white rounded-2xl shadow-2xl border border-slate-200 py-2 z-50">
                                <a href="{{ route('student.osis') }}" class="block px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-800 transition-colors">
                                    🏛️ OSIS & MPK
                                </a>
                                <a href="{{ route('student.extracurriculars') }}" class="block px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition-colors">
                                    ⚽ Ekstrakurikuler
                                </a>
                                <a href="{{ route('student.achievements') }}" class="block px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-amber-50 hover:text-amber-800 transition-colors">
                                    🏆 Prestasi Siswa
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('news.index') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('news.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Informasi</a>
                        <a href="{{ route('gallery.index') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('gallery.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Galeri</a>
                        <a href="{{ route('download.index') }}" class="hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('download.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">Download</a>
                        
                        <!-- SPMB Dropdown Menu -->
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button class="flex items-center gap-1 hover:text-emerald-800 transition-colors py-2 {{ request()->routeIs('spmb.*') ? 'text-emerald-800 font-extrabold border-b-2 border-emerald-800' : '' }}">
                                <span>SPMB</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
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
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="lg:hidden p-2.5 rounded-xl text-slate-700 hover:text-emerald-800 hover:bg-slate-100 border border-slate-200 transition-all shadow-sm focus:outline-none"
                            aria-label="Toggle Navigation Menu">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer Menu with Smooth Transitions -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="lg:hidden bg-white/98 backdrop-blur-xl border-b border-slate-200/90 px-5 pt-3 pb-8 space-y-2 shadow-2xl max-h-[85vh] overflow-y-auto"
                 style="display: none;">
                
                <a href="{{ route('home') }}" class="flex items-center gap-3 py-3 px-3 rounded-xl text-sm font-bold {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-800 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>🏠</span> <span>Beranda</span>
                </a>
                <a href="{{ route('profile') }}" class="flex items-center gap-3 py-3 px-3 rounded-xl text-sm font-bold {{ request()->routeIs('profile') ? 'bg-emerald-50 text-emerald-800 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>🏛️</span> <span>Profil Sekolah</span>
                </a>
                <!-- Mobile Kesiswaan Section -->
                <div class="py-2.5 px-3 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-1.5">
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-800 flex items-center gap-1.5">
                        <span>🏆</span> Kesiswaan & Ekstra
                    </span>
                    <div class="grid grid-cols-1 gap-1 pt-1">
                        <a href="{{ route('student.osis') }}" class="flex items-center gap-2 py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-800 hover:bg-indigo-50 hover:text-indigo-800 transition-colors shadow-xs">
                            <span>🏛️</span> OSIS & MPK
                        </a>
                        <a href="{{ route('student.extracurriculars') }}" class="flex items-center gap-2 py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-800 hover:bg-emerald-50 hover:text-emerald-800 transition-colors shadow-xs">
                            <span>⚽</span> Ekstrakurikuler
                        </a>
                        <a href="{{ route('student.achievements') }}" class="flex items-center gap-2 py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-800 hover:bg-amber-50 hover:text-amber-800 transition-colors shadow-xs">
                            <span>🏆</span> Prestasi Siswa
                        </a>
                    </div>
                </div>
                <a href="{{ route('news.index') }}" class="flex items-center gap-3 py-3 px-3 rounded-xl text-sm font-bold {{ request()->routeIs('news.*') ? 'bg-emerald-50 text-emerald-800 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>📰</span> <span>Informasi & Berita</span>
                </a>
                <a href="{{ route('gallery.index') }}" class="flex items-center gap-3 py-3 px-3 rounded-xl text-sm font-bold {{ request()->routeIs('gallery.*') ? 'bg-emerald-50 text-emerald-800 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>📸</span> <span>Galeri Kegiatan</span>
                </a>
                <a href="{{ route('download.index') }}" class="flex items-center gap-3 py-3 px-3 rounded-xl text-sm font-bold {{ request()->routeIs('download.*') ? 'bg-emerald-50 text-emerald-800 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>📥</span> <span>Pusat Download</span>
                </a>
                
                <!-- Mobile SPMB Section -->
                <div class="py-2.5 px-3 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-1.5">
                    <span class="text-xs font-black uppercase tracking-wider text-amber-600 flex items-center gap-1.5">
                        <span>📋</span> Layanan SPMB
                    </span>
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <a href="{{ route('spmb.pendaftar') }}" class="text-center py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-800 hover:bg-emerald-50 hover:text-emerald-800 transition-colors shadow-sm">
                            Pendaftar
                        </a>
                        <a href="{{ route('spmb.daftar_ulang') }}" class="text-center py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-800 hover:bg-emerald-50 hover:text-emerald-800 transition-colors shadow-sm">
                            Daftar Ulang
                        </a>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="flex items-center gap-3 py-3 px-3 rounded-xl text-sm font-bold {{ request()->routeIs('contact') ? 'bg-emerald-50 text-emerald-800 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
                    <span>📞</span> <span>Kontak Kami</span>
                </a>

                @if($igUrl || $fbUrl || $ytUrl || $tiktokUrl || $xUrl)
                    <div class="pt-3 pb-1 flex items-center justify-between px-1">
                        <span class="text-xs font-bold text-slate-500">Medsos Resmi:</span>
                        <div class="flex items-center gap-2">
                            @if($igUrl)
                                <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-slate-100 text-emerald-800 hover:bg-emerald-100" title="Instagram Resmi">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.13-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($fbUrl)
                                <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-slate-100 text-emerald-800 hover:bg-emerald-100" title="Facebook Resmi">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($ytUrl)
                                <a href="{{ $ytUrl }}" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-slate-100 text-emerald-800 hover:bg-emerald-100" title="YouTube Resmi">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if($tiktokUrl)
                                <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-slate-100 text-emerald-800 hover:bg-emerald-100" title="TikTok Resmi">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                </a>
                            @endif
                            @if($xUrl)
                                <a href="{{ $xUrl }}" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-slate-100 text-emerald-800 hover:bg-emerald-100" title="Twitter / X Resmi">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="pt-4 border-t border-slate-200">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-emerald-800 text-white font-extrabold text-xs shadow-md">
                            <span>📊</span> Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-amber-500 text-emerald-950 font-black text-xs shadow-md">
                            <span>🔐</span> Login Portal
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content Container with Offset for Fixed Header -->
    <main class="flex-grow pt-[128px] sm:pt-[116px]">
        @yield('content')
    </main>

    <!-- Global Premium Footer -->
    <footer class="bg-gradient-to-b from-slate-950 via-emerald-950 to-slate-950 text-slate-300 border-t border-emerald-900/60 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                
                <!-- Col 1: Identity -->
                <div class="space-y-4 sm:col-span-2">
                    <div class="flex items-center gap-3.5">
                        @if(\App\Models\Setting::getValue('school_logo'))
                            <img src="{{ asset(\App\Models\Setting::getValue('school_logo')) }}" alt="Logo {{ \App\Models\Setting::getValue('school_name', 'SMA NEGERI 24 BANDUNG') }}" class="w-12 h-12 object-contain bg-white/10 rounded-xl p-1 border border-white/20">
                        @else
                            <div class="w-11 h-11 rounded-2xl bg-amber-500 flex items-center justify-center text-emerald-950 font-black text-xl shadow-lg border border-amber-400">
                                24
                            </div>
                        @endif
                        <span class="font-black text-white text-lg sm:text-xl tracking-tight uppercase">
                            {{ \App\Models\Setting::getValue('school_name', 'SMA NEGERI 24 BANDUNG') }}
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-md leading-relaxed">
                        {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat 40614') }}. Sekolah berkarakter, unggul dalam prestasi akademik & non-akademik, serta berwawasan global.
                    </p>
                    <div class="pt-2 flex flex-wrap items-center gap-2.5">
                        <span class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold bg-emerald-900/80 text-emerald-300 border border-emerald-700">
                            NPSN: {{ \App\Models\Setting::getValue('school_npsn', '20219736') }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-[10px] sm:text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-400/30">
                            Akreditasi {{ \App\Models\Setting::getValue('school_accreditation', 'A (Unggul)') }}
                        </span>
                    </div>
                    @if($igUrl || $fbUrl || $ytUrl || $tiktokUrl || $xUrl)
                        <div class="pt-3 flex items-center gap-2">
                            <span class="text-xs text-slate-400 font-semibold">Ikuti Kami:</span>
                            @if($igUrl)
                                <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900/80 border border-emerald-800/80 text-slate-300 hover:text-amber-400 hover:border-amber-400 flex items-center justify-center transition-all" title="Instagram">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.13-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($fbUrl)
                                <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900/80 border border-emerald-800/80 text-slate-300 hover:text-amber-400 hover:border-amber-400 flex items-center justify-center transition-all" title="Facebook">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($ytUrl)
                                <a href="{{ $ytUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900/80 border border-emerald-800/80 text-slate-300 hover:text-amber-400 hover:border-amber-400 flex items-center justify-center transition-all" title="YouTube">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if($tiktokUrl)
                                <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-900/80 border border-emerald-800/80 text-slate-300 hover:text-amber-400 hover:border-amber-400 flex items-center justify-center transition-all" title="TikTok">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-amber-400 mb-4 border-b border-emerald-900/80 pb-2">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('profile') }}" class="hover:text-amber-400 transition-colors">Profil Sekolah</a></li>
                        <li><a href="{{ route('student.osis') }}" class="hover:text-amber-400 transition-colors">OSIS & MPK</a></li>
                        <li><a href="{{ route('student.extracurriculars') }}" class="hover:text-amber-400 transition-colors">Ekstrakurikuler</a></li>
                        <li><a href="{{ route('student.achievements') }}" class="hover:text-amber-400 transition-colors">Prestasi Siswa</a></li>
                        <li><a href="{{ route('academic.teachers') }}" class="hover:text-amber-400 transition-colors">Guru & Tendik</a></li>
                    </ul>
                </div>

                <!-- Col 3: SPMB & Access -->
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-amber-400 mb-4 border-b border-emerald-900/80 pb-2">Layanan SPMB</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="{{ route('spmb.pendaftar') }}" class="hover:text-amber-400 transition-colors">Pendaftar SPMB</a></li>
                        <li><a href="{{ route('spmb.daftar_ulang') }}" class="hover:text-amber-400 transition-colors">Daftar Ulang SPMB</a></li>
                        <li><a href="{{ route('download.index') }}" class="hover:text-amber-400 transition-colors">Pusat Unduhan Dokumen</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-amber-400 transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-emerald-900/80 mt-10 sm:mt-12 pt-6 sm:pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-3 text-center sm:text-left">
                <p>&copy; {{ date('Y') }} <strong>{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}</strong>. All rights reserved.</p>
                <p class="text-[11px] text-slate-400 font-mono">Designed with Laravel 12 & Tailwind CSS v4</p>
            </div>
        </div>
    </footer>

</body>
</html>
