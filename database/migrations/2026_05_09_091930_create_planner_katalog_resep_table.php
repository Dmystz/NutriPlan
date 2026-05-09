<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pivot: Planner ↔ KatalogResep (Many-to-Many)
 * Relasi: Planner "memiliki" banyak resep favorit.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planner_katalog_resep', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planner_id')->constrained('planners')->onDelete('cascade');
            $table->foreignId('katalog_resep_id')->constrained('katalog_resep')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['planner_id', 'katalog_resep_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planner_katalog_resep');
    }
};