<x-guest-layout>
    <!-- Headings -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold tracking-tight text-dark dark:text-white">
            Selamat Datang Kembali
        </h1>
        <p class="text-sm text-gray-dark dark:text-gray-light mt-2">
            Kelola dasbor multi-tenant unit sekolah Anda di WebMin.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <!-- Google Login Button (F2-03) -->
    <div class="mb-6">
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-transparent rounded-md shadow-sm text-sm font-semibold text-gray-700 dark:text-white bg-white dark:bg-[#2D2D2D] hover:bg-gray-50 dark:hover:bg-[#3D3D3D] transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red dark:focus:ring-offset-dark">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" width="24" height="24">
                <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-5.187 4.114-3.513 0-6.38-2.867-6.38-6.38s2.867-6.38 6.38-6.38c1.6 0 3.038.588 4.143 1.57l3.057-3.057C19.29 2.505 15.997 1.25 12.24 1.25 6.175 1.25 1.25 6.175 1.25 12.24s4.925 10.99 10.99 10.99c6.643 0 11.236-4.67 11.236-11.236 0-.663-.06-1.3-.171-1.925H12.24Z"/>
            </svg>
            Masuk dengan Google
        </a>
    </div>

    <!-- Divider -->
    <div class="relative flex py-4 items-center">
        <div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
        <span class="flex-shrink mx-4 text-xs font-semibold text-gray-dark uppercase tracking-wider">Atau masuk dengan email</span>
        <div class="flex-grow border-t border-gray-200 dark:border-gray-700"></div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-brand-red hover:text-brand-red-light rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-brand-red shadow-sm focus:ring-brand-red focus:ring-offset-2 dark:focus:ring-offset-dark" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-2.5 text-sm">
                Masuk ke Dasbor
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
