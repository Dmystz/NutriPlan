<?php

namespace App\Http\Controllers;

use App\Models\BmiRecord;
use App\Models\Planner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ══════════════════════════════
    //  REGISTER
    // ══════════════════════════════

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:120',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'umur'         => 'required|numeric|min:1|max:120',
            'berat_badan'  => 'required|numeric|min:10|max:500',
            'tinggi_badan' => 'required|numeric|min:50|max:300',
            'jenis_kelamin' => $request->jenis_kelamin == 'Perempuan'
                                ? 'Perempuan'
                                : 'Laki-laki',
            'target'       => 'nullable|in:maintenance,loss,gain',
        ], [], [
            'name'         => 'Name',
            'umur'         => 'Age',
            'berat_badan'  => 'Weight',
            'tinggi_badan' => 'Height',
        ]);

        // Simpan user
        $user = User::create([
            'nama'          => $request->name,
            'name'          => $request->name,   // kolom lama
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'umur'          => $request->umur,
            'berat_badan'   => $request->berat_badan,
            'tinggi_badan'  => $request->tinggi_badan,
            'jenis_kelamin' => $request->jenis_kelamin ?? 'Laki-laki',
            'target'        => $request->target        ?? 'maintenance',
            'activity_level'=> 1.55,
        ]);

        // Buat Planner otomatis
        Planner::create(['user_id' => $user->id]);

        // Simpan catatan BMI pertama
        BmiRecord::create([
            'user_id'      => $user->id,
            'berat_badan'  => $user->berat_badan,
            'tinggi_badan' => $user->tinggi_badan,
            'recorded_at'  => now()->toDateString(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // ══════════════════════════════
    //  LOGIN
    // ══════════════════════════════

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $request->session()->regenerate();

            // Kalkulasi BMI & target nutrisi saat login agar tersedia di session
            $bmi    = $user->hitungBmi();
            $target = $user->targetMakro();

            session([
                'user_id'         => $user->id,
                'user_name'       => $user->nama ?? $user->name,
                'user_email'      => $user->email,
                'bmi'             => $bmi,
                'bmi_kategori'    => $user->kategoriBmi(),
                'target_kalori'   => $target['kalori'],
                'target_protein'  => $target['protein'],
                'target_carbs'    => $target['carbs'],
                'target_fat'      => $target['fat'],
                'berat_badan'     => $user->berat_badan,
                'tinggi_badan'    => $user->tinggi_badan,
            ]);

            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Email atau password salah!'])->withInput();
    }

    // ══════════════════════════════
    //  UPDATE PROFIL / BODY DATA
    // ══════════════════════════════

    public function updateProfile(Request $request)
    {
        $request->validate([
            'berat_badan'   => 'required|numeric|min:10|max:500',
            'tinggi_badan'  => 'required|numeric|min:50|max:300',
            'target'        => 'nullable|in:maintenance,loss,gain',
            'activity_level'=> 'nullable|numeric|in:1.2,1.375,1.55,1.725,1.9',
        ]);

        $user = User::findOrFail(session('user_id'));
        $user->update($request->only('berat_badan', 'tinggi_badan', 'target', 'activity_level', 'umur'));

        // Simpan rekaman BMI baru jika beda dari sebelumnya
        $lastRecord = $user->bmiRecords()->first();
        if (! $lastRecord || $lastRecord->berat_badan != $request->berat_badan) {
            BmiRecord::create([
                'user_id'      => $user->id,
                'berat_badan'  => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'recorded_at'  => now()->toDateString(),
            ]);
        }

        // Perbarui session
        $target = $user->targetMakro();
        session([
            'bmi'           => $user->hitungBmi(),
            'bmi_kategori'  => $user->kategoriBmi(),
            'target_kalori' => $target['kalori'],
            'target_protein'=> $target['protein'],
            'target_carbs'  => $target['carbs'],
            'target_fat'    => $target['fat'],
            'berat_badan'   => $user->berat_badan,
            'tinggi_badan'  => $user->tinggi_badan,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}