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
                Kelola data berita, agenda, pendidik, galeri foto, dokumen, serta analitik trafik pengunjung {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.
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

    <!-- 2. 4 KARTU STATISTIK UTAMA: Background Berwarna Khusus -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- 📰 Card 1: Berita Artikel (Rich Emerald Gradient Background) -->
        <div class="bg-gradient-to-br from-emerald-700 via-emerald-800 to-emerald-950 p-6 rounded-3xl text-white border border-emerald-500/40 shadow-xl shadow-emerald-950/20 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-emerald-200 uppercase tracking-wider block">Berita & Artikel</span>
                    <div class="text-3xl font-black text-white group-hover:scale-105 transition-transform">{{ number_format($stats['total_news'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-950/80 text-amber-300 font-black text-2xl flex items-center justify-center shadow-inner border border-emerald-500/40 group-hover:rotate-6 transition-transform">
                    📰
                </div>
            </div>
            <div class="pt-3 border-t border-emerald-600/40 flex items-center justify-between text-xs text-emerald-100">
                <span>Terbit: <strong class="text-white">{{ $stats['published_news'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.news.index') }}" class="font-extrabold text-amber-300 hover:text-white flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- 📅 Card 2: Agenda Sekolah (Rich Indigo/Violet Gradient Background) -->
        <div class="bg-gradient-to-br from-indigo-700 via-indigo-800 to-slate-950 p-6 rounded-3xl text-white border border-indigo-500/40 shadow-xl shadow-indigo-950/20 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-indigo-200 uppercase tracking-wider block">Agenda Sekolah</span>
                    <div class="text-3xl font-black text-white group-hover:scale-105 transition-transform">{{ number_format($stats['total_events'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-950/80 text-indigo-200 font-black text-2xl flex items-center justify-center shadow-inner border border-indigo-500/40 group-hover:rotate-6 transition-transform">
                    📅
                </div>
            </div>
            <div class="pt-3 border-t border-indigo-600/40 flex items-center justify-between text-xs text-indigo-100">
                <span>Mendatang: <strong class="text-white">{{ $stats['upcoming_events'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.events.index') }}" class="font-extrabold text-amber-300 hover:text-white flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- 👨‍🏫 Card 3: Guru & Tendik (Rich Cyan/Teal Gradient Background) -->
        <div class="bg-gradient-to-br from-teal-700 via-cyan-900 to-slate-950 p-6 rounded-3xl text-white border border-cyan-500/40 shadow-xl shadow-cyan-950/20 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-cyan-200 uppercase tracking-wider block">Guru & Tendik</span>
                    <div class="text-3xl font-black text-white group-hover:scale-105 transition-transform">{{ number_format(($stats['total_teachers'] ?? 0) + ($stats['total_staff'] ?? 0)) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-cyan-950/80 text-cyan-300 font-black text-2xl flex items-center justify-center shadow-inner border border-cyan-500/40 group-hover:rotate-6 transition-transform">
                    👨‍🏫
                </div>
            </div>
            <div class="pt-3 border-t border-cyan-600/40 flex items-center justify-between text-xs text-cyan-100">
                <span>Guru: <strong class="text-white">{{ $stats['total_teachers'] ?? 0 }}</strong> | Tendik: <strong class="text-white">{{ $stats['total_staff'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.teachers.index') }}" class="font-extrabold text-amber-300 hover:text-white flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- 🖼️ Card 4: Galeri Media (Rich Amber/Gold Gradient Background) -->
        <div class="bg-gradient-to-br from-amber-600 via-amber-700 to-slate-950 p-6 rounded-3xl text-white border border-amber-500/40 shadow-xl shadow-amber-950/20 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 space-y-4 group">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-extrabold text-amber-200 uppercase tracking-wider block">Galeri Foto</span>
                    <div class="text-3xl font-black text-white group-hover:scale-105 transition-transform">{{ number_format($stats['total_galleries'] ?? 0) }}</div>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-amber-950/80 text-amber-300 font-black text-2xl flex items-center justify-center shadow-inner border border-amber-500/40 group-hover:rotate-6 transition-transform">
                    🖼️
                </div>
            </div>
            <div class="pt-3 border-t border-amber-600/40 flex items-center justify-between text-xs text-amber-100">
                <span>Total Foto: <strong class="text-white">{{ $stats['total_photos'] ?? 0 }}</strong></span>
                <a href="{{ route('admin.galleries.index') }}" class="font-extrabold text-amber-300 hover:text-white flex items-center gap-1 group-hover:underline">
                    <span>Kelola</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 3. STATISTIK SEKUNDER: KARTU BERWARNA VOLL GRADIENT -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
        <!-- Pengumuman Card (Rose Gradient) -->
        <div class="bg-gradient-to-br from-rose-600 to-rose-800 p-4 rounded-2xl text-white shadow-md hover:shadow-xl transition-all flex items-center justify-between border border-rose-500/40">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-rose-200 block">Pengumuman</span>
                <span class="text-xl font-black text-white">{{ number_format($stats['total_announcements'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-950/50 text-white font-bold flex items-center justify-center text-lg border border-rose-400/40">
                📢
            </div>
        </div>

        <!-- Prestasi Card (Amber Gradient) -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-700 p-4 rounded-2xl text-white shadow-md hover:shadow-xl transition-all flex items-center justify-between border border-amber-400/40">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-amber-100 block">Prestasi Siswa</span>
                <span class="text-xl font-black text-white">{{ number_format($stats['total_achievements'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-950/50 text-amber-300 font-bold flex items-center justify-center text-lg border border-amber-400/40">
                🏆
            </div>
        </div>

        <!-- Dokumen Card (Sky Blue Gradient) -->
        <div class="bg-gradient-to-br from-sky-600 to-blue-800 p-4 rounded-2xl text-white shadow-md hover:shadow-xl transition-all flex items-center justify-between border border-sky-400/40">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-sky-200 block">Dokumen SPMB</span>
                <span class="text-xl font-black text-white">{{ number_format($stats['total_documents'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-950/50 text-sky-200 font-bold flex items-center justify-center text-lg border border-sky-400/40">
                📁
            </div>
        </div>

        <!-- Pengguna Card (Emerald Teal Gradient) -->
        <div class="bg-gradient-to-br from-emerald-800 to-slate-900 p-4 rounded-2xl text-white shadow-md hover:shadow-xl transition-all flex items-center justify-between border border-emerald-500/40">
            <div>
                <span class="text-[10px] font-extrabold uppercase text-emerald-200 block">Pengguna Admin</span>
                <span class="text-xl font-black text-white">{{ number_format($stats['total_users'] ?? 0) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-950/50 text-amber-300 font-bold flex items-center justify-center text-lg border border-emerald-400/40">
                🔑
            </div>
        </div>
    </div>

    <!-- 4. AKTIVITAS TERBARU & GRAFIK PENGUNJUNG (SIDE BY SIDE / RESPONSIF) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
        
        <!-- Tabel Aktivitas Terbaru (Kiri: 7 Kolom) -->
        <div class="xl:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-900 p-6 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-emerald-800/50">
                <div>
                    <h3 class="text-base font-extrabold text-white flex items-center gap-2">
                        <span>⚡ Aktivitas Terbaru Sistem</span>
                    </h3>
                    <p class="text-xs text-slate-300 mt-0.5">Daftar publikasi dan perbaruan data konten terkini.</p>
                </div>
                
                <!-- Quick Actions Buttons -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.news.create') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-800 hover:bg-emerald-700 text-white border border-emerald-600 transition-colors shadow-sm">
                        + Berita
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-900 hover:bg-indigo-800 text-white border border-indigo-700 transition-colors shadow-sm">
                        + Agenda
                    </a>
                    <a href="{{ route('admin.teachers.create') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-cyan-900 hover:bg-cyan-800 text-white border border-cyan-700 transition-colors shadow-sm">
                        + Guru
                    </a>
                    <a href="{{ route('admin.galleries.create') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-amber-900 hover:bg-amber-800 text-amber-200 border border-amber-700 transition-colors shadow-sm">
                        + Galeri
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto max-h-[460px] overflow-y-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3.5">Modul</th>
                            <th class="px-4 py-3.5">Judul Konten</th>
                            <th class="px-4 py-3.5">Penulis</th>
                            <th class="px-4 py-3.5">Waktu</th>
                            <th class="px-4 py-3.5 text-center">Status</th>
                            <th class="px-4 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentActivities as $act)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-3 font-bold text-slate-900">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase
                                        @if($act['type'] === 'Berita') bg-emerald-100 text-emerald-900 border border-emerald-300
                                        @elseif($act['type'] === 'Agenda') bg-indigo-100 text-indigo-900 border border-indigo-300
                                        @elseif($act['type'] === 'Pengumuman') bg-rose-100 text-rose-900 border border-rose-300
                                        @else bg-amber-100 text-amber-900 border border-amber-300 @endif">
                                        <span>{{ $act['icon'] }}</span>
                                        <span>{{ $act['type'] }}</span>
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-bold text-slate-900 max-w-[180px] truncate text-xs">
                                    {{ $act['title'] }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 font-medium truncate max-w-[100px]">
                                    {{ $act['author'] }}
                                </td>
                                <td class="px-4 py-3 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                    {{ $act['time']->diffForHumans() }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase bg-slate-100 text-slate-800 border border-slate-300">
                                        {{ $act['status'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ $act['url'] }}" class="px-2.5 py-1 rounded-lg bg-emerald-900 text-white hover:bg-emerald-800 font-bold transition-colors shadow-xs text-[11px]">
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

        <!-- Grafik Kunjungan Web (Kanan: 5 Kolom) -->
        <div class="xl:col-span-5 bg-white p-6 rounded-3xl border border-slate-200 shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>📈</span>
                        <span>Grafik Kunjungan Web</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Tren trafik 14 hari terakhir (Pageviews & Pengunjung Unik)</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-900 border border-emerald-200">
                    Live
                </span>
            </div>

            <!-- Mini Summary Metric Badges -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 text-center">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block">Kunjungan Hari Ini</span>
                    <span class="text-lg font-black text-emerald-800">{{ number_format($visitorStats['today_views'] ?? 0) }}</span>
                    <span class="text-[10px] text-slate-500 block">({{ number_format($visitorStats['today_unique'] ?? 0) }} unik)</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 text-center">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block">Total Kunjungan</span>
                    <span class="text-lg font-black text-indigo-900">{{ number_format($visitorStats['total_views'] ?? 0) }}</span>
                    <span class="text-[10px] text-slate-500 block">seluruh waktu</span>
                </div>
            </div>

            <!-- Chart Legends -->
            <div class="flex items-center justify-center gap-4 text-xs pt-1">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                    <span class="text-[11px] text-slate-600 font-bold">Total Kunjungan</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                    <span class="text-[11px] text-slate-600 font-bold">Pengunjung Unik</span>
                </div>
            </div>

            <!-- Canvas Chart -->
            <div class="relative h-64 w-full">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('visitorChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const viewsData = @json($chartViewsData);
        const uniqueData = @json($chartUniqueData);

        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Kunjungan',
                        data: viewsData,
                        borderColor: '#059669',
                        backgroundColor: 'rgba(5, 150, 105, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#059669',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Pengunjung Unik',
                        data: uniqueData,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.08)',
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#f8fafc',
                        bodyColor: '#f8fafc',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 8,
                        cornerRadius: 10,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 9,
                                weight: '600'
                            },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 9
                            },
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
