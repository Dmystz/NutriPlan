<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Food extends Model
{
    protected $table = 'foods';  // ← tambahkan baris ini
    
    protected $fillable = [
        'name', 'emoji', 'image_path', 'category',
        'calories', 'protein', 'carbs', 'fat',
        'description', 'is_active',
    ];

    protected $casts = [
        'calories' => 'integer',
        'protein'  => 'float',
        'carbs'    => 'float',
        'fat'      => 'float',
        'is_active'=> 'boolean',
    ];

    // ── Accessor: URL gambar (pakai emoji jika tidak ada gambar) ──
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_path
                ? Storage::url($this->image_path)   // /storage/foods/xxx.jpg
                : null,
        );
    }

    // ── Scope: filter by category ──
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // ── Scope: search by name ──
    public function scopeSearch($query, string $keyword)
    {
        return $query->where('name', 'like', "%{$keyword}%");
    }

    // ── Scope: hanya yang aktif ──
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}