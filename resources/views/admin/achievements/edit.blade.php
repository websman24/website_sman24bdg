@extends('layouts.admin.app')

@section('title', 'Edit Prestasi - SMAN 24 Bandung')
@section('breadcrumb', 'Edit Prestasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Edit Data Prestasi Siswa</h2>
        <a href="{{ route('admin.achievements.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali ke Daftar Prestasi</a>
    </div>

    <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Prestasi / Kejuaraan</label>
            <input type="text" id="title" name="title" value="{{ old('title', $achievement->title) }}" required placeholder="contoh: Juara 1 Olimpiade Sains Matematika Kota Bandung" class="form-input-custom">
            @error('title')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Prestasi</label>
                <select id="category" name="category" required class="form-input-custom bg-white">
                    <option value="akademik" {{ old('category', $achievement->category) === 'akademik' ? 'selected' : '' }}>Akademik (Olimpiade, KSN, Karya Tulis)</option>
                    <option value="non_akademik" {{ old('category', $achievement->category) === 'non_akademik' ? 'selected' : '' }}>Non-Akademik (Olahraga, Seni, Pramuka, Paskibra)</option>
                </select>
                @error('category')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="level" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tingkat Kejuaraan</label>
                <select id="level" name="level" required class="form-input-custom bg-white">
                    <option value="kota" {{ old('level', $achievement->level) === 'kota' ? 'selected' : '' }}>Kota / Kabupaten</option>
                    <option value="provinsi" {{ old('level', $achievement->level) === 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                    <option value="nasional" {{ old('level', $achievement->level) === 'nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="internasional" {{ old('level', $achievement->level) === 'internasional' ? 'selected' : '' }}>Internasional</option>
                </select>
                @error('level')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label for="winner_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Siswa / Tim Pemenang</label>
                <input type="text" id="winner_name" name="winner_name" value="{{ old('winner_name', $achievement->winner_name) }}" required placeholder="Nama siswa atau tim..." class="form-input-custom">
                @error('winner_name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="event_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Event / Kompetisi</label>
                <input type="text" id="event_name" name="event_name" value="{{ old('event_name', $achievement->event_name) }}" required placeholder="Nama acara lomba..." class="form-input-custom">
                @error('event_name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="achievement_year" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tahun Prestasi</label>
                <input type="number" id="achievement_year" name="achievement_year" value="{{ old('achievement_year', $achievement->achievement_year) }}" required class="form-input-custom">
                @error('achievement_year')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="photo_file" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Penyerahan Piala / Dokumentasi (JPG/PNG/WEBP, Max 2MB)</label>
            @if($achievement->photo)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ asset($achievement->photo) }}" alt="{{ $achievement->title }}" class="w-16 h-14 object-cover rounded-xl border border-slate-200">
                    <div class="text-xs text-slate-600">
                        <span class="font-bold text-slate-800 block">Foto Saat Ini</span>
                        <span class="text-[11px] text-slate-500 font-mono">{{ asset($achievement->photo) }}</span>
                    </div>
                </div>
            @endif
            <input type="file" id="photo_file" name="photo_file" accept="image/*" class="form-input-custom bg-white">
            @error('photo_file')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi / Catatan Tambahan (Opsional)</label>
            <textarea id="description" name="description" rows="3" placeholder="Detail pencapaian, perolehan medali, dll..." class="form-input-custom">{{ old('description', $achievement->description) }}</textarea>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <x-button href="{{ route('admin.achievements.index') }}" variant="outline">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                Simpan Perubahan
            </x-button>
        </div>
    </form>
</div>
@endsection
