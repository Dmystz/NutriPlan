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
                // ✅ Simpan google_avatar setiap login supaya selalu fresh
                $user->update([
                    'google_id'     => $googleUser->getId(),
                    'google_avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                $user = User::create([
                    'nama'           => $googleUser->getName(),
                    'name'           => $googleUser->getName(),
                    'email'          => $googleUser->getEmail(),
                    'google_id'      => $googleUser->getId(),
                    'google_avatar'  => $googleUser->getAvatar(), // ✅ simpan avatar Google
                    'password'       => bcrypt(str()->random(16)),
                    'umur'           => 0,
                    'berat_badan'    => 0,
                    'tinggi_badan'   => 0,
                    'jenis_kelamin'  => 'male',
                    'target'         => 'maintenance',
                    'activity_level' => 1.55,
                ]);
            }

            // ✅ Set session LENGKAP — user_photo untuk lokal, user_google_avatar untuk Google
            session([
                'user_id'            => $user->id,
                'user_name'          => $user->nama ?? $user->name,
                'user_email'         => $user->email,
                'user_photo'         => $user->photo ?? null,          // foto upload manual
                'user_google_avatar' => $user->google_avatar ?? null,  // foto dari Google
            ]);

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