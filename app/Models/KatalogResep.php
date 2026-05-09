<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KatalogResep extends Model
{
    use HasFactory;

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
        'ingredients'  => 'array',
        'cara_masak'   => 'array',
        'tags'         => 'array',
        'is_public'    => 'boolean',
        'calories'     => 'integer',
        'protein'      => 'float',
        'carbs'        => 'float',
        'fat'          => 'float',
        'fiber'        => 'float',
        'total_nutrisi'=> 'float',
    ];

    protected $appends = ['image_url'];

    /* ── Computed ──────────────────────────────────── */

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    /* ── Relationships ─────────────────────────────── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalMakanan()
    {
        return $this->hasMany(JadwalMakanan::class);
    }

    public function planners()
    {
        return $this->belongsToMany(Planner::class, 'planner_katalog_resep');
    }

    /* ── Scopes ────────────────────────────────────── */

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByMealType($query, string $type)
    {
        return $query->where('meal_type', $type);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('nama_makanan', 'like', '%' . $term . '%');
    }
}