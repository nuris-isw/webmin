<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dasbor Admin Unit') }} - {{ $unit->nama_sekolah }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Page Heading -->
            <x-page-heading 
                heading="Dasbor {{ $unit->nama_sekolah }}" 
                subheading="Kelola informasi profil, kesiswaan, publikasi, dan pengaturan penerimaan siswa baru." 
            />

            <!-- Metrics grid (4 cards) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Berita -->
                <x-stat-card 
                    title="Total Berita & Artikel" 
                    :value="$stats['news']" 
                    subtext="Artikel yang dipublikasikan/draft"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18c0 .621-.504 1.125-1.125 1.125H5.625M19.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5z" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Total Prestasi -->
                <x-stat-card 
                    title="Total Prestasi" 
                    :value="$stats['achievements']" 
                    subtext="Prestasi terdaftar"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-2.25a1.125 1.125 0 00-1.125 1.125V18.75m9 0t-9 0M9 3.75h6M9 3.75a3 3 0 00-3 3v2.25a3 3 0 003 3h6a3 3 0 003-3V6.75a3 3 0 00-3-3M9 3.75h6" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Total Ekskul -->
                <x-stat-card 
                    title="Total Ekstrakurikuler" 
                    :value="$stats['extracurriculars']" 
                    subtext="Ekskul dan klub aktif"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.25 8.25 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Total Galeri -->
                <x-stat-card 
                    title="Galeri Kegiatan" 
                    :value="$stats['galleries']" 
                    subtext="Koleksi album foto"
                >
                    <x-slot name="icon">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Detail Sekolah & Pengaturan SPMB -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Info Unit & SPMB (Col 1 & 2) -->
                <div class="lg:col-span-2 space-y-6">
                    <x-card>
                        <x-slot name="title">Informasi Unit Sekolah</x-slot>
                        <x-slot name="subtitle">Ringkasan status operasional unit sekolah saat ini.</x-slot>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block font-semibold uppercase">Nama Sekolah</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $unit->nama_sekolah }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block font-semibold uppercase">Jenjang Pendidikan</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase mt-1 bg-brand-red/10 text-brand-red">
                                        {{ strtoupper($unit->jenjang) }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block font-semibold uppercase">Status Keaktifan</span>
                                    <span class="inline-flex items-center gap-1.5 text-sm font-bold mt-1 {{ $unit->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400' }}">
                                        <span class="w-2 h-2 rounded-full {{ $unit->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                        {{ $unit->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block font-semibold uppercase">Penerimaan Siswa Baru (SPMB)</span>
                                    @if ($unit->spmbSetting?->status_spmb)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase mt-1 bg-emerald-100 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-300">
                                            SPMB DIBUKA
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase mt-1 bg-rose-100 dark:bg-rose-950/20 text-rose-800 dark:text-rose-300">
                                            SPMB DITUTUP
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-wrap gap-4">
                            <a href="{{ route('admin.profile.edit', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Edit Profil Sekolah
                            </a>
                            <a href="{{ route('admin.spmb.edit', $unit) }}" class="inline-flex items-center px-4 py-2 bg-brand-red hover:bg-brand-red-light text-white font-semibold text-xs uppercase tracking-widest rounded-md transition duration-150">
                                Pengaturan SPMB
                            </a>
                        </div>
                    </x-card>
                </div>

                <!-- Pintasan Aksi (Col 3) -->
                <div>
                    <x-card>
                        <x-slot name="title">Pintasan Manajemen</x-slot>
                        <x-slot name="subtitle">Navigasi cepat untuk menambah konten.</x-slot>

                        <div class="space-y-3 mt-4">
                            <a href="{{ route('admin.news.create', $unit) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-800 hover:border-brand-red dark:hover:border-brand-red bg-gray-50/50 dark:bg-gray-900/20 transition group">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-brand-red transition">Tulis Berita Baru</span>
                                <span class="text-xs text-gray-400 group-hover:text-brand-red transition">+</span>
                            </a>
                            <a href="{{ route('admin.achievements.create', $unit) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-800 hover:border-brand-red dark:hover:border-brand-red bg-gray-50/50 dark:bg-gray-900/20 transition group">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-brand-red transition">Tambah Prestasi</span>
                                <span class="text-xs text-gray-400 group-hover:text-brand-red transition">+</span>
                            </a>
                            <a href="{{ route('admin.extracurriculars.create', $unit) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-800 hover:border-brand-red dark:hover:border-brand-red bg-gray-50/50 dark:bg-gray-900/20 transition group">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-brand-red transition">Tambah Ekstrakurikuler</span>
                                <span class="text-xs text-gray-400 group-hover:text-brand-red transition">+</span>
                            </a>
                            <a href="{{ route('admin.galleries.create', $unit) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-800 hover:border-brand-red dark:hover:border-brand-red bg-gray-50/50 dark:bg-gray-900/20 transition group">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-brand-red transition">Buat Album Galeri</span>
                                <span class="text-xs text-gray-400 group-hover:text-brand-red transition">+</span>
                            </a>
                        </div>
                    </x-card>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
