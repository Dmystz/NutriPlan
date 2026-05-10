<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'name',
        'email',
        'password',
        'google_id',
        'umur',
        'berat_badan',
        'tinggi_badan',
        'jenis_kelamin',
        'target',
        'activity_level',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'berat_badan'    => 'float',
        'tinggi_badan'   => 'float',
        'activity_level' => 'float',
    ];

    public function getNamaDisplayAttribute(): string
    {
        return $this->nama ?? $this->name ?? 'User';
    }

    public function planner()
    {
        return $this->hasOne(Planner::class);
    }

    public function jadwalMakanan()
    {
        return $this->hasManyThrough(Jadwalmakanan::class, Planner::class);
    }

    public function bmiRecords()
    {
        return $this->hasMany(BmiRecord::class)->orderByDesc('recorded_at');
    }

    public function mealLogs()
    {
        return $this->hasMany(MealLog::class, 'user_id');
    }

    public function hitungBmi(): float
    {
        if (! $this->tinggi_badan || $this->tinggi_badan <= 0) {
            return 0;
        }
        $tinggiMeter = $this->tinggi_badan / 100;
        return round($this->berat_badan / ($tinggiMeter ** 2), 2);
    }

    public function kategoriBmi(): string
    {
        $bmi = $this->hitungBmi();
        return match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 25   => 'Normal',
            $bmi < 30   => 'Overweight',
            $bmi < 35   => 'Obesity I',
            $bmi < 40   => 'Obesity II',
            default     => 'Obesity III',
        };
    }

    public function hitungBmr(): float
    {
        $berat  = $this->berat_badan  ?? 0;
        $tinggi = $this->tinggi_badan ?? 0;
        $umur   = $this->umur         ?? 25;

        if ($this->jenis_kelamin === 'female') {
            return (10 * $berat) + (6.25 * $tinggi) - (5 * $umur) - 161;
        }
        return (10 * $berat) + (6.25 * $tinggi) - (5 * $umur) + 5;
    }

    public function hitungTdee(): float
    {
        $activityLevel = $this->activity_level ?? 1.55;
        return round($this->hitungBmr() * $activityLevel);
    }

    public function targetKalori(): float
    {
        $tdee = $this->hitungTdee();
        return match ($this->target) {
            'loss'  => max($tdee - 500, 1200),
            'gain'  => $tdee + 500,
            default => $tdee,
        };
    }

    public function targetMakro(): array
    {
        $kcal = $this->targetKalori();

        [$pctProtein, $pctCarbs, $pctFat] = match ($this->target) {
            'gain'  => [0.30, 0.45, 0.25],
            'loss'  => [0.35, 0.35, 0.30],
            default => [0.30, 0.40, 0.30],
        };

        return [
            'kalori'  => (int) $kcal,
            'protein' => (int) round(($kcal * $pctProtein) / 4),
            'carbs'   => (int) round(($kcal * $pctCarbs)   / 4),
            'fat'     => (int) round(($kcal * $pctFat)     / 9),
        ];
    }

    public function beratIdeal(): array
    {
        if (! $this->tinggi_badan) {
            return ['min' => 0, 'max' => 0];
        }
        $h = $this->tinggi_badan / 100;
        return [
            'min' => round(18.5 * ($h ** 2), 1),
            'max' => round(24.9 * ($h ** 2), 1),
        ];
    }
}