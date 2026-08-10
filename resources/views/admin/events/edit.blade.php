@extends('layouts.admin.app')

@section('title', 'Edit Agenda - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Agenda')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Agenda / Acara Sekolah</h2>
        <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.events.update', $event) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold text-slate-700 mb-1">Judul Agenda</label>
            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required placeholder="contoh: Upacara Bendera HUT SMAN 24..." class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="location" class="block text-xs font-bold text-slate-700 mb-1">Lokasi Acara</label>
                <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" required placeholder="contoh: Lapangan Utama SMAN 24" class="form-input-custom">
                @error('location')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="start_date" class="block text-xs font-bold text-slate-700 mb-1">Tanggal & Waktu Mulai</label>
                <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required class="form-input-custom">
                @error('start_date')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="status" class="block text-xs font-bold text-slate-700 mb-1">Status Agenda</label>
            <select id="status" name="status" required class="form-input-custom bg-white">
                <option value="upcoming" {{ old('status', $event->status) === 'upcoming' ? 'selected' : '' }}>Akan Datang (Upcoming)</option>
                <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung (Ongoing)</option>
                <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                <option value="cancelled" {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
            </select>
            @error('status')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Agenda</label>
            <textarea id="description" name="description" rows="4" placeholder="Detail deskripsi kegiatan..." class="form-input-custom">{{ old('description', $event->description) }}</textarea>
            @error('description')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.events.index') }}" variant="outline">Batal</x-button>
            <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
        </div>
    </form>
</div>
@endsection
