<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light focus:bg-brand-red-dark active:bg-brand-red-deep border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-brand-red focus:ring-offset-2 dark:focus:ring-offset-dark transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
