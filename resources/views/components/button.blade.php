@props(['variant' => 'primary', 'type' => 'button'])

@php
$classes = match($variant) {
    'secondary' => 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/60 focus:ring-brand-red',
    'danger' => 'bg-rose-600 hover:bg-rose-500 focus:ring-rose-500 text-white',
    default => 'bg-brand-red hover:bg-brand-red-light focus:bg-brand-red-dark active:bg-brand-red-deep text-white focus:ring-brand-red',
};
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-dark transition ease-in-out duration-150 ' . $classes]) }}>
    {{ $slot }}
</button>
