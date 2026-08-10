@extends('layouts.admin.app')

@section('title', 'Manajemen Video YouTube - SMAN 24 Bandung')
@section('breadcrumb', 'Video YouTube')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Video Dokumentasi YouTube</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola video kegiatan SMAN 24 Bandung via YouTube Embed tanpa membebani penyimpanan server.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Video YouTube
        </a>
    </div>

    <!-- Search Bar -->
    <form action="{{ route('admin.videos.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex gap-3 items-center">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul video atau deskripsi..." class="form-input-custom">
        <x-button type="submit" variant="primary">Cari</x-button>
        @if($search)
            <a href="{{ route('admin.videos.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                Reset
            </a>
        @endif
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Thumbnail & Judul Video</th>
                        <th class="px-6 py-4">YouTube ID</th>
                        <th class="px-6 py-4">Tautan YouTube</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($videos as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="relative w-20 h-12 rounded-xl overflow-hidden bg-slate-900 border border-slate-200 shrink-0">
                                        <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/hqdefault.jpg" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                            <span class="text-white text-xs">▶️</span>
                                        </div>
                                    </div>
                                    <div class="max-w-md">
                                        <div class="font-bold text-slate-900 text-sm line-clamp-1 hover:text-emerald-700 transition-colors">
                                            {{ $item->title }}
                                        </div>
                                        <div class="text-slate-400 text-[11px] line-clamp-1 mt-0.5">{{ $item->description ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono font-bold text-emerald-800">
                                {{ $item->youtube_id }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ $item->youtube_url }}" target="_blank" class="text-sky-700 font-mono hover:underline text-[11px] truncate max-w-xs block">
                                    {{ $item->youtube_url }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->is_featured)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-900 border border-amber-300">
                                        ⭐ Utama
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px]">Standar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.videos.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.videos.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
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
                                Belum ada video YouTube terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($videos->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $videos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
