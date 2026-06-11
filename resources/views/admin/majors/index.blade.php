<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Jurusan / Program Keahlian') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Jurusan' => '#'
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
                <x-slot name="title">Daftar Jurusan / Program Keahlian</x-slot>
                <x-slot name="subtitle">Kelola kurikulum jurusan, nomenklatur istilah, dan kaprog kompetensi keahlian SMK.</x-slot>

                <div class="flex justify-end mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <!-- Add Button -->
                    <a href="{{ route('admin.majors.create', $unit) }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                        + Tambah Jurusan
                    </a>
                </div>

                <x-data-table :headers="['Foto Kaprog', 'Nama Jurusan', 'Nomenklatur', 'Singkatan', 'Kepala Program (Kaprog)', 'Aksi']">
                    @forelse ($majors as $major)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4">
                                @if ($major->foto_kaprog)
                                    <img src="@asset($major->foto_kaprog)" alt="Foto Kaprog" class="h-12 w-10 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                @else
                                    <div class="h-12 w-10 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-[9px] text-gray-400 text-center leading-none p-1">
                                        No Photo
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $major->nama_jurusan }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                {{ $major->nomenklatur_istilah }}
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-brand-red">
                                {{ $major->shortname }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $major->nama_kaprog ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.majors.edit', [$unit, $major]) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.majors.destroy', [$unit, $major]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data jurusan ini beserta data galeri program terkait?');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-full text-gray-400 dark:text-gray-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Jurusan</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Kelola kurikulum, nomenklatur program keahlian, dan kepala program (Kaprog) untuk SMK.</p>
                                    </div>
                                    <a href="{{ route('admin.majors.create', $unit) }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Tambah Jurusan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($majors as $major)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center gap-3">
                                    @if ($major->foto_kaprog)
                                        <img src="@asset($major->foto_kaprog)" alt="Foto Kaprog" class="h-16 w-14 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                    @else
                                        <div class="h-16 w-14 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400 text-center leading-none p-1">
                                            No Photo
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $major->nama_jurusan }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Singkatan: {{ $major->shortname }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Nomenklatur: {{ $major->nomenklatur_istilah }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mt-1">Kaprog: {{ $major->nama_kaprog ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-3 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('admin.majors.edit', [$unit, $major]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.majors.destroy', [$unit, $major]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data jurusan ini beserta data galeri program terkait?');">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Jurusan</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Tambah data program keahlian / jurusan baru.</p>
                                </div>
                                <a href="{{ route('admin.majors.create', $unit) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Tambah Jurusan
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($majors->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $majors->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
