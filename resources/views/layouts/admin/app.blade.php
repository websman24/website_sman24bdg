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
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-200 flex flex-col transition-transform duration-300 ease-in-out border-r border-slate-800 shadow-xl">
            
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-6 bg-slate-950 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center font-extrabold text-emerald-950 text-sm">
                        24
                    </div>
                    <span class="font-extrabold text-white tracking-tight text-sm">ADMIN SMAN 24</span>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- User Info Card -->
            <div class="p-4 mx-4 mt-4 bg-slate-800/70 rounded-xl border border-slate-700/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-700 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden text-xs">
                        <p class="font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-slate-400 truncate text-[11px]">{{ auth()->user()->email ?? 'admin@sman24bdg.sch.id' }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[9px] font-bold bg-amber-500 text-emerald-950 uppercase">
                            {{ auth()->user()->role ?? 'admin' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Sidebar Nav Categories & Items -->
            <nav class="flex-1 px-4 mt-4 space-y-4 text-xs font-semibold overflow-y-auto pb-6">
                
                <!-- Group: Main -->
                <div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-700 text-white font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                </div>

                <!-- Group: Konten -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Konten</div>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Berita</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Pengumuman</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Agenda</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                </div>

                <!-- Group: Sekolah -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Sekolah</div>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Profil</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Guru & Tendik</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Fasilitas</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                </div>

                <!-- Group: Media -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Media</div>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Galeri</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Download</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                </div>

                <!-- Group: Pengaturan -->
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Pengaturan</div>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>User</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                    <a href="javascript:void(0)" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 transition-colors">
                        <span>Pengaturan Website</span>
                        <span class="text-[9px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-500">Soon</span>
                    </a>
                </div>

            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-900/40 hover:bg-rose-900/80 text-rose-300 text-xs font-bold border border-rose-800/50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar dari Sistem
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content Area Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-100">
            
            <!-- Header -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-sm sm:text-base font-bold text-slate-900">Portal Administrasi Website</h1>
                        <p class="text-[11px] text-slate-500 hidden sm:block">SMA Negeri 24 Bandung - Jl. A.H. Nasution No. 27, Kota Bandung</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
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
            <div class="p-6 pb-0">
                @if(session('success'))
                    <div class="p-4 mb-2 text-xs text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center gap-3 shadow-sm">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 px-6 py-4 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    &copy; {{ date('Y') }} <strong>SMA Negeri 24 Bandung</strong>. All rights reserved.
                </div>
                <div class="text-[11px] text-slate-400">
                    Jl. A.H. Nasution No. 27, Kota Bandung
                </div>
            </footer>
        </div>

    </div>

</body>
</html>
