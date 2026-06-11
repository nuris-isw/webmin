<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Ekstrakurikuler' => route('admin.extracurriculars.index', $unit),
                'Tambah Ekstrakurikuler' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Tambah Ekstrakurikuler Baru</x-slot>
                <x-slot name="subtitle">Isi formulir berikut untuk mendaftarkan ekstrakurikuler baru di unit sekolah.</x-slot>

                <form method="POST" action="{{ route('admin.extracurriculars.store', $unit) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf

                    <!-- Nama Ekskul -->
                    <x-form-input name="nama_ekskul" label="Nama Ekstrakurikuler" :value="old('nama_ekskul')" required autofocus />

                    <!-- Pembina Ekskul -->
                    <x-form-input name="pembina_ekskul" label="Pembina Ekstrakurikuler" :value="old('pembina_ekskul')" placeholder="Nama guru / pembina" />

                    <!-- Jadwal Kegiatan -->
                    <x-form-textarea name="jadwal_kegiatan" label="Jadwal Kegiatan" placeholder="Contoh: Setiap Hari Sabtu, Pukul 09.00 - 11.00 WIB">{{ old('jadwal_kegiatan') }}</x-form-textarea>

                    <!-- Logo Ekskul -->
                    <x-form-file name="logo_ekskul" label="Logo / Lambang Ekstrakurikuler" accept="image/png, image/jpeg, image/webp" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-2">PNG, JPG, WEBP. Maksimal 2MB.</p>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.extracurriculars.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Ekstrakurikuler
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
