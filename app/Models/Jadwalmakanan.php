<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMakanan extends Model
{
    protected $table = 'jadwal_makanan';

    protected $fillable = [
        'user_id',
        'katalog_resep_id',
        'tanggal',
        'meal_type'
    ];

    public function recipe()
    {
        return $this->belongsTo(
            Katalogresep::class,
            'katalog_resep_id'
        );
    }
}