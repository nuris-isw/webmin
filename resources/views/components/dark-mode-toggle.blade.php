<button 
    x-data="{ dark: document.documentElement.classList.contains('dark') }"
    @click="
        dark = !dark; 
        localStorage.setItem('webmin-theme', dark ? 'dark' : 'light'); 
        if (dark) { 
            document.documentElement.classList.add('dark'); 
        } else { 
            document.documentElement.classList.remove('dark'); 
        }
    "
    type="button" 
    class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-700 dark:hover:text-white focus:outline-none transition"
    aria-label="Toggle dark mode"
>
    <!-- Sun Icon (visible in dark mode) -->
    <svg x-show="dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M4.22 4.22l1.636 1.636m12.288 12.288l1.636 1.636M3 12h2.25m13.5 0H21M5.856 18.144l-1.636 1.636m12.288-12.288l1.636-1.636M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z" />
    </svg>
    <!-- Moon Icon (visible in light mode) -->
    <svg x-show="!dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="display: none;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
    </svg>
</button>
