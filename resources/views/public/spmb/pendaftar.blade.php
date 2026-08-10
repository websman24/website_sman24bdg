@extends('layouts.public.app')

@section('title', 'Layanan Pendaftar SPMB - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold">Informasi Pendaftar SPMB</h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2">Seleksi Penerimaan Murid Baru SMA Negeri 24 Bandung.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-3">Petunjuk Pendaftaran Murid Baru</h2>
        <p class="text-slate-700 text-sm leading-relaxed">
            Calon peserta didik baru dapat mengunduh dokumen persyaratan di bawah ini dan mengikuti alur seleksi penerimaan murid baru sesuai jadwal yang ditetapkan oleh Dinas Pendidikan Provinsi Jawa Barat dan SMA Negeri 24 Bandung.
        </p>
    </div>

    <!-- Downloadable SPMB Documents -->
    <div class="space-y-4">
        <h3 class="text-base font-bold text-slate-900">Dokumen Persyaratan SPMB</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($spmbDocuments as $doc)
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $doc->title }}</h4>
                        <p class="text-xs text-slate-500 mt-1">{{ $doc->description }}</p>
                    </div>
                    <form action="{{ route('download.file', $doc) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold text-xs">
                            Unduh 📥
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-2 p-6 bg-slate-50 rounded-2xl text-center text-xs text-slate-400">
                    Belum ada berkas SPMB diunggah.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
