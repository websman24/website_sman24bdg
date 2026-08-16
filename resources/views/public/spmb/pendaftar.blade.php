@extends('layouts.public.app')

@section('title', 'Layanan Pendaftar SPMB - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['SPMB' => '', 'Pendaftar' => '']" />
        
        <!-- Running Text Kata-Kata Bijak SPMB (Di atas judul, background transparan) -->
        <div class="overflow-hidden bg-transparent py-1">
            <marquee behavior="scroll" direction="left" scrollamount="4" style="font-family: 'News701 BT', 'Georgia', serif; font-size: 14px; color: #facc15; font-weight: 700; display: block;">
                ✨ {{ \App\Models\Setting::getValue('spmb_quote', 'Pendidikan adalah tiket ke masa depan, hari esok dimiliki oleh orang-orang yang mempersiapkannya hari ini. — SMAN 24 Bandung') }} ✨
            </marquee>
        </div>

        <h1 class="text-3xl font-extrabold tracking-tight">Informasi Pendaftar SPMB</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Panduan pendaftaran dan informasi Seleksi Penerimaan Murid Baru {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <x-card :hover="false" class="space-y-4">
        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-3">Petunjuk Pendaftaran Murid Baru</h2>
        <p class="text-slate-700 text-sm leading-relaxed">
            Calon peserta didik baru dapat mengunduh dokumen persyaratan di bawah ini dan mengikuti alur seleksi penerimaan murid baru sesuai jadwal yang ditetapkan oleh Dinas Pendidikan Provinsi Jawa Barat dan {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.
        </p>
    </x-card>

    <!-- Downloadable SPMB Documents -->
    <div class="space-y-4">
        <h3 class="text-base font-bold text-slate-900">Dokumen Persyaratan SPMB</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($spmbDocuments as $doc)
                <x-card :hover="true" class="bg-slate-50 flex items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $doc->title }}</h4>
                        <p class="text-xs text-slate-500 mt-1">{{ $doc->description }}</p>
                    </div>
                    <form action="{{ route('download.file', $doc) }}" method="POST">
                        @csrf
                        <x-button type="submit" variant="secondary">
                            Unduh 📥
                        </x-button>
                    </form>
                </x-card>
            @empty
                <div class="col-span-2 p-6 bg-slate-50 rounded-2xl text-center text-xs text-slate-400">
                    Belum ada berkas SPMB diunggah.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
