@extends('layouts.admin.app')

@section('title', 'Tambah Data Guru - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Guru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Data Guru / Pendidik</h2>
        <a href="{{ route('admin.teachers.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Guru
        </a>
    </div>

    <form action="{{ route('admin.teachers.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="title_prefix" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gelar Depan</label>
                <input type="text" id="title_prefix" name="title_prefix" value="{{ old('title_prefix') }}" placeholder="contoh: Drs." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            </div>
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama tanpa gelar..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="title_suffix" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gelar Belakang</label>
                <input type="text" id="title_suffix" name="title_suffix" value="{{ old('title_suffix') }}" placeholder="contoh: M.Pd." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="nip" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">NIP (Opsional)</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
                @error('nip')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Mata Pelajaran</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required placeholder="contoh: Matematika, Fisika" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
                @error('subject')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jenis Kelamin</label>
                <select id="gender" name="gender" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none bg-white">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Email Guru</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="guru@sman24bdg.sch.id" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            </div>
            <div>
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nomor HP/WA</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="0812..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-700 focus:outline-none">
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.teachers.index') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold text-xs hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-md transition-all">
                Simpan Data Guru
            </button>
        </div>
    </form>
</div>
@endsection
