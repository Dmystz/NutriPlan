<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalMakananController;
use App\Http\Controllers\KatalogResepController;
use App\Http\Controllers\MealPlanController;      
use App\Http\Controllers\ProfileController;

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

/* ══════════════════════════════════════════════════════════
   PROTECTED — wajib login (session-based, bukan Sanctum)
   ══════════════════════════════════════════════════════════ */
Route::middleware(['auth.custom', 'nocache'])->group(function () {

    // ── Halaman statik ─────────────────────────────────────
    Route::get('/home',      fn() => view('layout.home'))     ->name('home');
    Route::get('/analytic',  fn() => view('layout.analytic')) ->name('analytic');
    Route::get('/nutrition', fn() => view('layout.nutrition'))->name('nutrition');
    Route::get('/recipes',   fn() => view('layout.recipes'))  ->name('recipes');

    // ── Meal Plan (Days + Week view) ───────────────────────
    Route::get('/meal_plan', [MealPlanController::class, 'index'])->name('meal_plan.index');

    // Jadwal makanan (Week view: Plan Manually & Edit Plan)
    Route::post  ('/meal_plan/jadwal',      [MealPlanController::class, 'storeJadwal'])  ->name('meal_plan.jadwal.store');
    Route::put   ('/meal_plan/jadwal/{id}', [MealPlanController::class, 'updateJadwal']) ->name('meal_plan.jadwal.update');
    Route::delete('/meal_plan/jadwal/{id}', [MealPlanController::class, 'destroyJadwal'])->name('meal_plan.jadwal.destroy');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // ── (Legacy) JadwalMakananController — sisakan jika masih dipakai di tempat lain
    // Route::post  ('/meal_plan/store',        [JadwalMakananController::class, 'store'])  ->name('mealplan.store');
    // Route::delete('/meal_plan/delete/{id}',  [JadwalMakananController::class, 'destroy'])->name('mealplan.destroy');
});