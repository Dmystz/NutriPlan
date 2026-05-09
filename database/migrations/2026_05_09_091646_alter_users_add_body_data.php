<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambahkan kolom body data ke tabel users yang sudah ada.
 * Jalankan: php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu supaya tidak duplikat jika kolom sudah ada
            if (! Schema::hasColumn('users', 'nama')) {
                // Rename 'name' → 'nama' tidak bisa langsung; tambahkan 'nama' saja
                // (AuthController sudah pakai 'name', jadi kita tambahkan alias)
                $table->string('nama')->nullable()->after('id');
            }
            if (! Schema::hasColumn('users', 'umur')) {
                $table->unsignedTinyInteger('umur')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'berat_badan')) {
                $table->decimal('berat_badan', 5, 2)->nullable()->after('umur');
            }
            if (! Schema::hasColumn('users', 'tinggi_badan')) {
                $table->decimal('tinggi_badan', 5, 2)->nullable()->after('berat_badan');
            }
            if (! Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['male', 'female'])->default('male')->after('tinggi_badan');
            }
            if (! Schema::hasColumn('users', 'target')) {
                // maintenance | loss | gain
                $table->enum('target', ['maintenance', 'loss', 'gain'])->default('maintenance')->after('jenis_kelamin');
            }
            if (! Schema::hasColumn('users', 'activity_level')) {
                // Faktor aktivitas untuk TDEE: 1.2 / 1.375 / 1.55 / 1.725 / 1.9
                $table->decimal('activity_level', 4, 3)->default(1.550)->after('target');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nama', 'umur', 'berat_badan', 'tinggi_badan',
                'jenis_kelamin', 'target', 'activity_level',
            ]);
        });
    }
};