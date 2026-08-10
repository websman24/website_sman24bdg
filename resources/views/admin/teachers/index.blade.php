@extends('layouts.admin.app')

@section('title', 'Manajemen Guru & Tendik - SMAN 24 Bandung')
@section('breadcrumb', 'Guru & Tendik')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Direktori Guru & Tendik</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data tenaga pendidik dan kependidikan SMAN 24 Bandung.</p>
        </div>
        <a href="{{ route('admin.teachers.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Guru Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">NIP / NUPTK</th>
                        <th class="px-6 py-4">Nama Lengkap & Gelar</th>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($teachers as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 text-slate-500 font-mono">
                                {{ $item->nip ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                {{ $item->full_name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    {{ $item->subject }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $item->email ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.teachers.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendidik ini?')">
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
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data pendidik terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($teachers->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
