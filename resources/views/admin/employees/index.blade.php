<x-app-layout>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Data Guru & Pegawai' => '#'
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
                <x-slot name="title">Data Guru & Pegawai</x-slot>
                <x-slot name="subtitle">Kelola data guru dan tenaga kependidikan. Urutkan berdasarkan <strong>Order Number</strong> — angka lebih kecil ditampilkan lebih awal (jabatan lebih tinggi).</x-slot>

                <div class="flex justify-end mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <!-- Add Button -->
                    <a href="{{ route('admin.employees.create', $unit) }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                        + Tambah Pegawai
                    </a>
                </div>

                <x-data-table :headers="['Foto', 'Nama', 'Jabatan', 'Order', 'Aksi']">
                    @forelse ($employees as $employee)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4">
                                @if ($employee->photo)
                                    <img src="@asset($employee->photo)" alt="Foto {{ $employee->nama }}" class="h-12 w-10 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="h-12 w-10 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-[9px] text-gray-400 text-center leading-none p-1">
                                        No Photo
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $employee->nama }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $employee->jabatan }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-center text-brand-red">
                                {{ $employee->order_number }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                                <x-icon-button :href="route('admin.employees.edit', [$unit, $employee])" icon="edit" color="neutral" tooltip="Edit Pegawai" />
                                <form action="{{ route('admin.employees.destroy', [$unit, $employee]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai {{ $employee->nama }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-icon-button type="submit" icon="trash" color="danger" tooltip="Hapus Pegawai" />
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
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Data Pegawai</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Tambahkan data guru dan tenaga kependidikan untuk ditampilkan di website sekolah.</p>
                                    </div>
                                    <a href="{{ route('admin.employees.create', $unit) }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Tambah Pegawai
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($employees as $employee)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center gap-3">
                                    @if ($employee->photo)
                                        <img src="@asset($employee->photo)" alt="Foto {{ $employee->nama }}" class="h-16 w-14 object-cover rounded-lg border border-gray-200 dark:border-gray-700 shrink-0">
                                    @else
                                        <div class="h-16 w-14 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400 text-center leading-none p-1 shrink-0">
                                            No Photo
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $employee->nama }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $employee->jabatan }}</p>
                                        <p class="text-xs text-brand-red font-bold mt-1">Order: {{ $employee->order_number }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <x-icon-button :href="route('admin.employees.edit', [$unit, $employee])" icon="edit" color="neutral" tooltip="Edit Pegawai" />
                                    <form action="{{ route('admin.employees.destroy', [$unit, $employee]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pegawai {{ $employee->nama }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-icon-button type="submit" icon="trash" color="danger" tooltip="Hapus Pegawai" />
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-800 flex flex-col items-center justify-center space-y-3">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Data Pegawai</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Tambah data guru/pegawai baru.</p>
                                </div>
                                <a href="{{ route('admin.employees.create', $unit) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Tambah Pegawai
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($employees->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $employees->links() }}
                    </div>
                @endif
            </x-card>
        </div>
</x-app-layout>
