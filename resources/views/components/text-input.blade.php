@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-red dark:focus:border-brand-red focus:ring-brand-red dark:focus:ring-brand-red rounded-md shadow-sm']) }}>
