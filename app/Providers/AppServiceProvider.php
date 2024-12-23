<?php

namespace App\Providers;

use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Domain\Interfaces\Storage\LocalStorageRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Domain\Interfaces\User\UserTypeRepositoryInterface;
use App\Domain\Service\Proxy\HolidaysServiceInterface;
use App\Infrastructure\Eloquent\Company\CompanyRepository;
use App\Infrastructure\Eloquent\Scheduling\ScheduleSettingsRepository;
use App\Infrastructure\Eloquent\Stock\Product\ProductRepository;
use App\Infrastructure\Eloquent\User\UserRepository;
use App\Infrastructure\Eloquent\User\UserTypeRepository;
use App\Infrastructure\Services\Proxy\HolidaysService;
use App\Infrastructure\Storage\LocalStorageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Company
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);

        // Proxy
        $this->app->bind(HolidaysServiceInterface::class, HolidaysService::class);
        
        // Schedule
        $this->app->bind(ScheduleSettingsRepositoryInterface::class, ScheduleSettingsRepository::class);

        // Stock
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        // User
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserTypeRepositoryInterface::class, UserTypeRepository::class);

        // Storage
        $this->app->bind(LocalStorageRepositoryInterface::class, LocalStorageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
