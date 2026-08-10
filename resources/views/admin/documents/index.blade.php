@extends('layouts.admin.app')

@section('title', 'Manajemen Dokumen & SPMB - SMAN 24 Bandung')
@section('breadcrumb', 'Dokumen & SPMB')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Unduhan Dokumen & SPMB</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola berkas publikasi, formulir, dan dokumen SPMB SMAN 24 Bandung.</p>
        </div>
        <a href="{{ route('admin.documents.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Dokumen
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Pengunduh</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($documents as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-sm truncate max-w-md">{{ $item->title }}</div>
                                <div class="text-slate-400 text-[11px] mt-0.5">{{ $item->file_type ?? 'PDF' }} &bull; {{ number_format(($item->file_size ?? 0) / 1024, 1) }} KB</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">
                                    {{ $item->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-mono">
                                {{ $item->download_count }}x diunduh
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.documents.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                Belum ada dokumen terdaftar.
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
