@extends('layouts.public.app')

@section('title', 'Pusat Unduhan Dokumen & Formulir - SMAN 24 Bandung')

@section('content')
<!-- Page Header Banner -->
<div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white py-12 border-b border-emerald-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <x-breadcrumb :items="['Pusat Unduhan' => '']" />
        <h1 class="text-3xl font-extrabold tracking-tight">Pusat Unduhan Dokumen & Formulir</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">Unduh berkas resmi, panduan akademik, formulir SPMB, dan surat edaran {{ \App\Models\Setting::getValue('school_name', 'SMA Negeri 24 Bandung') }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    @if(session('success'))
        <x-alert type="success">
            <span class="font-bold">{{ session('success') }}</span>
        </x-alert>
    @endif

    <!-- Search & Filter Bar -->
    <form action="{{ route('download.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex-1 w-full flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul dokumen atau deskripsi..." class="form-input-custom">
            <x-button type="submit" variant="primary">Cari</x-button>
        </div>
        <div class="flex gap-2 items-center overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('download.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ !request('category') ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Semua Dokumen</a>
            @foreach($categories as $cat)
                <a href="{{ route('download.index', ['category' => $cat]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap {{ request('category') === $cat ? 'bg-emerald-800 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </form>

    <!-- Documents List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Format & Nama Dokumen</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Ukuran Berkas</th>
                        <th class="px-6 py-4 text-center">Total Unduhan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs border border-slate-200 shrink-0 uppercase">
                                        @if(in_array(strtolower($doc->file_type), ['pdf']))
                                            📄 PDF
                                        @elseif(in_array(strtolower($doc->file_type), ['doc', 'docx']))
                                            📝 DOC
                                        @elseif(in_array(strtolower($doc->file_type), ['xls', 'xlsx']))
                                            📊 XLS
                                        @else
                                            📁 FILE
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm max-w-md leading-snug">{{ $doc->title }}</h3>
                                        <p class="text-slate-500 text-[11px] mt-0.5 line-clamp-1 max-w-md">{{ $doc->description ?? 'Dokumen resmi SMAN 24 Bandung.' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">
                                    {{ $doc->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-600 font-mono text-[11px]">
                                @if(($doc->file_size ?? 0) >= 1048576)
                                    {{ number_format(($doc->file_size ?? 0) / 1048576, 2) }} MB
                                @else
                                    {{ number_format(($doc->file_size ?? 0) / 1024, 1) }} KB
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-slate-500 font-mono">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    ⬇️ {{ number_format($doc->download_count) }}x
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('download.file', $doc) }}" method="POST">
                                    @csrf
                                    <x-button type="submit" variant="primary" class="shadow-xs font-bold text-xs py-2 px-3.5">
                                        Unduh ⬇️
                                    </x-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center space-y-2 text-slate-400">
                                <div class="text-3xl">📂</div>
                                <h4 class="font-bold text-slate-800 text-sm">Belum Ada Dokumen</h4>
                                <p class="text-xs text-slate-400">Berkas dan formulir akan ditampilkan di halaman ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($documents->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $documents->links() }}
        </div>
    @endif
</div>
@endsection
