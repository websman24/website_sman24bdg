@extends('layouts.public.app')

@section('title', 'Pusat Unduhan Dokumen - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Pusat Unduhan' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Pusat Unduhan Dokumen & Formulir</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Unduh berkas resmi, panduan akademik, dan formulir pendaftaran {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
    @if(session('success'))
        <x-alert type="success">
            <span class="font-bold">{{ session('success') }}</span>
        </x-alert>
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
                                <x-button type="submit" variant="primary">
                                    Unduh Berkas 📥
                                </x-button>
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
        <div class="pt-4 flex justify-center">
            {{ $documents->links() }}
        </div>
    @endif
</div>
@endsection
