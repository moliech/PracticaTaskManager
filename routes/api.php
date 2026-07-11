<?php
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::apiResource('tareas', TaskController::class)->middleware('auth:api');
    Route::get('listarUsuarios', [AuthController::class, 'listarUsuarios']);
    Route::apiResource('listarUsuario', AuthController::class)->middleware('auth:api');
});

