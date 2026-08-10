@props([
    'type' => 'success', // success, warning, danger, info
])

@php
    $styles = [
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-900 border-amber-200',
        'danger' => 'bg-rose-50 text-rose-800 border-rose-200',
        'info' => 'bg-sky-50 text-sky-800 border-sky-200',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'p-4 rounded-xl border text-xs font-medium flex items-center gap-3 ' . ($styles[$type] ?? $styles['success'])]) }}>
    <div class="flex-1">
        {{ $slot }}
    </div>
</div>
