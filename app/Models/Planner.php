<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planner extends Model
{
    protected $fillable = [
        'user_id',
    ];

    // Relasi: Planner milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Mengelola: Planner mengelola banyak JadwalMakanan
    public function jadwalMakanan()
    {
        return $this->hasMany(JadwalMakanan::class);
    }

    // Relasi Memiliki: Planner memiliki banyak KatalogResep
    public function katalogResep()
    {
        return $this->belongsToMany(KatalogResep::class, 'planner_katalog_resep');
    }
}