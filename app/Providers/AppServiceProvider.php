<?php

namespace App\Providers;

use App\Domain\Service\Proxy\HolidaysServiceInterface;
use App\Infrastructure\Service\Proxy\HolidaysService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HolidaysServiceInterface::class, HolidaysService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
