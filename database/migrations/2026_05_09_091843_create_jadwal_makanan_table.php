<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_makanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('katalog_resep_id')->nullable()->constrained('katalog_resep')->onDelete('set null');
            $table->date('tanggal');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack'])->default('lunch');
            $table->time('meal_time')->nullable(); // jam spesifik, misal 08:00
            $table->unsignedTinyInteger('servings')->default(1);
            $table->boolean('is_consumed')->default(false); // sudah dimakan atau belum
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_makanan');
    }
};