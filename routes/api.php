<?php

use App\Http\Controllers\Api\CompaniesController;
use App\Http\Controllers\Api\ConstructionsController;
use App\Http\Controllers\Api\PolicesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VehiclesController;
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

Route::apiResource('polizas', PolicesController::class);
Route::apiResource('empresas', CompaniesController::class);
Route::apiResource('usuarios', UsersController::class);
Route::apiResource('vehiculos', VehiclesController::class);
Route::post('vehiculos/search', [VehiclesController::class, 'search'])->name('vehiculos.search');
Route::apiResource('obras', ConstructionsController::class);
