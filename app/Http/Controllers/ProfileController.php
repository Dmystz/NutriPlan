<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'berat_badan'   => 'nullable|numeric|min:1|max:500',
            'tinggi_badan'  => 'nullable|numeric|min:1|max:300',
            'umur'          => 'nullable|integer|min:1|max:120',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'target'        => 'nullable|in:maintenance,lose,gain,muscle',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'          => $request->name,
            'email'         => $request->email,
            'berat_badan'   => $request->berat_badan,
            'tinggi_badan'  => $request->tinggi_badan,
            'umur'          => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'target'        => $request->target,
        ];

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $data['photo'] = $path;
            session(['user_photo' => $path]);
        }

        DB::table('users')->where('id', $userId)->update($data);

        // Update semua session yang dipakai navbar & modal
        session([
            'user_name'  => $request->name,
            'user_email' => $request->email,
        ]);

        return redirect()->route('home')->with('success', 'Profil berhasil diperbarui.');
    }
}