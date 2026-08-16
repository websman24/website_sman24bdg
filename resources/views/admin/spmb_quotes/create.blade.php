@extends('layouts.admin.app')

@section('title', 'Tambah Kata-Kata Bijak SPMB - SMAN 24 Bandung')
@section('breadcrumb', 'Tambah Kata-Kata Bijak')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Tambah Kata-Kata Bijak SPMB</h2>
            <p class="text-xs text-slate-500 mt-1">Buat kutipan kalimat inspiratif baru untuk running text di atas seksi Layanan SPMB.</p>
        </div>
        <x-button href="{{ route('admin.spmb-quotes.index') }}" variant="outline">
            &larr; Kembali
        </x-button>
    </div>

    <form action="{{ route('admin.spmb-quotes.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div>
            <label for="quote_text" class="block text-xs font-bold text-slate-700 mb-1">Teks Kata-Kata Bijak / Kalimat Inspiratif *</label>
            <textarea id="quote_text" name="quote_text" rows="3" required placeholder="Contoh: Pendidikan adalah tiket ke masa depan, hari esok dimiliki oleh orang-orang yang mempersiapkannya hari ini." class="form-input-custom">{{ old('quote_text') }}</textarea>
            @error('quote_text')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="author_source" class="block text-xs font-bold text-slate-700 mb-1">Sumber / Penulis (Opsional)</label>
                <input type="text" id="author_source" name="author_source" value="{{ old('author_source', 'SMAN 24 Bandung') }}" placeholder="Contoh: SMAN 24 Bandung / Nelson Mandela" class="form-input-custom">
            </div>

            <div>
                <label for="order_position" class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil *</label>
                <input type="number" id="order_position" name="order_position" value="{{ old('order_position', 1) }}" min="1" required class="form-input-custom">
            </div>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-emerald-800 focus:ring-emerald-800">
            <label for="is_active" class="text-xs font-bold text-slate-700">Aktifkan Running Text Ini Langsung</label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <x-button href="{{ route('admin.spmb-quotes.index') }}" variant="outline">Batal</x-button>
            <x-button type="submit" variant="primary">Simpan Kata Bijak</x-button>
        </div>
    </form>
</div>
@endsection
