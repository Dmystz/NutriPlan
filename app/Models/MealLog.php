<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MealLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_id',
        'name',
        'category',
        'meal_slot',
        'meal_time',
        'servings',
        'calories',
        'protein',
        'carbs',
        'fat',
        'log_date',
    ];

    protected $casts = [
        'log_date'  => 'date',
        'meal_time' => 'string',
        'calories'  => 'float',
        'protein'   => 'float',
        'carbs'     => 'float',
        'fat'       => 'float',
        'servings'  => 'integer',
    ];

    /* ── Relationships ─────────────────────────────── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    /* ── Scopes ────────────────────────────────────── */

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForDate($query, string $date)
    {
        return $query->whereDate('log_date', $date);
    }

    public function scopeForSlot($query, string $slot)
    {
        return $query->where('meal_slot', $slot);
    }

    /* ── Helpers ───────────────────────────────────── */

    /**
     * Nutrition totals for a given user & date.
     */
    public static function dailyTotals(int $userId, string $date): array
    {
        $row = static::forUser($userId)
            ->forDate($date)
            ->select(
                DB::raw('COALESCE(SUM(calories), 0) as calories'),
                DB::raw('COALESCE(SUM(protein),  0) as protein'),
                DB::raw('COALESCE(SUM(carbs),    0) as carbs'),
                DB::raw('COALESCE(SUM(fat),      0) as fat'),
            )
            ->first();

        return $row ? $row->toArray() : ['calories' => 0, 'protein' => 0, 'carbs' => 0, 'fat' => 0];
    }

    /**
     * Meals grouped by slot for a given user & date.
     */
    public static function groupedBySlot(int $userId, string $date): array
    {
        $slots = ['Breakfast', 'Snack', 'Lunch', 'Dinner'];
        $logs  = static::forUser($userId)
            ->forDate($date)
            ->orderBy('meal_time')
            ->get();

        $grouped = [];
        foreach ($slots as $slot) {
            $grouped[$slot] = $logs->where('meal_slot', $slot)->values();
        }

        return $grouped;
    }
}