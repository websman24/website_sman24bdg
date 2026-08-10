@extends('layouts.admin.app')

@section('title', 'Pengaturan Website - SMAN 24 Bandung')
@section('breadcrumb', 'Pengaturan Website')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Pengaturan Website Resmi</h2>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi identitas sekolah, informasi kontak, dan layanan SPMB.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="space-y-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">Identitas Sekolah</h3>
            <div>
                <label for="school_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah</label>
                <input type="text" id="school_name" name="school_name" value="{{ $settings['school_name']->value ?? 'SMA Negeri 24 Bandung' }}" class="form-input-custom">
            </div>
            <div>
                <label for="school_address" class="block text-xs font-bold text-slate-700 mb-1">Alamat Sekolah</label>
                <input type="text" id="school_address" name="school_address" value="{{ $settings['school_address']->value ?? 'Jl. A.H. Nasution No. 27, Kota Bandung' }}" class="form-input-custom">
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Kontak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="school_phone" class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" id="school_phone" name="school_phone" value="{{ $settings['school_phone']->value ?? '(022) 7800540' }}" class="form-input-custom">
                </div>
                <div>
                    <label for="school_email" class="block text-xs font-bold text-slate-700 mb-1">Email Resmi</label>
                    <input type="email" id="school_email" name="school_email" value="{{ $settings['school_email']->value ?? 'info@sman24bdg.sch.id' }}" class="form-input-custom">
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <x-button type="submit" variant="primary">
                Simpan Perubahan Pengaturan
            </x-button>
        </div>
    </form>
</div>
@endsection
