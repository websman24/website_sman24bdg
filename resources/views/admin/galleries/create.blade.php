@extends('layouts.admin.app')

@section('title', 'Tambah Album Foto - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Album')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Album Foto Baru</h2>
        <a href="{{ route('admin.galleries.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold text-slate-700 mb-1">Judul Album</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="contoh: Dokumentasi Upacara HUT RI..." class="form-input-custom">
        </div>

        <div>
            <label for="description" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Album</label>
            <textarea id="description" name="description" rows="3" placeholder="Keterangan singkat mengenai album foto..." class="form-input-custom">{{ old('description') }}</textarea>
        </div>

        <div class="pt-4 flex justify-end">
            <x-button type="submit" variant="primary">Simpan Album Foto</x-button>
        </div>
    </form>
</div>
@endsection
