@extends('layouts.admin.app')

@section('title', 'Edit Pengurus OSIS - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Pengurus OSIS')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Edit Data Pengurus OSIS & MPK</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui data {{ $member->name }} ({{ $member->position }}).</p>
        </div>
        <a href="{{ route('admin.osis.index', ['tab' => 'members']) }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali ke Daftar Pengurus
        </a>
    </div>

    <form action="{{ route('admin.osis.members.update', $member) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap Siswa</label>
                <input type="text" id="name" name="name" value="{{ old('name', $member->name) }}" required placeholder="e.g. Muhammad Rizky Pratama" class="form-input-custom">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="position" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jabatan</label>
                <input type="text" id="position" name="position" value="{{ old('position', $member->position) }}" required placeholder="e.g. Ketua OSIS, Sekretaris 1, Ketua Sekbid 1" class="form-input-custom">
                @error('position')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="department" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Divisi / Seksi Bidang</label>
                <select id="department" name="department" required class="form-input-custom bg-white">
                    @foreach($departments as $key => $label)
                        <option value="{{ $key }}" {{ old('department', $member->department) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('department')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="class_grade" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kelas</label>
                <input type="text" id="class_grade" name="class_grade" value="{{ old('class_grade', $member->class_grade) }}" placeholder="e.g. XI MIPA 1 / X-4" class="form-input-custom">
            </div>
            <div>
                <label for="order_position" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Urutan Tampilan</label>
                <input type="number" id="order_position" name="order_position" value="{{ old('order_position', $member->order_position) }}" min="0" class="form-input-custom">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="instagram" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Akun Instagram (Opsional)</label>
                <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $member->instagram) }}" placeholder="e.g. @rizky.pratama" class="form-input-custom">
            </div>
            <div>
                <label for="motto" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kutipan / Motto Siswa</label>
                <input type="text" id="motto" name="motto" value="{{ old('motto', $member->motto) }}" placeholder="e.g. Terus belajar dan memberi manfaat." class="form-input-custom">
            </div>
        </div>

        <div class="flex items-center">
            <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span>Status Aktif (Tampilkan di Struktur Organisasi)</span>
            </label>
        </div>

        <div>
            <label for="photo_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Pengurus (JPG/PNG/WEBP, Max 2MB)</label>
            @if($member->photo)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="w-16 h-16 object-cover rounded-xl border border-indigo-700 shadow-xs">
                    <div class="text-xs text-slate-600">
                        <span class="font-bold text-slate-800 block">Foto Aktif saat Ini</span>
                        <span class="text-[11px] text-slate-500 font-mono">{{ asset($member->photo) }}</span>
                    </div>
                </div>
            @endif
            <input type="file" id="photo_file" name="photo_file" accept="image/*" class="form-input-custom bg-white">
            @error('photo_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.osis.index', ['tab' => 'members']) }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
