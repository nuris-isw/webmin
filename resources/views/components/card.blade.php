@props(['title' => null, 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700']) }}>
    @if ($title || $subtitle)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            @if ($title)
                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
            @endif
            @if ($subtitle)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    @endif
    <div class="p-6 text-gray-900 dark:text-gray-100">
        {{ $slot }}
    </div>
</div>
