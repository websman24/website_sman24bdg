@props([
    'type' => 'skeleton', // skeleton, spinner
])

@if($type === 'spinner')
    <div {{ $attributes->merge(['class' => 'inline-block w-5 h-5 border-2 border-emerald-700 border-t-transparent rounded-full animate-spin']) }}></div>
@else
    <div {{ $attributes->merge(['class' => 'skeleton-loader h-4 w-full rounded-lg']) }}></div>
@endif
