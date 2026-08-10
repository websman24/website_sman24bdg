@extends('layouts.admin.app')

@section('title', 'Manajemen Agenda - SMAN 24 Bandung')
@section('breadcrumb', 'Agenda Sekolah')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Agenda & Acara Sekolah</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola jadwal kegiatan dan rapat SMAN 24 Bandung.</p>
        </div>
        <x-button href="{{ route('admin.events.create') }}" variant="primary">
            + Tambah Agenda Baru
        </x-button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Nama Agenda</th>
                    <th class="px-6 py-4">Lokasi</th>
                    <th class="px-6 py-4">Tanggal Mulai</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($events as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 text-sm">{{ $item->title }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $item->location }}</td>
                        <td class="px-6 py-4 text-slate-500 font-mono">{{ $item->start_date?->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.events.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 rounded bg-rose-50 text-rose-700 font-bold hover:bg-rose-100">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada agenda terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
