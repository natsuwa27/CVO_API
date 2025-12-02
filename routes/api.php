<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CalendarController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// routes de usuarios
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'readAll']);
    Route::post('/create', [UserController::class, 'create']);
    Route::get('/{id}', [UserController::class, 'readOne']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});

// routes de roles
Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'readAll']);
    Route::post('/create', [RoleController::class, 'create']);
    Route::get('/{id}', [RoleController::class, 'readOne']);
    Route::put('/{id}', [RoleController::class, 'update']);
});

// Calendarios
Route::get('/calendars', [CalendarController::class, 'index']);
Route::post('/calendars', [CalendarController::class, 'store']);

// Bloques del calendario
Route::post('/calendars/{calendar}/blocks', [CalendarController::class, 'addBlock']);
Route::put('/blocks/{block}', [CalendarController::class, 'updateBlock']);
Route::delete('/blocks/{block}', [CalendarController::class, 'destroyBlock']);
