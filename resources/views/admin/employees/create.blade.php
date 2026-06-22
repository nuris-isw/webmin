<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Data Guru & Pegawai' => route('admin.employees.index', $unit),
                'Tambah Pegawai' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Tambah Guru / Pegawai Baru</x-slot>
                <x-slot name="subtitle">Isi formulir berikut untuk menambahkan data guru atau tenaga kependidikan baru.</x-slot>

                <form method="POST" action="{{ route('admin.employees.store', $unit) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf

                    <!-- Nama -->
                    <x-form-input name="nama" label="Nama Lengkap" placeholder="Contoh: Drs. Ahmad Fauzi, M.Pd." :value="old('nama')" required autofocus />

                    <!-- Jabatan -->
                    <x-form-input name="jabatan" label="Jabatan / Posisi" placeholder="Contoh: Kepala Sekolah, Guru Matematika, Staf TU" :value="old('jabatan')" required />

                    <!-- Order Number -->
                    <x-form-input
                        name="order_number"
                        type="number"
                        label="Order Number (Urutan Tampil)"
                        placeholder="Contoh: 1 (jabatan tertinggi)"
                        :value="old('order_number', 0)"
                        required
                    />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4">Angka lebih kecil akan ditampilkan lebih awal. Gunakan <strong>1</strong> untuk jabatan tertinggi (Kepala Sekolah).</p>

                    <!-- Foto -->
                    <x-form-file name="photo" label="Foto Profil" accept="image/png, image/jpeg, image/webp" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-2">PNG, JPG, WEBP. Maksimal 2MB. Disarankan ukuran persegi.</p>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.employees.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Data Pegawai
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
