@props([
    'variant' => 'primary', // primary, secondary, danger, outline
    'type' => 'button',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition-all duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variants = [
        'primary' => 'bg-emerald-800 hover:bg-emerald-900 text-white focus:ring-emerald-700',
        'secondary' => 'bg-amber-500 hover:bg-amber-400 text-emerald-950 focus:ring-amber-500',
        'danger' => 'bg-rose-700 hover:bg-rose-800 text-white focus:ring-rose-600',
        'outline' => 'border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 focus:ring-slate-400',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
