<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMakanan extends Model
{
    protected $table = 'jadwal_makanan';

    protected $fillable = [
        'planner_id',
        'katalog_resep_id',
        'tanggal_kalender',
        'goals',
    ];

    protected $casts = [
        'tanggal_kalender' => 'date',
    ];

    // Relasi: JadwalMakanan milik satu Planner
    public function planner()
    {
        return $this->belongsTo(Planner::class);
    }

    // Relasi: JadwalMakanan menggunakan satu KatalogResep
    public function katalogResep()
    {
        return $this->belongsTo(KatalogResep::class);
    }
}