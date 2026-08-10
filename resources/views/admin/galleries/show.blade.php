@extends('layouts.admin.app')

@section('title', 'Kelola Foto Album: ' . $gallery->title . ' - SMAN 24 Bandung')
@section('breadcrumb', 'Kelola Foto Album')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-bold text-slate-900">{{ $gallery->title }}</h2>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800">
                    {{ $gallery->items->count() }} Foto
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ $gallery->description ?? 'Kelola foto-foto kegiatan di dalam album ini.' }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="px-4 py-2 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold text-xs transition-colors">
                Edit Info Album
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold text-xs transition-colors">
                &larr; Kembali ke Galeri
            </a>
        </div>
    </div>

    <!-- Upload Photo Form -->
    <form action="{{ route('admin.galleries.items.add', $gallery) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        @csrf
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
            <span>📷 Unggah Foto Baru ke Album Ini</span>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            <div class="sm:col-span-2 space-y-2">
                <label for="photo_file" class="block text-xs font-bold text-slate-700">Berkas Foto (JPG/PNG/WEBP, Max 5MB)</label>
                <input type="file" id="photo_file" name="photo_file" accept="image/*" required class="form-input-custom bg-white">
                @error('photo_file')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-button type="submit" variant="primary" class="w-full">
                    + Unggah Foto
                </x-button>
            </div>
        </div>
        <div>
            <label for="caption" class="block text-xs font-bold text-slate-700 mb-1">Keterangan / Caption Foto (Opsional)</label>
            <input type="text" id="caption" name="caption" placeholder="Tulis caption singkat foto..." class="form-input-custom">
        </div>
    </form>

    <!-- Photos Grid Manager -->
    <div class="space-y-4">
        <h3 class="text-base font-bold text-slate-900 border-b border-slate-200 pb-2">Daftar Foto dalam Album</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($gallery->items as $item)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="relative w-full h-44 bg-slate-100 overflow-hidden">
                        <img src="{{ asset($item->image_path) }}" alt="Foto Galeri" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @if($gallery->cover_image === $item->image_path)
                            <span class="absolute top-2 left-2 px-2.5 py-1 rounded-full text-[9px] font-extrabold bg-amber-500 text-emerald-950 shadow-md uppercase">
                                ⭐ Cover Album
                            </span>
                        @endif
                    </div>

                    <div class="p-4 space-y-3 flex-1 flex flex-col justify-between">
                        <p class="text-xs text-slate-600 italic line-clamp-2 leading-relaxed">
                            {{ $item->caption ?? 'Tanpa caption' }}
                        </p>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            @if($gallery->cover_image !== $item->image_path)
                                <form action="{{ route('admin.galleries.items.cover', [$gallery, $item]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-bold text-amber-700 hover:text-amber-900 hover:underline">
                                        Set Cover
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] font-bold text-emerald-700">Cover Utama</span>
                            @endif

                            <form action="{{ route('admin.galleries.items.delete', [$gallery, $item]) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari album?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-[10px] transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 bg-white p-12 rounded-2xl border border-slate-200 text-center space-y-2">
                    <div class="text-3xl">🖼️</div>
                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Foto dalam Album</h4>
                    <p class="text-xs text-slate-400">Gunakan form di atas untuk mengunggah foto kegiatan ke dalam album ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
