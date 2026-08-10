@extends('layouts.admin.app')

@section('title', 'Dashboard Admin - SMA Negeri 24 Bandung')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="space-y-6">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-700/60 border border-emerald-500/50 text-amber-400 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Portal Admin SMAN 24 Bandung
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat Datang di Admin Website<br>
                    <span class="text-amber-400">SMA Negeri 24 Bandung</span>
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed pt-1">
                    Alamat: Jl. A.H. Nasution No. 27, Kota Bandung. Sistem tata kelola informasi sekolah berbasis Laravel 12.
                </p>
            </div>
        </div>

        <!-- Dummy Stats Grid for Layout Testing -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Dummy Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm card-hover-effect">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Berita & Pengumuman</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                        📰
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-extrabold text-slate-900">12</div>
                    <p class="text-xs text-slate-500 mt-1">Item Berita (Dummy)</p>
                </div>
            </div>

            <!-- Dummy Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm card-hover-effect">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Guru & Tendik</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold">
                        👨‍🏫
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-extrabold text-slate-900">64</div>
                    <p class="text-xs text-slate-500 mt-1">Tenaga Pendidik (Dummy)</p>
                </div>
            </div>

            <!-- Dummy Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm card-hover-effect">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Siswa</span>
                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center font-bold">
                        🎒
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-extrabold text-slate-900">1,048</div>
                    <p class="text-xs text-slate-500 mt-1">Siswa Terdaftar (Dummy)</p>
                </div>
            </div>

            <!-- Dummy Card 4 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm card-hover-effect">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Galeri Media</span>
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center font-bold">
                        🖼️
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-extrabold text-slate-900">38</div>
                    <p class="text-xs text-slate-500 mt-1">Album Foto (Dummy)</p>
                </div>
            </div>

        </div>

        <!-- System Architecture Notes -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Status Tahap 1 - Arsitektur Dasar
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-600">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                    <span class="font-bold text-slate-800">Autentikasi & Authorization</span>
                    <p>Login CSRF-protected via <code class="px-1 py-0.5 rounded bg-slate-200 text-slate-800">/admin/login</code>, password hashing, validasi input FormRequest, dan AdminMiddleware.</p>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                    <span class="font-bold text-slate-800">Navigasi Sidebar Safe Placeholders</span>
                    <p>Seluruh menu tambahan di sidebar menggunakan safe route placeholders (<code class="px-1 py-0.5 rounded bg-slate-200 text-slate-800">javascript:void(0)</code>) agar tidak menyebabkan error.</p>
                </div>
            </div>
        </div>

    </div>
@endsection
