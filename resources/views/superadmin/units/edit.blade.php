<x-app-layout>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <x-breadcrumb :items="[
                'Dashboard' => route('superadmin.dashboard'),
                'Manajemen Unit' => route('superadmin.units.index'),
                'Edit Unit' => '#'
            ]" />

            <x-card>
                <x-slot name="title">
                    Ubah Detail Unit Sekolah
                </x-slot>
                <x-slot name="subtitle">
                    Perbarui nama sekolah, jenjang pendidikan, atau status operasional unit.
                </x-slot>

                <form method="POST" action="{{ route('superadmin.units.update', $unit) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Sekolah -->
                    <x-form-input name="nama_sekolah" label="Nama Unit Sekolah" :value="old('nama_sekolah', $unit->nama_sekolah)" required autofocus />

                    <!-- Jenjang Pendidikan -->
                    <x-form-select name="jenjang" label="Jenjang Pendidikan" required>
                        <option value="tk" @selected(old('jenjang', $unit->jenjang) === 'tk')>TK (Taman Kanak-kanak)</option>
                        <option value="smp" @selected(old('jenjang', $unit->jenjang) === 'smp')>SMP (Sekolah Menengah Pertama)</option>
                        <option value="smk" @selected(old('jenjang', $unit->jenjang) === 'smk')>SMK (Sekolah Menengah Kejuruan)</option>
                    </x-form-select>

                    <!-- Status Aktif -->
                    <x-form-select name="is_active" label="Status Operasional" required>
                        <option value="1" @selected(old('is_active', $unit->is_active ? '1' : '0') === '1')>Aktif (Dapat diakses publik/admin)</option>
                        <option value="0" @selected(old('is_active', $unit->is_active ? '1' : '0') === '0')>Non-aktif (Akses ditutup sementara)</option>
                    </x-form-select>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('superadmin.units.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Perbarui Unit
                        </x-button>
                    </div>

                </form>
            </x-card>

        </div>
</x-app-layout>
