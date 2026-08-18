@extends('layouts.public.app')

@section('title', $news->title . ' - SMA Negeri 24 Bandung')
@section('meta_description', Str::limit(strip_tags($news->excerpt ?? $news->content), 155))
@section('meta_keywords', 'Berita, SMAN 24 Bandung, Informasi Sekolah, ' . ($news->category?->name ?? 'Kegiatan Sekolah'))
@section('og_type', 'article')
@section('og_title', $news->title . ' - SMA Negeri 24 Bandung')
@section('og_description', Str::limit(strip_tags($news->excerpt ?? $news->content), 155))
@section('og_image', $news->thumbnail ? asset($news->thumbnail) : asset('assets/images/logo.png'))

@section('extra_json_ld')
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "{{ '@type' }}": "NewsArticle",
  "headline": "{{ addslashes($news->title) }}",
  "image": [
    "{{ $news->thumbnail ? asset($news->thumbnail) : asset('assets/images/logo.png') }}"
  ],
  "datePublished": "{{ $news->published_at?->toIso8601String() ?? $news->created_at->toIso8601String() }}",
  "dateModified": "{{ $news->updated_at->toIso8601String() }}",
  "author": [{
      "{{ '@type' }}": "Person",
      "name": "{{ addslashes($news->author?->name ?? 'Admin SMAN 24') }}"
  }],
  "publisher": {
      "{{ '@type' }}": "Organization",
      "name": "SMA Negeri 24 Bandung",
      "logo": {
        "{{ '@type' }}": "ImageObject",
        "url": "{{ asset('assets/images/logo.png') }}"
      }
  },
  "description": "{{ addslashes(Str::limit(strip_tags($news->excerpt ?? $news->content), 155)) }}"
}
</script>
@endsection

@section('content')
<!-- 1. Page Header Banner (Wide Layout - max-w-7xl) -->
<div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-900 text-white py-10 sm:py-14 border-b border-emerald-800/60 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <x-breadcrumb :items="['Berita & Informasi' => route('news.index'), Str::limit($news->title, 40) => '']" />
        
        <div class="flex flex-wrap items-center gap-2.5 text-xs pt-1">
            <span class="px-3 py-1 rounded-full font-extrabold bg-amber-400 text-emerald-950 text-[10px] sm:text-xs uppercase shadow-sm">
                {{ $news->category?->name ?? 'Umum' }}
            </span>
            <span class="text-slate-300 font-mono text-xs">{{ $news->published_at?->format('d M Y, H:i') ?? $news->created_at->format('d M Y, H:i') }} WIB</span>
            <span class="text-slate-400 font-mono text-xs">&bull; 👁️ {{ number_format($news->views_count) }} views</span>
            <span class="text-amber-300 font-mono text-xs">&bull; 💬 {{ number_format($news->comments->count()) }} komentar</span>
        </div>

        <h1 class="text-2xl sm:text-4xl md:text-5xl font-black leading-tight text-white tracking-tight">
            {{ $news->title }}
        </h1>

        <div class="text-xs sm:text-sm text-slate-300 flex flex-wrap items-center gap-2 pt-1">
            <span>Dipublikasikan oleh:</span>
            <span class="font-bold text-amber-300 bg-slate-900/80 px-3 py-1 rounded-xl border border-emerald-700/60 shadow-sm">
                ✍️ {{ $news->author?->name ?? 'Admin SMAN 24' }}
            </span>
        </div>
    </div>
</div>

