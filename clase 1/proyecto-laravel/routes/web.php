<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

// ── Ruta raíz: redirige según autenticación ──────────────────
Route::get('/', function () {
    return redirect()->route('estudiantes.index');
});

// ── Rutas de autenticación (solo para invitados) ─────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Rutas protegidas (requieren sesión activa) ───────────────
Route::middleware('auth')->group(function () {
    Route::resource('estudiantes', EstudianteController::class)
        ->except(['show']); // No necesitamos vista de detalle individual
});
