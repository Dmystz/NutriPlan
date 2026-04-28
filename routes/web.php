<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('layout.home');
});

Route::get('/meal_plan', function () {
    return view('layout.meal_plan');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::get('/home', function () {

    if (!session('user_id')) {
        return redirect('/login');
    }

    return view('layout.home');
})->name('home');

// LOGOUT
Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});
