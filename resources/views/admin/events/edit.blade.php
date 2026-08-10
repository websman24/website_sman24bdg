@extends('layouts.admin.app')

@section('title', 'Edit Agenda - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Agenda')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Agenda / Kegiatan Sekolah</h2>
        <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Daftar Agenda</a>
    </div>

    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Agenda Kegiatan</label>
            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required placeholder="contoh: Masa Pengenalan Lingkungan Sekolah (MPLS), Ujian Akhir Semester..." class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Lokasi Kegiatan</label>
                <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" required placeholder="contoh: Aula Utama / Lapangan Upacara SMAN 24" class="form-input-custom">
                @error('location')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Agenda</label>
                <select id="status" name="status" required class="form-input-custom bg-white">
                    <option value="upcoming" {{ old('status', $event->status) === 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                    <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung (Ongoing)</option>
                    <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
                @error('status')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Waktu & Tanggal Mulai</label>
                <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required class="form-input-custom">
                @error('start_date')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Waktu & Tanggal Selesai (Opsional)</label>
                <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}" class="form-input-custom">
            </div>
        </div>

        <div>
            <label for="banner_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Banner Agenda (JPG/PNG/WEBP, Max 2MB)</label>
            @if($event->banner)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ asset($event->banner) }}" alt="Banner" class="w-16 h-16 object-cover rounded-lg border border-slate-200">
                    <div class="text-xs text-slate-600">
                        <span class="font-bold text-slate-800 block">Banner saat Ini</span>
                        <span class="text-[11px] text-slate-500 font-mono">{{ asset($event->banner) }}</span>
                    </div>
                </div>
            @endif
            <input type="file" id="banner_file" name="banner_file" accept="image/*" class="form-input-custom bg-white">
            @error('banner_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Rinci Kegiatan</label>
            <textarea id="description" name="description" rows="5" placeholder="Detail deskripsi kegiatan, instruksi peserta, dll..." class="form-input-custom">{{ old('description', $event->description) }}</textarea>
            @error('description')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.events.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
