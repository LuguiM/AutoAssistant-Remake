<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\controllers\PerfilMecanicoController;
use App\Http\controllers\ServiciosMecanicosController;
use Illuminate\Http\Request;
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

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('auth/logout', [AuthController::class, 'logout']);

    //Rutas para el perfil del usuario
    Route::get('users/{id}', [UserController::class, 'showUser']);

    //Rutas para perfil mecanico
    Route::get('verificarPerfil/{id}', [PerfilMecanicoController::class,'verificarPerfil']);
    Route::get('perfilMecanico', [PerfilMecanicoController::class, 'index']);
    Route::post('perfilMecanico/crear', [PerfilMecanicoController::class,'store']);
    Route::get('perfilMecanico/{id}', [PerfilMecanicoController::class ,'show']);
    Route::get('perfilMecanico/perfiles/{id}', [PerfilMecanicoController::class ,'showPerfil']);


    
    //Rutas para servicio mecanicos
    Route::get('servicio-mecanico',[ServiciosMecanicosController::class, 'index']);
    Route::get('servicio-mecanico/inscritos/{id}',[ServiciosMecanicosController::class, 'serviciosInscritos']);
    Route::post('servicio-mecanico',[ServiciosMecanicosController::class,'store']);
    Route::get('servicio-mecanico/{id}',[ServiciosMecanicosController::class, 'show']);



});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
