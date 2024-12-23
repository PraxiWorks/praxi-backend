<?php

use App\Http\Controllers\Stock\ProductController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Proxy\HolidaysController;
use App\Http\Controllers\Scheduling\ScheduleSettings\ScheduleSettingsController;
use App\Http\Controllers\Signup\SignupController;
use App\Http\Controllers\User\UserController;
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
    Route::post('login', [LoginController::class, 'login']);
    Route::post('signup', [SignupController::class, 'store']);
});

Route::middleware('auth')->group(function () {

    Route::prefix('{companyId}')->group(function () {

        // Route::prefix('login')->group(function () {
        //     Route::post('', [signupController::class, 'store']);
        // });

        //Configurações Agenda
        Route::prefix('schedule-settings')->group(function () {
            Route::post('/', [ScheduleSettingsController::class, 'store']);
            Route::get('', [ScheduleSettingsController::class, 'index']);
            Route::put('/{configId}', [ScheduleSettingsController::class, 'update']);
        });

        // Eventos
        // Route::prefix('eventos')->group(function () {
        //     Route::post('/', [EventController::class, 'store']);  // Criar evento
        //     Route::get('/', [EventController::class, 'index']);   // Listar eventos
        //     Route::get('/{eventoId}', [EventController::class, 'show']);  // Mostrar evento
        //     Route::put('/{eventoId}', [EventController::class, 'update']);  // Atualizar evento
        //     Route::delete('/{eventoId}', [EventController::class, 'delete']);  // Deletar evento
        // });

        // // Estoque
        Route::prefix('stock')->group(function () {
            Route::prefix('products')->group(function () {
                Route::post('/', [ProductController::class, 'store']);
                Route::get('', [ProductController::class, 'index']);
                Route::get('/{productId}', [ProductController::class, 'show']);
                Route::put('/{productId}', [ProductController::class, 'update']);
                Route::delete('/{productId}', [ProductController::class, 'delete']);
            });
        });

        // Usuários
        Route::prefix('users')->group(function () {
            Route::post('/', [UserController::class, 'store']);
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{userId}', [UserController::class, 'show']);
            Route::put('/{userId}', [UserController::class, 'update']);
            Route::delete('/{userId}', [UserController::class, 'delete']);
        });

        // // Clientes
        // Route::prefix('clientes')->group(function () {
        //     Route::post('/', [ClientController::class, 'store']);
        //     Route::get('/', [ClientController::class, 'index']);
        //     Route::get('/{clientId}', [ClientController::class, 'show']);
        //     Route::put('/{clientId}', [ClientController::class, 'update']);
        //     Route::delete('/{clientId}', [ClientController::class, 'delete']);
        // });
    })->middleware('validateCompany');
});
