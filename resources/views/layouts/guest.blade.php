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
    <body class="font-sans antialiased text-dark dark:text-white bg-white dark:bg-dark">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Left Side: Form Container -->
            <div class="w-full md:w-[45%] lg:w-[40%] flex flex-col justify-between px-6 py-12 sm:px-12 lg:px-16 bg-white dark:bg-dark z-10 min-h-screen">
                <div class="my-auto w-full max-w-md mx-auto">
                    <!-- Mobile Logo -->
                    <div class="flex md:hidden justify-center mb-8">
                        <a href="/" class="p-3 bg-white rounded-[15px] shadow-sm inline-block">
                            <x-application-logo class="h-12 w-auto" />
                        </a>
                    </div>
                    
                    <!-- Form Slot -->
                    <div class="mt-4">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <footer class="w-full max-w-md mx-auto mt-8 pt-6 border-t border-gray-100 dark:border-gray-800/80 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} Web Admin. Hak Cipta Dilindungi.
                    </p>
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">
                        Multi-tenant platform untuk pengelolaan unit sekolah.
                    </p>
                </footer>
            </div>

            <!-- Right Side: Stunning Visual Brand Panel -->
            <div class="hidden md:flex md:w-[55%] lg:w-[60%] relative overflow-hidden bg-gradient-to-br from-brand-red-light via-brand-red to-brand-red-deep items-center justify-center p-12 lg:p-16">
                <!-- Decorative Subtle Grid Overlay -->
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:24px_24px]"></div>
                
                <!-- Glowing Decorative Circles -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 rounded-full bg-brand-red-deep opacity-30 blur-3xl"></div>
                
                <div class="relative z-10 max-w-lg text-white">
                    <div class="mb-8 inline-block p-4 bg-white rounded-[15px] shadow-sm">
                        <x-application-logo class="h-16 w-auto" />
                    </div>
                    
                    <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight text-white border-none p-0 mb-4 drop-shadow-md">
                        Satu Dasbor Terpadu Untuk Seluruh Unit Sekolah
                    </h2>
                    
                    <p class="text-lg text-white/90 font-medium leading-relaxed drop-shadow-sm">
                        Kelola identitas, informasi akademik, kesiswaan, prestasi, dan publikasi sekolah dalam satu ekosistem multi-tenant yang terintegrasi.
                    </p>
                    
                    <div class="mt-12 flex items-center gap-4 text-xs font-semibold uppercase tracking-widest text-white/70">
                        <span>Web Admin Platform</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
                        <span>Multi-Tenant CMS</span>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>
