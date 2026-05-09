<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalMakananController;
use App\Http\Controllers\KatalogResepController;

Route::get('/', function () {
    if (session('user_id')) return redirect()->route('home');
    return view('layout.landing_pg');
})->name('landing');

Route::get('/login', function () {
    if (session('user_id')) return redirect()->route('home');
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    if (session('user_id')) return redirect()->route('home');
    return view('auth.register');
})->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('landing');
})->name('logout');

Route::get('/meal_plan', [
    JadwalMakananController::class,
    'index'
]);

Route::post('/meal_plan/store', [
    JadwalMakananController::class,
    'store'
])->name('mealplan.store');

Route::delete('/meal_plan/delete/{id}', [
    JadwalMakananController::class,
    'destroy'
])->name('mealplan.destroy');

Route::middleware(['auth.custom', 'nocache'])->group(function () {
    Route::get('/home',      fn() => view('layout.home'))->name('home');
    Route::get('/analytic',  fn() => view('layout.analytic'))->name('analytic');
    Route::get('/nutrition', fn() => view('layout.nutrition'))->name('nutrition');
    Route::get('/recipes',   fn() => view('layout.recipes'))->name('recipes');
});