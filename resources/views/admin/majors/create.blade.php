<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Jurusan' => route('admin.majors.index', $unit),
                'Tambah Jurusan' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Tambah Jurusan Baru</x-slot>
                <x-slot name="subtitle">Isi formulir berikut untuk mendaftarkan Program/Konsentrasi Keahlian baru.</x-slot>

                <form method="POST" action="{{ route('admin.majors.store', $unit) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf

                    <!-- Nama Jurusan -->
                    <x-form-input name="nama_jurusan" label="Nama Lengkap Jurusan" placeholder="Contoh: Teknik Komputer dan Jaringan" :value="old('nama_jurusan')" required autofocus />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomenklatur Istilah -->
                        <x-form-select name="nomenklatur_istilah" label="Nomenklatur Istilah" required>
                            <option value="">-- Pilih Istilah --</option>
                            <option value="Program Keahlian" @selected(old('nomenklatur_istilah') === 'Program Keahlian')>Program Keahlian</option>
                            <option value="Konsentrasi Keahlian" @selected(old('nomenklatur_istilah') === 'Konsentrasi Keahlian')>Konsentrasi Keahlian</option>
                            <option value="Program Studi" @selected(old('nomenklatur_istilah') === 'Program Studi')>Program Studi</option>
                        </x-form-select>

                        <!-- Singkatan (Shortname) -->
                        <x-form-input name="shortname" label="Singkatan / Kode Jurusan" placeholder="Contoh: TKJ" :value="old('shortname')" required />
                    </div>

                    <!-- Kepala Program (Kaprog) -->
                    <x-form-input name="nama_kaprog" label="Nama Kepala Program Keahlian (Kaprog)" :value="old('nama_kaprog')" />

                    <!-- Foto Kaprog -->
                    <x-form-file name="foto_kaprog" label="Foto Kepala Program Keahlian" accept="image/png, image/jpeg, image/webp" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-2">PNG, JPG, WEBP. Maksimal 2MB.</p>

                    <!-- Deskripsi Jurusan (Rich Text) -->
                    <x-form-rich-text name="deskripsi_jurusan" label="Deskripsi Jurusan (Kompetensi & Prospek Kerja)" :value="old('deskripsi_jurusan')" />

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.majors.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Jurusan
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
