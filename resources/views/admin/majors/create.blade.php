<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar ' . $unit->getMajorLabel() => route('admin.majors.index', $unit),
                'Tambah ' . $unit->getMajorLabel() => '#'
            ]" />

            <x-card>
                <x-slot name="title">Tambah {{ $unit->getMajorLabel() }} Baru</x-slot>
                <x-slot name="subtitle">Isi formulir berikut untuk mendaftarkan {{ strtolower($unit->getMajorLabel()) }} baru.</x-slot>

                <form method="POST" action="{{ route('admin.majors.store', $unit) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf

                    <!-- Nama Jurusan -->
                    <x-form-input name="nama_jurusan" label="Nama Lengkap {{ $unit->getMajorLabel() }}" placeholder="Contoh: {{ $unit->isSmk() ? 'Teknik Komputer dan Jaringan' : ($unit->isSmp() ? 'Bilingual Class' : 'Preschool') }}" :value="old('nama_jurusan')" required autofocus />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomenklatur Istilah -->
                        <x-form-select name="nomenklatur_istilah" label="Nomenklatur Istilah" required>
                            <option value="">-- Pilih Istilah --</option>
                            @if ($unit->isSmk())
                                <option value="Program Keahlian" @selected(old('nomenklatur_istilah') === 'Program Keahlian')>Program Keahlian</option>
                                <option value="Konsentrasi Keahlian" @selected(old('nomenklatur_istilah') === 'Konsentrasi Keahlian')>Konsentrasi Keahlian</option>
                                <option value="Program Studi" @selected(old('nomenklatur_istilah') === 'Program Studi')>Program Studi</option>
                            @elseif ($unit->isSmp())
                                <option value="Program Unggulan" @selected(old('nomenklatur_istilah') === 'Program Unggulan')>Program Unggulan</option>
                                <option value="Kelas Khusus" @selected(old('nomenklatur_istilah') === 'Kelas Khusus')>Kelas Khusus</option>
                                <option value="Program Kelas" @selected(old('nomenklatur_istilah') === 'Program Kelas')>Program Kelas</option>
                            @else
                                <option value="Program Pendidikan" @selected(old('nomenklatur_istilah') === 'Program Pendidikan')>Program Pendidikan</option>
                                <option value="Kelas Bermain" @selected(old('nomenklatur_istilah') === 'Kelas Bermain')>Kelas Bermain</option>
                                <option value="Layanan Pendidikan" @selected(old('nomenklatur_istilah') === 'Layanan Pendidikan')>Layanan Pendidikan</option>
                            @endif
                        </x-form-select>

                        <!-- Singkatan (Shortname) -->
                        <x-form-input name="shortname" label="Singkatan / Kode {{ $unit->getMajorLabel() }}" placeholder="Contoh: {{ $unit->isSmk() ? 'TKJ' : ($unit->isSmp() ? 'BIL' : 'PRE') }}" :value="old('shortname')" required />
                    </div>

                    <!-- Kepala Program (Kaprog) -->
                    <x-form-input name="nama_kaprog" label="Nama {{ $unit->getLeaderLabel() }}" :value="old('nama_kaprog')" />

                    <!-- Foto Kaprog -->
                    <x-form-file name="foto_kaprog" label="Foto {{ $unit->getLeaderLabel() }}" accept="image/png, image/jpeg, image/webp" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-2">PNG, JPG, WEBP. Maksimal 2MB.</p>

                    <!-- Deskripsi Jurusan (Rich Text) -->
                    <x-form-rich-text name="deskripsi_jurusan" label="Deskripsi {{ $unit->getMajorLabel() }} (Keterangan & Detail)" :value="old('deskripsi_jurusan')" />

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.majors.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan {{ $unit->getMajorLabel() }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
