<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('emoji', 10)->nullable();
            $table->string('image_path')->nullable();
            $table->enum('category', ['meal', 'drink', 'snack'])->default('meal');
            $table->unsignedSmallInteger('calories')->default(0);
            $table->decimal('protein', 6, 2)->default(0);
            $table->decimal('carbs',   6, 2)->default(0);
            $table->decimal('fat',     6, 2)->default(0);
            $table->string('description', 120)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};