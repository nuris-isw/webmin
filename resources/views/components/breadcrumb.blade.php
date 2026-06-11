@props(['items'])

@php
    $dashboardUrl = route('dashboard');
    $filteredItems = [];

    foreach ($items as $label => $url) {
        if (strtolower($label) === 'dashboard') {
            $dashboardUrl = $url;
        } else {
            $filteredItems[$label] = $url;
        }
    }
@endphp

<nav class="flex text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <a href="{{ $dashboardUrl }}" class="inline-flex items-center hover:text-brand-red transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Dashboard
            </a>
        </li>
        
        @foreach ($filteredItems as $label => $url)
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    @if ($loop->last)
                        <span class="text-gray-800 dark:text-gray-200 truncate max-w-[150px] md:max-w-none">
                            {{ $label }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="hover:text-brand-red transition truncate max-w-[150px] md:max-w-none">
                            {{ $label }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
