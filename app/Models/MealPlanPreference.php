<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlanPreference extends Model
{
    protected $fillable = [
        'user_id',
        'target_kalori',
        'protein_pct',
        'carbs_pct',
        'fat_pct',
        'diet_pref',
        'meals_per_day',
        'avoid_items',
    ];

    protected $casts = [
        'avoid_items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}