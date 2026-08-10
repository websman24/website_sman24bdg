@props([
    'hover' => true,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200 p-6 shadow-sm ' . ($hover ? 'card-hover-effect' : '')]) }}>
    {{ $slot }}
</div>
