<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('asset', function ($expression) {
            return "<?php echo \App\Helpers\AssetHelper::getUrl($expression); ?>";
        });
    }
}

if (!function_exists('school_asset')) {
    function school_asset(?string $path): string
    {
        return \App\Helpers\AssetHelper::getUrl($path);
    }
}

