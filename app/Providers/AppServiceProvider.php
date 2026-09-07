<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. បន្ថែមការ import URL facade ទីនេះ

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
        // 2. បង្ខំឱ្យប្រើ HTTPS នៅពេលរត់នៅលើ Production
        if ($this->app->environment('production')) {
            URL::forceHttps();
        }
    }
}