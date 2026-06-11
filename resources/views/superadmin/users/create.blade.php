<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftarkan Akun Admin Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <x-breadcrumb :items="[
                'Manajemen Admin' => route('superadmin.users.index'),
                'Tambah Akun' => '#'
            ]" />

            <x-card>
                <x-slot name="title">
                    Pendaftaran Pengguna Baru
                </x-slot>
                <x-slot name="subtitle">
                    Buat akun administrator yayasan atau kaitkan admin baru dengan unit sekolah yang dikelola.
                </x-slot>

                <form method="POST" action="{{ route('superadmin.users.store') }}" x-data="{ role: '{{ old('role', 'admin') }}' }" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <x-form-input name="name" label="Nama Lengkap" :value="old('name')" required autofocus />

                    <!-- Email Address -->
                    <x-form-input name="email" label="Alamat Email" type="email" :value="old('email')" required />

                    <!-- Role Selection -->
                    <x-form-select name="role" label="Hak Akses / Peran" x-model="role">
                        <option value="admin">Admin Unit (Operasional Sekolah)</option>
                        <option value="superadmin">Superadmin (Badan Penyelenggara/Yayasan)</option>
                    </x-form-select>

                    <!-- Unit Selection (Conditional based on role) -->
                    <div x-show="role === 'admin'" x-transition class="space-y-2">
                        <x-form-select name="unit_id" label="Unit Sekolah">
                            <option value="">-- Pilih Unit Sekolah --</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                                    {{ $unit->nama_sekolah }} ({{ strtoupper($unit->jenjang) }})
                                </option>
                            @endforeach
                        </x-form-select>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Pilih unit sekolah yang akan dikelola oleh admin ini. Isolasi data ketat akan diberlakukan berdasarkan unit yang dipilih.
                        </p>
                    </div>

                    <!-- Password -->
                    <x-form-input name="password" label="Password" type="password" required />

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('superadmin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Akun
                        </x-button>
                    </div>

                </form>
            </x-card>

        </div>
    </div>
</x-app-layout>
