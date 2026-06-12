<x-app-layout>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Ekstrakurikuler' => '#'
            ]" />

            <!-- Flash Alerts -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            <!-- Main Listing Card -->
            <x-card>
                <x-slot name="title">Daftar Ekstrakurikuler</x-slot>
                <x-slot name="subtitle">Kelola data klub, organisasi kesiswaan, dan ekstrakurikuler di tingkat sekolah.</x-slot>

                <div class="flex justify-end mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <!-- Add Button -->
                    <a href="{{ route('admin.extracurriculars.create', $unit) }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                        + Tambah Ekstrakurikuler
                    </a>
                </div>

                <x-data-table :headers="['Logo', 'Nama Ekskul', 'Pembina', 'Jadwal Kegiatan', 'Aksi']">
                    @forelse ($extracurriculars as $ekskul)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4">
                                @if ($ekskul->logo_ekskul)
                                    <img src="@asset($ekskul->logo_ekskul)" alt="Logo Ekskul" class="h-12 w-12 object-contain rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 p-1">
                                @else
                                    <div class="h-12 w-12 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-[10px] text-gray-400">
                                        No Logo
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $ekskul->nama_ekskul }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold">
                                {{ $ekskul->pembina_ekskul ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $ekskul->jadwal_kegiatan ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                                <x-icon-button :href="route('admin.extracurriculars.edit', [$unit, $ekskul])" icon="edit" color="neutral" tooltip="Edit Ekskul" />
                                <form action="{{ route('admin.extracurriculars.destroy', [$unit, $ekskul]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ekstrakurikuler ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-icon-button type="submit" icon="trash" color="danger" tooltip="Hapus Ekskul" />
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-full text-gray-400 dark:text-gray-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Ekstrakurikuler</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Kelola daftar ekstrakurikuler, organisasi kesiswaan, atau klub minat bakat sekolah.</p>
                                    </div>
                                    <a href="{{ route('admin.extracurriculars.create', $unit) }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Tambah Ekstrakurikuler
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($extracurriculars as $ekskul)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center gap-3">
                                    @if ($ekskul->logo_ekskul)
                                        <img src="@asset($ekskul->logo_ekskul)" alt="Logo Ekskul" class="h-16 w-16 object-contain rounded-lg border border-gray-200 dark:border-gray-700 bg-white p-1">
                                    @else
                                        <div class="h-16 w-16 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                            No Logo
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $ekskul->nama_ekskul }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Pembina: {{ $ekskul->pembina_ekskul ?? '—' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Jadwal: {{ $ekskul->jadwal_kegiatan ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <x-icon-button :href="route('admin.extracurriculars.edit', [$unit, $ekskul])" icon="edit" color="neutral" tooltip="Edit Ekskul" />
                                    <form action="{{ route('admin.extracurriculars.destroy', [$unit, $ekskul]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ekstrakurikuler ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-icon-button type="submit" icon="trash" color="danger" tooltip="Hapus Ekskul" />
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-800 flex flex-col items-center justify-center space-y-3">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Ekstrakurikuler</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Tambah data ekstrakurikuler baru untuk unit ini.</p>
                                </div>
                                <a href="{{ route('admin.extracurriculars.create', $unit) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Tambah Ekstrakurikuler
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($extracurriculars->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $extracurriculars->links() }}
                    </div>
                @endif
            </x-card>
        </div>
</x-app-layout>
