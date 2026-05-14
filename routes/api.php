<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MealLogController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\KatalogResepController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.custom'])->group(function () {

    Route::get('/foods', [FoodController::class, 'index']);

    Route::get('/meal-logs/summary', [MealLogController::class, 'summary']);

    Route::get('/meal-logs', [MealLogController::class, 'index']);
    Route::post('/meal-logs', [MealLogController::class, 'store']);
    Route::get('/meal-logs/{id}', [MealLogController::class, 'show']);
    Route::put('/meal-logs/{id}', [MealLogController::class, 'update']);
    Route::delete('/meal-logs/{id}', [MealLogController::class, 'destroy']);
    Route::get('/week-meal-plan', [MealPlanController::class, 'weekPlan']);
    Route::get('/meal-plan/day', [MealPlanController::class, 'dayData']);
    Route::get('/bmi-latest', [App\Http\Controllers\AnalyticController::class, 'latest']);
    Route::prefix('recipes')->group(function () {
 
    // Section cards (Recommended & Popular) — dipanggil JS saat blade load
    Route::get('/recommended', [KatalogResepController::class, 'recommended']);
    Route::get('/popular',     [KatalogResepController::class, 'popular']);
 
    // "Your Recipes" modal / halaman
    Route::get('/mine',        [KatalogResepController::class, 'mine']);
 
    // CRUD lengkap
    Route::get('/',            [KatalogResepController::class, 'apiIndex']);   // GET  /api/recipes?search=&meal_type=
    Route::post('/',           [KatalogResepController::class, 'store']);      // POST /api/recipes
    Route::get('/{id}',        [KatalogResepController::class, 'show']);       // GET  /api/recipes/{id}
    Route::put('/{id}',        [KatalogResepController::class, 'update']);     // PUT  /api/recipes/{id}
    Route::delete('/{id}',     [KatalogResepController::class, 'destroy']);    // DEL  /api/recipes/{id}
});
});
