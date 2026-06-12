@props([
    'type' => 'link',
    'href' => '#',
    'tooltip' => '',
    'icon' => 'eye',
    'color' => 'neutral'
])

@php
$colorClasses = match ($color) {
    'danger' => 'bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/30',
    'info' => 'bg-brand-red/10 text-brand-red hover:bg-brand-red/20 dark:bg-brand-red/20 dark:text-brand-red-light',
    default => 'bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/80 hover:text-gray-700 dark:hover:text-gray-200'
};
@endphp

<div class="relative group inline-block">
    @if ($type === 'link')
        <a href="{{ $href }}" title="{{ $tooltip }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center w-8 h-8 rounded-lg transition duration-150 ' . $colorClasses]) }}>
            @switch($icon)
                @case('eye')
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    @break
                @case('edit')
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    @break
                @case('trash')
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    @break
            @endswitch
        </a>
    @else
        <button type="submit" title="{{ $tooltip }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center w-8 h-8 rounded-lg transition duration-150 ' . $colorClasses]) }}>
            @switch($icon)
                @case('eye')
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    @break
                @case('edit')
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    @break
                @case('trash')
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    @break
            @endswitch
        </button>
    @endif
    
    @if ($tooltip)
        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block px-2 py-1 bg-gray-950/95 dark:bg-gray-900/95 text-white text-[10px] font-medium rounded shadow-md border border-gray-800 dark:border-gray-700 whitespace-nowrap z-50 pointer-events-none transition-all duration-150">
            {{ $tooltip }}
        </div>
    @endif
</div>
