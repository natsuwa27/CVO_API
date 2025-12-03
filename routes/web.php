<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\CalendarController;

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
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':3'])->group(function () {
    Route::get('/cliente/homecliente', [PetController::class, 'index'])->name('cliente.homecliente');
    Route::get('/cliente/registro_mascota', [PetController::class, 'create'])->name('pets.create');
    Route::post('/cliente/registro_mascota', [PetController::class, 'store'])->name('pets.store');
    
    
});


//ariel
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::prefix('pets')->group(function () {
        // Lista de mascotas
        Route::get('/', [PetController::class, 'index'])->name('cliente.homecliente');

        // Formulario de registro
        Route::get('/create', [PetController::class, 'create'])->name('pets.create');

        // Guardar nueva mascota
        Route::post('/store', [PetController::class, 'store'])->name('pets.store');

        // Ver detalle de mascota
        Route::get('/{id}', [PetController::class, 'show'])->name('pets.show');

        // Formulario de edición
        Route::get('/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');

        // Actualizar mascota
        Route::put('/{id}', [PetController::class, 'update'])->name('pets.update');

        // Eliminar mascota
        Route::delete('/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
    });
});

Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');


Route::post('/registro', [WebAuthController::class, 'webRegister']);

//carlos
Route::middleware(['auth', 'role:3'])->group(function () {
    Route::prefix('appointments')->group(function () {
        Route::get('/index', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/create', [AppointmentController::class, 'createForm'])->name('appointments.create');
        Route::post('/store', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/show/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::get('/edit/{id}', [AppointmentController::class, 'editForm'])->name('appointments.edit');
        Route::put('/updateWeb/{id}', [AppointmentController::class, 'updateWeb'])->name('appointments.update');
        Route::delete('/deleteWeb/{id}', [AppointmentController::class, 'deleteWeb'])->name('appointments.delete');
    });
});

Route::post('/registro', [WebAuthController::class, 'webRegister']);

Route::middleware(['auth','role:1'])->group(function () {
    Route::get('/calendars', [CalendarController::class, 'index'])->name('calendars.index');
    Route::post('/calendars/generate-month', [CalendarController::class, 'generateMonth'])->name('calendars.generateMonth');
    Route::get('/calendars/{calendar}', [CalendarController::class, 'show'])->name('calendars.show');
    Route::patch('/calendars/{calendar}/close', [CalendarController::class, 'closeDay'])->name('calendars.closeDay');
    Route::patch('/blocks/{block}/toggle', [CalendarController::class, 'toggleBlock'])->name('blocks.toggle');
});
