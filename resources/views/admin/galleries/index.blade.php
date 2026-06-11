<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Galeri Kegiatan') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Galeri' => '#'
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
                <x-slot name="title">Daftar Galeri Kegiatan</x-slot>
                <x-slot name="subtitle">Kelola dokumentasi foto kegiatan, program, dan spanduk utama sekolah.</x-slot>

                <div class="flex justify-end mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <!-- Add Button -->
                    <a href="{{ route('admin.galleries.create', $unit) }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                        + Buat Album Galeri
                    </a>
                </div>

                <x-data-table :headers="['Cover / Thumbnail', 'Nama Kegiatan', 'Opsi Tampilan', 'Jumlah Foto', 'Aksi']">
                    @forelse ($galleries as $gal)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4">
                                @php
                                    $firstPhoto = $gal->photos->first();
                                @endphp
                                @if ($firstPhoto)
                                    <img src="@asset($firstPhoto->file_foto)" alt="Thumbnail Galeri" class="h-12 w-20 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="h-12 w-20 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-[10px] text-gray-400">
                                        Kosong
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $gal->nama_kegiatan }}
                                @if ($gal->major)
                                    <span class="block text-xs text-brand-red font-medium">Program: {{ $gal->major->nama_jurusan }} ({{ $gal->major->shortname }})</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    {{ str_replace('_', ' ', strtoupper($gal->opsi_tampilan)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold">
                                {{ $gal->photos_count }} Foto
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.galleries.edit', [$unit, $gal]) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Edit / Susun
                                </a>
                                <form action="{{ route('admin.galleries.destroy', [$unit, $gal]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album galeri ini beserta seluruh foto di dalamnya?');">
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
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-full text-gray-400 dark:text-gray-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Galeri</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Buat album foto dokumentasi kegiatan sekolah atau banner/spanduk utama.</p>
                                    </div>
                                    <a href="{{ route('admin.galleries.create', $unit) }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Buat Album Galeri
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($galleries as $gal)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center gap-3">
                                    @php
                                        $firstPhoto = $gal->photos->first();
                                    @endphp
                                    @if ($firstPhoto)
                                        <img src="@asset($firstPhoto->file_foto)" alt="Thumbnail" class="h-16 w-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                    @else
                                        <div class="h-16 w-24 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                            Kosong
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $gal->nama_kegiatan }}</h3>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-gray-200 dark:bg-gray-700 text-gray-750 dark:text-gray-300 mt-1">
                                            {{ str_replace('_', ' ', $gal->opsi_tampilan) }}
                                        </span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $gal->photos_count }} Foto</p>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.galleries.edit', [$unit, $gal]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                                        Edit / Susun
                                    </a>
                                    <form action="{{ route('admin.galleries.destroy', [$unit, $gal]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album galeri ini beserta seluruh foto di dalamnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-rose-50 dark:bg-rose-950/20 text-rose-600 hover:bg-rose-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-800 flex flex-col items-center justify-center space-y-3">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Galeri</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Tambah album galeri baru untuk unit ini.</p>
                                </div>
                                <a href="{{ route('admin.galleries.create', $unit) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Buat Album
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($galleries->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $galleries->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
