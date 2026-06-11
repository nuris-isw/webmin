<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Ekstrakurikuler') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
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
                                    <img src="{{ Storage::url($ekskul->logo_ekskul) }}" alt="Logo Ekskul" class="h-12 w-12 object-contain rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 p-1">
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
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.extracurriculars.edit', [$unit, $ekskul]) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.extracurriculars.destroy', [$unit, $ekskul]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ekstrakurikuler ini?');">
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
                                Belum ada ekstrakurikuler yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($extracurriculars as $ekskul)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center gap-3">
                                    @if ($ekskul->logo_ekskul)
                                        <img src="{{ Storage::url($ekskul->logo_ekskul) }}" alt="Logo Ekskul" class="h-16 w-16 object-contain rounded-lg border border-gray-200 dark:border-gray-700 bg-white p-1">
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
                                <div class="flex justify-end gap-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.extracurriculars.edit', [$unit, $ekskul]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.extracurriculars.destroy', [$unit, $ekskul]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ekstrakurikuler ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-rose-50 dark:bg-rose-950/20 text-rose-600 hover:bg-rose-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                Belum ada ekstrakurikuler yang ditambahkan.
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>
            </x-card>
        </div>
    </div>
</x-app-layout>
