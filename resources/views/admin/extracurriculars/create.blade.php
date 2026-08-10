@extends('layouts.admin.app')

@section('title', 'Tambah Ekstrakurikuler - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Ekstrakurikuler')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Ekstrakurikuler Baru</h2>
        <a href="{{ route('admin.extracurriculars.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.extracurriculars.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama Ekstrakurikuler</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="contoh: Paskibra SMAN 24" class="form-input-custom">
            </div>

            <div>
                <label for="category" class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                <input type="text" id="category" name="category" value="{{ old('category') }}" required placeholder="contoh: Bela Negara, Olahraga, Seni" class="form-input-custom">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="mentor_name" class="block text-xs font-bold text-slate-700 mb-1">Nama Pembina</label>
                <input type="text" id="mentor_name" name="mentor_name" value="{{ old('mentor_name') }}" placeholder="Nama pembina..." class="form-input-custom">
            </div>

            <div>
                <label for="schedule" class="block text-xs font-bold text-slate-700 mb-1">Jadwal Latihan</label>
                <input type="text" id="schedule" name="schedule" value="{{ old('schedule') }}" placeholder="contoh: Setiap Rabu & Sabtu 15.30 WIB" class="form-input-custom">
            </div>
        </div>

        <div>
            <label for="description" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi</label>
            <textarea id="description" name="description" rows="3" placeholder="Keterangan ektrakurikuler..." class="form-input-custom">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end">
            <x-button type="submit" variant="primary">Simpan Ekstrakurikuler</x-button>
        </div>
    </form>
</div>
@endsection
