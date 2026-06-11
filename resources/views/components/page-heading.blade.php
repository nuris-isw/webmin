@props(['heading', 'subheading' => null])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-l-4 border-brand-red pl-3 leading-tight">
        {{ $heading }}
    </h2>
    @if ($subheading)
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ $subheading }}
        </p>
    @endif
</div>
