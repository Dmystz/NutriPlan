<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('katalog_resep', function (Blueprint $table) {
            $table->id();
            $table->string('nama_makanan');
            $table->text('ingredients')->nullable();   // JSON string bahan-bahan
            $table->text('cara_masak')->nullable();    // JSON langkah memasak
            $table->string('meal_type')->nullable();   // breakfast|lunch|dinner|snack
            $table->string('difficulty')->nullable();  // easy|medium|hard
            $table->unsignedSmallInteger('cook_time')->nullable(); // menit
            $table->unsignedTinyInteger('servings')->default(1);
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();          // ["Vegan","Keto",...]
            $table->boolean('is_public')->default(true);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Makro per sajian
            $table->unsignedSmallInteger('calories')->default(0);
            $table->decimal('protein', 6, 2)->default(0);
            $table->decimal('carbs',   6, 2)->default(0);
            $table->decimal('fat',     6, 2)->default(0);
            $table->decimal('fiber',   6, 2)->default(0);

            // total_nutrisi (kompatibel dengan kode lama)
            $table->decimal('total_nutrisi', 8, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('katalog_resep');
    }
};