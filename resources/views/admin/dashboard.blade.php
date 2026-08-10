@extends('layouts.admin.app')

@section('title', 'Admin Dashboard - SMAN 24 Bandung')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Banner Card -->
    <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-950 rounded-3xl p-6 sm:p-8 text-white shadow-2xl relative overflow-hidden border border-emerald-900/60">
        <div class="relative z-10 space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-900/80 border border-amber-400/40 text-amber-400 text-xs font-extrabold shadow-inner">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                PORTAL ADMINISTRASI CMS TERPADU
            </div>
            <h2 class="text-2xl sm:text-4xl font-black tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}!
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                Kelola seluruh data publikasi berita, pengumuman, agenda sekolah, profil pendidik, album galeri media, serta berkas SPMB {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }} secara terintegrasi.
            </p>
        </div>
    </div>

    <!-- Real-time Statistics Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-5">
        <!-- News Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Berita</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-800 text-base">📰</span>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $stats['total_news'] ?? 0 }}</div>
            <a href="{{ route('admin.news.index') }}" class="text-[11px] font-extrabold text-emerald-800 hover:underline block">Kelola Berita &rarr;</a>
        </div>

        <!-- Announcement Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Pengumuman</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600 text-base">📢</span>
            </div>
            <div class="text-2xl font-black text-amber-600">{{ $stats['total_announcements'] ?? 0 }}</div>
            <a href="{{ route('admin.announcements.index') }}" class="text-[11px] font-extrabold text-emerald-800 hover:underline block">Kelola Pengumuman &rarr;</a>
        </div>

        <!-- Teacher Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Guru & Tendik</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-800 text-base">👨‍🏫</span>
            </div>
            <div class="text-2xl font-black text-slate-900">{{ $stats['total_teachers'] ?? 0 }}</div>
            <a href="{{ route('admin.teachers.index') }}" class="text-[11px] font-extrabold text-emerald-800 hover:underline block">Kelola Data Guru &rarr;</a>
        </div>

        <!-- Document Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Dokumen SPMB</span>
                <span class="p-2 rounded-xl bg-sky-50 text-sky-700 text-base">📁</span>
            </div>
            <div class="text-2xl font-black text-sky-700">{{ $stats['total_documents'] ?? 0 }}</div>
            <a href="{{ route('admin.documents.index') }}" class="text-[11px] font-extrabold text-emerald-800 hover:underline block">Kelola Berkas &rarr;</a>
        </div>

        <!-- Event Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Agenda</span>
                <span class="p-2 rounded-xl bg-purple-50 text-purple-700 text-base">🗓️</span>
            </div>
            <div class="text-2xl font-black text-purple-700">{{ $stats['total_events'] ?? 0 }}</div>
            <a href="{{ route('admin.events.index') }}" class="text-[11px] font-extrabold text-emerald-800 hover:underline block">Kelola Agenda &rarr;</a>
        </div>

        <!-- Achievement Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3 card-hover-effect">
            <div class="flex items-center justify-between">
                <span class="text-xs font-extrabold text-slate-500 uppercase tracking-wider block">Prestasi</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-700 text-base">🏆</span>
            </div>
            <div class="text-2xl font-black text-amber-700">{{ $stats['total_achievements'] ?? 0 }}</div>
            <a href="{{ route('admin.achievements.index') }}" class="text-[11px] font-extrabold text-emerald-800 hover:underline block">Kelola Prestasi &rarr;</a>
        </div>
    </div>

    <!-- Quick Action Links & Recent Content Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Latest News Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-slate-900 text-sm">📰 Berita Publikasi Terbaru</h3>
                <a href="{{ route('admin.news.create') }}" class="text-xs font-extrabold text-emerald-800 hover:underline">+ Tambah Berita</a>
            </div>
            <div class="space-y-3">
                @forelse($latestNews as $item)
                    <div class="flex items-center justify-between text-xs py-2 border-b border-slate-100 last:border-0">
                        <span class="font-bold text-slate-800 truncate max-w-xs">{{ $item->title }}</span>
                        <span class="text-[10px] font-mono text-slate-400">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 py-6 text-center">Belum ada berita dipublikasikan.</div>
                @endforelse
            </div>
        </div>

        <!-- Latest Announcements Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-slate-900 text-sm">📢 Pengumuman Terakhir</h3>
                <a href="{{ route('admin.announcements.create') }}" class="text-xs font-extrabold text-emerald-800 hover:underline">+ Tambah Pengumuman</a>
            </div>
            <div class="space-y-3">
                @forelse($latestAnnouncements as $item)
                    <div class="flex items-center justify-between text-xs py-2 border-b border-slate-100 last:border-0">
                        <span class="font-bold text-slate-800 truncate max-w-xs">{{ $item->title }}</span>
                        <span class="text-[10px] font-mono text-slate-400">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 py-6 text-center">Belum ada pengumuman terdaftar.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
