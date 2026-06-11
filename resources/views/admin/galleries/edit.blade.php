<x-app-layout>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Daftar Galeri' => route('admin.galleries.index', $unit),
                'Edit Galeri' => '#'
            ]" />

            <x-card>
                <x-slot name="title">Edit Album Galeri</x-slot>
                <x-slot name="subtitle">Perbarui detail album kegiatan dan urutan foto-foto dokumentasi.</x-slot>

                <form 
                    method="POST" 
                    action="{{ route('admin.galleries.update', [$unit, $gallery]) }}" 
                    enctype="multipart/form-data" 
                    x-data="{ 
                        isSmk: {{ $unit->isSmk() ? 'true' : 'false' }}, 
                        opsiTampilan: '{{ old('opsi_tampilan', $gallery->opsi_tampilan) }}',
                        photos: {{ $gallery->photos->values()->toJson() }},
                        deletedPhotos: [],
                        isUploading: false,
                        progress: 0,
                        errors: {},
                        moveLeft(index) {
                            if (index > 0) {
                                let temp = this.photos[index];
                                this.photos[index] = this.photos[index - 1];
                                this.photos[index - 1] = temp;
                                this.photos = [...this.photos];
                            }
                        },
                        moveRight(index) {
                            if (index < this.photos.length - 1) {
                                let temp = this.photos[index];
                                this.photos[index] = this.photos[index + 1];
                                this.photos[index + 1] = temp;
                                this.photos = [...this.photos];
                            }
                        },
                        removePhoto(id, index) {
                            if (confirm('Apakah Anda yakin ingin menghapus foto ini secara permanen dari server?')) {
                                this.deletedPhotos.push(id);
                                this.photos.splice(index, 1);
                            }
                        },
                        submitForm(e) {
                            let form = e.target;
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
                                    alert('Terjadi kesalahan saat menyimpan perubahan.');
                                }
                            });
                            
                            xhr.addEventListener('error', () => {
                                this.isUploading = false;
                                alert('Koneksi terputus saat mengunggah berkas.');
                            });
                            
                            xhr.send(formData);
                        }
                    }"
                    @submit.prevent="submitForm($event)"
                    class="space-y-6 mt-4"
                >
                    @csrf
                    @method('PUT')

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

                    <!-- Submit deleted photo IDs -->
                    <template x-for="id in deletedPhotos" :key="id">
                        <input type="hidden" name="deleted_photos[]" :value="id">
                    </template>

                    <!-- Nama Kegiatan -->
                    <x-form-input name="nama_kegiatan" label="Nama Kegiatan / Album" :value="old('nama_kegiatan', $gallery->nama_kegiatan)" required />

                    <!-- Opsi Tampilan -->
                    <x-form-select name="opsi_tampilan" label="Penempatan Tampilan (Display Routing)" x-model="opsiTampilan" required>
                        <option value="hero_section" @selected(old('opsi_tampilan', $gallery->opsi_tampilan) === 'hero_section')>Hero Section (Slide Utama Depan)</option>
                        <option value="gambar_pembuka" @selected(old('opsi_tampilan', $gallery->opsi_tampilan) === 'gambar_pembuka')>Gambar Pembuka (Halaman Depan)</option>
                        <option value="galeri_dokumentasi" @selected(old('opsi_tampilan', $gallery->opsi_tampilan) === 'galeri_dokumentasi')>Galeri Dokumentasi Umum</option>
                        @if ($unit->isSmk())
                            <option value="galeri_program" @selected(old('opsi_tampilan', $gallery->opsi_tampilan) === 'galeri_program')>Galeri Program Keahlian (Khusus SMK)</option>
                        @endif
                    </x-form-select>

                    <!-- Major Selection ( SMK + galeri_program only ) -->
                    @if ($unit->isSmk())
                        <div x-show="isSmk && opsiTampilan === 'galeri_program'" x-transition class="space-y-2">
                            <x-form-select name="major_id" label="Program Keahlian Terkait">
                                <option value="">-- Pilih Program Keahlian --</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}" @selected(old('major_id', $gallery->major_id) == $major->id)>
                                        {{ $major->nama_jurusan }} ({{ $major->shortname }})
                                    </option>
                                @endforeach
                            </x-form-select>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Foto album ini hanya akan dimuat pada halaman detail program keahlian yang dipilih.</p>
                        </div>
                    @endif

                    <!-- Reordering & Photo list -->
                    <div class="border-t border-gray-100 dark:border-gray-800 pt-6 space-y-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Susunan Foto Album Saat Ini</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Gunakan tombol panah (&larr; / &rarr;) untuk mengatur urutan foto dalam album. Foto pertama (paling kiri) akan menjadi cover / thumbnail.</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            <template x-for="(photo, index) in photos" :key="photo.id">
                                <div class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-2 flex flex-col justify-between">
                                    <!-- Submit photo ordering -->
                                    <input type="hidden" name="existing_photos_order[]" :value="photo.id">
                                    
                                    <img :src="'{{ school_asset('') }}/' + photo.file_foto" class="h-24 w-full object-cover rounded" alt="Foto">
                                    
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex gap-1">
                                            <button type="button" @click="moveLeft(index)" :disabled="index === 0" class="p-1.5 rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 disabled:opacity-30 cursor-pointer transition">
                                                &larr;
                                            </button>
                                            <button type="button" @click="moveRight(index)" :disabled="index === photos.length - 1" class="p-1.5 rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 disabled:opacity-30 cursor-pointer transition">
                                                &rarr;
                                            </button>
                                        </div>
                                        <button type="button" @click="removePhoto(photo.id, index)" class="p-1 px-2.5 rounded bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/20 dark:hover:bg-rose-900/30 text-rose-600 cursor-pointer text-xs font-bold transition">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Add new photos -->
                    <div class="border-t border-gray-100 dark:border-gray-800 pt-6 space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Unggah Foto Tambahan Baru
                        </label>
                        <input 
                            type="file" 
                            name="photos[]" 
                            accept="image/png, image/jpeg, image/webp" 
                            multiple 
                            class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-red/10 file:text-brand-red hover:file:bg-brand-red/20 dark:file:bg-brand-red/20 dark:file:text-white cursor-pointer file:cursor-pointer"
                        />
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WEBP. Maksimal 2MB per file. Foto yang diunggah akan otomatis ditambahkan ke akhir album.</p>
                        @error('photos')
                            <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <a href="{{ route('admin.galleries.index', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Batal
                        </a>
                        <x-button type="submit">
                            Simpan Perubahan
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
                                <h4 class="font-semibold text-gray-800 dark:text-gray-250" x-text="progress < 100 ? 'Mengunggah Galeri...' : 'Menyimpan Perubahan...'"></h4>
                                <span class="text-sm font-bold text-rose-600 dark:text-rose-400" x-text="progress + '%'"></span>
                            </div>
                            <div class="w-full bg-gray-150 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div 
                                    class="bg-gradient-to-r from-rose-500 to-rose-700 h-full rounded-full transition-all duration-150 ease-out" 
                                    :style="'width: ' + progress + '%'"
                                ></div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Mohon jangan menutup halaman ini atau menekan tombol kembali sampai proses selesai.</p>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
</x-app-layout>
