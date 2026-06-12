@php
    $unitParam = request()->route('unit');
    $sidebarUnit = null;
    if ($unitParam instanceof \App\Models\Unit) {
        $sidebarUnit = $unitParam;
    } elseif (is_string($unitParam)) {
        $sidebarUnit = \App\Models\Unit::where('slug', $unitParam)->first();
    } elseif (Auth::user()->unit) {
        $sidebarUnit = Auth::user()->unit;
    }
    $unitSlug = $sidebarUnit ? $sidebarUnit->slug : null;
@endphp

<div class="flex-1 flex flex-col justify-between overflow-y-auto">
    <nav class="px-4 py-6 space-y-7">
        
        @if (Auth::user()->isSuperadmin() && $sidebarUnit)
            <!-- Superadmin Active Control Scope Banner -->
            <div class="p-3 bg-brand-red/10 border border-brand-red/20 rounded-lg">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded bg-brand-red text-white flex items-center justify-center font-bold text-xs shrink-0">
                        {{ strtoupper($sidebarUnit->jenjang) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[9px] font-bold text-brand-red uppercase tracking-wider">Sedang Mengelola</p>
                        <p class="text-xs font-bold text-gray-900 dark:text-white truncate">
                            {{ $sidebarUnit->nama_sekolah }}
                        </p>
                    </div>
                </div>
                <div class="mt-2.5 pt-2 border-t border-brand-red/10 flex justify-between items-center text-[10px]">
                    <a href="{{ route('superadmin.units.show', $sidebarUnit) }}" class="text-brand-red hover:underline font-semibold">
                        Detail Unit
                    </a>
                    <a href="{{ route('superadmin.units.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-brand-red transition">
                        Tutup Kendali ×
                    </a>
                </div>
            </div>
        @endif

        <!-- Dashboard & Global Admin -->
        <div class="space-y-2">
            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4">
                Dasbor Utama
            </span>
            <div class="mt-2 space-y-1">
                <x-nav-link :href="Auth::user()->isSuperadmin() ? route('superadmin.dashboard') : ($unitSlug ? route('admin.dashboard', ['unit' => $unitSlug]) : route('dashboard'))" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('superadmin.dashboard')">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </x-nav-link>
                
                @if (Auth::user()->isSuperadmin())
                    <x-nav-link :href="route('superadmin.units.index')" :active="request()->routeIs('superadmin.units.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        Manajemen Unit
                    </x-nav-link>
                    <x-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        Manajemen Admin
                    </x-nav-link>
                @endif
            </div>
        </div>

        <!-- Identitas Sekolah -->
        @if (Auth::user()->isSuperadmin() || Auth::user()->unit_id !== null)
            <div class="space-y-2">
                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4">
                    Identitas & Profil
                </span>
                <div class="mt-2 space-y-1">
                    <x-nav-link :href="($unitSlug && Route::has('admin.profile.edit')) ? route('admin.profile.edit', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.profile.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                        Profil Sekolah
                    </x-nav-link>
                </div>
            </div>
        @endif

        <!-- Kesiswaan -->
        @if (Auth::user()->isSuperadmin() || Auth::user()->unit_id !== null)
            <div class="space-y-2">
                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4">
                    Data Kesiswaan
                </span>
                <div class="mt-2 space-y-1">
                    <x-nav-link :href="($unitSlug && Route::has('admin.achievements.index')) ? route('admin.achievements.index', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.achievements.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                        Prestasi
                    </x-nav-link>
                    <x-nav-link :href="($unitSlug && Route::has('admin.extracurriculars.index')) ? route('admin.extracurriculars.index', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.extracurriculars.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                        Ekstrakurikuler
                    </x-nav-link>
                </div>
            </div>
        @endif

        <!-- Publikasi -->
        @if (Auth::user()->isSuperadmin() || Auth::user()->unit_id !== null)
            <div class="space-y-2">
                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4">
                    Publikasi & Informasi
                </span>
                <div class="mt-2 space-y-1">
                    <x-nav-link :href="($unitSlug && Route::has('admin.news.index')) ? route('admin.news.index', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.news.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18c0 .621-.504 1.125-1.125 1.125H5.625M19.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5z" />
                        </svg>
                        Berita / Artikel
                    </x-nav-link>
                    <x-nav-link :href="($unitSlug && Route::has('admin.galleries.index')) ? route('admin.galleries.index', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.galleries.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Galeri Kegiatan
                    </x-nav-link>
                    <x-nav-link :href="($unitSlug && Route::has('admin.spmb.edit')) ? route('admin.spmb.edit', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.spmb.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m-5.8 0c-1.13.093-1.976 1.057-1.976 2.192V16.5A2.25 2.25 0 006.496 18.75h1.129" />
                        </svg>
                        Pengaturan SPMB
                    </x-nav-link>
                </div>
            </div>
        @endif

        <!-- Akademik SMK (Khusus SMK) -->
        @if (Auth::user()->isSuperadmin() || (Auth::user()->unit && Auth::user()->unit->isSmk()))
            <div class="space-y-2">
                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest px-4">
                    Kurikulum SMK
                </span>
                <div class="mt-2 space-y-1">
                    <x-nav-link :href="($unitSlug && Route::has('admin.majors.index')) ? route('admin.majors.index', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.majors.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        Manajemen Jurusan
                    </x-nav-link>
                </div>
            </div>
        @endif

    </nav>
</div>
