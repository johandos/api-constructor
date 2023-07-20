<?php

use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\ObraController;
use App\Http\Controllers\Api\PolizasController;
use App\Http\Controllers\Api\UsuariosController;
use App\Http\Controllers\Api\VehiculoController;
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

Route::apiResource('polizas', PolizasController::class);
Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('usuarios', UsuariosController::class);
Route::apiResource('vehiculos', VehiculoController::class);
Route::post('vehiculos/search', [VehiculoController::class, 'search'])->name('vehiculos.search');
Route::apiResource('obras', ObraController::class);
