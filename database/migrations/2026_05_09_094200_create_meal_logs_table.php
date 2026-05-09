<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('food_id')->nullable();
            $table->string('name');
            $table->string('category')->default('meal');
            $table->string('meal_slot')->nullable();
            $table->time('meal_time')->nullable();
            $table->integer('servings')->default(1);
            $table->float('calories')->default(0);
            $table->float('protein')->default(0);
            $table->float('carbs')->default(0);
            $table->float('fat')->default(0);
            $table->date('log_date')->default(DB::raw('(CURDATE())'));
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_logs');
    }
};