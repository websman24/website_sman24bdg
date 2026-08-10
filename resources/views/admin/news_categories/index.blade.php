@extends('layouts.admin.app')

@section('title', 'Kategori Berita - SMAN 24 Bandung')
@section('breadcrumb', 'Kategori Berita')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Manajemen Kategori Berita</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola daftar pengelompokan jenis kategori artikel dan berita sekolah.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
            &larr; Kembali ke Kelola Berita
        </a>
    </div>

    @if(session('error'))
        <x-alert type="error" class="mb-4">
            {{ session('error') }}
        </x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Form Tambah Kategori Baru (4 Cols) -->
        <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Tambah Jenis Kategori Baru</h3>
            
            <form action="{{ route('admin.news-categories.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama Kategori</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="contoh: Prestasi, Ekstrakurikuler, Alumni..." class="form-input-custom">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Kategori (Opsional)</label>
                    <textarea id="description" name="description" rows="3" placeholder="Keterangan singkat kategori..." class="form-input-custom">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <x-button type="submit" variant="primary" class="w-full justify-center">
                        + Tambah Kategori
                    </x-button>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Kategori (8 Cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Slug</th>
                            <th class="px-6 py-4 text-center">Jumlah Berita</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($categories as $cat)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ $cat->name }}</div>
                                    @if($cat->description)
                                        <div class="text-slate-500 text-[11px] mt-0.5">{{ $cat->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-slate-500 text-[11px]">
                                    {{ $cat->slug }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $cat->news_count }} berita
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.news-categories.edit', $cat) }}" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.news-categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada kategori berita terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($categories->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
