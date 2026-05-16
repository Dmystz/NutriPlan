<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JadwalMakanan extends Model
{
    protected $table = 'jadwal_makanan'; // or whatever your actual table name is

    protected $fillable = [
        'user_id',
        'katalog_resep_id',
        'tanggal',        // ← confirm this matches your actual column name
        'meal_type',
        'meal_time',
        'servings',
        'catatan',
        'is_consumed',
    ];

    protected $casts = [
        'is_consumed' => 'boolean',
        'tanggal'     => 'date',
    ];

    /* ── Relationships ─────────────────────────────────── */
    public function resep()
    {
        return $this->belongsTo(KatalogResep::class, 'katalog_resep_id');
    }

    /* ── Scopes ────────────────────────────────────────── */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('tanggal', $date); // ← match your real column
    }
}