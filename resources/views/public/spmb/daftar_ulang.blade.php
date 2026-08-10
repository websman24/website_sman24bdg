@extends('layouts.public.app')

@section('title', 'Daftar Ulang SPMB - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Verifikasi & Daftar Ulang SPMB</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Layanan verifikasi berkas bagi calon peserta didik yang dinyatakan diterima.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-3">Alur & Lokasi Daftar Ulang</h2>
        <div class="space-y-3 text-slate-700 text-sm leading-relaxed">
            <p>1. Hadir langsung ke lokasi verifikasi di <strong>Kampus {{ \App\Models\Setting::getValue('school_name', 'SMAN 24 Bandung') }}, {{ \App\Models\Setting::getValue('school_address', 'Jl. A.H. Nasution No. 27, Kota Bandung') }}</strong>.</p>
            <p>2. Membawa bukti cetak tanda lulus seleksi SPMB dan kelengkapan dokumen fisik (IJAZAH/SKL, KK, Akta Kelahiran, Pasfoto).</p>
            <p>3. Melakukan verifikasi data dengan panitia SPMB di Aula Sekolah.</p>
        </div>
    </div>
</div>
@endsection
