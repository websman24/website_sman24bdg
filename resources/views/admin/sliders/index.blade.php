@extends('layouts.admin.app')

@section('title', 'Manajemen Hero Image Slider - SMAN 24 Bandung')
@section('breadcrumb', 'Hero Slider')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Manajemen Hero Image Slider</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola slide banner gambar utama yang tampil di beranda website publik.</p>
        </div>
        <x-button href="{{ route('admin.sliders.create') }}" variant="primary">
            + Tambah Slide Baru
        </x-button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Preview Gambar</th>
                    <th class="px-6 py-4">Judul Slide</th>
                    <th class="px-6 py-4">Urutan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($sliders as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            @if($item->image_path)
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-24 h-14 object-cover rounded-xl border border-slate-200 shadow-sm">
                            @else
                                <div class="w-24 h-14 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs">No Image</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $item->title }}</div>
                            <div class="text-slate-500 text-[11px] mt-0.5">{{ $item->subtitle }}</div>
                        </td>
                        <td class="px-6 py-4 font-mono font-bold text-emerald-800">
                            #{{ $item->order_position }}
                        </td>
                        <td class="px-6 py-4">
                            @if($item->is_active)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.sliders.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus slide ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 font-bold hover:bg-rose-100 transition-colors">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada slide banner terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
