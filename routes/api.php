<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AppointmentController;

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

Route::prefix('appointments')->group(function () {
    Route::post('/create', [AppointmentController::class, 'create']);
    Route::get('/read/{id}', [AppointmentController::class, 'read']);
    Route::get('/read', [AppointmentController::class, 'myAppointments']);
    Route::put('/update/{id}', [AppointmentController::class, 'update']);
    Route::delete('/delete/{id}', [AppointmentController::class, 'delete']);
});
Route::get('/pets', [PetController::class, 'apiIndex']);
