<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|min:6',
            'umur'         => 'required|numeric',
            'berat_badan'  => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ], [], [
            // Custom name agar error message rapi (misal: "The weight field is required")
            'umur'         => 'age',
            'berat_badan'  => 'weight',
            'tinggi_badan' => 'height',
        ]);

        // Proses Simpan ke Database
        $userId = DB::table('users')->insertGetId([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'umur'         => $request->umur,
            'berat_badan'  => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);
        DB::table('planners')->insert([
        'user_id'    => $userId, // Menghubungkan ke user yang baru daftar
        'created_at' => now(),
        'updated_at' => now()
        ]);

        return redirect()->route('login')->with('success', 'Register berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $request->session()->regenerate();
            
            session([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
            ]);
            
            return redirect()->route('home');
        }

        return back()->with('error', 'Email atau password salah!');
    }
}