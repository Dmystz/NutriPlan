<?php
// ─────────────────────────────────────────────
// Tambahkan ke: routes/api.php
// ─────────────────────────────────────────────

use App\Http\Controllers\FoodController;
use App\Http\Controllers\MealLogController;

Route::get('/foods', [FoodController::class, 'index']);
Route::post('/meal-logs', [MealLogController::class, 'store']);
Route::get('/meal-logs', [MealLogController::class, 'index']);
// Publik – dipakai modal (tanpa auth)

// Admin – butuh auth / middleware admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/foods',           [FoodController::class, 'store']);
    Route::put('/admin/foods/{food}',     [FoodController::class, 'update']);
    Route::delete('/admin/foods/{food}',  [FoodController::class, 'destroy']);
});

// ─────────────────────────────────────────────
// Jangan lupa jalankan perintah ini sekali:
// php artisan storage:link
// ─────────────────────────────────────────────