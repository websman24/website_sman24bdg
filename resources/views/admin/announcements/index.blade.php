@extends('layouts.admin.app')

@section('title', 'Manajemen Pengumuman - SMAN 24 Bandung')
@section('breadcrumb', 'Pengumuman')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Pengumuman Resmi</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola pengumuman penting, pin ke atas, berkas lampiran, dan status publikasi SMAN 24 Bandung.</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengumuman Baru
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <form action="{{ route('admin.announcements.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul pengumuman atau isi konten..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        
        <div class="flex gap-3 items-center w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                <option value="">-- Semua Status --</option>
                <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
            </select>

            @if($search || $status)
                <a href="{{ route('admin.announcements.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
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
                        <th class="px-6 py-4">Judul Pengumuman</th>
                        <th class="px-6 py-4">Pin Status</th>
                        <th class="px-6 py-4">Lampiran</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($announcements as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 text-sm truncate max-w-md">{{ $item->title }}</div>
                                <div class="text-slate-400 text-[11px] mt-0.5 font-mono">{{ $item->published_at?->format('d M Y, H:i') ?? $item->created_at->format('d M Y, H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->is_pinned)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                        📌 Pinned
                                    </span>
                                @else
                                    <span class="text-slate-400 font-medium">Standar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($item->attachment_file)
                                    <a href="{{ asset($item->attachment_file) }}" target="_blank" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200 hover:underline inline-flex items-center gap-1">
                                        📎 Unduh Berkas
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $item->status === 'published' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-600 border border-slate-300' }}">
                                    {{ $item->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($item->status === 'published')
                                        <a href="{{ route('announcements.show', $item->slug) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 font-bold transition-colors">
                                            Preview
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.announcements.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.announcements.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
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
                                Tidak ada pengumuman ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($announcements->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
