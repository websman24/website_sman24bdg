@extends('layouts.admin.app')

@section('title', 'Admin Dashboard - SMAN 24 Bandung')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- 1. BANNER WELCOME CARD: Selamat Datang Admin -->
    <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-2xl relative overflow-hidden border border-emerald-800/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="relative z-10 space-y-2 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-900/80 border border-amber-400/40 text-amber-400 text-xs font-extrabold shadow-inner">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                PORTAL ADMINISTRASI CMS TERPADU
            </div>
            <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
                Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}!
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Kelola data berita, agenda, pendidik, galeri foto, dokumen, serta akun administrator {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.
            </p>
        </div>

        <div class="flex items-center gap-3.5 bg-slate-900/80 p-4 rounded-2xl border border-emerald-700/50 shrink-0 shadow-lg backdrop-blur-md">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-amber-300 font-black text-xl flex items-center justify-center border-2 border-amber-400/60 shadow-md">
                👤
            </div>
            <div class="text-xs">
                <span class="text-slate-400 block font-medium">Role Pengguna:</span>
                <span class="font-extrabold text-amber-300 uppercase tracking-wider text-sm">{{ auth()->user()->role ?? 'Admin' }}</span>
            </div>
        </div>
    </div>

    <!-- 2. 4 KARTU STATISTIK UTAMA: Berita | Agenda | Guru | Galeri -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- 📰 Card 1: Berita Artikel (Emerald Theme) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 hover:border-emerald-500/40 hover:bg-emerald-50/30 transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-emerald-800 uppercase tracking-wider block">Berita & Artikel</span>
                    <div class="text-3xl font-black text-slate-900 group-hover:text-emerald-900 transition-colors">{{ number_format($stats['total_news'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-950 text-amber-300 font-black text-2xl flex items-center justify-center shadow-lg border border-emerald-700/60 group-hover:scale-110 transition-transform">
                    📰
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Status Terbit: <strong class="text-emerald-800">{{ $stats['published_news'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.news.index') }}" class="font-extrabold text-emerald-800 hover:text-emerald-950 flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- 📅 Card 2: Agenda Sekolah (Indigo/Purple Theme) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 hover:border-indigo-500/40 hover:bg-indigo-50/30 transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-indigo-700 uppercase tracking-wider block">Agenda Sekolah</span>
                    <div class="text-3xl font-black text-indigo-950 group-hover:text-indigo-900 transition-colors">{{ number_format($stats['total_events'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-950 text-indigo-200 font-black text-2xl flex items-center justify-center shadow-lg border border-indigo-700/60 group-hover:scale-110 transition-transform">
                    📅
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Mendatang: <strong class="text-indigo-700">{{ $stats['upcoming_events'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.events.index') }}" class="font-extrabold text-indigo-700 hover:text-indigo-950 flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- 👨‍🏫 Card 3: Guru & Tendik (Cyan/Teal Theme) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 hover:border-cyan-500/40 hover:bg-cyan-50/30 transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-cyan-800 uppercase tracking-wider block">Guru & Tendik</span>
                    <div class="text-3xl font-black text-slate-900 group-hover:text-cyan-950 transition-colors">{{ number_format(($stats['total_teachers'] ?? 0) + ($stats['total_staff'] ?? 0)) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-cyan-950 text-cyan-300 font-black text-2xl flex items-center justify-center shadow-lg border border-cyan-700/60 group-hover:scale-110 transition-transform">
                    👨‍🏫
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Guru: <strong class="text-cyan-800">{{ $stats['total_teachers'] ?? 0 }}</strong> | Tendik: <strong>{{ $stats['total_staff'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.teachers.index') }}" class="font-extrabold text-cyan-800 hover:text-cyan-950 flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- 🖼️ Card 4: Galeri Media (Amber/Gold Theme) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 hover:border-amber-500/40 hover:bg-amber-50/30 transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-amber-700 uppercase tracking-wider block">Galeri Foto</span>
                    <div class="text-3xl font-black text-amber-950 group-hover:text-amber-900 transition-colors">{{ number_format($stats['total_galleries'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-950 text-amber-400 font-black text-2xl flex items-center justify-center shadow-lg border border-amber-700/60 group-hover:scale-110 transition-transform">
                    🖼️
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Total Foto: <strong class="text-amber-700">{{ $stats['total_photos'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.galleries.index') }}" class="font-extrabold text-amber-700 hover:text-amber-950 flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 3. STATISTIK TAMBAHAN (SEKUNDER) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
        <!-- Pengumuman Card -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 hover:border-rose-300 hover:bg-rose-50/40 transition-all shadow-xs hover:shadow-md flex items-center justify-between">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-rose-700 block">Pengumuman</span>
                <span class="text-xl font-black text-slate-900">{{ number_format($stats['total_announcements'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 font-bold flex items-center justify-center text-lg border border-rose-200">
                📢
            </div>
        </div>

        <!-- Prestasi Card -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 hover:border-amber-300 hover:bg-amber-50/40 transition-all shadow-xs hover:shadow-md flex items-center justify-between">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-amber-700 block">Prestasi Siswa</span>
                <span class="text-xl font-black text-slate-900">{{ number_format($stats['total_achievements'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-lg border border-amber-200">
                🏆
            </div>
        </div>

        <!-- Dokumen Card -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 hover:border-sky-300 hover:bg-sky-50/40 transition-all shadow-xs hover:shadow-md flex items-center justify-between">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-sky-700 block">Dokumen SPMB</span>
                <span class="text-xl font-black text-slate-900">{{ number_format($stats['total_documents'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-800 font-bold flex items-center justify-center text-lg border border-sky-200">
                📁
            </div>
        </div>

        <!-- Pengguna Card -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 hover:border-emerald-300 hover:bg-emerald-50/40 transition-all shadow-xs hover:shadow-md flex items-center justify-between">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-emerald-800 block">Pengguna Admin</span>
                <span class="text-xl font-black text-slate-900">{{ number_format($stats['total_users'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-lg border border-emerald-200">
                🔑
            </div>
        </div>
    </div>

    <!-- 4. TABEL AKTIVITAS TERBARU (RECENT ACTIVITY FEED) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        <!-- Table Header -->
        <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-900 p-6 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-emerald-800/50">
            <div>
                <h3 class="text-lg font-extrabold text-white flex items-center gap-2">
                    <span>⚡ Aktivitas Terbaru Sistem</span>
                </h3>
                <p class="text-xs text-slate-300 mt-0.5">Daftar publikasi dan perbaruan data konten terkini SMAN 24 Bandung.</p>
            </div>
            
            <!-- Quick Actions Buttons -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.news.create') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-800 hover:bg-emerald-700 text-white border border-emerald-600 transition-colors shadow-sm">
                    + Berita
                </a>
                <a href="{{ route('admin.events.create') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-indigo-900 hover:bg-indigo-800 text-white border border-indigo-700 transition-colors shadow-sm">
                    + Agenda
                </a>
                <a href="{{ route('admin.teachers.create') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-cyan-900 hover:bg-cyan-800 text-white border border-cyan-700 transition-colors shadow-sm">
                    + Guru
                </a>
                <a href="{{ route('admin.galleries.create') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-900 hover:bg-amber-800 text-amber-200 border border-amber-700 transition-colors shadow-sm">
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
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase
                                    @if($act['type'] === 'Berita') bg-emerald-100 text-emerald-900 border border-emerald-300
                                    @elseif($act['type'] === 'Agenda') bg-indigo-100 text-indigo-900 border border-indigo-300
                                    @elseif($act['type'] === 'Pengumuman') bg-rose-100 text-rose-900 border border-rose-300
                                    @else bg-amber-100 text-amber-900 border border-amber-300 @endif">
                                    <span>{{ $act['icon'] }}</span>
                                    <span>{{ $act['type'] }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900 max-w-xs truncate text-sm">
                                {{ $act['title'] }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                {{ $act['author'] }}
                            </td>
                            <td class="px-6 py-4 font-mono text-[11px] text-slate-500">
                                {{ $act['time']->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-extrabold uppercase bg-slate-100 text-slate-800 border border-slate-300">
                                    {{ $act['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ $act['url'] }}" class="px-3.5 py-1.5 rounded-lg bg-emerald-900 text-white hover:bg-emerald-800 font-bold transition-colors shadow-xs">
                                    Buka &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada aktivitas tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
