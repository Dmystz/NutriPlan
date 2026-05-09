<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BmiRecord extends Model
{
    protected $table = 'bmi_records';

    protected $fillable = [
        'user_id',
        'berat_badan',
        'tinggi_badan',
        'bmi_value',
        'status',
        'recorded_at',
    ];

    protected $casts = [
        'berat_badan'  => 'float',
        'tinggi_badan' => 'float',
        'bmi_value'    => 'float',
        'recorded_at'  => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Hitung & tentukan status secara otomatis sebelum disimpan */
    protected static function booted(): void
    {
        static::creating(function (BmiRecord $record) {
            $h   = $record->tinggi_badan / 100;
            $bmi = $record->berat_badan / ($h ** 2);

            $record->bmi_value = round($bmi, 2);
            $record->status    = match (true) {
                $bmi < 18.5 => 'underweight',
                $bmi < 25   => 'normal',
                $bmi < 30   => 'overweight',
                $bmi < 35   => 'obese_1',
                $bmi < 40   => 'obese_2',
                default     => 'obese_3',
            };
        });
    }
}