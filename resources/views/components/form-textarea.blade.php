@props(['name', 'label' => null, 'value' => null, 'required' => false, 'rows' => 4])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1']) }}>
    @if ($label)
        <x-input-label for="{{ $name }}" :value="$label" class="font-semibold text-gray-700 dark:text-gray-300" />
    @endif
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}" 
        @required($required)
        {{ $attributes->except('class')->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-red dark:focus:border-brand-red focus:ring-brand-red dark:focus:ring-brand-red rounded-md shadow-sm block w-full']) }}
    >{{ $value ?? $slot }}</textarea>
    <x-input-error :messages="$errors->get($name)" class="mt-1" />
</div>
