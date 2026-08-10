@extends('layouts.admin.app')

@section('title', 'Manajemen Prestasi Siswa - SMAN 24 Bandung')
@section('breadcrumb', 'Prestasi Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Prestasi Siswa & Sekolah</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola pencapaian juara lomba, olimpiade, dan kompetisi akademik/non-akademik SMAN 24 Bandung.</p>
        </div>
        <a href="{{ route('admin.achievements.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Prestasi Baru
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <form action="{{ route('admin.achievements.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama peraih, judul prestasi, atau nama event..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        
        <div class="flex flex-wrap md:flex-nowrap gap-3 items-center w-full md:w-auto">
            <select name="category" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                <option value="">-- Semua Kategori --</option>
                <option value="akademik" {{ $category === 'akademik' ? 'selected' : '' }}>Akademik</option>
                <option value="non_akademik" {{ $category === 'non_akademik' ? 'selected' : '' }}>Non-Akademik</option>
            </select>

            <select name="level" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                <option value="">-- Semua Tingkat --</option>
                <option value="kota" {{ $level === 'kota' ? 'selected' : '' }}>Kota / Kabupaten</option>
                <option value="provinsi" {{ $level === 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                <option value="nasional" {{ $level === 'nasional' ? 'selected' : '' }}>Nasional</option>
                <option value="internasional" {{ $level === 'internasional' ? 'selected' : '' }}>Internasional</option>
            </select>

            @if($search || $category || $level)
                <a href="{{ route('admin.achievements.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
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
                        <th class="px-6 py-4">Foto & Judul Prestasi</th>
                        <th class="px-6 py-4">Peraih / Pemenang</th>
                        <th class="px-6 py-4">Event Lomba</th>
                        <th class="px-6 py-4 text-center">Tingkat</th>
                        <th class="px-6 py-4 text-center">Tahun</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($achievements as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if($item->photo)
                                        <img src="{{ asset($item->photo) }}" alt="{{ $item->title }}" class="w-14 h-11 rounded-xl object-cover border border-slate-200 shadow-xs">
                                    @else
                                        <div class="w-14 h-11 rounded-xl bg-amber-100 text-amber-900 font-black flex items-center justify-center text-sm border border-amber-200">
                                            🥇
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm max-w-xs leading-snug">{{ $item->title }}</div>
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[9px] font-extrabold uppercase {{ $item->category === 'akademik' ? 'bg-sky-50 text-sky-800 border border-sky-200' : 'bg-amber-50 text-amber-900 border border-amber-200' }}">
                                            {{ $item->category === 'akademik' ? 'Akademik' : 'Non-Akademik' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800">
                                👤 {{ $item->winner_name }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $item->event_name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-amber-500/20 text-amber-900 border border-amber-300">
                                    {{ strtoupper($item->level) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-mono font-bold text-slate-700">
                                {{ $item->achievement_year }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.achievements.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.achievements.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data prestasi ini?')">
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
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data prestasi terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($achievements->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $achievements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
