<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category',
        'calories', 'protein', 'carbs', 'fat',
        'fiber', 'sugar', 'sodium',
        'prep_time', 'image_path',
        'ingredients', 'steps',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps'       => 'array',
        'calories'    => 'float',
        'protein'     => 'float',
        'carbs'       => 'float',
        'fat'         => 'float',
        'fiber'       => 'float',
        'sugar'       => 'float',
        'sodium'      => 'float',
    ];

    // ── Daily-value reference amounts ──────────────────────────────────
    public function dailyValuePercent(string $macro): int
    {
        $dv = [
            'calories' => 2000,
            'protein'  => 50,    // g
            'carbs'    => 275,   // g
            'fat'      => 78,    // g
            'fiber'    => 28,    // g
            'sugar'    => 50,    // g
            'sodium'   => 2300,  // mg
        ];

        $ref = $dv[$macro] ?? 1;
        return (int) round(($this->{$macro} / $ref) * 100);
    }

    // ── Scopes ──────────────────────────────────────────────────────────
    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        return $query->where(function ($q) use ($term) {
            $q->where('name',        'like', "%{$term}%")
              ->orWhere('description','like', "%{$term}%")
              ->orWhere('category',   'like', "%{$term}%");
        });
    }
}