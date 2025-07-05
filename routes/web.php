<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VacanteController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas del portal de vacantes
Route::prefix('vacantes')->group(function () {
    Route::get('/', [VacanteController::class, 'index'])->name('vacantes.index');
    Route::get('/crear', [VacanteController::class, 'create'])->name('vacantes.create');
    Route::post('/crear', [VacanteController::class, 'store'])->name('vacantes.store');
    Route::get('/{vacante}', [VacanteController::class, 'show'])->name('vacantes.show');
    
    // Postulaciones
    Route::get('/{vacante}/postular', [PostulacionController::class, 'create'])->name('postulaciones.create');
    Route::post('/{vacante}/postular', [PostulacionController::class, 'store'])->name('postulaciones.store');
});

// Rutas de autenticación
Route::prefix('vacantes/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Ruta temporal del admin sin autenticación (solo para testing)
Route::get('vacantes/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard.temp');

// Rutas de administración (requieren autenticación)
Route::prefix('vacantes/admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Gestión de vacantes
    Route::get('/vacantes', [AdminController::class, 'vacantes'])->name('admin.vacantes');
    Route::get('/vacantes/{vacante}', [AdminController::class, 'verVacante'])->name('admin.vacantes.show');
    Route::patch('/vacantes/{vacante}/aprobar', [AdminController::class, 'aprobarVacante'])->name('admin.vacantes.aprobar');
    Route::patch('/vacantes/{vacante}/rechazar', [AdminController::class, 'rechazarVacante'])->name('admin.vacantes.rechazar');
    Route::patch('/vacantes/{vacante}/cerrar', [AdminController::class, 'cerrarVacante'])->name('admin.vacantes.cerrar');
    
    // Postulaciones
    Route::get('/postulaciones', [AdminController::class, 'postulaciones'])->name('admin.postulaciones');
    
    // Gestión de usuarios (solo administradores)
    Route::middleware('can:admin-only')->group(function () {
        Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
        Route::post('/usuarios', [AdminController::class, 'crearUsuario'])->name('admin.usuarios.store');
    });
});

// Redirección por defecto
Route::get('/', function () {
    return redirect()->route('vacantes.index');
});
