@props([
    'items' => [],
])

<nav class="flex text-xs text-slate-500 font-medium space-x-2 items-center" aria-label="Breadcrumb">
    <a href="{{ route('home') }}" class="hover:text-emerald-800 transition-colors">Beranda</a>
    @foreach($items as $label => $url)
        <span>/</span>
        @if($url && !$loop->last)
            <a href="{{ $url }}" class="hover:text-emerald-800 transition-colors">{{ $label }}</a>
        @else
            <span class="text-slate-800 font-bold">{{ $label }}</span>
        @endif
    @endforeach
</nav>
