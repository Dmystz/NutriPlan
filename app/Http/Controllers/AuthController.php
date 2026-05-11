<?php

namespace App\Http\Controllers;

use App\Models\BmiRecord;
use App\Models\Planner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ══════════════════════════════
    //  REGISTER
    // ══════════════════════════════

    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:120',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'umur'          => 'required|numeric|min:1|max:120',
            'berat_badan'   => 'required|numeric|min:10|max:500',
            'tinggi_badan'  => 'required|numeric|min:50|max:300',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'target'        => 'nullable|in:maintenance,loss,gain',
        ], [], [
            'name'         => 'Name',
            'umur'         => 'Age',
            'berat_badan'  => 'Weight',
            'tinggi_badan' => 'Height',
        ]);

        // Simpan user
        $user = User::create([
            'nama'          => $request->name,
            'name'          => $request->name,
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
        $h   = $user->tinggi_badan / 100;
        $bmi = round($user->berat_badan / ($h ** 2), 2);
        BmiRecord::create([
            'user_id'      => $user->id,
            'berat_badan'  => $user->berat_badan,
            'tinggi_badan' => $user->tinggi_badan,
            'bmi_value'    => $bmi,
            'status'       => $this->bmiStatus($bmi),
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

            // Login via Auth facade agar konsisten dengan Google OAuth
            Auth::login($user);

            // Kalkulasi BMI & target nutrisi saat login
            $bmi    = $user->hitungBmi();
            $target = $user->targetMakro();

            // Set session manual (backward-compatible)
            session([
                'user_id'         => $user->id,
                'user_name'       => $user->nama ?? $user->name,
                'user_email'      => $user->email,
                'user_photo'      => $user->photo ?? null,
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
    //  LOGOUT
    // ══════════════════════════════

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
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

        // Support session-based dan Auth facade
        $userId = session('user_id') ?? (Auth::check() ? Auth::id() : null);
        if (! $userId) return redirect()->route('login');

        $user = User::findOrFail($userId);
        $user->update($request->only('berat_badan', 'tinggi_badan', 'target', 'activity_level', 'umur'));

        // Simpan rekaman BMI baru jika beda dari sebelumnya
        $lastRecord = $user->bmiRecords()->latest('recorded_at')->first();
        if (! $lastRecord || (float) $lastRecord->berat_badan != (float) $request->berat_badan) {
            $h   = (float) $request->tinggi_badan / 100;
            $bmi = round((float) $request->berat_badan / ($h ** 2), 2);
            BmiRecord::create([
                'user_id'      => $user->id,
                'berat_badan'  => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'bmi_value'    => $bmi,
                'status'       => $this->bmiStatus($bmi),
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

    // ══════════════════════════════
    //  HELPER PRIVATE
    // ══════════════════════════════

    private function bmiStatus(float $bmi): string
    {
        return match (true) {
            $bmi < 18.5 => 'underweight',
            $bmi < 25   => 'normal',
            $bmi < 30   => 'overweight',
            $bmi < 35   => 'obese_1',
            $bmi < 40   => 'obese_2',
            default     => 'obese_3',
        };
    }
}