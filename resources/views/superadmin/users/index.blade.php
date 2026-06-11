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

                <div class="flex justify-end mb-6">
                    <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center px-4 py-2.5 bg-brand-red hover:bg-brand-red-light active:bg-brand-red-deep text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                        + Tambah Akun
                    </a>
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
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Belum ada pengguna terdaftar.
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
                            <div class="p-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                Belum ada pengguna terdaftar.
                            </div>
                        @endforelse
                    </x-slot>
                </x-data-table>

            </x-card>

        </div>
    </div>
</x-app-layout>
