<x-app-layout>

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
                    x-data="{ 
                        hasPrograms: {{ ($unit->isSmk() || count($majors) > 0) ? 'true' : 'false' }}, 
                        opsiTampilan: '{{ old('opsi_tampilan', '') }}',
                        isUploading: false,
                        progress: 0,
                        errors: {},
                        submitForm(e) {
                            let form = e.target;
                            let fileInput = form.querySelector('input[type=&quot;file&quot;]');
                            if (fileInput && fileInput.files.length > 0) {
                                this.isUploading = true;
                                this.progress = 0;
                                this.errors = {};
                                
                                let formData = new FormData(form);
                                let xhr = new XMLHttpRequest();
                                xhr.open(form.method.toUpperCase(), form.action);
                                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                                
                                xhr.upload.addEventListener('progress', (event) => {
                                    if (event.lengthComputable) {
                                        this.progress = Math.round((event.loaded * 100) / event.total);
                                    }
                                });
                                
                                xhr.addEventListener('load', () => {
                                    this.isUploading = false;
                                    if (xhr.status >= 200 && xhr.status < 300) {
                                        let response = JSON.parse(xhr.responseText);
                                        if (response.redirect) {
                                            window.location.href = response.redirect;
                                        } else {
                                            window.location.reload();
                                        }
                                    } else if (xhr.status === 422) {
                                        let response = JSON.parse(xhr.responseText);
                                        this.errors = response.errors;
                                    } else {
                                        alert('Terjadi kesalahan saat mengunggah berkas.');
                                    }
                                });
                                
                                xhr.addEventListener('error', () => {
                                    this.isUploading = false;
                                    alert('Koneksi terputus saat mengunggah berkas.');
                                });
                                
                                xhr.send(formData);
                            } else {
                                form.submit();
                            }
                        }
                    }"
                    @submit.prevent="submitForm($event)"
                    class="space-y-6 mt-4"
                >
                    @csrf

                    <!-- AJAX Validation Error Box -->
                    <div x-show="Object.keys(errors).length > 0" class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-lg text-sm dark:bg-rose-950/20 dark:border-rose-900 dark:text-rose-400" style="display: none;">
                        <h5 class="font-semibold mb-2">Mohon perbaiki kesalahan berikut:</h5>
                        <ul class="list-disc pl-5 space-y-1">
                            <template x-for="(errList, field) in errors" :key="field">
                                <template x-for="err in errList" :key="err">
                                    <li x-text="err"></li>
                                </template>
                            </template>
                        </ul>
                    </div>

                    <!-- Nama Kegiatan -->
                    <x-form-input name="nama_kegiatan" label="Nama Kegiatan / Album" :value="old('nama_kegiatan')" required autofocus />

                    <!-- Opsi Tampilan -->
                    <x-form-select name="opsi_tampilan" label="Penempatan Tampilan (Display Routing)" x-model="opsiTampilan" required>
                        <option value="">-- Pilih Opsi Tampilan --</option>
                        <option value="hero_section" @selected(old('opsi_tampilan') === 'hero_section')>Hero Section (Slide Utama Depan)</option>
                        <option value="gambar_pembuka" @selected(old('opsi_tampilan') === 'gambar_pembuka')>Gambar Pembuka (Halaman Depan)</option>
                        <option value="galeri_dokumentasi" @selected(old('opsi_tampilan') === 'galeri_dokumentasi')>Galeri Dokumentasi Umum</option>
                        @if ($unit->isSmk() || count($majors) > 0)
                            <option value="galeri_program" @selected(old('opsi_tampilan') === 'galeri_program')>
                                {{ $unit->isSmk() ? 'Galeri Program Keahlian (Khusus SMK)' : 'Galeri Khusus Program/Layanan' }}
                            </option>
                        @endif
                    </x-form-select>

                    <!-- Major Selection -->
                    @if ($unit->isSmk() || count($majors) > 0)
                        <div x-show="hasPrograms && opsiTampilan === 'galeri_program'" x-transition class="space-y-2">
                            <x-form-select name="major_id" label="{{ $unit->isSmk() ? 'Program Keahlian Terkait' : 'Program Pendidikan Terkait' }}">
                                <option value="">-- Pilih {{ $unit->isSmk() ? 'Program Keahlian' : 'Program Pendidikan' }} --</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}" @selected(old('major_id') == $major->id)>
                                        {{ $major->nama_jurusan }} ({{ $major->shortname }})
                                    </option>
                                @endforeach
                            </x-form-select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Foto album ini hanya akan dimuat pada halaman detail {{ strtolower($unit->getMajorLabel()) }} yang dipilih.</p>
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

                    <!-- Upload Progress Overlay (Premium Glassmorphism Modal) -->
                    <div 
                        x-show="isUploading" 
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                        style="display: none;"
                    >
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 border border-gray-150 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">Mengunggah Galeri...</h4>
                                <span class="text-sm font-bold text-rose-600 dark:text-rose-400" x-text="progress + '%'"></span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div 
                                    class="bg-gradient-to-r from-rose-500 to-rose-700 h-full rounded-full transition-all duration-150 ease-out" 
                                    :style="'width: ' + progress + '%'"
                                ></div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Mohon jangan menutup halaman ini atau menekan tombol kembali sampai proses unggah selesai.</p>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
