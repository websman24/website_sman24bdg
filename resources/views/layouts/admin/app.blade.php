<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - SMAN 24 Bandung')</title>

    <!-- Favicon & App Icon -->
    @if(\App\Models\Setting::getValue('school_logo'))
        <link rel="icon" type="image/png" href="{{ asset(\App\Models\Setting::getValue('school_logo')) }}">
        <link rel="apple-touch-icon" href="{{ asset(\App\Models\Setting::getValue('school_logo')) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Trix Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
    </style>
    <script>
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- Mobile Backdrop Overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-40 md:hidden"
         style="display: none;"></div>

    <div class="h-screen flex flex-col md:flex-row overflow-hidden">
        
        <!-- Sleek Dark-Emerald Admin Sidebar (Fixed & Independent Scroll) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="fixed md:static inset-y-0 left-0 z-50 w-64 h-full bg-gradient-to-b from-slate-950 via-emerald-950 to-slate-950 text-slate-200 flex flex-col transition-transform duration-300 ease-in-out border-r border-emerald-900/60 shadow-2xl shrink-0"
               x-data="{
                   openPublikasi: {{ request()->routeIs(['admin.news.*', 'admin.news-categories.*', 'admin.announcements.*', 'admin.events.*', 'admin.sliders.*', 'admin.spmb-quotes.*']) ? 'true' : 'false' }},
                   openAkademik: {{ request()->routeIs(['admin.profiles.*', 'admin.teachers.*', 'admin.staff.*', 'admin.achievements.*', 'admin.extracurriculars.*']) ? 'true' : 'false' }},
                   openMedia: {{ request()->routeIs(['admin.galleries.*', 'admin.videos.*', 'admin.documents.*']) ? 'true' : 'false' }},
                   openSistem: {{ request()->routeIs(['admin.users.*', 'admin.settings.*']) ? 'true' : 'false' }}
               }">
            
            <!-- Sidebar Header Brand -->
            <div class="h-16 sm:h-20 flex items-center justify-between px-6 bg-slate-950/90 border-b border-emerald-900/80 shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    @if(\App\Models\Setting::getValue('school_logo'))
                        <img src="{{ asset(\App\Models\Setting::getValue('school_logo')) }}" alt="Logo Sekolah" class="w-9 h-9 object-contain bg-white/10 rounded-xl p-1 border border-amber-400/40 shadow-md shrink-0">
                    @else
                        <div class="w-9 h-9 rounded-xl bg-amber-500 flex items-center justify-center font-black text-emerald-950 text-sm shadow-lg border border-amber-400 shrink-0">
                            24
                        </div>
                    @endif
                    <div class="flex flex-col min-w-0">
                        <span class="font-black text-white tracking-tight text-sm uppercase font-sans truncate">ADMIN SMAN 24</span>
                        <span class="text-[9px] text-amber-400 font-bold tracking-widest uppercase truncate">CMS Management</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white p-1" aria-label="Tutup Sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- User Info Card -->
            <div class="p-3.5 mx-3 mt-3 bg-emerald-900/30 rounded-2xl border border-emerald-700/40 shadow-inner shrink-0">
                <div class="flex items-center gap-3">
                    @if(auth()->user() && auth()->user()->avatar)
                        <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full object-cover border-2 border-amber-400 shrink-0">
                    @else
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center font-extrabold text-white text-xs shrink-0 border border-emerald-500/40 shadow-md">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                    <div class="overflow-hidden text-xs min-w-0">
                        <p class="font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-slate-400 truncate text-[10px]">{{ auth()->user()->email ?? 'admin@sman24bdg.sch.id' }}</p>
                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[8px] font-extrabold bg-amber-500 text-emerald-950 uppercase shadow-sm">
                            {{ auth()->user()->role ?? 'admin' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation Collapsible Accordions -->
            <nav class="flex-1 px-3 mt-3 space-y-2 text-xs font-semibold overflow-y-auto pb-6 custom-scrollbar">
                
                <!-- Main Dashboard Link -->
                <div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 text-white font-extrabold shadow-md border border-emerald-600' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="w-7 h-7 rounded-lg bg-emerald-800/80 text-amber-400 flex items-center justify-center shadow-inner shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </div>
                        <span class="font-bold">Dashboard Utama</span>
                    </a>
                </div>

                <!-- Dropdown 1: Konten Publikasi (Superadmin, Admin, Editor) -->
                @if(auth()->user() && auth()->user()->hasAnyRole(['superadmin', 'admin', 'editor']))
                <div class="space-y-1">
                    <button @click="openPublikasi = !openPublikasi" 
                            type="button"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all font-bold {{ request()->routeIs(['admin.news.*', 'admin.news-categories.*', 'admin.announcements.*', 'admin.events.*', 'admin.sliders.*', 'admin.spmb-quotes.*']) ? 'bg-emerald-900/60 text-amber-400 border border-emerald-700/60 shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-800/80 text-amber-400 flex items-center justify-center shadow-inner shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                            <span class="font-bold">Konten Publikasi</span>
                        </div>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openPublikasi ? 'rotate-180 text-amber-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openPublikasi" 
                          x-transition:enter="transition ease-out duration-150"
                          x-transition:enter-start="opacity-0 -translate-y-1"
                          x-transition:enter-end="opacity-100 translate-y-0"
                          class="mt-1 pl-3 pr-1 space-y-1 border-l-2 border-emerald-800/60 ml-4 py-1"
                          style="display: none;">
                        <a href="{{ route('admin.news.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.news.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Berita Sekolah</span>
                        </a>
                        <a href="{{ route('admin.news-categories.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.news-categories.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span>Kategori Berita</span>
                        </a>
                        <a href="{{ route('admin.announcements.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.announcements.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            <span>Pengumuman Resmi</span>
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.events.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Agenda Kegiatan</span>
                        </a>
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.sliders.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-purple-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Hero Image Slider</span>
                        </a>
                        <a href="{{ route('admin.spmb-quotes.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.spmb-quotes.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            <span>Running Text SPMB</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Dropdown 2: Data Sekolah & Kesiswaan (Superadmin, Admin) -->
                @if(auth()->user() && auth()->user()->isAdmin())
                <div class="space-y-1">
                    <button @click="openAkademik = !openAkademik" 
                            type="button"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all font-bold {{ request()->routeIs(['admin.profiles.*', 'admin.teachers.*', 'admin.staff.*', 'admin.achievements.*', 'admin.extracurriculars.*']) ? 'bg-emerald-900/60 text-amber-400 border border-emerald-700/60 shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-800/80 text-amber-400 flex items-center justify-center shadow-inner shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                            </div>
                            <span class="font-bold">Sekolah & Kesiswaan</span>
                        </div>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openAkademik ? 'rotate-180 text-amber-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openAkademik" 
                          x-transition:enter="transition ease-out duration-150"
                          x-transition:enter-start="opacity-0 -translate-y-1"
                          x-transition:enter-end="opacity-100 translate-y-0"
                          class="mt-1 pl-3 pr-1 space-y-1 border-l-2 border-emerald-800/60 ml-4 py-1"
                          style="display: none;">
                        <a href="{{ route('admin.profiles.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.profiles.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Profil & Visi Misi</span>
                        </a>
                        <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.teachers.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Guru & Pendidik</span>
                        </a>
                        <a href="{{ route('admin.staff.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2H9.17A3.001 3.001 0 0112 14z"/></svg>
                            <span>Tenaga Kependidikan</span>
                        </a>
                        <a href="{{ route('admin.achievements.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.achievements.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            <span>Prestasi Siswa</span>
                        </a>
                        <a href="{{ route('admin.extracurriculars.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.extracurriculars.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-orange-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                            <span>Ekstrakurikuler</span>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Dropdown 3: Media & Dokumen -->
                <div class="space-y-1">
                    <button @click="openMedia = !openMedia" 
                            type="button"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all font-bold {{ request()->routeIs(['admin.galleries.*', 'admin.videos.*', 'admin.documents.*']) ? 'bg-emerald-900/60 text-amber-400 border border-emerald-700/60 shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-800/80 text-amber-400 flex items-center justify-center shadow-inner shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="font-bold">Media & Dokumen</span>
                        </div>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openMedia ? 'rotate-180 text-amber-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openMedia" 
                          x-transition:enter="transition ease-out duration-150"
                          x-transition:enter-start="opacity-0 -translate-y-1"
                          x-transition:enter-end="opacity-100 translate-y-0"
                          class="mt-1 pl-3 pr-1 space-y-1 border-l-2 border-emerald-800/60 ml-4 py-1"
                          style="display: none;">
                        @if(auth()->user() && auth()->user()->hasAnyRole(['superadmin', 'admin', 'editor']))
                        <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.galleries.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Galeri Foto</span>
                        </a>
                        <a href="{{ route('admin.videos.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.videos.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Video YouTube</span>
                        </a>
                        @endif
                        <a href="{{ route('admin.documents.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.documents.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Dokumen & SPMB</span>
                        </a>
                    </div>
                </div>

                <!-- Dropdown 4: Sistem & Pengaturan (Superadmin, Admin) -->
                @if(auth()->user() && auth()->user()->isAdmin())
                <div class="space-y-1">
                    <button @click="openSistem = !openSistem" 
                            type="button"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all font-bold {{ request()->routeIs(['admin.users.*', 'admin.settings.*']) ? 'bg-emerald-900/60 text-amber-400 border border-emerald-700/60 shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-800/80 text-amber-400 flex items-center justify-center shadow-inner shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="font-bold">Sistem & Pengguna</span>
                        </div>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openSistem ? 'rotate-180 text-amber-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openSistem" 
                          x-transition:enter="transition ease-out duration-150"
                          x-transition:enter-start="opacity-0 -translate-y-1"
                          x-transition:enter-end="opacity-100 translate-y-0"
                          class="mt-1 pl-3 pr-1 space-y-1 border-l-2 border-emerald-800/60 ml-4 py-1"
                          style="display: none;">
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.users.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            <span>Pengguna & Hak Akses</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[11px] transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-800 text-white font-extrabold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            <span>Pengaturan Website</span>
                        </a>
                    </div>
                </div>
                @endif

            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-3 border-t border-emerald-900/60 bg-slate-950/80 shrink-0">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-900/30 hover:bg-rose-900/80 text-rose-300 text-xs font-bold border border-rose-800/50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar dari Sistem
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content Area Wrapper (Fixed Header + Independent Content Scroll) -->
        <div class="flex-1 flex flex-col h-full min-w-0 bg-slate-100 overflow-hidden">
            
            <!-- Fixed Topbar Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 shadow-sm shrink-0 z-10">
                <div class="flex items-center gap-4 min-w-0">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100" aria-label="Buka Menu Sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="min-w-0">
                        <h1 class="text-sm sm:text-base font-extrabold text-slate-900 truncate">Portal Administrasi CMS</h1>
                        <p class="text-[11px] text-slate-500 hidden sm:block truncate">{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }} - {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200 transition-colors shadow-sm">
                        <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden sm:inline">Lihat Website Utama</span>
                        <span class="sm:hidden">Web</span>
                    </a>
                </div>
            </header>

            <!-- Fixed Breadcrumb Navigation -->
            <div class="bg-white border-b border-slate-200 px-4 sm:px-6 py-2.5 text-xs text-slate-500 flex items-center gap-2 shrink-0 z-10">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700 font-medium">Admin</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-800 font-bold">@yield('breadcrumb', 'Dashboard')</span>
            </div>

            <!-- Independent Scrollable Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6 custom-scrollbar">
                <!-- Page Flash Notifications -->
                @if(session('success'))
                    <x-alert type="success">
                        <span class="font-bold">{{ session('success') }}</span>
                    </x-alert>
                @endif
                @if(session('error'))
                    <x-alert type="error">
                        <span class="font-bold">{{ session('error') }}</span>
                    </x-alert>
                @endif
                @if(session('warning'))
                    <x-alert type="warning">
                        <span class="font-bold">{{ session('warning') }}</span>
                    </x-alert>
                @endif

                <!-- Content Body -->
                @yield('content')
            </main>

            <!-- Fixed Footer at the Bottom -->
            <footer class="bg-white border-t border-slate-200 px-4 sm:px-6 py-3 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2 shrink-0 z-10 shadow-xs">
                <div>
                    &copy; {{ date('Y') }} <strong>{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}</strong>. All rights reserved.
                </div>
                <div class="text-[11px] text-slate-400 font-mono">
                    {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}
                </div>
            </footer>

        </div>

    </div>

</body>
</html>
