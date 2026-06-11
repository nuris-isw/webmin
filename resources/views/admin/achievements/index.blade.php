<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Prestasi') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Prestasi' => '#'
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
                <x-slot name="title">Daftar Prestasi Unit</x-slot>
                <x-slot name="subtitle">Kelola data prestasi akademik dan non-akademik di tingkat sekolah.</x-slot>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.achievements.index', $unit) }}" class="flex flex-wrap items-end gap-3 flex-1">
                        <div class="w-full sm:w-auto">
                            <label for="peraih_prestasi" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Peraih Prestasi</label>
                            <select name="peraih_prestasi" id="peraih_prestasi" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm focus:border-brand-red focus:ring-brand-red shadow-sm">
                                <option value="">Semua Peraih</option>
                                <option value="siswa" {{ request('peraih_prestasi') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="guru" {{ request('peraih_prestasi') === 'guru' ? 'selected' : '' }}>Guru</option>
                                <option value="tendik" {{ request('peraih_prestasi') === 'tendik' ? 'selected' : '' }}>Tenaga Kependidikan</option>
                                <option value="sekolah" {{ request('peraih_prestasi') === 'sekolah' ? 'selected' : '' }}>Institusi Sekolah</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto pt-2 sm:pt-0">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 transition duration-150">
                                Filter
                            </button>
                            @if (request()->filled('peraih_prestasi'))
                                <a href="{{ route('admin.achievements.index', $unit) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Add Button -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.achievements.create', $unit) }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                            + Tambah Prestasi
                        </a>
                    </div>
                </div>

                <x-data-table :headers="['Foto', 'Judul Prestasi', 'Tahun', 'Peraih', 'Aksi']">
                    @forelse ($achievements as $ach)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4">
                                @if ($ach->foto_penghargaan)
                                    <img src="@asset($ach->foto_penghargaan)" alt="Foto Penghargaan" class="h-12 w-12 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="h-12 w-12 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-[10px] text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $ach->judul_prestasi }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold">
                                {{ $ach->tahun_prestasi }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-brand-red/10 text-brand-red">
                                    {{ $ach->peraih_prestasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.achievements.edit', [$unit, $ach]) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.achievements.destroy', [$unit, $ach]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data prestasi ini?');">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Prestasi</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Kelola dan publikasikan penghargaan serta prestasi akademik maupun non-akademik siswa dan guru.</p>
                                    </div>
                                    <a href="{{ route('admin.achievements.create', $unit) }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Tambah Prestasi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($achievements as $ach)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center gap-3">
                                    @if ($ach->foto_penghargaan)
                                        <img src="@asset($ach->foto_penghargaan)" alt="Foto Penghargaan" class="h-16 w-16 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                    @else
                                        <div class="h-16 w-16 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                            No Photo
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $ach->judul_prestasi }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tahun: {{ $ach->tahun_prestasi }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-brand-red/10 text-brand-red mt-1">
                                            {{ $ach->peraih_prestasi }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.achievements.edit', [$unit, $ach]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.achievements.destroy', [$unit, $ach]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data prestasi ini?');">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Prestasi</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Tambah data prestasi untuk unit ini.</p>
                                </div>
                                <a href="{{ route('admin.achievements.create', $unit) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Tambah Prestasi
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($achievements->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $achievements->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
