<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se definen las rutas de la API. Estas rutas son cargadas por el 
| RouteServiceProvider dentro de un grupo que asigna el middleware "api".
|
*/

Route::apiResource('hotels', HotelController::class);

