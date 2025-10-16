<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Milon\Barcode\BarcodeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(BarcodeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
        \URL::forceScheme('https');
        }
    }
}
