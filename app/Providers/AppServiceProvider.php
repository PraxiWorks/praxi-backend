<?php

namespace App\Providers;

use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Core\Module\ModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanRepositoryInterface;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupPermissionRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserPermissionRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventProcedureRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRecurrenceRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventTypeRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventValidatorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Interfaces\Settings\Company\CompanyModuleRepositoryInterface;
use App\Domain\Interfaces\Settings\Company\CompanyPlanRepositoryInterface;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Domain\Interfaces\Storage\LocalStorageRepositoryInterface;
use App\Domain\Service\Proxy\HolidaysServiceInterface;
use App\Infrastructure\Eloquent\Core\Company\CompanyRepository;
use App\Infrastructure\Eloquent\Core\Module\ModuleRepository;
use App\Infrastructure\Eloquent\Core\Permission\ModulePermissionRepository;
use App\Infrastructure\Eloquent\Core\Permission\PermissionRepository;
use App\Infrastructure\Eloquent\Core\Plan\PlanModuleRepository;
use App\Infrastructure\Eloquent\Core\Plan\PlanRepository;
use App\Infrastructure\Eloquent\Register\Client\ClientRepository;
use App\Infrastructure\Eloquent\Register\Group\GroupRepository;
use App\Infrastructure\Eloquent\Register\User\GroupPermissionRepository;
use App\Infrastructure\Eloquent\Register\User\UserPermissionRepository;
use App\Infrastructure\Eloquent\Register\User\UserRepository;
use App\Infrastructure\Eloquent\Scheduling\EventColorRepository;
use App\Infrastructure\Eloquent\Scheduling\EventProcedureRepository;
use App\Infrastructure\Eloquent\Scheduling\EventRecurrenceRepository;
use App\Infrastructure\Eloquent\Scheduling\EventRepository;
use App\Infrastructure\Eloquent\Scheduling\EventStatusRepository;
use App\Infrastructure\Eloquent\Scheduling\EventTypeRepository;
use App\Infrastructure\Eloquent\Scheduling\ScheduleSettingsRepository;
use App\Infrastructure\Eloquent\Settings\Company\CompanyModuleRepository;
use App\Infrastructure\Eloquent\Settings\Company\CompanyPlanRepository;
use App\Infrastructure\Eloquent\Stock\Product\ProductRepository;
use App\Infrastructure\Eloquent\Stock\ProductCategory\ProductCategoryRepository;
use App\Infrastructure\Services\Proxy\HolidaysService;
use App\Infrastructure\Storage\LocalStorageRepository;
use App\Services\Scheduling\Event\EventValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Core
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ModuleRepositoryInterface::class, ModuleRepository::class);
        $this->app->bind(ModulePermissionRepositoryInterface::class, ModulePermissionRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(PlanModuleRepositoryInterface::class, PlanModuleRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);

        // Proxy
        $this->app->bind(HolidaysServiceInterface::class, HolidaysService::class);

        // Schedule
        $this->app->bind(ScheduleSettingsRepositoryInterface::class, ScheduleSettingsRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(EventTypeRepositoryInterface::class, EventTypeRepository::class);
        $this->app->bind(EventProcedureRepositoryInterface::class, EventProcedureRepository::class);
        $this->app->bind(EventStatusRepositoryInterface::class, EventStatusRepository::class);
        $this->app->bind(EventColorRepositoryInterface::class, EventColorRepository::class);
        $this->app->bind(EventRecurrenceRepositoryInterface::class, EventRecurrenceRepository::class);
        $this->app->bind(EventValidatorRepositoryInterface::class, EventValidator::class);

        // Stock
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);

        // Register
        $this->app->bind(GroupPermissionRepositoryInterface::class, GroupPermissionRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(UserPermissionRepositoryInterface::class, UserPermissionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);

        //Settings
        $this->app->bind(CompanyModuleRepositoryInterface::class, CompanyModuleRepository::class);
        $this->app->bind(CompanyPlanRepositoryInterface::class, CompanyPlanRepository::class);

        // Storage
        $this->app->bind(LocalStorageRepositoryInterface::class, LocalStorageRepository::class);
    }
}
