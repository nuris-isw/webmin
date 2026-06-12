<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <x-breadcrumb :items="[
                'Dashboard' => route('superadmin.dashboard'),
                'Manajemen Unit' => route('superadmin.units.index'),
                'Tambah Unit' => '#'
            ]" />

            <x-card>
                <x-slot name="title">
                    Registrasi Unit Sekolah Baru
                </x-slot>
                <x-slot name="subtitle">
                    Buat entitas unit sekolah baru dalam platform WebMin. Sistem akan otomatis menginisialisasi profil sekolah dan halaman SPMB default.
                </x-slot>

                <form method="POST" action="{{ route('superadmin.units.store') }}" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <x-alert type="error" message="Terdapat kesalahan pada data yang dimasukkan. Silakan periksa kembali formulir di bawah." />
                    @endif

                    <!-- Nama Sekolah -->
                    <x-form-input name="nama_sekolah" label="Nama Unit Sekolah" :value="old('nama_sekolah')" placeholder="Contoh: SMK Teknologi Mandiri" required autofocus />

                    <!-- Jenjang Pendidikan -->
                    <x-form-select name="jenjang" label="Jenjang Pendidikan" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="tk" @selected(old('jenjang') === 'tk')>TK (Taman Kanak-kanak)</option>
                        <option value="smp" @selected(old('jenjang') === 'smp')>SMP (Sekolah Menengah Pertama)</option>
                        <option value="smk" @selected(old('jenjang') === 'smk')>SMK (Sekolah Menengah Kejuruan)</option>
                    </x-form-select>

                    <!-- Status Aktif -->
                    <x-form-select name="is_active" label="Status Operasional" required>
                        <option value="1" @selected(old('is_active', '1') === '1')>Aktif (Dapat diakses publik/admin)</option>
                        <option value="0" @selected(old('is_active', '1') === '0')>Non-aktif (Akses ditutup sementara)</option>
                    </x-form-select>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('superadmin.units.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Unit
                        </x-button>
                    </div>

                </form>
            </x-card>

        </div>
</x-app-layout>
