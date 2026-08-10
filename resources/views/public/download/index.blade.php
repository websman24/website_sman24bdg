@extends('layouts.public.app')

@section('title', 'Pusat Unduhan Dokumen - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Pusat Unduhan Dokumen & Formulir</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Unduh berkas resmi, panduan, dan formulir SMAN 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4">Judul Dokumen</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Ukuran</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($documents as $doc)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $doc->title }}</div>
                            <div class="text-slate-500 text-[11px] mt-0.5">{{ $doc->description }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">
                                {{ $doc->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-mono">
                            {{ number_format(($doc->file_size ?? 0) / 1024, 1) }} KB
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('download.file', $doc) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-xs transition-colors">
                                    Unduh Berkas 📥
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            Belum ada dokumen tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($documents->hasPages())
        <div class="pt-4">
            {{ $documents->links() }}
        </div>
    @endif
</div>
@endsection
