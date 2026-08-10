@extends('layouts.admin.app')

@section('title', 'Admin Dashboard - SMAN 24 Bandung')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Banner Card -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-700 text-amber-400 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Portal Administrasi Resmi
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}!
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                Kelola konten publikasi berita, pengumuman, data pendidik, galeri media, serta berkas SPMB SMA Negeri 24 Bandung dari panel administrasi terpadu.
            </p>
        </div>
    </div>

    <!-- Real-time Statistics Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- News Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Berita</span>
            <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_news'] ?? 0 }}</div>
            <a href="{{ route('admin.news.index') }}" class="text-[11px] font-bold text-emerald-800 hover:underline block">Kelola &rarr;</a>
        </div>

        <!-- Announcement Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Pengumuman</span>
            <div class="text-2xl font-extrabold text-amber-600">{{ $stats['total_announcements'] ?? 0 }}</div>
            <a href="{{ route('admin.announcements.index') }}" class="text-[11px] font-bold text-emerald-800 hover:underline block">Kelola &rarr;</a>
        </div>

        <!-- Teacher Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Guru & Tendik</span>
            <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_teachers'] ?? 0 }}</div>
            <a href="{{ route('admin.teachers.index') }}" class="text-[11px] font-bold text-emerald-800 hover:underline block">Kelola &rarr;</a>
        </div>

        <!-- Document Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Dokumen SPMB</span>
            <div class="text-2xl font-extrabold text-sky-700">{{ $stats['total_documents'] ?? 0 }}</div>
            <a href="{{ route('admin.documents.index') }}" class="text-[11px] font-bold text-emerald-800 hover:underline block">Kelola &rarr;</a>
        </div>

        <!-- Event Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Agenda</span>
            <div class="text-2xl font-extrabold text-emerald-800">{{ $stats['total_events'] ?? 0 }}</div>
            <a href="{{ route('admin.events.index') }}" class="text-[11px] font-bold text-emerald-800 hover:underline block">Kelola &rarr;</a>
        </div>

        <!-- Achievement Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Prestasi</span>
            <div class="text-2xl font-extrabold text-purple-700">{{ $stats['total_achievements'] ?? 0 }}</div>
            <a href="{{ route('admin.achievements.index') }}" class="text-[11px] font-bold text-emerald-800 hover:underline block">Kelola &rarr;</a>
        </div>
    </div>

    <!-- Quick Action Links & Recent Content Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Latest News Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-sm">Berita Terbaru</h3>
                <a href="{{ route('admin.news.create') }}" class="text-xs font-bold text-emerald-800 hover:underline">+ Tambah Berita</a>
            </div>
            <div class="space-y-3">
                @forelse($latestNews as $item)
                    <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 last:border-0">
                        <span class="font-bold text-slate-800 truncate max-w-xs">{{ $item->title }}</span>
                        <span class="text-[10px] text-slate-400">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 py-4 text-center">Belum ada berita.</div>
                @endforelse
            </div>
        </div>

        <!-- Latest Announcements Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-sm">Pengumuman Terakhir</h3>
                <a href="{{ route('admin.announcements.create') }}" class="text-xs font-bold text-emerald-800 hover:underline">+ Tambah Pengumuman</a>
            </div>
            <div class="space-y-3">
                @forelse($latestAnnouncements as $item)
                    <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-100 last:border-0">
                        <span class="font-bold text-slate-800 truncate max-w-xs">{{ $item->title }}</span>
                        <span class="text-[10px] text-slate-400">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                @empty
                    <div class="text-xs text-slate-400 py-4 text-center">Belum ada pengumuman.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
