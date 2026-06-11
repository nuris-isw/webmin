@props(['name', 'label' => null, 'type' => 'text', 'value' => null, 'required' => false])

<div {{ $attributes->merge(['class' => 'space-y-1']) }}>
    @if ($label)
        <x-input-label :for="$name" :value="$label" class="font-semibold text-gray-700 dark:text-gray-300" />
    @endif
    <x-text-input :id="$name" :name="$name" :type="$type" :value="$value" :required="$required" class="block w-full" />
    <x-input-error :messages="$errors->get($name)" class="mt-1" />
</div>
