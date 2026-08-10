@extends('layouts.public.app')

@section('title', $gallery->title . ' - SMAN 24 Bandung')

@section('content')
<div class="bg-emerald-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-2">
        <h1 class="text-3xl font-extrabold">{{ $gallery->title }}</h1>
        <p class="text-slate-300 text-xs sm:text-sm">{{ $gallery->description }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($gallery->items as $item)
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                <div class="w-full h-48 bg-slate-100 rounded-xl flex items-center justify-center text-3xl">
                    🖼️
                </div>
                @if($item->caption)
                    <p class="text-xs text-slate-600 font-medium">{{ $item->caption }}</p>
                @endif
            </div>
        @empty
            <div class="col-span-3 py-12 text-center text-xs text-slate-400">
                Belum ada foto dalam album ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
