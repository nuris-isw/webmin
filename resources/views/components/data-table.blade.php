@props(['headers'])

<div class="w-full">
    <!-- Desktop View (Table) -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-900/50">
                    @foreach ($headers as $header)
                        <th class="px-6 py-4">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Mobile Stack Card View -->
    <div class="block md:hidden space-y-4">
        @if (isset($mobile))
            {{ $mobile }}
        @else
            <p class="text-xs text-gray-400 text-center py-4">Tampilan mobile belum terkonfigurasi.</p>
        @endif
    </div>
</div>
