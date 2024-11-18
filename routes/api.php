<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\TipoMantenimientoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\DetalleManVehiculoController;
use App\Http\Controllers\DetallePresDispositivoController;
use App\Http\Controllers\DetallePresVehiculoController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaRepuestoController;
use App\Http\Controllers\ModeloRepuestoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\RepuestoUsadoController;
use App\Http\Controllers\TipoDispositivoController;
use App\Http\Controllers\TipoRepuestoController;
use App\Http\Middleware\ApiAuthMiddleware;
use App\Models\DetallePresDispositivo;
use App\Models\DetallePresVehiculo;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
Route::post('/user', [UserController::class, 'store']);
Route::post('/user/login', [UserController::class,'login']);
Route::get('/user/getIdentity', [UserController::class,'getIdentity']);
Route::resource('/Departamento', DepartamentoController::class, ['except'=> ['create','edit']]);
Route::resource('/Empleado', EmpleadoController::class, ['except'=> ['create','edit']]);
Route::resource('/Mantenimiento', MantenimientoController::class, ['except'=> ['create','edit']]);
Route::resource('/TipoMantenimiento', TipoMantenimientoController::class, ['except'=> ['create','edit']]);
Route::resource('/Vehiculo', VehiculoController::class, ['except'=> ['create','edit']]);
Route::resource('/DetalleManVehiculo', DetalleManVehiculoController::class, ['except'=> ['create','edit']]);
Route::resource('/MarcaRepuesto', MarcaRepuestoController::class, ['except'=> ['create','edit']]);
Route::resource('/ModeloRepuesto', ModeloRepuestoController::class, ['except'=> ['create','edit']]);
Route::resource('/Repuesto', RepuestoController::class, ['except'=> ['create','edit']]);
Route::resource('/RepuestoUsado', RepuestoUsadoController::class, ['except'=> ['create','edit']]);
Route::resource('/TipoRepuesto', TipoRepuestoController::class, ['except'=> ['create','edit']]);
Route::resource('/TipoDispositivo', TipoDispositivoController::class, ['except'=> ['create','edit']]);
Route::resource('/Dispositivo', DispositivoController::class, ['except'=> ['create','edit']]);
Route::resource('/DetallePresDispositivo', DetallePresDispositivoController::class, ['except'=> ['create','edit']]);
Route::resource('/DetallePresVehiculo', DetallePresVehiculoController::class, ['except'=> ['create','edit']]);
Route::resource('/Prestamo', PrestamoController::class, ['except'=> ['create','edit']]);
Route::resource('/user', UserController::class, ['only' => ['index', 'show','destroy']])->middleware(ApiAuthMiddleware::class);
});