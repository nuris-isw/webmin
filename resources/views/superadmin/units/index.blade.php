<x-app-layout>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Page Heading -->
            <x-page-heading heading="Manajemen Unit Sekolah" subheading="Daftarkan dan kelola unit sekolah (TK, SMP, SMK) yang bergabung dalam platform WebMin." />

            <!-- Flash Notifications -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            <!-- Table Card Container -->
            <x-card>
                <x-slot name="title">
                    Daftar Sekolah yang Terdaftar
                </x-slot>
                <x-slot name="subtitle">
                    Daftarkan unit sekolah baru (TK, SMP, SMK) atau kelola status operasionalnya.
                </x-slot>

                <div class="flex justify-end mb-6">
                    <a href="{{ route('superadmin.units.create') }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                        + Tambah Unit Sekolah
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
                                <form action="{{ route('superadmin.units.destroy', $unit) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Menghapus unit ini akan menghapus seluruh data profil, prestasi, ekskul, berita, dan jurusan terkait. Apakah Anda yakin ingin melanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-icon-button type="submit" icon="trash" color="danger" tooltip="Hapus Unit" />
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-full text-gray-400 dark:text-gray-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Unit Sekolah</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Silakan daftarkan unit sekolah baru (TK, SMP, atau SMK) untuk mulai mengelola profil dan konten akademik.</p>
                                    </div>
                                    <a href="{{ route('superadmin.units.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Tambah Unit Sekolah
                                    </a>
                                </div>
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
                                    <form action="{{ route('superadmin.units.destroy', $unit) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Menghapus unit ini akan menghapus seluruh data profil, prestasi, ekskul, berita, dan jurusan terkait. Apakah Anda yakin ingin melanjutkan?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-icon-button type="submit" icon="trash" color="danger" tooltip="Hapus Unit" />
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-800 flex flex-col items-center justify-center space-y-3">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Unit Sekolah</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Mulai tambahkan unit sekolah pertama Anda.</p>
                                </div>
                                <a href="{{ route('superadmin.units.create') }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Tambah Unit
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($units->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $units->links() }}
                    </div>
                @endif

            </x-card>

        </div>
</x-app-layout>
