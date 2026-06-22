<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Data Guru & Pegawai' => route('admin.employees.index', $unit),
                'Edit: ' . $employee->nama => '#'
            ]" />

            <x-card>
                <x-slot name="title">Edit Data Pegawai</x-slot>
                <x-slot name="subtitle">Perbarui informasi untuk <strong>{{ $employee->nama }}</strong>.</x-slot>

                <form method="POST" action="{{ route('admin.employees.update', [$unit, $employee]) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <x-form-input name="nama" label="Nama Lengkap" placeholder="Contoh: Drs. Ahmad Fauzi, M.Pd." :value="old('nama', $employee->nama)" required autofocus />

                    <!-- Jabatan -->
                    <x-form-input name="jabatan" label="Jabatan / Posisi" placeholder="Contoh: Kepala Sekolah, Guru Matematika, Staf TU" :value="old('jabatan', $employee->jabatan)" required />

                    <!-- Order Number -->
                    <x-form-input
                        name="order_number"
                        type="number"
                        label="Order Number (Urutan Tampil)"
                        placeholder="Contoh: 1 (jabatan tertinggi)"
                        :value="old('order_number', $employee->order_number)"
                        required
                    />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-4">Angka lebih kecil akan ditampilkan lebih awal. Gunakan <strong>1</strong> untuk jabatan tertinggi (Kepala Sekolah).</p>

                    <!-- Foto Saat Ini -->
                    @if ($employee->photo)
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Foto Saat Ini</label>
                            <div class="flex items-center gap-4">
                                <img src="@asset($employee->photo)" alt="Foto {{ $employee->nama }}" class="h-24 w-20 object-cover rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Upload foto baru di bawah untuk mengganti foto ini.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Foto Baru -->
                    <x-form-file name="photo" label="{{ $employee->photo ? 'Ganti Foto Profil' : 'Foto Profil' }}" accept="image/png, image/jpeg, image/webp" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 -mt-2">PNG, JPG, WEBP. Maksimal 2MB. Biarkan kosong jika tidak ingin mengganti foto.</p>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.employees.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Perbarui Data Pegawai
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
