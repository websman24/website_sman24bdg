@extends('layouts.admin.app')

@section('title', 'Manajemen Kata-Kata Bijak SPMB - SMAN 24 Bandung')
@section('breadcrumb', 'Kata-Kata Bijak SPMB')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Kata-Kata Bijak (Running Text SPMB)</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola daftar kalimat inspiratif dan kata-kata bijak yang tampil pada seksi Layanan SPMB di beranda.</p>
        </div>
        <x-button href="{{ route('admin.spmb-quotes.create') }}" variant="primary">
            + Tambah Kata Bijak
        </x-button>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.spmb-quotes.index') }}" class="flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari teks kata bijak atau pembuat..." class="form-input-custom flex-1">
            <x-button type="submit" variant="secondary">Cari</x-button>
            @if($search)
                <x-button href="{{ route('admin.spmb-quotes.index') }}" variant="outline">Reset</x-button>
            @endif
        </form>
    </div>

    <!-- Quotes Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4 w-16 text-center">Urutan</th>
                        <th class="p-4">Teks Kata-Kata Bijak</th>
                        <th class="p-4">Sumber / Penulis</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($quotes as $q)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 text-center font-mono font-bold text-slate-600">{{ $q->order_position }}</td>
                            <td class="p-4 font-medium text-slate-900 max-w-md leading-relaxed">
                                "{{ $q->quote_text }}"
                            </td>
                            <td class="p-4 text-slate-600 font-medium">{{ $q->author_source ?? '-' }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.spmb-quotes.toggle', $q) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-extrabold transition-colors {{ $q->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-500 border border-slate-300' }}">
                                        {{ $q->is_active ? '● Aktif' : '○ Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.spmb-quotes.edit', $q) }}" class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 font-bold hover:bg-amber-100 transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('admin.spmb-quotes.destroy', $q) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kata bijak ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 font-bold hover:bg-rose-100 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">Belum ada kata-kata bijak SPMB terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($quotes->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $quotes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
