@extends('layouts.admin.app')

@section('title', 'Detail Staf - ' . $staff->name)
@section('breadcrumb', 'Detail Tendik')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Detail Tenaga Kependidikan (Tendik)</h2>
            <p class="text-xs text-slate-500 mt-1">Informasi lengkap profil staf & tenaga kependidikan SMAN 24 Bandung.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.staff.edit', $staff) }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold text-xs shadow-sm transition-all">
                Edit Data
            </a>
            <a href="{{ route('admin.staff.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                &larr; Kembali
            </a>
        </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-8">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 border-b border-slate-100 pb-6">
            @if($staff->photo)
                <img src="{{ asset($staff->photo) }}" alt="{{ $staff->name }}" class="w-28 h-28 rounded-2xl object-cover border-2 border-emerald-800 shadow-md">
            @else
                <div class="w-28 h-28 rounded-2xl bg-amber-500 text-emerald-950 font-black text-3xl flex items-center justify-center border-2 border-amber-400 shadow-md">
                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                </div>
            @endif
            
            <div class="space-y-2 text-center sm:text-left">
                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $staff->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                    {{ $staff->is_active ? 'Aktif Bekerja' : 'Non-Aktif' }}
                </span>
                <h3 class="text-2xl font-black text-slate-900">{{ $staff->name }}</h3>
                <div class="text-xs font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200 inline-block">
                    👔 {{ $staff->position }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <div class="space-y-4">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">NIP</span>
                    <p class="font-mono text-sm font-bold text-slate-800">{{ $staff->nip ?? 'Belum Diisi' }}</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Jenis Kelamin</span>
                    <p class="font-bold text-slate-800">{{ $staff->gender === 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Email Resmi</span>
                    <p class="font-bold text-slate-800">{{ $staff->email ?? 'Tidak ada email terdaftar' }}</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Nomor Telepon / WA</span>
                    <p class="font-mono font-bold text-slate-800">{{ $staff->phone ?? 'Tidak ada nomor telepon' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
