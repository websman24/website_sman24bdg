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

                <!-- Hero Overview Card -->
                <div class="lg:col-span-5">
                    <div class="bg-slate-900/90 p-6 rounded-3xl border border-slate-700/80 space-y-4 shadow-xl">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Identitas Sekolah</span>
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-900 text-emerald-300 border border-emerald-700">Akreditasi A</span>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between py-1 border-b border-slate-800">
                                <span class="text-slate-400">Nama Sekolah</span>
                                <span class="font-semibold text-white">SMA Negeri 24 Bandung</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-800">
                                <span class="text-slate-400">NPSN</span>
                                <span class="font-semibold text-white">20219736</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-800">
                                <span class="text-slate-400">Alamat</span>
                                <span class="font-semibold text-white text-right">Jl. A.H. Nasution No. 27</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-800">
                                <span class="text-slate-400">Kota / Provinsi</span>
                                <span class="font-semibold text-white">Kota Bandung, Jawa Barat</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-400">Status Aplikasi</span>
                                <span class="font-bold text-amber-400">Tahap 1 Ready</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Placeholder Section 1: Profil -->
    <section id="profil" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Menu Profil</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Profil SMA Negeri 24 Bandung</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2">Visi, Misi, Sejarah, dan Struktur Organisasi Sekolah.</p>
            </div>

            <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 text-center space-y-3">
                <div class="text-3xl">🏛️</div>
                <h3 class="text-base font-bold text-slate-800">Placeholder Konten Profil</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Halaman profil sekolah sedang disiapkan. Pada tahap berikutnya, section ini akan menampilkan sejarah sekolah, visi & misi, serta daftar pimpinan sekolah.
                </p>
            </div>
        </div>
    </section>

    <!-- Placeholder Section 2: Akademik -->
    <section id="akademik" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Menu Akademik</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Program Akademik & Kurikulum</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2">Kurikulum Merdeka, Kalender Pendidikan, dan Fasilitas Pembelajaran.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center space-y-3">
                <div class="text-3xl">📚</div>
                <h3 class="text-base font-bold text-slate-800">Placeholder Konten Akademik</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Modul program akademik, jadwal pelajaran, dan direktori pembelajaran guru akan diimplementasikan pada tahap selanjutnya.
                </p>
            </div>
        </div>
    </section>

    <!-- Placeholder Section 3: Kesiswaan -->
    <section id="kesiswaan" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Menu Kesiswaan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Kegiatan Siswa & Ekstrakurikuler</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2">OSIS, MPK, Ekstrakurikuler, dan Prestasi Siswa.</p>
            </div>

            <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 text-center space-y-3">
                <div class="text-3xl">⚽</div>
                <h3 class="text-base font-bold text-slate-800">Placeholder Konten Kesiswaan</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Daftar kegiatan OSIS, ekstrakurikuler (Paskibra, Pramuka, PMR, Olahraga, Seni), serta dokumentasi prestasi siswa.
                </p>
            </div>
        </div>
    </section>

    <!-- Placeholder Section 4: Informasi -->
    <section id="informasi" class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Menu Informasi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Berita, Pengumuman & Agenda</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2">Pusat kabar dan kegiatan terbaru SMA Negeri 24 Bandung.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center space-y-3">
                <div class="text-3xl">📰</div>
                <h3 class="text-base font-bold text-slate-800">Placeholder Berita & Pengumuman</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    Integrasi sistem manajemen konten (CMS berita, agenda kegiatan, pengumuman sekolah) siap dikembangkan pada tahap selanjutnya.
                </p>
            </div>
        </div>
    </section>

    <!-- Placeholder Section 5: Galeri & Download -->
    <section id="galeri" class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Galeri Box -->
                <div id="download" class="bg-slate-50 p-8 rounded-2xl border border-slate-200 text-center space-y-3">
                    <div class="text-3xl">🖼️</div>
                    <h3 class="text-base font-bold text-slate-800">Placeholder Galeri Foto</h3>
                    <p class="text-xs text-slate-500">
                        Dokumentasi foto kegiatan sekolah, acara resmi, dan fasilitas SMAN 24 Bandung.
                    </p>
                </div>

                <!-- Download Box -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 text-center space-y-3">
                    <div class="text-3xl">📁</div>
                    <h3 class="text-base font-bold text-slate-800">Placeholder Download Dokumen</h3>
                    <p class="text-xs text-slate-500">
                        Pusat unduhan formulir, panduan akademik, dan dokumen publik sekolah.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SPMB Section (Seleksi Penerimaan Murid Baru: Pendaftar & Daftar Ulang) -->
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
                            Layanan portal pendaftaran bagi calon murid baru, cek status verifikasi pendaftaran, dan informasi berkas persyaratan SPMB SMA Negeri 24 Bandung.
                        </p>
                    </div>
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-950 border border-emerald-700 text-xs text-amber-300 font-semibold">
                            <span>Status: Placeholder Modul Pendaftar</span>
                        </span>
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
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-950 border border-emerald-700 text-xs text-emerald-300 font-semibold">
                            <span>Status: Placeholder Modul Daftar Ulang</span>
                        </span>
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
