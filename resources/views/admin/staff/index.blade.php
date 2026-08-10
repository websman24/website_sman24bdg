@extends('layouts.admin.app')

@section('title', 'Manajemen Tenaga Kependidikan - SMAN 24 Bandung')
@section('breadcrumb', 'Tenaga Kependidikan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Tenaga Kependidikan (Tendik)</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data staf tata usaha, laboratorium, perpustakaan, dan kebersihan SMAN 24 Bandung.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.teachers.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                👨‍🏫 Kelola Data Guru
            </a>
            <a href="{{ route('admin.staff.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Tendik Baru
            </a>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <form action="{{ route('admin.staff.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama staff, NIP, atau jabatan..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        
        <div class="flex flex-wrap md:flex-nowrap gap-3 items-center w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                <option value="">-- Semua Status --</option>
                <option value="active" {{ $status === 'active' || $status === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $status === 'inactive' || $status === '0' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <select name="gender" onchange="this.form.submit()" class="form-input-custom bg-white py-2 text-xs w-full sm:w-auto">
                <option value="">-- Gender --</option>
                <option value="L" {{ $gender === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                <option value="P" {{ $gender === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
            </select>

            @if($search || $status || $gender)
                <a href="{{ route('admin.staff.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors">
                    Reset Filter
                </a>
            @endif
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Foto & Nama Staf</th>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($staffMembers as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if($item->photo)
                                        <img src="{{ asset($item->photo) }}" alt="{{ $item->name }}" class="w-11 h-11 rounded-xl object-cover border border-slate-200 shadow-xs">
                                    @else
                                        <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-900 font-extrabold flex items-center justify-center text-sm border border-amber-200">
                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $item->name }}</div>
                                        <div class="text-slate-400 text-[11px]">Gender: {{ $item->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-mono">
                                {{ $item->nip ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $item->position }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 space-y-0.5">
                                <div class="text-[11px]">{{ $item->email ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $item->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $item->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-500 border border-slate-300' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.staff.show', $item) }}" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 font-bold transition-colors">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.staff.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.staff.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data tenaga kependidikan ini?')">
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
                                Tidak ada data tenaga kependidikan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($staffMembers->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $staffMembers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
