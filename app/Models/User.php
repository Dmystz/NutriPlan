<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'name',          // kolom lama (AuthController pakai 'name')
        'email',
        'password',
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

    // ── Accessor: nama tampil (prioritaskan 'nama', fallback ke 'name') ──
    public function getNamaDisplayAttribute(): string
    {
        return $this->nama ?? $this->name ?? 'User';
    }

    // ══════════════════════════════
    //  RELASI
    // ══════════════════════════════

    /** User punya satu Planner */
    public function planner()
    {
        return $this->hasOne(Planner::class);
    }

    /** Shortcut: jadwal makan user (lewat planner) */
    public function jadwalMakanan()
    {
        return $this->hasManyThrough(Jadwalmakanan::class, Planner::class);
    }

    /** Riwayat BMI */
    public function bmiRecords()
    {
        return $this->hasMany(BmiRecord::class)->orderByDesc('recorded_at');
    }

    /** Log makan harian */
    public function mealLogs()
    {
        return $this->hasMany(MealLog::class, 'user_id');
    }

    // ══════════════════════════════
    //  KALKULASI NUTRISI
    // ══════════════════════════════

    /**
     * Hitung BMI.
     * Formula: berat (kg) / tinggi² (m²)
     */
    public function hitungBmi(): float
    {
        if (! $this->tinggi_badan || $this->tinggi_badan <= 0) {
            return 0;
        }
        $tinggiMeter = $this->tinggi_badan / 100;
        return round($this->berat_badan / ($tinggiMeter ** 2), 2);
    }

    /**
     * Kategori BMI (WHO standard).
     */
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

    /**
     * BMR (Basal Metabolic Rate) — Mifflin-St Jeor Equation.
     * Lebih akurat dari Harris-Benedict.
     */
    public function hitungBmr(): float
    {
        $berat  = $this->berat_badan  ?? 0;
        $tinggi = $this->tinggi_badan ?? 0;
        $umur   = $this->umur         ?? 25;

        if ($this->jenis_kelamin === 'female') {
            return (10 * $berat) + (6.25 * $tinggi) - (5 * $umur) - 161;
        }
        // male (default)
        return (10 * $berat) + (6.25 * $tinggi) - (5 * $umur) + 5;
    }

    /**
     * TDEE (Total Daily Energy Expenditure).
     * TDEE = BMR × activity_level
     */
    public function hitungTdee(): float
    {
        $activityLevel = $this->activity_level ?? 1.55;
        return round($this->hitungBmr() * $activityLevel);
    }

    /**
     * Target kalori harian berdasarkan goal user.
     * maintenance : TDEE
     * loss        : TDEE - 500 (defisit ~0.5 kg/minggu)
     * gain        : TDEE + 500 (surplus ~0.5 kg/minggu)
     */
    public function targetKalori(): float
    {
        $tdee = $this->hitungTdee();
        return match ($this->target) {
            'loss'  => max($tdee - 500, 1200), // minimal 1200 kcal
            'gain'  => $tdee + 500,
            default => $tdee,                  // maintenance
        };
    }

    /**
     * Target makro harian (gram).
     * Protein: 30%, Carbs: 40%, Fat: 30% dari total kalori.
     * (bisa disesuaikan per goal)
     */
    public function targetMakro(): array
    {
        $kcal = $this->targetKalori();

        // Distribusi makro berdasarkan goal
        [$pctProtein, $pctCarbs, $pctFat] = match ($this->target) {
            'gain'  => [0.30, 0.45, 0.25], // lebih banyak karbo untuk energi
            'loss'  => [0.35, 0.35, 0.30], // lebih banyak protein untuk jaga otot
            default => [0.30, 0.40, 0.30], // balanced
        };

        return [
            'kalori'  => (int) $kcal,
            'protein' => (int) round(($kcal * $pctProtein) / 4),  // 4 kcal/g
            'carbs'   => (int) round(($kcal * $pctCarbs)   / 4),  // 4 kcal/g
            'fat'     => (int) round(($kcal * $pctFat)     / 9),  // 9 kcal/g
        ];
    }

    /**
     * Berat ideal (range BMI normal: 18.5–24.9).
     */
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