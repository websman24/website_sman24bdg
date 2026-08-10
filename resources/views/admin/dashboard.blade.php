@extends('layouts.admin.app')

@section('title', 'Admin Dashboard - SMAN 24 Bandung')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- 1. BANNER WELCOME CARD: Selamat Datang Admin -->
    <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-950 rounded-3xl p-6 sm:p-8 text-white shadow-2xl relative overflow-hidden border border-emerald-900/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="relative z-10 space-y-2 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-900/80 border border-amber-400/40 text-amber-400 text-xs font-extrabold shadow-inner">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                PORTAL ADMINISTRASI CMS TERPADU
            </div>
            <h2 class="text-2xl sm:text-4xl font-black tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}!
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Kelola data berita, agenda, pendidik, galeri foto, dokumen, serta akun administrator {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.
            </p>
        </div>

        <div class="flex items-center gap-3 bg-emerald-900/40 p-4 rounded-2xl border border-emerald-700/50 shrink-0">
            <div class="w-12 h-12 rounded-full bg-emerald-800 text-amber-400 font-black text-xl flex items-center justify-center border-2 border-amber-400/60 shadow-md">
                👤
            </div>
            <div class="text-xs">
                <span class="text-slate-300 block">Role Anda:</span>
                <span class="font-extrabold text-amber-300 uppercase tracking-wider text-sm">{{ auth()->user()->role ?? 'Admin' }}</span>
            </div>
        </div>
    </div>

    <!-- 2. 4 KARTU STATISTIK UTAMA: Berita | Agenda | Guru | Galeri -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 📰 Berita -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 card-hover-effect">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider block">Berita Artikel</span>
                    <div class="text-3xl font-black text-slate-900">{{ number_format($stats['total_news'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-800 font-black text-2xl flex items-center justify-center shadow-sm border border-emerald-200">
                    📰
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Terbit: <strong>{{ $stats['published_news'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.news.index') }}" class="font-extrabold text-emerald-800 hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        <!-- 📅 Agenda -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 card-hover-effect">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider block">Agenda Sekolah</span>
                    <div class="text-3xl font-black text-purple-700">{{ number_format($stats['total_events'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-800 font-black text-2xl flex items-center justify-center shadow-sm border border-purple-200">
                    📅
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-purple-700 font-medium">Mendatang: <strong>{{ $stats['upcoming_events'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.events.index') }}" class="font-extrabold text-purple-800 hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        <!-- 👨‍🏫 Guru & Tendik -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 card-hover-effect">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider block">Guru & Tendik</span>
                    <div class="text-3xl font-black text-slate-900">{{ number_format(($stats['total_teachers'] ?? 0) + ($stats['total_staff'] ?? 0)) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-900 font-black text-2xl flex items-center justify-center shadow-sm border border-emerald-300">
                    👨‍🏫
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Guru: <strong>{{ $stats['total_teachers'] ?? 0 }}</strong> | Tendik: <strong>{{ $stats['total_staff'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.teachers.index') }}" class="font-extrabold text-emerald-800 hover:underline">Kelola &rarr;</a>
            </div>
        </div>

        <!-- 🖼️ Galeri Media -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 card-hover-effect">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider block">Galeri Foto</span>
                    <div class="text-3xl font-black text-amber-600">{{ number_format($stats['total_galleries'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-800 font-black text-2xl flex items-center justify-center shadow-sm border border-amber-300">
                    🖼️
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-amber-700 font-medium">Total Foto: <strong>{{ $stats['total_photos'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.galleries.index') }}" class="font-extrabold text-amber-800 hover:underline">Kelola &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 3. STATISTIK TAMBAHAN & QUICK SHORTCUT BAR -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Pengumuman</span>
                <span class="text-xl font-black text-slate-900">{{ number_format($stats['total_announcements'] ?? 0) }}</span>
            </div>
            <span class="text-2xl">📢</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Prestasi Siswa</span>
                <span class="text-xl font-black text-amber-600">{{ number_format($stats['total_achievements'] ?? 0) }}</span>
            </div>
            <span class="text-2xl">🏆</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Dokumen Unduhan</span>
                <span class="text-xl font-black text-sky-700">{{ number_format($stats['total_documents'] ?? 0) }}</span>
            </div>
            <span class="text-2xl">📁</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Pengguna Admin</span>
                <span class="text-xl font-black text-emerald-800">{{ number_format($stats['total_users'] ?? 0) }}</span>
            </div>
            <span class="text-2xl">🔑</span>
        </div>
    </div>

    <!-- 4. TABEL AKTIVITAS TERBARU (RECENT ACTIVITY FEED) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                    <span>⚡ Aktivitas Terbaru Sistem</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar publikasi dan perbaruan data konten terkini SMAN 24 Bandung.</p>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.news.create') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 hover:bg-emerald-100 transition-colors">
                    + Berita
                </a>
                <a href="{{ route('admin.events.create') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-purple-50 text-purple-800 hover:bg-purple-100 transition-colors">
                    + Agenda
                </a>
                <a href="{{ route('admin.teachers.create') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-sky-50 text-sky-800 hover:bg-sky-100 transition-colors">
                    + Guru
                </a>
                <a href="{{ route('admin.galleries.create') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-amber-50 text-amber-800 hover:bg-amber-100 transition-colors">
                    + Galeri
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Tipe Modul</th>
                        <th class="px-6 py-4">Judul Konten</th>
                        <th class="px-6 py-4">Pengubah / Penulis</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentActivities as $act)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] bg-slate-100 text-slate-800 border border-slate-200">
                                    <span>{{ $act['icon'] }}</span>
                                    <span>{{ $act['type'] }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800 max-w-xs truncate">
                                {{ $act['title'] }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $act['author'] }}
                            </td>
                            <td class="px-6 py-4 font-mono text-[11px] text-slate-400">
                                {{ $act['time']->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 rounded text-[9px] font-extrabold uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $act['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ $act['url'] }}" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold transition-colors">
                                    Buka &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada aktivitas tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
