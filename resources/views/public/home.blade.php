@extends('layouts.public.app')

@section('title', 'SMA Negeri 24 Bandung - Official Website')

@section('content')
    <!-- Hero Section -->
    <section class="relative hero-gradient text-white overflow-hidden py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-900/80 border border-emerald-700 text-amber-400 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        Selamat Datang di Official Website
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                        SMA Negeri 24 Bandung
                    </h1>

                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Mewujudkan generasi terdidik yang cerdas, berkarakter, berbudaya, serta berwawasan global di Kota Bandung.
                    </p>

                    <!-- School Address -->
                    <div class="flex items-center gap-3 text-xs sm:text-sm text-emerald-200 bg-emerald-950/60 p-3.5 rounded-2xl border border-emerald-800/80 max-w-xl">
                        <svg class="w-5 h-5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <span class="font-bold text-white block">{{ $schoolInfo['name'] }}</span>
                            <span class="text-xs text-slate-300">{{ $schoolInfo['address'] }}</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="#profil" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold text-xs transition-all shadow-md">
                            Jelajahi Profil
                        </a>
                        <a href="{{ route('admin.login') }}" class="px-5 py-3 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white font-semibold text-xs border border-emerald-600 transition-all">
                            Portal Admin
                        </a>
                    </div>
                </div>

                <!-- Hero Dynamic Headmaster Greeting Card -->
                <div class="lg:col-span-5">
                    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-700/80 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Sambutan Kepala Sekolah</span>
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-900 text-emerald-300 border border-emerald-700">Akreditasi A</span>
                        </div>

                        <div class="space-y-3 text-xs">
                            <h3 class="text-sm font-bold text-white">
                                {{ $profiles['sambutan_kepala_sekolah']->title ?? 'Sambutan Kepala Sekolah' }}
                            </h3>
                            <p class="text-slate-300 leading-relaxed italic">
                                "{{ $profiles['sambutan_kepala_sekolah']->content ?? $schoolInfo['motto'] }}"
                            </p>
                            @if(isset($profiles['sambutan_kepala_sekolah']->meta_json['headmaster_name']))
                                <div class="pt-2 border-t border-slate-800 text-right">
                                    <span class="font-bold text-amber-400 block">{{ $profiles['sambutan_kepala_sekolah']->meta_json['headmaster_name'] }}</span>
                                    <span class="text-[10px] text-slate-400">Kepala SMAN 24 Bandung</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Dynamic Section 1: Profil & Visi Misi -->
    <section id="profil" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Profil Sekolah</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">SMA Negeri 24 Bandung</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2">Jl. A.H. Nasution No. 27, Kota Bandung.</p>
            </div>

            <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 space-y-4">
                <div class="flex items-center gap-3 text-emerald-800 font-bold text-lg">
                    <span class="text-2xl">🏛️</span>
                    <h3>{{ $profiles['visi_misi']->title ?? 'Visi dan Misi Sekolah' }}</h3>
                </div>
                <p class="text-slate-700 text-sm leading-relaxed">
                    {{ $profiles['visi_misi']->content ?? 'Terwujudnya sekolah berkarakter, unggul dalam prestasi akademik dan non-akademik, serta berwawasan global.' }}
                </p>
            </div>
        </div>
    </section>

    <!-- Dynamic Section 2: Berita Terbaru & Pengumuman (Real Data) -->
    <section id="informasi" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Kabar Sekolah</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Berita & Pengumuman Terbaru</h2>
                </div>
                <a href="{{ route('admin.login') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 inline-flex items-center gap-1">
                    Kelola Informasi &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Berita Grid (2 Columns) -->
                <div class="lg:col-span-2 space-y-6">
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Berita Terbaru</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @forelse($latestNews as $news)
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between card-hover-effect">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="px-2.5 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800 text-[10px]">
                                            {{ $news->category->name ?? 'Umum' }}
                                        </span>
                                        <span class="text-slate-400 text-[11px]">{{ $news->published_at?->format('d M Y') }}</span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-base leading-snug line-clamp-2">{{ $news->title }}</h4>
                                    <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed">{{ $news->excerpt }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 bg-white p-8 rounded-2xl border border-slate-200 text-center text-xs text-slate-400">
                                Belum ada berita dipublikasikan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pengumuman Pinned (1 Column) -->
                <div class="space-y-6">
                    <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Pengumuman Tersemat</h3>
                    <div class="space-y-4">
                        @forelse($pinnedAnnouncements as $ann)
                            <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-800">📌 Pengumuman</span>
                                    <span class="text-[10px] text-slate-400">{{ $ann->created_at->format('d M Y') }}</span>
                                </div>
                                <h5 class="font-bold text-slate-900 text-sm leading-snug">{{ $ann->title }}</h5>
                                <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed">{{ $ann->content }}</p>
                            </div>
                        @empty
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 text-center text-xs text-slate-400">
                                Belum ada pengumuman tersemat.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Dynamic Section 3: Direktori Guru (Real Data) -->
    <section id="akademik" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Tenaga Pendidik</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Direktori Guru SMAN 24 Bandung</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2">Guru berkualitas dan berintegritas tinggi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($teachers as $teacher)
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 text-center space-y-3 card-hover-effect">
                        <div class="w-16 h-16 mx-auto rounded-full bg-emerald-800 text-white font-extrabold text-xl flex items-center justify-center shadow-md">
                            {{ strtoupper(substr($teacher->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $teacher->full_name }}</h4>
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                {{ $teacher->subject }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-8 text-xs text-slate-400">Belum ada data guru terdaftar.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Dynamic SPMB Section (Real Documents Data) -->
    <section id="spmb" class="py-16 bg-emerald-950 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-500 text-emerald-950 inline-block">Layanan SPMB</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Seleksi Penerimaan Murid Baru (SPMB)</h2>
                <p class="text-slate-300 text-xs sm:text-sm">
                    Pusat layanan pendaftaran dan verifikasi daftar ulang siswa baru SMA Negeri 24 Bandung.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Sub-menu Card 1: Pendaftar -->
                <div id="spmb-pendaftar" class="bg-emerald-900/60 p-8 rounded-3xl border border-emerald-700/80 space-y-4 hover:border-amber-400/80 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-emerald-950 flex items-center justify-center text-2xl font-bold">
                        📝
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-amber-400">Pendaftar SPMB</h3>
                        <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                            Layanan portal pendaftaran bagi calon murid baru dan informasi berkas persyaratan SPMB SMA Negeri 24 Bandung.
                        </p>
                    </div>

                    <!-- List of Real SPMB Documents -->
                    <div class="pt-2 space-y-2">
                        <span class="text-[11px] font-bold text-amber-300 uppercase tracking-wider block">Dokumen Persyaratan:</span>
                        @forelse($spmbDocuments as $doc)
                            <div class="flex items-center justify-between bg-emerald-950/80 p-3 rounded-xl border border-emerald-800 text-xs">
                                <span class="truncate font-semibold text-white max-w-[200px]">{{ $doc->title }}</span>
                                <span class="text-[10px] text-amber-400 font-mono">({{ $doc->file_type ?? 'PDF' }})</span>
                            </div>
                        @empty
                            <div class="text-xs text-slate-400">Belum ada dokumen SPMB diunggah.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Sub-menu Card 2: Daftar Ulang -->
                <div id="spmb-daftar-ulang" class="bg-emerald-900/60 p-8 rounded-3xl border border-emerald-700/80 space-y-4 hover:border-amber-400/80 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-emerald-950 flex items-center justify-center text-2xl font-bold">
                        ✅
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-emerald-300">Daftar Ulang SPMB</h3>
                        <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                            Layanan daftar ulang bagi calon peserta didik yang dinyatakan lulus seleksi SPMB SMA Negeri 24 Bandung.
                        </p>
                    </div>
                    <div class="pt-2">
                        <div class="bg-emerald-950/80 p-4 rounded-xl border border-emerald-800 text-xs text-emerald-200">
                            <strong>Status Layanan:</strong> Verifikasi daftar ulang dilakukan di kampus SMAN 24 Bandung, Jl. A.H. Nasution No. 27.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location & Contact Section -->
    <section id="kontak" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="space-y-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-500 text-emerald-950">Kontak Sekolah</span>
                        <h3 class="text-2xl font-extrabold">SMA Negeri 24 Bandung</h3>
                        <div class="space-y-2 text-xs sm:text-sm text-slate-300 pt-2">
                            <p><strong>Alamat:</strong> Jl. A.H. Nasution No. 27, Kota Bandung, Jawa Barat</p>
                            <p><strong>Telepon:</strong> (022) 7800540</p>
                            <p><strong>Email:</strong> info@sman24bdg.sch.id</p>
                        </div>
                    </div>

                    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 text-center space-y-3">
                        <div class="text-3xl">🏫</div>
                        <h4 class="text-base font-bold text-white">Portal Admin Website</h4>
                        <p class="text-xs text-slate-400">Masuk untuk mengelola konten dan sistem informasi sekolah.</p>
                        <a href="{{ route('admin.login') }}" class="inline-block px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold text-xs transition-all">
                            Masuk Portal Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
