<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalMakananController;
use App\Http\Controllers\KatalogResepController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AnalyticController;

/* ══════════════════════════════════════════════════════════
   PUBLIC — tidak perlu login
   ══════════════════════════════════════════════════════════ */

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

Route::post('/login',    [AuthController::class, 'login'])   ->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('landing');
})->name('logout');

Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

Route::get ('/complete-profile', [ProfileController::class, 'showComplete'])->name('profile.complete');
Route::post('/complete-profile', [ProfileController::class, 'complete'])    ->name('profile.complete.store');

/* ══════════════════════════════════════════════════════════
   PROTECTED — wajib login (session-based, bukan Sanctum)
   ══════════════════════════════════════════════════════════ */

Route::middleware(['auth.custom', 'nocache'])->group(function () {

    // ── Halaman statik ──────────────────────────────────────────────────
    Route::get('/home',      fn() => view('layout.home'))     ->name('home');
    Route::get('/nutrition', fn() => view('layout.nutrition'))->name('nutrition');
    Route::get('/recipes',   fn() => view('layout.recipes'))  ->name('recipes');

    // ── Analytic (BMI) ──────────────────────────────────────────────────
    Route::get ('/analytic',         [AnalyticController::class, 'index'])  ->name('analytic');
    Route::post('/analytic/bmi',     [AnalyticController::class, 'store'])  ->name('analytic.store');
    Route::get ('/analytic/history', [AnalyticController::class, 'history'])->name('analytic.history');

    // ── Meal Plan ───────────────────────────────────────────────────────
    Route::get   ('/meal_plan',             [MealPlanController::class, 'index'])        ->name('meal_plan.index');
    Route::post  ('/meal_plan/jadwal',      [MealPlanController::class, 'storeJadwal'])  ->name('meal_plan.jadwal.store');
    Route::put   ('/meal_plan/jadwal/{id}', [MealPlanController::class, 'updateJadwal']) ->name('meal_plan.jadwal.update');
    Route::delete('/meal_plan/jadwal/{id}', [MealPlanController::class, 'destroyJadwal'])->name('meal_plan.jadwal.destroy');

    // ── Profile ─────────────────────────────────────────────────────────
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get ('/meal_plan/preferences',      [MealPlanController::class, 'getPreferences']) ->name('meal_plan.pref.get');
    Route::post('/meal_plan/preferences',      [MealPlanController::class, 'savePreferences'])->name('meal_plan.pref.save');

    // ── (Legacy) JadwalMakananController ───────────────────────────────
    // Route::post  ('/meal_plan/store',       [JadwalMakananController::class, 'store'])  ->name('mealplan.store');
    // Route::delete('/meal_plan/delete/{id}', [JadwalMakananController::class, 'destroy'])->name('mealplan.destroy');

});