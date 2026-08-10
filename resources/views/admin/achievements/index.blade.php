@extends('layouts.admin.app')

@section('title', 'Manajemen Prestasi - SMAN 24 Bandung')
@section('breadcrumb', 'Prestasi Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Prestasi Siswa & Sekolah</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola pencapaian lomba dan olimpiade SMAN 24 Bandung.</p>
        </div>
        <x-button href="{{ route('admin.achievements.create') }}" variant="primary">
            + Tambah Prestasi Baru
        </x-button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Judul Prestasi</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Tingkat</th>
                    <th class="px-6 py-4">Pemenang</th>
                    <th class="px-6 py-4">Tahun</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($achievements as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 text-sm">{{ $item->title }}</td>
                        <td class="px-6 py-4 uppercase font-bold text-emerald-800">{{ $item->category }}</td>
                        <td class="px-6 py-4 uppercase font-bold text-amber-700">Tingkat {{ $item->level }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $item->winner_name }}</td>
                        <td class="px-6 py-4 font-mono text-slate-500">{{ $item->achievement_year }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.achievements.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 rounded bg-rose-50 text-rose-700 font-bold hover:bg-rose-100">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada prestasi terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
