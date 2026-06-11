<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Prestasi Baru') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Prestasi' => route('admin.achievements.index', $unit),
                'Tambah Prestasi' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Tambah Prestasi Baru</x-slot>
                <x-slot name="subtitle">Isi formulir berikut untuk mendaftarkan pencapaian prestasi baru.</x-slot>

                <form method="POST" action="{{ route('admin.achievements.store', $unit) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf

                    <!-- Judul Prestasi -->
                    <x-form-input name="judul_prestasi" label="Judul Prestasi / Penghargaan" :value="old('judul_prestasi')" required autofocus />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tahun Prestasi -->
                        <x-form-input name="tahun_prestasi" label="Tahun Prestasi" :value="old('tahun_prestasi')" placeholder="Contoh: 2026" required />

                        <!-- Peraih Prestasi -->
                        <x-form-select name="peraih_prestasi" label="Peraih Prestasi" required>
                            <option value="">-- Pilih Peraih --</option>
                            <option value="siswa" @selected(old('peraih_prestasi') === 'siswa')>Siswa</option>
                            <option value="guru" @selected(old('peraih_prestasi') === 'guru')>Guru</option>
                            <option value="tendik" @selected(old('peraih_prestasi') === 'tendik')>Tenaga Kependidikan</option>
                            <option value="sekolah" @selected(old('peraih_prestasi') === 'sekolah')>Institusi Sekolah</option>
                        </x-form-select>
                    </div>

                    <!-- Deskripsi Prestasi -->
                    <x-form-textarea name="deskripsi_prestasi" label="Deskripsi Singkat / Keterangan">{{ old('deskripsi_prestasi') }}</x-form-textarea>

                    <!-- Foto Penghargaan -->
                    <x-form-file name="foto_penghargaan" label="Foto Penghargaan / Piala / Dokumentasi" accept="image/png, image/jpeg, image/webp" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-2">PNG, JPG, WEBP. Maksimal 2MB.</p>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.achievements.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Prestasi
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
