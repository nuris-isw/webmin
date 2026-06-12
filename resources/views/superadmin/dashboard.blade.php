<x-app-layout>
<x-slot name="title">Dasbor Superadmin</x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
            <!-- Page Heading -->
            <x-page-heading heading="Ringkasan Platform WebMin" subheading="Statistik dan informasi global seluruh unit sekolah dalam platform." />

            <!-- Metrics grid (4 cards) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Total Sekolah -->
                <x-stat-card 
                    title="Total Unit Sekolah" 
                    :value="$totalUnits" 
                    subtext="Unit aktif & non-aktif"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Total User Admin -->
                <x-stat-card 
                    title="Total Admin Unit" 
                    :value="$totalAdmins" 
                    subtext="Akun pengelola aktif"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Total Berita -->
                <x-stat-card 
                    title="Total Berita / Artikel" 
                    :value="$totalNews" 
                    subtext="Kumpulan publikasi sekolah"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Total Prestasi -->
                <x-stat-card 
                    title="Total Prestasi" 
                    :value="$totalAchievements" 
                    subtext="Siswa, guru, & sekolah"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </x-slot>
                </x-stat-card>

            </div>

            <!-- School Units Overview List -->
            <x-card>
                <x-slot name="title">
                    Status Unit Sekolah Terdaftar
                </x-slot>
                <x-slot name="subtitle">
                    Daftar unit sekolah yang dikelola dalam multi-tenant platform WebMin.
                </x-slot>

                <div class="flex justify-end mb-6">
                    <a href="{{ route('superadmin.units.index') }}" class="text-xs font-bold text-brand-red hover:text-brand-red-light uppercase tracking-wider flex items-center gap-1.5 transition">
                        Kelola Seluruh Unit 
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>

                <x-data-table :headers="['Nama Sekolah', 'Jenjang', 'Status', 'Jumlah Pengelola', 'Aksi']">
                    @forelse ($units as $unit)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $unit->nama_sekolah }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $unit->isSmk() ? 'bg-amber-100 dark:bg-amber-950/20 text-amber-800 dark:text-amber-300' : 'bg-blue-100 dark:bg-blue-950/20 text-blue-800 dark:text-blue-300' }}">
                                    {{ strtoupper($unit->jenjang) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($unit->is_active)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-400 dark:text-gray-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Non-aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                {{ $unit->users_count }} Pengelola
                            </td>
                            <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                                <x-icon-button :href="route('superadmin.units.show', $unit)" icon="eye" color="info" tooltip="Detail Unit" />
                                <x-icon-button :href="route('superadmin.units.edit', $unit)" icon="edit" color="neutral" tooltip="Edit Unit" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Belum ada unit sekolah yang terdaftar.
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($units as $unit)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $unit->nama_sekolah }}</h3>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ strtoupper($unit->jenjang) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Status: {{ $unit->is_active ? 'Aktif' : 'Non-aktif' }}</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $unit->users_count }} Pengelola</span>
                                </div>
                                <div class="flex justify-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <x-icon-button :href="route('superadmin.units.show', $unit)" icon="eye" color="info" tooltip="Detail Unit" />
                                    <x-icon-button :href="route('superadmin.units.edit', $unit)" icon="edit" color="neutral" tooltip="Edit Unit" />
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                Belum ada unit sekolah yang terdaftar.
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

            </x-card>
    </div>
</x-app-layout>
