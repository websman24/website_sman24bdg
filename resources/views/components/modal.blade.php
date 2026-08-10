@props([
    'id' => 'modal',
    'title' => 'Konfirmasi',
])

<div x-data="{ open: false }"
     x-show="open"
     x-on:open-modal.window="if ($event.detail.id === '{{ $id }}') open = true"
     x-on:close-modal.window="if ($event.detail.id === '{{ $id }}') open = false"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 space-y-4" @click.away="open = false">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-base font-bold text-slate-900">{{ $title }}</h3>
            <button @click="open = false" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="text-xs text-slate-600">
            {{ $slot }}
        </div>
    </div>
</div>
