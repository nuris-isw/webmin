@props(['name', 'label' => null, 'required' => false, 'accept' => '*'])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1']) }}>
    @if ($label)
        <x-input-label for="{{ $name }}" :value="$label" class="font-semibold text-gray-700 dark:text-gray-300" />
    @endif
    <input 
        id="{{ $name }}" 
        name="{{ $name }}" 
        type="file" 
        accept="{{ $accept }}"
        @required($required)
        {{ $attributes->except(['class', 'accept'])->merge(['class' => 'block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-red/10 file:text-brand-red hover:file:bg-brand-red/20 dark:file:bg-brand-red/20 dark:file:text-white dark:hover:file:bg-brand-red/30 cursor-pointer file:cursor-pointer']) }}
    />
    <x-input-error :messages="$errors->get($name)" class="mt-1" />
</div>
