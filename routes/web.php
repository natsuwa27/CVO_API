<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('auth.bienvenida');
})->name('bienvenida');


Route::get("/login", function () {
    return redirect()->route("login");
});

// Registro y login
Route::get('/registro', function () {
    return view('auth.registro');
})->name('registro');

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// ADMIN (role_id = 1)


        Route::middleware(['auth', 'role:1'])->group(function () {

    Route::get('/admin/homeadmin', [WebAuthController::class, 'adminPanel'])
        ->name('admin.homeadmin');

    Route::post('/admin/desactivar/{id}', [WebAuthController::class, 'desactivar'])
        ->name('admin.desactivar');

    Route::post('/admin/reactivar/{id}', [WebAuthController::class, 'reactivar'])
        ->name('admin.reactivar');

    Route::get('/admin/crear-usuario', [WebAuthController::class, 'showCreateUser'])
        ->name('admin.crearusuario');

    Route::post('/admin/crear-usuario', [WebAuthController::class, 'storeUser'])
        ->name('admin.storeusuario');

        Route::put('/admin/usuarios/{id}', [WebAuthController::class, 'updateusuario'])
    ->name('admin.updateusuario');


});




// EMPLEADO (role_id = 2)
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/empleado/homeempleado', fn() => view('empleado.homeempleado'))
        ->name('empleado.homeempleado');
});

// CLIENTE (role_id = 3)
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/cliente/homecliente', fn() => view('cliente.homecliente'))
        ->name('cliente.homecliente');
});

Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');



Route::post('/registro', [WebAuthController::class, 'webRegister']);