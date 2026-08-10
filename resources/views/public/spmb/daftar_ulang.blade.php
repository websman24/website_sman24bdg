@extends('layouts.public.app')

@section('title', 'Daftar Ulang SPMB - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['SPMB' => '', 'Daftar Ulang' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Verifikasi & Daftar Ulang SPMB</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Layanan verifikasi berkas dan registrasi fisik bagi calon peserta didik yang dinyatakan diterima.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <x-card :hover="false" class="space-y-4">
        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-3">Alur & Lokasi Daftar Ulang</h2>
        <div class="space-y-3 text-slate-700 text-sm leading-relaxed">
            <p>1. Hadir langsung ke lokasi verifikasi di <strong>Kampus {{ \App\Models\Setting::getValue('school_name', 'SMAN 24 Bandung') }}, {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}</strong>.</p>
            <p>2. Membawa bukti cetak tanda lulus seleksi SPMB dan kelengkapan dokumen fisik (IJAZAH/SKL, KK, Akta Kelahiran, Pasfoto).</p>
            <p>3. Melakukan verifikasi data dengan panitia SPMB di Aula Sekolah.</p>
        </div>
    </x-card>
</div>
@endsection
