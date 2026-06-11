<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Unit Sekolah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Notifications -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
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
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('superadmin.units.show', $unit) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Detail
                                </a>
                                <a href="{{ route('superadmin.units.edit', $unit) }}" class="text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                                    Edit
                                </a>
                                <form action="{{ route('superadmin.units.destroy', $unit) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Menghapus unit ini akan menghapus seluruh data profil, prestasi, ekskul, berita, dan jurusan terkait. Apakah Anda yakin ingin melanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-500 transition">
                                        Hapus
                                    </button>
                                </form>
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
                                    <a href="{{ route('superadmin.units.edit', $unit) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('superadmin.units.destroy', $unit) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Menghapus unit ini akan menghapus seluruh data terkait. Apakah Anda yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-rose-50 dark:bg-rose-950/20 text-rose-600 hover:bg-rose-100 dark:hover:bg-rose-900/30 transition">
                                            Hapus
                                        </button>
                                    </form>
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
    </div>
</x-app-layout>
