<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Simpan riwayat BMI user — ditampilkan di halaman Analytic (BMI History chart).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bmi_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('berat_badan',  5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('bmi_value',    5, 2);
            // underweight | normal | overweight | obese_1 | obese_2 | obese_3
            $table->string('status', 20)->default('normal');
            $table->date('recorded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bmi_records');
    }
};