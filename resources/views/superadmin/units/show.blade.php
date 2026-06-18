<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
            <x-breadcrumb :items="[
                'Dashboard' => route('superadmin.dashboard'),
                'Manajemen Unit' => route('superadmin.units.index'),
                $unit->nama_sekolah => '#'
            ]" />

            <!-- Flash Notifications -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            <!-- Unit Identity Header Card -->
            <x-card>
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-brand-red/10 text-brand-red flex items-center justify-center font-extrabold text-2xl shrink-0">
                            {{ strtoupper($unit->jenjang) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                                {{ $unit->nama_sekolah }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Slug: <code class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700/50 rounded">{{ $unit->slug }}</code>
                                <span class="mx-2">•</span>
                                Status: 
                                @if ($unit->is_active)
                                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Aktif</span>
                                @else
                                    <span class="text-gray-400 font-semibold">Non-aktif</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('superadmin.units.edit', $unit) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Edit Unit
                        </a>
                    </div>
                </div>
            </x-card>

            <!-- Grid: Left side stats, Right side admins -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Side: Content Stats & Override Panel -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        
                        <!-- Berita -->
                        <div class="p-5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Berita</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['news'] }}</p>
                        </div>

                        <!-- Prestasi -->
                        <div class="p-5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Prestasi</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['achievements'] }}</p>
                        </div>

                        <!-- Ekskul -->
                        <div class="p-5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Ekstrakurikuler</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['extracurriculars'] }}</p>
                        </div>

                        <!-- Program / Jurusan -->
                        <div class="p-5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total {{ $unit->getMajorLabel() }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['majors'] }}</p>
                        </div>

                    </div>

                    <!-- Content Override Navigation Center (F4-07) -->
                    <x-card>
                        <x-slot name="title">
                            Pusat Kendali & Override Konten Unit (Superadmin)
                        </x-slot>
                        <x-slot name="subtitle">
                            Gunakan tombol di bawah untuk langsung menavigasi ke dasbor dan mengedit konten unit sekolah ini.
                        </x-slot>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                            
                            <a href="{{ Route::has('admin.profile.edit') ? route('admin.profile.edit', ['unit' => $unit->slug]) : '#' }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-800 hover:border-brand-red transition">
                                <div class="p-2 bg-brand-red/10 text-brand-red rounded">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-950 dark:text-white">Profil Sekolah</p>
                                    <p class="text-[10px] text-gray-500">Ubah identitas, visi, misi & kalender</p>
                                </div>
                            </a>

                            <a href="{{ Route::has('admin.news.index') ? route('admin.news.index', ['unit' => $unit->slug]) : '#' }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-800 hover:border-brand-red transition">
                                <div class="p-2 bg-brand-red/10 text-brand-red rounded">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 00-2-2m2 2a2 2 0 012 2v8a2 2 0 01-2 2h-3" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-950 dark:text-white">Berita & Artikel</p>
                                    <p class="text-[10px] text-gray-500">Kelola rilis berita sekolah</p>
                                </div>
                            </a>

                            <a href="{{ Route::has('admin.achievements.index') ? route('admin.achievements.index', ['unit' => $unit->slug]) : '#' }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-800 hover:border-brand-red transition">
                                <div class="p-2 bg-brand-red/10 text-brand-red rounded">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-950 dark:text-white">Prestasi Sekolah</p>
                                    <p class="text-[10px] text-gray-500">Kelola daftar pencapaian</p>
                                </div>
                            </a>

                            <a href="{{ Route::has('admin.extracurriculars.index') ? route('admin.extracurriculars.index', ['unit' => $unit->slug]) : '#' }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-800 hover:border-brand-red transition">
                                <div class="p-2 bg-brand-red/10 text-brand-red rounded">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.362 5.214A8.25 8.25 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-950 dark:text-white">Ekstrakurikuler</p>
                                    <p class="text-[10px] text-gray-500">Kelola kegiatan ekstrakurikuler</p>
                                </div>
                            </a>

                            <a href="{{ Route::has('admin.spmb.edit') ? route('admin.spmb.edit', ['unit' => $unit->slug]) : '#' }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-800 hover:border-brand-red transition">
                                <div class="p-2 bg-brand-red/10 text-brand-red rounded">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-950 dark:text-white">Penerimaan Siswa (SPMB)</p>
                                    <p class="text-[10px] text-gray-500">Atur status pendaftaran PPDB</p>
                                </div>
                            </a>

                            <a href="{{ Route::has('admin.majors.index') ? route('admin.majors.index', ['unit' => $unit->slug]) : '#' }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-800 hover:border-brand-red transition">
                                <div class="p-2 bg-brand-red/10 text-brand-red rounded">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-950 dark:text-white">{{ $unit->getMajorLabel() }}</p>
                                    <p class="text-[10px] text-gray-500">Kelola {{ strtolower($unit->getMajorLabel()) }} sekolah</p>
                                </div>
                            </a>

                        </div>
                    </x-card>

                </div>

                <!-- Right Side: Assigned Administrators -->
                <div>
                    <x-card>
                        <x-slot name="title">
                            Admin Pengelola ({{ count($unit->users) }})
                        </x-slot>

                        <div class="mt-4 space-y-4">
                            @forelse ($unit->users as $admin)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-800">
                                    <div class="w-8 h-8 rounded-full bg-brand-red/10 text-brand-red flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ substr($admin->name, 0, 2) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-gray-900 dark:text-white truncate">
                                            {{ $admin->name }}
                                        </p>
                                        <p class="text-[10px] text-gray-500 truncate">
                                            {{ $admin->email }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-400 text-xs bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-dashed border-gray-200 dark:border-gray-800">
                                    Belum ada administrator yang ditugaskan ke sekolah ini.
                                </div>
                            @endforelse

                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                <a href="{{ route('superadmin.users.create', ['unit_id' => $unit->id]) }}" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-800 hover:bg-gray-50 transition">
                                    + Tugaskan Admin
                                </a>
                            </div>
                        </div>
                    </x-card>
                </div>

            </div>
    </div>
</x-app-layout>
