<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        if (!$this->image_path) {
            return asset('img/meal1_home.png');
        }

        // Data lama: path dimulai dengan "img/" → langsung pakai asset()
        if (str_starts_with($this->image_path, 'img/')) {
            return asset($this->image_path);
        }

        // Data baru: upload via storage → pakai Storage::url()
        return Storage::disk('public')->url($this->image_path);
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
        $val = $this->ingredients;
        if (!$val) return [];
        
        // Coba parse sebagai JSON dulu
        $decoded = json_decode($val, true);
        if (is_array($decoded)) return array_filter($decoded);
        
        // Kalau bukan JSON, split per baris
        return array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $val)));
    }

    public function getCaraMasakListAttribute(): array
    {
        $val = $this->cara_masak;
        if (!$val) return [];
        
        // Coba parse sebagai JSON dulu
        $decoded = json_decode($val, true);
        if (is_array($decoded)) return array_filter($decoded);
        
        // Kalau bukan JSON, split per baris
        return array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $val)));
    }
}