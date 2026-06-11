<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Profil Sekolah') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumbs -->
            <x-breadcrumb :items="[
                'Dashboard' => route('admin.dashboard', $unit),
                'Profil Sekolah' => '#'
            ]" />

            <!-- Flash Alerts -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            <!-- Tabs container driven by Alpine.js -->
            <div x-data="{ activeTab: '{{ old('active_tab', 'tab-a') }}' }" class="space-y-6">
                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button 
                            type="button"
                            @click="activeTab = 'tab-a'"
                            :class="activeTab === 'tab-a' ? 'border-brand-red text-brand-red' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition duration-150"
                        >
                            Tab A: Kontak & Lokasi
                        </button>
                        <button 
                            type="button"
                            @click="activeTab = 'tab-b'"
                            :class="activeTab === 'tab-b' ? 'border-brand-red text-brand-red' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition duration-150"
                        >
                            Tab B: Profil & Sejarah
                        </button>
                        <button 
                            type="button"
                            @click="activeTab = 'tab-c'"
                            :class="activeTab === 'tab-c' ? 'border-brand-red text-brand-red' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition duration-150"
                        >
                            Tab C: Akademik
                        </button>
                    </nav>
                </div>

                <!-- Profile Edit Form (Single Form covering all Tabs) -->
                <form method="POST" action="{{ route('admin.profile.update', $unit) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Hidden input to persist active tab on validation fail -->
                    <input type="hidden" name="active_tab" :value="activeTab">

                    <!-- TAB A: Kontak & Lokasi -->
                    <div x-show="activeTab === 'tab-a'" x-transition class="space-y-6">
                        <x-card>
                            <x-slot name="title">Kontak & Lokasi Sekolah</x-slot>
                            <x-slot name="subtitle">Informasi alamat, kontak resmi, dan integrasi media sosial.</x-slot>

                            <div class="space-y-6 mt-4">
                                <!-- Logo Sekolah Upload & Preview -->
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                                    <div class="md:col-span-1 flex justify-center">
                                        @if ($profile->logo_sekolah)
                                            <img src="@asset($profile->logo_sekolah)" alt="Logo Sekolah" class="h-24 w-24 object-contain rounded-lg border border-gray-200 dark:border-gray-800 bg-gray-50 p-2">
                                        @else
                                            <div class="h-24 w-24 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400">
                                                No Logo
                                            </div>
                                        @endif
                                    </div>
                                    <div class="md:col-span-3">
                                        <x-form-file name="logo_sekolah" label="Unggah Logo Sekolah Baru" accept="image/png, image/jpeg, image/webp" />
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, WEBP. Maksimal 2MB.</p>
                                    </div>
                                </div>

                                <!-- Email & Telepon -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-form-input name="email" label="Alamat Email Resmi" type="email" :value="old('email', $profile->email)" />
                                    <x-form-input name="telepon" label="Nomor Telepon Resmi" :value="old('telepon', $profile->telepon)" />
                                </div>

                                <!-- Alamat Lengkap -->
                                <x-form-textarea name="alamat" label="Alamat Lengkap Sekolah">{{ old('alamat', $profile->alamat) }}</x-form-textarea>

                                <!-- Google Maps Embed URL -->
                                <x-form-input name="google_map_embed_url" label="Google Maps Embed URL" :value="old('google_map_embed_url', $profile->google_map_embed_url)" placeholder="https://www.google.com/maps/embed?pb=..." />
                                <p class="text-xs text-gray-500 dark:text-gray-400">Salin link src iframe embed dari Google Maps share menu.</p>

                                <!-- Media Sosial -->
                                <div class="border-t border-gray-100 dark:border-gray-800 pt-6 space-y-4">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Akun Media Sosial Resmi</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <x-form-input name="media_sosial[instagram]" label="Link Instagram" :value="old('media_sosial.instagram', $profile->media_sosial['instagram'] ?? null)" />
                                        <x-form-input name="media_sosial[facebook]" label="Link Facebook" :value="old('media_sosial.facebook', $profile->media_sosial['facebook'] ?? null)" />
                                        <x-form-input name="media_sosial[youtube]" label="Link YouTube" :value="old('media_sosial.youtube', $profile->media_sosial['youtube'] ?? null)" />
                                        <x-form-input name="media_sosial[tiktok]" label="Link TikTok" :value="old('media_sosial.tiktok', $profile->media_sosial['tiktok'] ?? null)" />
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>

                    <!-- TAB B: Profil & Sejarah -->
                    <div x-show="activeTab === 'tab-b'" x-transition class="space-y-6">
                        <x-card>
                            <x-slot name="title">Kepemimpinan & Sejarah Sekolah</x-slot>
                            <x-slot name="subtitle">Unggah informasi pimpinan dan sambutan/sejarah singkat sekolah.</x-slot>

                            <div class="space-y-6 mt-4">
                                <!-- Kepala Sekolah Photo & Name -->
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                                    <div class="md:col-span-1 flex justify-center">
                                        @if ($profile->foto_kepala_sekolah)
                                            <img src="@asset($profile->foto_kepala_sekolah)" alt="Foto Kepala Sekolah" class="h-28 w-24 object-cover rounded-lg border border-gray-200 dark:border-gray-800">
                                        @else
                                            <div class="h-28 w-24 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-xs text-gray-400 text-center p-2">
                                                No Photo
                                            </div>
                                        @endif
                                    </div>
                                    <div class="md:col-span-3 space-y-4">
                                        <x-form-input name="nama_kepala_sekolah" label="Nama Lengkap Kepala Sekolah" :value="old('nama_kepala_sekolah', $profile->nama_kepala_sekolah)" />
                                        <div>
                                            <x-form-file name="foto_kepala_sekolah" label="Unggah Foto Kepala Sekolah Baru" accept="image/png, image/jpeg, image/webp" />
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">PNG, JPG, WEBP. Maksimal 2MB.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sambutan Kepala Sekolah (Rich Text) -->
                                <x-form-rich-text name="sambutan_kepala_sekolah" label="Sambutan Kepala Sekolah" :value="old('sambutan_kepala_sekolah', $profile->sambutan_kepala_sekolah)" />

                                <!-- Sejarah Singkat Sekolah (Rich Text) -->
                                <x-form-rich-text name="sejarah_singkat_sekolah" label="Sejarah Singkat Sekolah" :value="old('sejarah_singkat_sekolah', $profile->sejarah_singkat_sekolah)" />
                            </div>
                        </x-card>
                    </div>

                    <!-- TAB C: Akademik -->
                    <div x-show="activeTab === 'tab-c'" x-transition class="space-y-6">
                        <x-card>
                            <x-slot name="title">Karakteristik Akademik & Kurikulum</x-slot>
                            <x-slot name="subtitle">Kelola visi, misi, kurikulum, serta kalender akademik sekolah.</x-slot>

                            <div class="space-y-6 mt-4">
                                <!-- Visi (Rich Text) -->
                                <x-form-rich-text name="visi" label="Visi Sekolah" :value="old('visi', $profile->visi)" />

                                <!-- Misi (Rich Text) -->
                                <x-form-rich-text name="misi" label="Misi Sekolah" :value="old('misi', $profile->misi)" />

                                <!-- Deskripsi Kurikulum (Rich Text) -->
                                <x-form-rich-text name="deskripsi_kurikulum" label="Deskripsi Kurikulum" :value="old('deskripsi_kurikulum', $profile->deskripsi_kurikulum)" />

                                <!-- Kalender Akademik PDF -->
                                <div class="border-t border-gray-100 dark:border-gray-800 pt-6 space-y-4">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">File Kalender Akademik</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                                        <div class="md:col-span-1 flex justify-center">
                                            @if ($profile->pdf_kalender_akademik)
                                                <a href="@asset($profile->pdf_kalender_akademik)" target="_blank" class="inline-flex items-center gap-2 px-4 py-3 bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold dark:bg-rose-950/20 dark:border-rose-900 dark:text-rose-400 transition">
                                                    <svg class="w-5 h-5 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                    </svg>
                                                    Lihat PDF
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400">Belum ada file</span>
                                            @endif
                                        </div>
                                        <div class="md:col-span-3">
                                            <x-form-file name="pdf_kalender_akademik" label="Unggah File PDF Kalender Akademik Baru" accept="application/pdf" />
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Format PDF saja. Maksimal 10MB.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.dashboard', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition">
                            Kembali ke Dasbor
                        </a>
                        <x-button type="submit">
                            Simpan Profil
                        </x-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
