<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/login', fn() => redirect('/admin/login'))->name('login');
Route::get('/register', fn() => redirect('/admin/register'))->name('register');

Route::post('login', [AuthController::class, 'handleLogin'])->name('handle_login');
Route::post('register', [AuthController::class, 'handleRegister'])->name('handle_register');