<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KatalogResep extends Model
{
    protected $table = 'katalog_resep';

    protected $fillable = [
        'nama_makanan',
        'ingredients',
        'cara_masak',
        'meal_type',
        'difficulty',
        'cook_time',
        'servings',
        'image_path',
        'description',
        'tags',
        'is_public',
        'user_id',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'total_nutrisi',
    ];

    protected $casts = [
        'calories'     => 'integer',
        'protein'      => 'float',
        'carbs'        => 'float',
        'fat'          => 'float',
        'fiber'        => 'float',
        'total_nutrisi'=> 'float',
        'is_public'    => 'boolean',
        'tags'         => 'array',
    ];

    // ── Auto-hitung total_nutrisi (kalori) sebelum simpan ──
    protected static function booted(): void
    {
        static::saving(function (KatalogResep $r) {
            $r->total_nutrisi = $r->calories ?? 0;
        });
    }

    // ── Accessor URL gambar ──
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? Storage::url($this->image_path)
            : null;
    }

    // ══════════════════════════════
    //  RELASI
    // ══════════════════════════════

    /** Resep ini dibuat oleh user tertentu */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Relasi pivot: dimiliki banyak Planner */
    public function planners()
    {
        return $this->belongsToMany(Planner::class, 'planner_katalog_resep');
    }

    /** Jadwal yang menggunakan resep ini */
    public function jadwalMakanan()
    {
        return $this->hasMany(Jadwalmakanan::class, 'katalog_resep_id');
    }

    // ══════════════════════════════
    //  SCOPE
    // ══════════════════════════════

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeMealType($query, string $type)
    {
        return $query->where('meal_type', $type);
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where('nama_makanan', 'like', "%{$keyword}%");
    }

    public function scopeMaxCalories($query, int $max)
    {
        return $query->where('calories', '<=', $max);
    }
}