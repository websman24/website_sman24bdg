@extends('layouts.admin.app')

@section('title', 'Manajemen Agenda Sekolah - SMAN 24 Bandung')
@section('breadcrumb', 'Agenda Sekolah')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Agenda & Jadwal Kegiatan</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola jadwal kegiatan SMAN 24 Bandung (MPLS, Ujian, Rapat, Upacara, Kegiatan Siswa, Libur).</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Agenda Baru
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <form action="{{ route('admin.events.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama agenda, lokasi, atau deskripsi..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        
        <div class="flex gap-3 items-center w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                <option value="">-- Semua Status Agenda --</option>
                <option value="upcoming" {{ $status === 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                <option value="ongoing" {{ $status === 'ongoing' ? 'selected' : '' }}>Berlangsung (Ongoing)</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
            </select>

            @if($search || $status)
                <a href="{{ route('admin.events.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
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
                        <th class="px-6 py-4">Banner & Nama Agenda</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Waktu Kegiatan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($events as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if($item->banner)
                                        <img src="{{ asset($item->banner) }}" alt="{{ $item->title }}" class="w-14 h-11 rounded-xl object-cover border border-slate-200 shadow-xs">
                                    @else
                                        <div class="w-14 h-11 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold text-xs border border-slate-200">
                                            🗓️
                                        </div>
                                    @endif
                                    <div class="max-w-md">
                                        <div class="font-bold text-slate-900 text-sm line-clamp-1 hover:text-emerald-700 transition-colors">
                                            {{ $item->title }}
                                        </div>
                                        <div class="text-slate-400 text-[11px] mt-0.5">
                                            Dibuat oleh: {{ $item->author->name ?? 'Admin SMAN 24' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-700 font-medium">
                                📍 {{ $item->location }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 space-y-0.5">
                                <div class="font-bold font-mono text-[11px]">🕒 {{ $item->start_date?->format('d M Y, H:i') }} WIB</div>
                                @if($item->end_date)
                                    <div class="text-[10px] text-slate-400 font-mono">s.d. {{ $item->end_date->format('d M Y, H:i') }} WIB</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border
                                    @if($item->status === 'upcoming') bg-sky-100 text-sky-800 border-sky-300
                                    @elseif($item->status === 'ongoing') bg-amber-100 text-amber-900 border-amber-300
                                    @elseif($item->status === 'completed') bg-slate-100 text-slate-600 border-slate-300
                                    @else bg-rose-100 text-rose-800 border-rose-300 @endif">
                                    {{ $item->status === 'upcoming' ? 'Mendatang' : ($item->status === 'ongoing' ? 'Berlangsung' : ($item->status === 'completed' ? 'Selesai' : 'Dibatalkan')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('events.show', $item->slug) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 font-bold transition-colors">
                                        Preview
                                    </a>
                                    <a href="{{ route('admin.events.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda kegiatan ini?')">
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
                                Tidak ada agenda kegiatan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($events->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
