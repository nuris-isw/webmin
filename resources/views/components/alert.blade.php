@props(['type' => 'info', 'message' => null])

@php
$classes = match($type) {
    'success' => 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-200 dark:border-emerald-800/30 text-emerald-800 dark:text-emerald-200',
    'error' => 'bg-rose-50 dark:bg-rose-950/20 border-rose-200 dark:border-rose-800/30 text-rose-800 dark:text-rose-200',
    'warning' => 'bg-amber-50 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800/30 text-amber-800 dark:text-amber-200',
    default => 'bg-blue-50 dark:bg-blue-950/20 border-blue-200 dark:border-blue-800/30 text-blue-800 dark:text-blue-200',
};
@endphp

<div {{ $attributes->merge(['class' => 'p-4 border rounded-lg text-sm font-medium ' . $classes]) }}>
    {{ $message ?? $slot }}
</div>
