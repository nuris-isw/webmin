<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts: Plus Jakarta Sans (Design System) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Dark mode: inject class before render to prevent flash -->
        <script>
            (function () {
                var saved = localStorage.getItem('webmin-theme');
                if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-dark dark:text-white bg-gray-50 dark:bg-dark">
        
        <!-- App Container with Alpine.js off-canvas sidebar state -->
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
            
            <!-- 1. Desktop Sidebar -->
            <aside class="hidden md:flex flex-col w-64 bg-white dark:bg-[#121212] border-r border-gray-200 dark:border-gray-800 shrink-0">
                <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <x-application-logo class="h-9 w-auto" />
                        <span class="font-extrabold text-lg tracking-tight text-gray-900 dark:text-white">
                            WebMin
                        </span>
                    </a>
                </div>
                
                <!-- Dynamic Navigation Component -->
                <x-nav-sidebar />
                
                <!-- Bottom Info / User profile quick link -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-[#0c0c0c]/30">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-brand-red/10 text-brand-red flex items-center justify-center font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-[10px] text-gray-500 truncate">
                                {{ Auth::user()->role === 'superadmin' ? 'Superadmin (Yayasan)' : 'Admin Unit' }}
                            </p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- 2. Mobile Sidebar Off-canvas Drawer -->
            <div x-show="sidebarOpen" class="relative z-50 md:hidden" x-ref="dialog" role="dialog" aria-modal="true" style="display: none;">
                <!-- Backdrop overlay -->
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                     @click="sidebarOpen = false"></div>

                <div class="fixed inset-0 flex">
                    <!-- Drawer container -->
                    <div x-show="sidebarOpen" 
                         x-transition:enter="transition ease-in-out duration-300 transform"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transition ease-in-out duration-300 transform"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="relative mr-16 flex w-full max-w-xs flex-1 flex-col bg-white dark:bg-[#121212] border-r border-gray-200 dark:border-gray-800"
                         @click.away="sidebarOpen = false">
                        
                        <!-- Close button -->
                        <div class="absolute top-0 right-0 -mr-12 pt-4">
                            <button @click="sidebarOpen = false" type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="sr-only">Close sidebar</span>
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Sidebar Header -->
                        <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-800">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                                <x-application-logo class="h-9 w-auto" />
                                <span class="font-extrabold text-lg tracking-tight text-gray-900 dark:text-white">
                                    WebMin
                                </span>
                            </a>
                        </div>

                        <!-- Dynamic Navigation -->
                        <x-nav-sidebar />
                    </div>
                </div>
            </div>

            <!-- 3. Right Panel (Header + Content) -->
            <div class="flex-1 flex flex-col min-w-0">
                
                <!-- Top Header Bar -->
                <header class="h-16 bg-white dark:bg-[#121212] border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-4 sm:px-6 z-20 shadow-sm shrink-0">
                    
                    <!-- Left: Hamburger toggle (mobile only) -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" type="button" class="p-2 -ml-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-700 dark:hover:text-white md:hidden">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Right: Dark mode toggle & User Profile Dropdown -->
                    <div class="flex items-center gap-4">
                        
                        <!-- Dark Mode Toggle Component -->
                        <x-dark-mode-toggle />
                        
                        <!-- User Profile Settings Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-1.5 border border-gray-200 dark:border-gray-800 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/80 focus:outline-none transition">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="fill-current h-4 w-4 ms-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    Ubah Profil
                                </x-dropdown-link>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        Keluar Sesi
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>

                    </div>
                </header>

                <!-- Page Main Content area -->
                <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-dark p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
                
            </div>
            
        </div>
    </body>
</html>
