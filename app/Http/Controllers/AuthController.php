<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validasi basic
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        // insert ke database
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('register')->with('success', 'Register berhasil!');
    }
    public function login(Request $request)
    {
    $user = DB::table('users')
        ->where('email', $request->email)
        ->first();

    if ($user && Hash::check($request->password, $user->password)) {

        // simpan session
        session([
            'user_id' => $user->id,
            'user_name' => $user->name
        ]);

        return redirect()->route('home');
    }

    return back()->with('error', 'Email atau password salah!');
    }
}