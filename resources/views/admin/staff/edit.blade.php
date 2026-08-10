@extends('layouts.admin.app')

@section('title', 'Edit Tenaga Kependidikan - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Tendik')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Data Tenaga Kependidikan (Tendik)</h2>
        <a href="{{ route('admin.staff.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Tendik
        </a>
    </div>

    <form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $staff->name) }}" required placeholder="Masukkan nama lengkap staf..." class="form-input-custom">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="position" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jabatan</label>
                <input type="text" id="position" name="position" value="{{ old('position', $staff->position) }}" required placeholder="contoh: Kepala Tata Usaha, Staff Laboratorium..." class="form-input-custom">
                @error('position')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="nip" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">NIP (Opsional)</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip', $staff->nip) }}" placeholder="Nomor Induk Pegawai..." class="form-input-custom">
                @error('nip')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jenis Kelamin</label>
                <select id="gender" name="gender" required class="form-input-custom bg-white">
                    <option value="L" {{ old('gender', $staff->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $staff->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label for="order_position" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Urutan Tampilan</label>
                <input type="number" id="order_position" name="order_position" value="{{ old('order_position', $staff->order_position) }}" min="0" class="form-input-custom">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Email Staf</label>
                <input type="email" id="email" name="email" value="{{ old('email', $staff->email) }}" placeholder="tu@sman24bdg.sch.id" class="form-input-custom">
            </div>
            <div>
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nomor HP/WA</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $staff->phone) }}" placeholder="0812..." class="form-input-custom">
            </div>
        </div>

        <div class="flex items-center">
            <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $staff->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Status Aktif (Tampilkan di Publik)</span>
            </label>
        </div>

        <div>
            <label for="photo_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Staf (JPG/PNG/WEBP, Max 2MB)</label>
            @if($staff->photo)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ asset($staff->photo) }}" alt="{{ $staff->name }}" class="w-16 h-16 object-cover rounded-xl border border-emerald-800 shadow-sm">
                    <div class="text-xs text-slate-600">
                        <span class="font-bold text-slate-800 block">Foto Aktif saat Ini</span>
                        <span class="text-[11px] text-slate-500 font-mono">{{ asset($staff->photo) }}</span>
                    </div>
                </div>
            @endif
            <input type="file" id="photo_file" name="photo_file" accept="image/*" class="form-input-custom bg-white">
            @error('photo_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.staff.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
