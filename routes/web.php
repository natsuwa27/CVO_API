<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


Route::get('/bienvenida', function () {
    return view('auth.bienvenida');
})->name('bienvenida');


Route::get("/", function () {
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
    Route::get('/admin/homeadmin', fn() => view('admin.homeadmin'))
        ->name('admin.homeadmin');
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

Route::get('/force-logout', function(){
    
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect("/login");

});

Route::post('/registro', [WebAuthController::class, 'webRegister']);