<!-- 2. Main Content Grid (Wide Layout - max-w-7xl) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
        
        <!-- Left Main Article Column (8 Kolom) -->
        <main class="lg:col-span-8 space-y-8">
            
            <article class="bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-10 space-y-8">
                <!-- Featured Thumbnail -->
                @if($news->thumbnail)
                    <div class="w-full max-h-[520px] rounded-2xl overflow-hidden shadow-md border border-slate-200 bg-slate-100 relative group">
                        <img src="{{ asset($news->thumbnail) }}" alt="{{ $news->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                @endif

                <!-- Excerpt Quote -->
                @if($news->excerpt)
                    <div class="p-5 sm:p-6 bg-emerald-50/90 rounded-2xl border-l-4 border-emerald-700 text-emerald-950 text-base sm:text-lg font-medium italic leading-relaxed shadow-xs">
                        "{{ $news->excerpt }}"
                    </div>
                @endif

                <!-- Rich Prose Article Content -->
                <div class="prose prose-slate prose-emerald lg:prose-lg max-w-none text-slate-800 leading-relaxed">
                    {!! clean($news->content) !!}
                </div>

                <!-- Footer Article Details & Share -->
                <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('news.index') }}" class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs sm:text-sm transition-colors">
                        &larr; Kembali ke Daftar Berita
                    </a>
                    <div class="text-xs text-slate-400 font-mono text-center sm:text-right">
                        Humas & Publikasi Resmi SMA Negeri 24 Bandung
                    </div>
                </div>
            </article>

            <!-- Reader Comments Section -->
            <section id="comments" class="bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-10 space-y-8">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center text-xl font-bold border border-emerald-200">
                            💬
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-2xl font-bold text-slate-900">Komentar Pembaca</h3>
                            <p class="text-xs text-slate-500">Berbagi tanggapan positif dan diskusi terkait artikel ini.</p>
                        </div>
                    </div>
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-900 border border-emerald-200">
                        {{ $news->comments->count() }} Komentar
                    </span>
                </div>

                @if(session('comment_success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-xs sm:text-sm text-emerald-800 font-semibold shadow-xs">
                        <span class="text-xl">✅</span>
                        <span>{{ session('comment_success') }}</span>
                    </div>
                @endif

                <!-- Existing Comments List -->
                <div class="space-y-4">
                    @forelse($news->comments as $comment)
                        <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-emerald-800 text-amber-300 font-black text-xs flex items-center justify-center shadow-xs">
                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 text-xs sm:text-sm block">{{ $comment->name }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-500 bg-white px-2.5 py-0.5 rounded-md border border-slate-200">
                                    Pembaca
                                </span>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed pl-12">
                                {{ $comment->comment }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-slate-400 space-y-1">
                            <div class="text-3xl">✍️</div>
                            <p class="text-sm font-semibold text-slate-700">Belum ada komentar untuk artikel ini.</p>
                            <p class="text-xs text-slate-400">Jadilah yang pertama memberikan tanggapan atau opini Anda!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                <form action="{{ route('news.comments.store', $news->slug) }}" method="POST" class="pt-6 border-t border-slate-100 space-y-5">
                    @csrf
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                        <span>✍️</span> Tulis Tanggapan Anda
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Nama Anda <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Ahmad Fauzi" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20 text-xs sm:text-sm outline-hidden transition-all bg-slate-50/50">
                            @error('name')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Alamat Email (Opsional)</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. ahmad@example.com (tidak dipublikasikan)" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20 text-xs sm:text-sm outline-hidden transition-all bg-slate-50/50">
                            @error('email')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="comment" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Isi Komentar <span class="text-rose-500">*</span></label>
                        <textarea id="comment" name="comment" rows="4" required placeholder="Tuliskan komentar atau tanggapan Anda dengan bahasa yang santun dan membangun..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20 text-xs sm:text-sm outline-hidden transition-all bg-slate-50/50">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all">
                            <span>🚀</span>
                            <span>Kirim Komentar</span>
                        </button>
                    </div>
                </form>
            </section>

        </main>

        <!-- Right Sidebar Column (4 Kolom) -->
        <aside class="lg:col-span-4 space-y-8 sticky top-24">
            
            <!-- Berita Terbaru Lainnya Widget -->
            @if(isset($latestNews) && $latestNews->isNotEmpty())
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-900 p-5 text-white flex items-center justify-between border-b border-emerald-800/50">
                        <h3 class="text-sm font-extrabold text-white flex items-center gap-2">
                            <span>📰 Berita Terbaru</span>
                        </h3>
                        <a href="{{ route('news.index') }}" class="text-[11px] text-amber-300 hover:underline font-bold">Semua &rarr;</a>
                    </div>
                    
                    <div class="p-5 divide-y divide-slate-100">
                        @foreach($latestNews as $lat)
                            <a href="{{ route('news.show', $lat->slug) }}" class="py-3.5 first:pt-0 last:pb-0 flex items-start gap-3.5 group">
                                @if($lat->thumbnail)
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                        <img src="{{ asset($lat->thumbnail) }}" alt="{{ $lat->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1 space-y-1">
                                    <span class="text-[9px] font-extrabold text-emerald-800 uppercase">
                                        {{ $lat->category?->name ?? 'Umum' }}
                                    </span>
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-emerald-800 transition-colors line-clamp-2 leading-snug">
                                        {{ $lat->title }}
                                    </h4>
                                    <span class="text-[10px] text-slate-400 font-mono block">
                                        {{ $lat->published_at?->format('d M Y') ?? $lat->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Kategori Berita Widget -->
            @if(isset($categories) && $categories->isNotEmpty())
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-6 space-y-4">
                    <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <span>🏷️ Kategori Artikel</span>
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $cat)
                            <a href="{{ route('news.index', ['category' => $cat->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-50 hover:bg-emerald-50 hover:text-emerald-900 border border-slate-200 transition-colors">
                                <span>{{ $cat->name }}</span>
                                <span class="px-1.5 py-0.2 rounded-full bg-slate-200 text-[10px] text-slate-700">{{ $cat->news_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Humas SMAN 24 Card -->
            <div class="bg-gradient-to-br from-emerald-900 via-emerald-950 to-slate-950 p-6 rounded-3xl text-white shadow-xl border border-emerald-700/40 space-y-3">
                <span class="text-amber-300 font-bold text-xs uppercase tracking-wider block">Portal Informasi Sekolah</span>
                <h4 class="text-base font-black text-white">SMA Negeri 24 Bandung</h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Dapatkan informasi kegiatan, prestasi, dan pengumuman resmi sekolah terpercaya.
                </p>
                <div class="pt-2">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-emerald-950 font-extrabold text-xs transition-colors shadow-md">
                        <span>📞 Kontak Sekolah</span>
                    </a>
                </div>
            </div>

        </aside>

    </div>

    <!-- 3. Bottom Showcase: Artikel Berita Terkait (4 Kolom Penuh Lebar) -->
    @if($relatedNews->isNotEmpty())
        <section class="space-y-6 pt-6 border-t border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                        <span>📚 Artikel Berita Terkait</span>
                    </h3>
                    <p class="text-xs text-slate-500">Rekomendasi informasi penting lainnya yang relevan.</p>
                </div>
                <a href="{{ route('news.index') }}" class="text-xs sm:text-sm font-bold text-emerald-800 hover:underline">Lihat Semua Berita &rarr;</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedNews as $rel)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 p-4 space-y-3 flex flex-col justify-between overflow-hidden group">
                        <div class="space-y-2.5">
                            @if($rel->thumbnail)
                                <div class="w-full aspect-video rounded-xl overflow-hidden bg-slate-100 mb-2">
                                    <img src="{{ asset($rel->thumbnail) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @endif
                            <span class="text-[10px] font-extrabold text-emerald-900 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-block">
                                {{ $rel->category?->name ?? 'Umum' }}
                            </span>
                            <h4 class="font-bold text-slate-900 text-sm line-clamp-2 leading-snug group-hover:text-emerald-800 transition-colors">
                                <a href="{{ route('news.show', $rel->slug) }}">
                                    {{ $rel->title }}
                                </a>
                            </h4>
                        </div>
                        <div class="text-[11px] text-slate-400 font-mono pt-2 border-t border-slate-100 flex items-center justify-between">
                            <span>{{ $rel->published_at?->format('d M Y') ?? $rel->created_at->format('d M Y') }}</span>
                            <span class="font-bold text-emerald-800 group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
