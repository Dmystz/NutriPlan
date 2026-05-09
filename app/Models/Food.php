<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'emoji',
        'image_path',
        'category',
        'calories',
        'protein',
        'carbs',
        'fat',
        'description',
        'is_active',
    ];

    protected $casts = [
        'calories'  => 'integer',
        'protein'   => 'float',
        'carbs'     => 'float',
        'fat'       => 'float',
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }

        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('name', 'like', '%' . $term . '%');
    }

    public function mealLogs()
    {
        return $this->hasMany(MealLog::class);
    }
}