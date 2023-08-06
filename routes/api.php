<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CompaniesController;
use App\Http\Controllers\Api\ConstructionsController;
use App\Http\Controllers\Api\PolicesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VehiclesController;
use Illuminate\Support\Facades\Route;

/**
 * Auth User
**/
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth:sanctum')->group(function (){
    Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::apiResource('polizas', PolicesController::class);
    Route::get('polizas_search', [PolicesController::class, 'search'])->name('polizas.search');
    Route::apiResource('empresas', CompaniesController::class);
    Route::get('empresas_search', [CompaniesController::class, 'search'])->name('empresas.search');
    Route::apiResource('usuarios', UsersController::class);
    Route::get('usuarios_search', [UsersController::class, 'search'])->name('usuarios.search');
    Route::apiResource('vehiculos', VehiclesController::class);
    Route::get('vehiculos_search', [VehiclesController::class, 'search'])->name('vehiculos.search');
    Route::apiResource('obras', ConstructionsController::class);
    Route::get('obras_search', [ConstructionsController::class, 'search'])->name('obras.search');
});
