@extends('layouts.admin.app')

@section('title', 'Tambah Pengguna - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Pengguna')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Akun Pengguna Administrator Baru</h2>
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Daftar Pengguna</a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap Pengguna</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap..." class="form-input-custom">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Alamat Email Login</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh: user@sman24bdg.sch.id" class="form-input-custom">
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kata Sandi (Minimal 8 Karakter)</label>
                <input type="password" id="password" name="password" required placeholder="••••••••" class="form-input-custom">
                @error('password')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" class="form-input-custom">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Role / Hak Akses Pengguna</label>
                <select id="role" name="role" required class="form-input-custom bg-white">
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin CMS (Akses Penuh CMS)</option>
                    <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin (Hak Akses Lengkap)</option>
                    <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor / Humas (Penulis Berita & Pengumuman)</option>
                    <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru / Pengajar (Akses Materi & Pengumuman)</option>
                </select>
                @error('role')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="avatar_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Profile / Avatar (JPG/PNG/WEBP, Max 2MB)</label>
                <input type="file" id="avatar_file" name="avatar_file" accept="image/*" class="form-input-custom bg-white">
                @error('avatar_file')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center">
            <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Status Akun Aktif (Izinkan Login ke Portal Admin)</span>
            </label>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.users.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Akun Pengguna
            </x-button>
        </div>
    </form>
</div>
@endsection
