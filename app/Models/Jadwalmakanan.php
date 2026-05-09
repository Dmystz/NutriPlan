<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwalmakanan extends Model
{
    protected $table = 'jadwal_makanan';

    protected $fillable = [
        'user_id',
        'katalog_resep_id',
        'tanggal',
        'meal_type',
        'meal_time',
        'servings',
        'is_consumed',
        'catatan',
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'is_consumed' => 'boolean',
        'servings'    => 'integer',
    ];

    // ══════════════════════════════
    //  RELASI
    // ══════════════════════════════

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(KatalogResep::class, 'katalog_resep_id');
    }

    // ══════════════════════════════
    //  HELPER: kalori total (porsi × kalori per sajian)
    // ══════════════════════════════

    public function totalKalori(): int
    {
        return ($this->recipe->calories ?? 0) * ($this->servings ?? 1);
    }

    public function totalProtein(): float
    {
        return ($this->recipe->protein ?? 0) * ($this->servings ?? 1);
    }

    public function totalCarbs(): float
    {
        return ($this->recipe->carbs ?? 0) * ($this->servings ?? 1);
    }

    public function totalFat(): float
    {
        return ($this->recipe->fat ?? 0) * ($this->servings ?? 1);
    }
}