<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMakanan extends Model
{
    use HasFactory;

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

    /* ── Relationships ─────────────────────────────── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resep()
    {
        return $this->belongsTo(KatalogResep::class, 'katalog_resep_id');
    }

    /* ── Scopes ────────────────────────────────────── */

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForDate($query, string $date)
    {
        return $query->whereDate('tanggal', $date);
    }

    public function scopeForWeek($query, string $startDate, string $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }
}