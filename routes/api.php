<?php

use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Proxy\HolidaysController;
use App\Http\Controllers\Register\Client\ClientController;
use App\Http\Controllers\Register\ClientAddress\ClientAddressController;
use App\Http\Controllers\Scheduling\ScheduleSettings\ScheduleSettingsController;
use App\Http\Controllers\Signup\SignupController;
use App\Http\Controllers\Register\User\UserController;
use App\Http\Controllers\Scheduling\Event\EventController;
use App\Http\Controllers\Settings\EventProcedure\EventProcedureController;
use App\Http\Controllers\Settings\Group\GroupController;
use App\Http\Controllers\Stock\Product\ProductController;
use App\Http\Controllers\Stock\ProductCategory\ProductCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('proxy')->group(function () {
    Route::get('/feriados/{month}/{year}', [HolidaysController::class, 'index']);
});

Route::prefix('auth')->group(function () {
    Route::post('signup', [SignupController::class, 'store']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {

    Route::prefix('{companyId}')->group(function () {

        // Agendamento
        Route::prefix('scheduling')->group(function () {
            // Configurações Agenda
            Route::prefix('schedule-settings')->group(function () {
                Route::post('/', [ScheduleSettingsController::class, 'store'])->middleware('permission:scheduling.scheduleSettings.store');
                Route::get('', [ScheduleSettingsController::class, 'index'])->middleware('permission:scheduling.scheduleSettings.list');
                Route::put('/{configId}', [ScheduleSettingsController::class, 'update'])->middleware('permission:scheduling.scheduleSettings.update');
            });

            // Eventos
            Route::prefix('events')->group(function () {
                Route::post('/', [EventController::class, 'store'])->middleware('permission:scheduling.event.store');
                Route::get('/', [EventController::class, 'index'])->middleware('permission:scheduling.event.list');
                Route::get('/{eventId}', [EventController::class, 'show'])->middleware('permission:scheduling.event.show');
                Route::put('/{eventId}', [EventController::class, 'update'])->middleware('permission:scheduling.event.update');
                Route::delete('/{eventId}', [EventController::class, 'delete'])->middleware('permission:scheduling.event.delete');
            });
        });

        // Estoque
        Route::prefix('stock')->group(function () {
            // Produtos
            Route::prefix('products')->group(function () {
                Route::post('/', [ProductController::class, 'store'])->middleware('permission:stock.product.store');
                Route::get('', [ProductController::class, 'index'])->middleware('permission:stock.product.list');
                Route::get('/{productId}', [ProductController::class, 'show'])->middleware('permission:stock.product.show');
                Route::put('/{productId}', [ProductController::class, 'update'])->middleware('permission:stock.product.update');
                Route::delete('/{productId}', [ProductController::class, 'delete'])->middleware('permission:stock.product.delete');
            });

            // Categorias de Produtos
            Route::prefix('product-categories')->group(function () {
                Route::post('/', [ProductCategoryController::class, 'store']);
                Route::get('/', [ProductCategoryController::class, 'index']);
                Route::get('/{productCategoryId}', [ProductCategoryController::class, 'show']);
                Route::put('/{productCategoryId}', [ProductCategoryController::class, 'update']);
                Route::delete('/{productCategoryId}', [ProductCategoryController::class, 'delete']);
            });
        });

        // Cadastros
        Route::prefix('register')->group(function () {
            // Usuários
            Route::prefix('users')->group(function () {
                Route::post('/', [UserController::class, 'store'])->middleware('permission:system.user.store');
                Route::get('/', [UserController::class, 'index'])->middleware('permission:system.user.list');
                Route::get('/{userId}', [UserController::class, 'show'])->middleware('permission:system.user.show');
                Route::put('/{userId}', [UserController::class, 'update'])->middleware('permission:system.user.update');
                Route::delete('/{userId}', [UserController::class, 'delete'])->middleware('permission:system.user.delete');
            });

            // Clientes
            Route::prefix('clients')->group(function () {
                Route::post('/', [ClientController::class, 'store'])->middleware('permission:system.client.store');
                Route::get('/', [ClientController::class, 'index'])->middleware('permission:system.client.list');
                Route::get('/{clientId}', [ClientController::class, 'show'])->middleware('permission:system.client.show');
                Route::put('/{clientId}', [ClientController::class, 'update'])->middleware('permission:system.client.update');
                Route::delete('/{clientId}', [ClientController::class, 'delete'])->middleware('permission:system.client.delete');
            });

            // Clientes Endereços
            Route::prefix('client-addresses')->group(function () {
                Route::post('/', [ClientAddressController::class, 'store'])->middleware('permission:system.clientAddress.store');
                Route::get('/', [ClientAddressController::class, 'index'])->middleware('permission:system.clientAddress.list');
                Route::get('/{clientAddressId}', [ClientAddressController::class, 'show'])->middleware('permission:system.clientAddress.show');
                Route::put('/{clientAddressId}', [ClientAddressController::class, 'update'])->middleware('permission:system.clientAddress.update');
                Route::delete('/{clientAddressId}', [ClientAddressController::class, 'delete'])->middleware('permission:system.clientAddress.delete');
            });
        });

        // Configurações
        Route::prefix('settings')->group(function () {
            // Grupos de permissões
            Route::prefix('groups')->group(function () {
                Route::post('/', [GroupController::class, 'store'])->middleware('permission:system.group.store');
                Route::get('/', [GroupController::class, 'index'])->middleware('permission:system.group.list');
                Route::get('/{groupId}', [GroupController::class, 'show'])->middleware('permission:system.group.show');
                Route::put('/{groupId}', [GroupController::class, 'update'])->middleware('permission:system.group.update');
                Route::delete('/{groupId}', [GroupController::class, 'delete'])->middleware('permission:system.group.delete');
            });

            // Cadastro de procedimentos
            Route::prefix('event-procedures')->group(function () {
                Route::post('/', [EventProcedureController::class, 'store'])->middleware('permission:scheduling.eventProcedure.store');
                Route::get('/', [EventProcedureController::class, 'index'])->middleware('permission:scheduling.eventProcedure.list');
                Route::get('/{eventProcedureId}', [EventProcedureController::class, 'show'])->middleware('permission:scheduling.eventProcedure.show');
                Route::put('/{eventProcedureId}', [EventProcedureController::class, 'update'])->middleware('permission:scheduling.eventProcedure.update');
                Route::delete('/{eventProcedureId}', [EventProcedureController::class, 'delete'])->middleware('permission:scheduling.eventProcedure.delete');
            });
        });
    })->middleware('validateCompany');
});
