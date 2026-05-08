<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KatalogResep extends Model
{
    protected $table = 'katalog_resep';

    protected $fillable = [
        'nama_makanan',
        'ingredients',
        'total_nutrisi',
    ];

    protected $casts = [
        'total_nutrisi' => 'float',
    ];

    // Relasi: KatalogResep dimiliki banyak Planner
    public function planners()
    {
        return $this->belongsToMany(Planner::class, 'planner_katalog_resep');
    }

    // Relasi: KatalogResep digunakan di banyak JadwalMakanan
    public function jadwalMakanan()
    {
        return $this->hasMany(JadwalMakanan::class);
    }
}