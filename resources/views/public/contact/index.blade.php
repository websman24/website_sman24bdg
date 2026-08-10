@extends('layouts.public.app')

@section('title', 'Kontak Kami - SMA Negeri 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Kontak Kami' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Hubungi Kami</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Informasi layanan kontak, alamat resmi, dan peta lokasi {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informasi Kontak Card -->
        <x-card :hover="false" class="space-y-6">
            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-3">Informasi Kontak Sekolah</h2>
            
            <div class="space-y-4 text-xs sm:text-sm text-slate-700">
                <div class="flex items-start gap-3">
                    <span class="text-xl">📍</span>
                    <div>
                        <strong class="block text-slate-900">Alamat Sekolah:</strong>
                        <span>{{ $contact['address'] }}</span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="text-xl">📞</span>
                    <div>
                        <strong class="block text-slate-900">Telepon:</strong>
                        <span>{{ $contact['phone'] }}</span>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <span class="text-xl">✉️</span>
                    <div>
                        <strong class="block text-slate-900">Email Resmi:</strong>
                        <span>{{ $contact['email'] }}</span>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Location Box -->
        <div class="bg-slate-900 p-8 rounded-2xl text-white shadow-sm flex flex-col justify-between space-y-6">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-500 text-emerald-950">Lokasi Kampus</span>
                <h3 class="text-xl font-bold">{{ $contact['name'] }}</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Terletak strategis di {{ $contact['address'] }}.
                </p>
            </div>
            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 text-center text-xs text-slate-400">
                🗺️ Peta Lokasi Google Maps
            </div>
        </div>
    </div>
</div>
@endsection
