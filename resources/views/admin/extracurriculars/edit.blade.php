<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Ekstrakurikuler') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Ekstrakurikuler' => route('admin.extracurriculars.index', $unit),
                'Edit Ekstrakurikuler' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Edit Ekstrakurikuler</x-slot>
                <x-slot name="subtitle">Perbarui informasi detail kegiatan ekstrakurikuler.</x-slot>

                <form method="POST" action="{{ route('admin.extracurriculars.update', [$unit, $extracurricular]) }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama Ekskul -->
                    <x-form-input name="nama_ekskul" label="Nama Ekstrakurikuler" :value="old('nama_ekskul', $extracurricular->nama_ekskul)" required autofocus />

                    <!-- Pembina Ekskul -->
                    <x-form-input name="pembina_ekskul" label="Pembina Ekstrakurikuler" :value="old('pembina_ekskul', $extracurricular->pembina_ekskul)" placeholder="Nama guru / pembina" />

                    <!-- Jadwal Kegiatan -->
                    <x-form-textarea name="jadwal_kegiatan" label="Jadwal Kegiatan" placeholder="Contoh: Setiap Hari Sabtu, Pukul 09.00 - 11.00 WIB">{{ old('jadwal_kegiatan', $extracurricular->jadwal_kegiatan) }}</x-form-textarea>

                    <!-- Logo Ekskul -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center border-t border-gray-100 dark:border-gray-800 pt-6">
                        <div class="md:col-span-1 flex justify-center">
                            @if ($extracurricular->logo_ekskul)
                                <img src="@asset($extracurricular->logo_ekskul)" alt="Logo Ekskul" class="h-20 w-20 object-contain rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 p-1">
                            @else
                                <div class="h-20 w-20 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                    No Logo
                                </div>
                            @endif
                        </div>
                        <div class="md:col-span-3">
                            <x-form-file name="logo_ekskul" label="Ganti Logo / Lambang Ekstrakurikuler" accept="image/png, image/jpeg, image/webp" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, WEBP. Maksimal 2MB. Biarkan kosong jika tidak ingin mengganti.</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.extracurriculars.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Perbarui Ekstrakurikuler
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
