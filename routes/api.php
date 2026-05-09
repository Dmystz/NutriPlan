<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MealLogController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MealPlanController;

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

    Route::get('/meal-plan/day', [MealPlanController::class, 'dayData']);

});