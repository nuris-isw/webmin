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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                        Manajemen Unit
                    </x-nav-link>
                    <x-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 21m-5.34-2.236a9.19 9.19 0 01-1.397-1.107 4.125 4.125 0 007.533-2.493M10.089 21a11.332 11.332 0 01-5.34-2.236m5.34 2.236v-.003a9.202 9.202 0 003.61-3.003m3.75 3.003A11.33 11.33 0 0015 19.128M15 3.987a3 3 0 11-3 3M12 3.987a3 3 0 113 3m-3-3a3.75 3.75 0 100 7.5c.447 0 .875-.079 1.272-.224l-.17-.34M3.75 16.5a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zm16.5 0a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-2.25a1.125 1.125 0 00-1.125 1.125V18.75m9 0t-9 0M9 3.75h6M9 3.75a3 3 0 00-3 3v2.25a3 3 0 003 3h6a3 3 0 003-3V6.75a3 3 0 00-3-3M9 3.75h6" />
                        </svg>
                        Prestasi
                    </x-nav-link>
                    <x-nav-link :href="($unitSlug && Route::has('admin.extracurriculars.index')) ? route('admin.extracurriculars.index', ['unit' => $unitSlug]) : '#'" :active="request()->routeIs('admin.extracurriculars.*')">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.25 8.25 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.9c2.785 0 5.48-.233 8.102-.684a60.457 60.457 0 00-.491-6.347m-15.382 0a48.536 48.536 0 00-3.088-3.97c-1.077-1.077-1.077-2.823 0-3.9a48.4 48.4 0 013.088-3.97m15.382 0a48.536 48.536 0 013.088 3.97c1.077 1.077 1.077 2.823 0 3.9a48.4 48.4 0 01-3.088 3.97m-15.382 0l3.088-3.97m12.294 3.97l-3.088-3.97m-9.206 0a48.536 48.536 0 019.206 0m-9.206 0V6.75m9.206 0V6.75" />
                        </svg>
                        Manajemen Jurusan
                    </x-nav-link>
                </div>
            </div>
        @endif

    </nav>
</div>
