@props(['title', 'value', 'subtext' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 relative']) }}>
    <!-- Brand red accent top line -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-brand-red"></div>
    
    <div class="p-6 flex items-center justify-between">
        <div class="space-y-1">
            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                {{ $title }}
            </p>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                {{ $value }}
            </p>
            @if ($subtext)
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    {{ $subtext }}
                </p>
            @endif
        </div>
        
        @if ($icon)
            <div class="p-3 bg-brand-red/5 dark:bg-brand-red/10 text-brand-red rounded-lg shrink-0">
                {{ $icon }}
            </div>
        @endif
    </div>
</div>
