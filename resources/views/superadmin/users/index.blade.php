<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Akun Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                    Daftar Pengguna Platform
                </x-slot>
                <x-slot name="subtitle">
                    Kelola seluruh akun Administrator Yayasan dan Administrator Unit Sekolah.
                </x-slot>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('superadmin.users.index') }}" class="flex flex-wrap items-end gap-3 flex-1">
                        <div class="w-full sm:w-auto">
                            <label for="role" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Peran</label>
                            <select name="role" id="role" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm focus:border-brand-red focus:ring-brand-red shadow-sm">
                                <option value="">Semua Peran</option>
                                <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin Unit</option>
                            </select>
                        </div>

                        <div class="w-full sm:w-auto">
                            <label for="unit_id" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Unit Sekolah</label>
                            <select name="unit_id" id="unit_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm focus:border-brand-red focus:ring-brand-red shadow-sm">
                                <option value="">Semua Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama_sekolah }} ({{ strtoupper($unit->jenjang) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto pt-2 sm:pt-0">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Filter
                            </button>
                            @if (request()->filled('role') || request()->filled('unit_id'))
                                <a href="{{ route('superadmin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Add User Button -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                            + Tambah Akun
                        </a>
                    </div>
                </div>

                <x-data-table :headers="['Nama', 'Email', 'Peran', 'Unit Sekolah', 'Aksi']">
                    @forelse ($users as $user)
                        <tr class="odd:bg-gray-50/35 even:bg-white dark:odd:bg-gray-800 dark:even:bg-[#1E1E1E]">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->isSuperadmin())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-red/10 text-brand-red">
                                        Superadmin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        Admin Unit
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium">
                                @if ($user->unit)
                                    <span class="text-gray-900 dark:text-white">
                                        {{ $user->unit->nama_sekolah }}
                                    </span>
                                    <span class="text-xs text-gray-500 block">
                                        Jenjang: {{ strtoupper($user->unit->jenjang) }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-600">
                                        — (Yayasan)
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('superadmin.users.edit', $user) }}" class="text-xs font-semibold text-brand-red hover:text-brand-red-light transition">
                                    Edit
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-500 transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-full text-gray-400 dark:text-gray-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-950 dark:text-white">Belum Ada Pengguna</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Pengguna admin digunakan untuk mengelola setiap unit sekolah. Silakan daftarkan pengguna baru.</p>
                                    </div>
                                    <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-155">
                                        + Tambah Admin Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($users as $user)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 space-y-3">
                                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-2">
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        @if ($user->isSuperadmin())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-brand-red/10 text-brand-red">
                                                Superadmin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                                Admin
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">Unit Terkait:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        {{ $user->unit?->nama_sekolah ?? '— (Yayasan)' }}
                                    </span>
                                </div>
                                <div class="flex justify-end gap-4 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('superadmin.users.edit', $user) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition">
                                        Edit
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-rose-50 dark:bg-rose-950/20 text-rose-600 hover:bg-rose-100 dark:hover:bg-rose-900/30 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-800 flex flex-col items-center justify-center space-y-3">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Belum Ada Pengguna</h3>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Silakan daftarkan pengguna admin baru.</p>
                                </div>
                                <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center px-3 py-1.5 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-[10px] uppercase tracking-widest rounded-md transition duration-150">
                                    + Tambah Admin
                                </a>
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

                @if ($users->hasPages())
                    <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-6">
                        {{ $users->links() }}
                    </div>
                @endif

            </x-card>

        </div>
    </div>
</x-app-layout>
