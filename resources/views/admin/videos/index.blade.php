@extends('layouts.admin.app')

@section('title', 'Manajemen Video YouTube - SMAN 24 Bandung')
@section('breadcrumb', 'Video YouTube')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Video YouTube</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola galeri video resmi SMA Negeri 24 Bandung.</p>
        </div>
        <x-button href="{{ route('admin.videos.create') }}" variant="primary">
            + Tambah Video YouTube
        </x-button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Judul Video</th>
                    <th class="px-6 py-4">YouTube ID</th>
                    <th class="px-6 py-4">URL</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($videos as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 text-sm">{{ $item->title }}</td>
                        <td class="px-6 py-4 font-mono text-emerald-800 font-bold">{{ $item->youtube_id }}</td>
                        <td class="px-6 py-4 text-slate-500 truncate max-w-xs">{{ $item->youtube_url }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.videos.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 rounded bg-rose-50 text-rose-700 font-bold hover:bg-rose-100">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada video terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
