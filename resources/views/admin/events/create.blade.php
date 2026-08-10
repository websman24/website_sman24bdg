@extends('layouts.admin.app')

@section('title', 'Tambah Agenda Baru - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Agenda')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Agenda / Acara Baru</h2>
        <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.events.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold text-slate-700 mb-1">Judul Agenda</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="contoh: Upacara Bendera HUT SMAN 24..." class="form-input-custom">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="location" class="block text-xs font-bold text-slate-700 mb-1">Lokasi Acara</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required placeholder="contoh: Lapangan Utama SMAN 24" class="form-input-custom">
            </div>

            <div>
                <label for="start_date" class="block text-xs font-bold text-slate-700 mb-1">Tanggal & Waktu Mulai</label>
                <input type="datetime-local" id="start_date" name="start_date" required class="form-input-custom">
            </div>
        </div>

        <div>
            <label for="status" class="block text-xs font-bold text-slate-700 mb-1">Status Agenda</label>
            <select id="status" name="status" required class="form-input-custom bg-white">
                <option value="upcoming">Akan Datang (Upcoming)</option>
                <option value="ongoing">Sedang Berlangsung (Ongoing)</option>
                <option value="completed">Selesai (Completed)</option>
            </select>
        </div>

        <div>
            <label for="description" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Agenda</label>
            <textarea id="description" name="description" rows="4" placeholder="Detail deskripsi kegiatan..." class="form-input-custom">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button type="submit" variant="primary">Simpan Agenda</x-button>
        </div>
    </form>
</div>
@endsection
