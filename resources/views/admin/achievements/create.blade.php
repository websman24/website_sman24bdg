@extends('layouts.admin.app')

@section('title', 'Tambah Prestasi - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Prestasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Prestasi Baru</h2>
        <a href="{{ route('admin.achievements.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.achievements.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold text-slate-700 mb-1">Judul Prestasi</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="contoh: Juara 1 Olimpiade Sains Kota Bandung" class="form-input-custom">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="category" class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                <select id="category" name="category" required class="form-input-custom bg-white">
                    <option value="akademik">Akademik</option>
                    <option value="non_akademik">Non-Akademik</option>
                </select>
            </div>

            <div>
                <label for="level" class="block text-xs font-bold text-slate-700 mb-1">Tingkat Kejuaraan</label>
                <select id="level" name="level" required class="form-input-custom bg-white">
                    <option value="kota">Kota / Kabupaten</option>
                    <option value="provinsi">Provinsi</option>
                    <option value="nasional">Nasional</option>
                    <option value="internasional">Internasional</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="winner_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Pemenang / Tim</label>
                <input type="text" id="winner_name" name="winner_name" value="{{ old('winner_name') }}" required placeholder="Nama siswa..." class="form-input-custom">
            </div>

            <div>
                <label for="event_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Event Lomba</label>
                <input type="text" id="event_name" name="event_name" value="{{ old('event_name') }}" required placeholder="Nama kompetisi..." class="form-input-custom">
            </div>

            <div>
                <label for="achievement_year" class="block text-xs font-bold text-slate-700 mb-1">Tahun Prestasi</label>
                <input type="number" id="achievement_year" name="achievement_year" value="{{ date('Y') }}" required class="form-input-custom">
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button type="submit" variant="primary">Simpan Prestasi</x-button>
        </div>
    </form>
</div>
@endsection
