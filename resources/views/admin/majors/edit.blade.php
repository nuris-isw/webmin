<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar ' . $unit->getMajorLabel() => route('admin.majors.index', $unit),
                'Edit ' . $unit->getMajorLabel() => '#'
            ]" />

            <x-card>
                <x-slot name="title">Edit Data {{ $unit->getMajorLabel() }}</x-slot>
                <x-slot name="subtitle">Perbarui informasi {{ strtolower($unit->getMajorLabel()) }} sekolah.</x-slot>

                <form method="POST" action="{{ route('admin.majors.update', [$unit, $major]) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama Jurusan -->
                    <x-form-input name="nama_jurusan" label="Nama Lengkap {{ $unit->getMajorLabel() }}" placeholder="Contoh: {{ $unit->isSmk() ? 'Teknik Komputer dan Jaringan' : ($unit->isSmp() ? 'Bilingual Class' : 'Preschool') }}" :value="old('nama_jurusan', $major->nama_jurusan)" required />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomenklatur Istilah -->
                        <x-form-select name="nomenklatur_istilah" label="Nomenklatur Istilah" required>
                            <option value="">-- Pilih Istilah --</option>
                            @if ($unit->isSmk())
                                <option value="Program Keahlian" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Program Keahlian')>Program Keahlian</option>
                                <option value="Konsentrasi Keahlian" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Konsentrasi Keahlian')>Konsentrasi Keahlian</option>
                                <option value="Program Studi" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Program Studi')>Program Studi</option>
                            @elseif ($unit->isSmp())
                                <option value="Program Unggulan" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Program Unggulan')>Program Unggulan</option>
                                <option value="Kelas Khusus" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Kelas Khusus')>Kelas Khusus</option>
                                <option value="Program Kelas" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Program Kelas')>Program Kelas</option>
                            @else
                                <option value="Program Pendidikan" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Program Pendidikan')>Program Pendidikan</option>
                                <option value="Kelas Bermain" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Kelas Bermain')>Kelas Bermain</option>
                                <option value="Layanan Pendidikan" @selected(old('nomenklatur_istilah', $major->nomenklatur_istilah) === 'Layanan Pendidikan')>Layanan Pendidikan</option>
                            @endif
                        </x-form-select>

                        <!-- Singkatan (Shortname) -->
                        <x-form-input name="shortname" label="Singkatan / Kode {{ $unit->getMajorLabel() }}" placeholder="Contoh: {{ $unit->isSmk() ? 'TKJ' : ($unit->isSmp() ? 'BIL' : 'PRE') }}" :value="old('shortname', $major->shortname)" required />
                    </div>

                    <!-- Kepala Program (Kaprog) -->
                    <x-form-input name="nama_kaprog" label="Nama {{ $unit->getLeaderLabel() }}" :value="old('nama_kaprog', $major->nama_kaprog)" />

                    <!-- Foto Kaprog -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center border-t border-gray-100 dark:border-gray-800 pt-6">
                        <div class="md:col-span-1 flex justify-center">
                            @if ($major->foto_kaprog)
                                <img src="@asset($major->foto_kaprog)" alt="Foto {{ $unit->getLeaderLabel() }}" class="h-20 w-16 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                            @else
                                <div class="h-20 w-16 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                    No Photo
                                </div>
                            @endif
                        </div>
                        <div class="md:col-span-3">
                            <x-form-file name="foto_kaprog" label="Ganti Foto {{ $unit->getLeaderLabel() }}" accept="image/png, image/jpeg, image/webp" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, WEBP. Maksimal 2MB. Biarkan kosong jika tidak ingin mengganti.</p>
                        </div>
                    </div>

                    <!-- Deskripsi Jurusan (Rich Text) -->
                    <x-form-rich-text name="deskripsi_jurusan" label="Deskripsi {{ $unit->getMajorLabel() }} (Keterangan & Detail)" :value="old('deskripsi_jurusan', $major->deskripsi_jurusan)" />

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.majors.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Perbarui {{ $unit->getMajorLabel() }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
