<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'tags'          => 'array',
        'is_public'     => 'boolean',
        'calories'      => 'integer',
        'protein'       => 'float',
        'carbs'         => 'float',
        'fat'           => 'float',
        'fiber'         => 'float',
        'total_nutrisi' => 'float',
    ];

    /* ── Relationships ─────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ── Scopes ────────────────────────────────────── */

    public function scopeVisible($query, ?int $userId = null)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('is_public', true);

            if ($userId) {
                $q->orWhere('user_id', $userId);
            }
        });
    }

    public function scopeByMealType($query, string $mealType)
    {
        return $query->where('meal_type', strtolower($mealType));
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_makanan', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    /* ── Accessors ─────────────────────────────────── */

    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? asset($this->image_path)
            : asset('img/meal1_home.png');
    }

    public function getMealTypeColorAttribute(): string
    {
        return match (strtolower((string) $this->meal_type)) {
            'breakfast' => '#95CD41',
            'lunch'     => '#EA5C2B',
            'dinner'    => '#2B7FFF',
            'snacks'    => '#FBBF24',
            'desserts'  => '#A78BFA',
            'drinks'    => '#34D399',
            default     => '#6B7280',
        };
    }

    /* ── Helpers untuk ubah TEXT jadi array ────────── */

    public function getIngredientsListAttribute(): array
    {
        return array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n/', $this->ingredients ?? ''))
        );
    }

    public function getCaraMasakListAttribute(): array
    {
        return array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n/', $this->cara_masak ?? ''))
        );
    }
}