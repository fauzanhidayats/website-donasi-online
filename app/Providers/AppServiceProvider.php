<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Paksa penggunaan HTTPS jika APP_URL mengandung 'ngrok'
        if (str_contains(env('APP_URL'), 'ngrok')) {
            URL::forceScheme('https');
        }

        // Atau, versi lebih fleksibel kalau kamu pakai selain ngrok juga
        // if (request()->isSecure() || str_contains(env('APP_URL'), 'ngrok')) {
        //     URL::forceScheme('https');
        // }
    }
}
