<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'umur',
        'berat_badan',
        'tinggi_badan',
        'jenis_kelamin',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'berat_badan' => 'float',
        'tinggi_badan' => 'float',
    ];

    // Relasi: User memiliki satu Planner
    public function planner()
    {
        return $this->hasOne(Planner::class);
    }

    // Relasi: User membuat banyak JadwalMakanan (lewat Planner)
    public function jadwalMakanan()
    {
        return $this->hasManyThrough(JadwalMakanan::class, Planner::class);
    }
}