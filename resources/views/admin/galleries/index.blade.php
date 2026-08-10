@extends('layouts.admin.app')

@section('title', 'Manajemen Galeri Foto - SMAN 24 Bandung')
@section('breadcrumb', 'Galeri Foto')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Album Galeri Foto</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola album dokumentasi kegiatan, upload foto-foto, dan atur cover album SMAN 24 Bandung.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Album Foto Baru
        </a>
    </div>

    <!-- Search Bar -->
    <form action="{{ route('admin.galleries.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex gap-3 items-center">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama album atau deskripsi..." class="form-input-custom">
        <x-button type="submit" variant="primary">Cari</x-button>
        @if($search)
            <a href="{{ route('admin.galleries.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                Reset
            </a>
        @endif
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Cover & Judul Album</th>
                        <th class="px-6 py-4">Jumlah Foto</th>
                        <th class="px-6 py-4">Pembuat</th>
                        <th class="px-6 py-4">Tanggal Publikasi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($galleries as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if($item->cover_image)
                                        <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title }}" class="w-14 h-11 rounded-xl object-cover border border-slate-200 shadow-xs">
                                    @else
                                        <div class="w-14 h-11 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold text-xs border border-slate-200">
                                            🖼️
                                        </div>
                                    @endif
                                    <div class="max-w-md">
                                        <div class="font-bold text-slate-900 text-sm line-clamp-1 hover:text-emerald-700 transition-colors">
                                            <a href="{{ route('admin.galleries.show', $item) }}">{{ $item->title }}</a>
                                        </div>
                                        <div class="text-slate-400 text-[11px] line-clamp-1 mt-0.5">{{ $item->description ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-emerald-800">
                                📸 {{ $item->items_count }} foto
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                {{ $item->author->name ?? 'Admin SMAN 24' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-mono text-[11px]">
                                {{ $item->published_at?->format('d M Y') ?? $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.galleries.show', $item) }}" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold transition-colors">
                                        Kelola Foto ({{ $item->items_count }})
                                    </a>
                                    <a href="{{ route('admin.galleries.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit Album
                                    </a>
                                    <form action="{{ route('admin.galleries.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album ini beserta seluruh foto di dalamnya?')">
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
                                Belum ada album foto terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($galleries->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
