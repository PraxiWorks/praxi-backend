<?php

use App\Http\Controllers\Proxy\HolidaysController;
use App\Http\Controllers\Scheduling\ScheduleSettingsController;
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

Route::prefix('{companyId}')->group(function () {

    //Configurações Agenda
    Route::prefix('schedule-settings')->group(function () {
        Route::post('', [ScheduleSettingsController::class, 'store']);
        Route::get('', [ScheduleSettingsController::class, 'index']);
        Route::put('/{configId}', [ScheduleSettingsController::class, 'update']);
    });

    // Eventos
    // Route::prefix('eventos')->group(function () {
    //     Route::post('/', [EventController::class, 'store']);  // Criar evento
    //     Route::get('/', [EventController::class, 'index']);   // Listar eventos
    //     Route::get('/{eventoId}', [EventController::class, 'show']);  // Mostrar evento
    //     Route::put('/{eventoId}', [EventController::class, 'update']);  // Atualizar evento
    //     Route::delete('/{eventoId}', [EventController::class, 'destroy']);  // Deletar evento
    // });

    // // Estoque
    // Route::prefix('estoque')->group(function () {
    //     Route::post('/', [ItemController::class, 'store']);
    //     Route::get('/', [ItemController::class, 'index']);
    //     Route::get('/{itemId}', [ItemController::class, 'show']);
    //     Route::put('/{itemId}', [ItemController::class, 'update']);
    //     Route::delete('/{itemId}', [ItemController::class, 'destroy']);
    // });

    // // Usuários
    // Route::prefix('usuarios')->group(function () {
    //     Route::post('/', [UserController::class, 'store']);
    //     Route::get('/', [UserController::class, 'index']);
    //     Route::get('/{userId}', [UserController::class, 'show']);
    //     Route::put('/{userId}', [UserController::class, 'update']);
    //     Route::delete('/{userId}', [UserController::class, 'destroy']);
    // });

    // // Clientes
    // Route::prefix('clientes')->group(function () {
    //     Route::post('/', [ClientController::class, 'store']);
    //     Route::get('/', [ClientController::class, 'index']);
    //     Route::get('/{clientId}', [ClientController::class, 'show']);
    //     Route::put('/{clientId}', [ClientController::class, 'update']);
    //     Route::delete('/{clientId}', [ClientController::class, 'destroy']);
    // });
});
