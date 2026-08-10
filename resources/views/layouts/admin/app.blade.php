<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - SMAN 24 Bandung')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sleek Dark-Emerald Admin Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-slate-950 via-emerald-950 to-slate-950 text-slate-200 flex flex-col transition-transform duration-300 ease-in-out border-r border-emerald-900/60 shadow-2xl">
            
            <!-- Sidebar Header Brand -->
            <div class="h-20 flex items-center justify-between px-6 bg-slate-950/90 border-b border-emerald-900/80">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 flex items-center justify-center font-black text-emerald-950 text-sm shadow-lg border border-amber-400">
                        24
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-white tracking-tight text-sm uppercase font-sans">ADMIN SMAN 24</span>
                        <span class="text-[9px] text-amber-400 font-bold tracking-widest uppercase">CMS Management</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- User Info Card -->
            <div class="p-4 mx-4 mt-4 bg-emerald-900/30 rounded-2xl border border-emerald-700/40 shadow-inner">
                <div class="flex items-center gap-3">
                    @if(auth()->user() && auth()->user()->avatar)
                        <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-amber-400 shrink-0">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 flex items-center justify-center font-extrabold text-white text-sm shrink-0 border border-emerald-500/40 shadow-md">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                    <div class="overflow-hidden text-xs">
                        <p class="font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-slate-400 truncate text-[11px]">{{ auth()->user()->email ?? 'admin@sman24bdg.sch.id' }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[9px] font-extrabold bg-amber-500 text-emerald-950 uppercase shadow-sm">
                            {{ auth()->user()->role ?? 'admin' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation Categories & Items -->
            <nav class="flex-1 px-4 mt-4 space-y-4 text-xs font-semibold overflow-y-auto pb-6">
                
                <!-- Main Dashboard -->
                <div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 text-white font-extrabold shadow-md border border-emerald-600' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </div>

                <!-- Group: Konten Publikasi -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-amber-400/80">Konten Publikasi</div>
                    <a href="{{ route('admin.sliders.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.sliders.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>🖼️ Hero Image Slider</span>
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.news.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>📰 Berita Sekolah</span>
                    </a>
                    <a href="{{ route('admin.news-categories.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.news-categories.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>🏷️ Kategori Berita</span>
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.announcements.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>📢 Pengumuman</span>
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.events.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>🗓️ Agenda Sekolah</span>
                    </a>
                </div>

                <!-- Group: Data Sekolah -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-amber-400/80">Data Sekolah</div>
                    <a href="{{ route('admin.profiles.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.profiles.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>🏛️ Profil Sekolah</span>
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.teachers.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>👨‍🏫 Data Guru & Pendidik</span>
                    </a>
                    <a href="{{ route('admin.staff.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>👔 Tenaga Kependidikan</span>
                    </a>
                    <a href="{{ route('admin.achievements.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.achievements.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>🏆 Prestasi Siswa</span>
                    </a>
                    <a href="{{ route('admin.extracurriculars.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.extracurriculars.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>⚽ Ekstrakurikuler</span>
                    </a>
                </div>

                <!-- Group: Media & Dokumen -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-amber-400/80">Media & Dokumen</div>
                    <a href="{{ route('admin.galleries.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.galleries.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>🖼️ Galeri Foto</span>
                    </a>
                    <a href="{{ route('admin.videos.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.videos.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>▶️ Video YouTube</span>
                    </a>
                    <a href="{{ route('admin.documents.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.documents.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>📁 Dokumen & SPMB</span>
                    </a>
                </div>

                <!-- Group: Pengaturan & Pengguna -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-amber-400/80">Sistem & Pengguna</div>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>🔑 Pengguna & Hak Akses</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <span>⚙️ Pengaturan Website</span>
                    </a>
                </div>

            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-emerald-900/60 bg-slate-950/80">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-900/30 hover:bg-rose-900/80 text-rose-300 text-xs font-bold border border-rose-800/50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar dari Sistem
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content Area Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-100">
            
            <!-- Topbar Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-sm sm:text-base font-extrabold text-slate-900">Portal Administrasi CMS</h1>
                        <p class="text-[11px] text-slate-500 hidden sm:block">{{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }} - {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200 transition-colors shadow-sm">
                        <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden sm:inline">Lihat Website Utama</span>
                        <span class="sm:hidden">Web</span>
                    </a>
                </div>
            </header>

            <!-- Breadcrumb Navigation -->
            <div class="bg-white border-b border-slate-200 px-6 py-2.5 text-xs text-slate-500 flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700 font-medium">Admin</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-800 font-bold">@yield('breadcrumb', 'Dashboard')</span>
            </div>

            <!-- Page Flash Notifications -->
            <div class="p-6 pb-0 space-y-3">
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
            </div>

            <!-- Content Body -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 px-6 py-4 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
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
