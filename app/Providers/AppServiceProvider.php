<?php

namespace App\Providers;

use App\Domain\Factories\Http\HttpFactory;
use App\Domain\Interfaces\Core\Company\CompanyModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Company\CompanyPlanRepositoryInterface;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Core\Module\ModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanRepositoryInterface;
use App\Domain\Interfaces\Http\HttpRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Customer\StripeCustomerRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Method\Card\StripeCustomerCardRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Refund\StripeRefundRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Subscription\StripeSubscriptionRepositoryInterface;
use App\Domain\Interfaces\Payments\Stripe\Transaction\StripeTransactionRepositoryInterface;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRecurrenceRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventValidatorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\ScheduleSettingsRepositoryInterface;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;
use App\Domain\Interfaces\Storage\LocalStorageRepositoryInterface;
use App\Domain\Service\Payments\Customer\CustomerGatewayInterface;
use App\Domain\Service\Payments\PaymentMethod\Card\CardGatewayInterface;
use App\Domain\Service\Payments\Refund\RefundGatewayInterface;
use App\Domain\Service\Payments\Subscription\SubscriptionGatewayInterface;
use App\Domain\Service\Proxy\HolidaysServiceInterface;
use App\Infrastructure\Eloquent\Core\Company\CompanyModuleRepository;
use App\Infrastructure\Eloquent\Core\Company\CompanyPlanRepository;
use App\Infrastructure\Eloquent\Core\Company\CompanyRepository;
use App\Infrastructure\Eloquent\Core\Module\ModuleRepository;
use App\Infrastructure\Eloquent\Core\Permission\ModulePermissionRepository;
use App\Infrastructure\Eloquent\Core\Permission\PermissionRepository;
use App\Infrastructure\Eloquent\Core\Plan\PlanModuleRepository;
use App\Infrastructure\Eloquent\Core\Plan\PlanRepository;
use App\Infrastructure\Eloquent\Payments\Stripe\Customer\StripeCustomerRepository;
use App\Infrastructure\Eloquent\Payments\Stripe\Method\Card\StripeCustomerCardRepository;
use App\Infrastructure\Eloquent\Payments\Stripe\Refund\StripeRefundRepository;
use App\Infrastructure\Eloquent\Payments\Stripe\Subscription\StripeSubscriptionRepository;
use App\Infrastructure\Eloquent\Payments\Stripe\Transaction\StripeTransactionRepository;
use App\Infrastructure\Eloquent\Register\Client\ClientRepository;
use App\Infrastructure\Eloquent\Register\ClientAddress\ClientAddressRepository;
use App\Infrastructure\Eloquent\Register\User\UserRepository;
use App\Infrastructure\Eloquent\Register\UserPermission\UserPermissionRepository;
use App\Infrastructure\Eloquent\Scheduling\EventColorRepository;
use App\Infrastructure\Eloquent\Scheduling\EventRecurrenceRepository;
use App\Infrastructure\Eloquent\Scheduling\EventRepository;
use App\Infrastructure\Eloquent\Scheduling\EventStatusRepository;
use App\Infrastructure\Eloquent\Scheduling\ScheduleSettingsRepository;
use App\Infrastructure\Eloquent\Settings\EventProcedure\EventProcedureRepository;
use App\Infrastructure\Eloquent\Settings\Group\GroupRepository;
use App\Infrastructure\Eloquent\Settings\GroupPermission\GroupPermissionRepository;
use App\Infrastructure\Eloquent\Stock\Product\ProductRepository;
use App\Infrastructure\Eloquent\Stock\ProductCategory\ProductCategoryRepository;
use App\Infrastructure\Eloquent\Stock\Supplier\SupplierRepository;
use App\Infrastructure\Services\Payments\MercadoPago\Refund\MercadoPagoRefundGateway;
use App\Infrastructure\Services\Payments\Stripe\Customer\StripeCustomerGateway;
use App\Infrastructure\Services\Payments\Stripe\Method\Card\StripeCardGateway;
use App\Infrastructure\Services\Payments\Stripe\Refund\StripeRefundGateway;
use App\Infrastructure\Services\Payments\Stripe\Subscription\StripeSubscriptionGateway;
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
        $this->app->bind(CompanyModuleRepositoryInterface::class, CompanyModuleRepository::class);
        $this->app->bind(CompanyPlanRepositoryInterface::class, CompanyPlanRepository::class);
        $this->app->bind(ModuleRepositoryInterface::class, ModuleRepository::class);
        $this->app->bind(ModulePermissionRepositoryInterface::class, ModulePermissionRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(PlanModuleRepositoryInterface::class, PlanModuleRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);

        // Proxy
        $this->app->bind(HolidaysServiceInterface::class, HolidaysService::class);

        // Http
        $this->app->bind(HttpRepositoryInterface::class, HttpFactory::new(env('HTTP_CLIENT')));

        // Schedule
        $this->app->bind(ScheduleSettingsRepositoryInterface::class, ScheduleSettingsRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(EventStatusRepositoryInterface::class, EventStatusRepository::class);
        $this->app->bind(EventColorRepositoryInterface::class, EventColorRepository::class);
        $this->app->bind(EventRecurrenceRepositoryInterface::class, EventRecurrenceRepository::class);
        $this->app->bind(EventValidatorRepositoryInterface::class, EventValidator::class);

        // Stock
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);

        // Register
        $this->app->bind(UserPermissionRepositoryInterface::class, UserPermissionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ClientAddressRepositoryInterface::class, ClientAddressRepository::class);

        // Settings
        $this->app->bind(GroupPermissionRepositoryInterface::class, GroupPermissionRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(EventProcedureRepositoryInterface::class, EventProcedureRepository::class);

        // Storage
        $this->app->bind(LocalStorageRepositoryInterface::class, LocalStorageRepository::class);

        // Payments - Stripe Integrations
        $this->app->bind(CustomerGatewayInterface::class, StripeCustomerGateway::class);
        $this->app->bind(CardGatewayInterface::class, StripeCardGateway::class);
        $this->app->bind(SubscriptionGatewayInterface::class, StripeSubscriptionGateway::class);
        $this->app->bind(RefundGatewayInterface::class, StripeRefundGateway::class);

        // Payments - Stripe Repositories
        $this->app->bind(StripeCustomerRepositoryInterface::class, StripeCustomerRepository::class);
        $this->app->bind(StripeCustomerCardRepositoryInterface::class, StripeCustomerCardRepository::class);
        $this->app->bind(StripeSubscriptionRepositoryInterface::class, StripeSubscriptionRepository::class);
        $this->app->bind(StripeTransactionRepositoryInterface::class, StripeTransactionRepository::class);
        $this->app->bind(StripeRefundRepositoryInterface::class, StripeRefundRepository::class);
    }
}
