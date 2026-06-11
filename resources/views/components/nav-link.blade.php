@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2.5 border-l-4 border-brand-red bg-brand-red/5 dark:bg-brand-red/10 text-brand-red dark:text-white font-bold text-sm leading-5 transition duration-150 ease-in-out'
            : 'flex items-center px-4 py-2.5 border-l-4 border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800/40 hover:border-gray-300 dark:hover:border-gray-700 font-medium text-sm leading-5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
