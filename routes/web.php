<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FirebaseUserController;

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Registro
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/', fn() => view('home'))->name('home');
    Route::get('/', fn() => view('home'))->name('home');
    Route::get('/secretaria', fn() => 'Panel Secretaria')->name('secretaria.dashboard');
    Route::get('/admin/users', [App\Http\Controllers\FirebaseUserController::class, 'index'])
    ->name('admin.users.index');
Route::get('/users', [FirebaseUserController::class, 'index'])->name('users.index');
Route::get('/users/{uid}/edit', [FirebaseUserController::class, 'edit'])->name('users.edit');
Route::patch('/users/{uid}', [FirebaseUserController::class, 'update'])->name('users.update');
Route::delete('/users/{uid}', [FirebaseUserController::class, 'destroy'])->name('users.destroy');
});
