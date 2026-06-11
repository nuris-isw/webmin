<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Album Galeri Baru') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Galeri' => route('admin.galleries.index', $unit),
                'Buat Galeri' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Buat Album Galeri Baru</x-slot>
                <x-slot name="subtitle">Unggah dokumentasi foto kegiatan sekolah.</x-slot>

                <form 
                    method="POST" 
                    action="{{ route('admin.galleries.store', $unit) }}" 
                    enctype="multipart/form-data" 
                    x-data="{ isSmk: {{ $unit->isSmk() ? 'true' : 'false' }}, opsiTampilan: '{{ old('opsi_tampilan', '') }}' }"
                    class="space-y-6 mt-4"
                >
                    @csrf

                    <!-- Nama Kegiatan -->
                    <x-form-input name="nama_kegiatan" label="Nama Kegiatan / Album" :value="old('nama_kegiatan')" required autofocus />

                    <!-- Opsi Tampilan -->
                    <x-form-select name="opsi_tampilan" label="Penempatan Tampilan (Display Routing)" x-model="opsiTampilan" required>
                        <option value="">-- Pilih Opsi Tampilan --</option>
                        <option value="hero_section" @selected(old('opsi_tampilan') === 'hero_section')>Hero Section (Slide Utama Depan)</option>
                        <option value="gambar_pembuka" @selected(old('opsi_tampilan') === 'gambar_pembuka')>Gambar Pembuka (Halaman Depan)</option>
                        <option value="galeri_dokumentasi" @selected(old('opsi_tampilan') === 'galeri_dokumentasi')>Galeri Dokumentasi Umum</option>
                        @if ($unit->isSmk())
                            <option value="galeri_program" @selected(old('opsi_tampilan') === 'galeri_program')>Galeri Program Keahlian (Khusus SMK)</option>
                        @endif
                    </x-form-select>

                    <!-- Major Selection ( SMK + galeri_program only ) -->
                    @if ($unit->isSmk())
                        <div x-show="isSmk && opsiTampilan === 'galeri_program'" x-transition class="space-y-2">
                            <x-form-select name="major_id" label="Program Keahlian Terkait">
                                <option value="">-- Pilih Program Keahlian --</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}" @selected(old('major_id') == $major->id)>
                                        {{ $major->nama_jurusan }} ({{ $major->shortname }})
                                    </option>
                                @endforeach
                            </x-form-select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Foto album ini hanya akan dimuat pada halaman detail program keahlian yang dipilih.</p>
                        </div>
                    @endif

                    <!-- Multi-photo upload -->
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Unggah Foto-foto Kegiatan (Multi-upload)
                        </label>
                        <input 
                            type="file" 
                            name="photos[]" 
                            accept="image/png, image/jpeg, image/webp" 
                            multiple 
                            required
                            class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-red/10 file:text-brand-red hover:file:bg-brand-red/20 dark:file:bg-brand-red/20 dark:file:text-white cursor-pointer file:cursor-pointer"
                        />
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, WEBP. Maksimal 2MB per file. Anda dapat memilih beberapa foto sekaligus.</p>
                        @error('photos')
                            <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('photos.*')
                            <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.galleries.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Buat Album
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
