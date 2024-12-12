<?php

namespace App\Providers;

use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Service\Proxy\HolidaysServiceInterface;
use App\Infrastructure\Eloquent\Company\CompanyRepository;
use App\Infrastructure\Eloquent\Scheduling\ScheduleSettingsRepository;
use App\Infrastructure\Service\Proxy\HolidaysService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Company
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);

        // Proxy
        $this->app->bind(HolidaysServiceInterface::class, HolidaysService::class);
        
        // Schedule
        $this->app->bind(ScheduleSettingsRepositoryInterface::class, ScheduleSettingsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
