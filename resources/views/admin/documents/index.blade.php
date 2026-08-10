@extends('layouts.admin.app')

@section('title', 'Manajemen Dokumen & Pusat Unduhan - SMAN 24 Bandung')
@section('breadcrumb', 'Pusat Unduhan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Dokumen & Pusat Unduhan</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola berkas publikasi PDF, Word (DOC/DOCX), Excel (XLS/XLSX), dan dokumen SPMB SMAN 24 Bandung.</p>
        </div>
        <a href="{{ route('admin.documents.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Dokumen Baru
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <form action="{{ route('admin.documents.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul dokumen atau deskripsi..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        
        <div class="flex gap-3 items-center w-full md:w-auto">
            <select name="category" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            @if($search || $category)
                <a href="{{ route('admin.documents.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Judul Dokumen & Berkas</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Ukuran Berkas</th>
                        <th class="px-6 py-4 text-center">Total Unduhan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($documents as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs border border-slate-200 shrink-0 uppercase">
                                        @if(in_array(strtolower($item->file_type), ['pdf']))
                                            📄 PDF
                                        @elseif(in_array(strtolower($item->file_type), ['doc', 'docx']))
                                            📝 DOC
                                        @elseif(in_array(strtolower($item->file_type), ['xls', 'xlsx']))
                                            📊 XLS
                                        @else
                                            📁 FILE
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm max-w-md line-clamp-1">{{ $item->title }}</div>
                                        <div class="text-slate-400 text-[11px] mt-0.5 line-clamp-1">{{ $item->description ?? asset($item->file_path) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-600 font-mono text-[11px]">
                                @if(($item->file_size ?? 0) >= 1048576)
                                    {{ number_format(($item->file_size ?? 0) / 1048576, 2) }} MB
                                @else
                                    {{ number_format(($item->file_size ?? 0) / 1024, 1) }} KB
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    ⬇️ {{ number_format($item->download_count) }}x
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('download.file', $item) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 font-bold transition-colors">
                                        Unduh
                                    </a>
                                    <a href="{{ route('admin.documents.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.documents.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada dokumen publik terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($documents->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
