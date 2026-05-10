<?php
namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                $user->update(['google_id' => $googleUser->getId()]);
            } else {
                $user = User::create([
                    'nama'           => $googleUser->getName(),
                    'name'           => $googleUser->getName(),
                    'email'          => $googleUser->getEmail(),
                    'google_id'      => $googleUser->getId(),
                    'password'       => bcrypt(str()->random(16)),
                    'umur'           => 0,
                    'berat_badan'    => 0,
                    'tinggi_badan'   => 0,
                    'jenis_kelamin'  => 'male',
                    'target'         => 'maintenance',
                    'activity_level' => 1.55,
                ]);
            }

            session([
                'user_id'    => $user->id,
                'user_name'  => $user->nama ?? $user->name,
                'user_email' => $user->email,
            ]);

            // Kalau data belum lengkap arahkan ke complete profile
            if (!$user->umur || !$user->berat_badan || !$user->tinggi_badan) {
                return redirect()->route('profile.complete')
                                 ->with('info', 'Lengkapi data profilmu terlebih dahulu!');
            }

            return redirect()->route('home');

        } catch (\Exception $e) {
            return redirect()->route('login')
                             ->with('error', 'Google login gagal. Silakan coba lagi.');
        }
    }
}