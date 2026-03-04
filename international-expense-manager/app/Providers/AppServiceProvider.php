<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\AddressLookupInterface::class,
            \App\Infrastructure\Services\ViaCepService::class
        );
        $this->app->bind(
            \App\Domain\Repositories\CurrencyConverterInterface::class,
            \App\Infrastructure\Services\AwesomeCurrencyService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
