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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 21m-5.34-2.236a9.19 9.19 0 01-1.397-1.107 4.125 4.125 0 007.533-2.493M10.089 21a11.332 11.332 0 01-5.34-2.236m5.34 2.236v-.003a9.202 9.202 0 003.61-3.003m3.75 3.003A11.33 11.33 0 0015 19.128M15 3.987a3 3 0 11-3 3M12 3.987a3 3 0 113 3m-3-3a3.75 3.75 0 100 7.5c.447 0 .875-.079 1.272-.224l-.17-.34M3.75 16.5a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zm16.5 0a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18c0 .621-.504 1.125-1.125 1.125H5.625M19.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-2.25a1.125 1.125 0 00-1.125 1.125V18.75m9 0t-9 0M9 3.75h6M9 3.75a3 3 0 00-3 3v2.25a3 3 0 003 3h6a3 3 0 003-3V6.75a3 3 0 00-3-3M9 3.75h6" />
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
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('superadmin.units.show', $unit) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Detail
                                </a>
                                <a href="{{ route('superadmin.units.edit', $unit) }}" class="text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                                    Edit
                                </a>
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
                                <div class="flex justify-end gap-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('superadmin.units.show', $unit) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('superadmin.units.edit', $unit) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 transition">
                                        Edit
                                    </a>
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
