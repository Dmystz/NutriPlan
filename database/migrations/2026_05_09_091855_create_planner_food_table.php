<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * planner_food = log harian makanan yang dikonsumsi user.
 * Dipakai oleh MealLogController (POST /api/meal-logs).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planner_food', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('food_id')->nullable()->constrained('foods')->onDelete('set null');
            $table->string('name');                    // nama makanan (bisa manual)
            $table->enum('category', ['meal', 'drink', 'snack'])->default('meal');
            $table->string('meal_slot', 30)->nullable(); // Breakfast|Lunch|Dinner|Snack
            $table->time('meal_time')->nullable();
            $table->date('log_date');
            $table->decimal('calories', 8, 2)->default(0);
            $table->decimal('protein',  6, 2)->default(0);
            $table->decimal('carbs',    6, 2)->default(0);
            $table->decimal('fat',      6, 2)->default(0);
            $table->unsignedTinyInteger('servings')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planner_food');
    }
};