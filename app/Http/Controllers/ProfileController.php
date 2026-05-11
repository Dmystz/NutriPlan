<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Ambil user ID dari session ATAU Auth facade (support Google OAuth).
     */
    private function getUserId(): ?int
    {
        $id = session('user_id');
        if (! $id && Auth::check()) {
            $id = Auth::id();
        }
        return $id ? (int) $id : null;
    }

    /**
     * Update profil user (nama, email, body data, foto).
     */
    public function update(Request $request)
    {
        $userId = $this->getUserId();
        if (! $userId) {
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
            $path         = $request->file('photo')->store('profile_photos', 'public');
            $data['photo'] = $path;
        }

        DB::table('users')->where('id', $userId)->update($data);

        // Refresh session dari DB supaya akurat
        $updatedUser = DB::table('users')->where('id', $userId)->first();

        session([
            'user_name'          => $updatedUser->name,
            'user_email'         => $updatedUser->email,
            'user_photo'         => $updatedUser->photo ?? null,
            // Jaga google_avatar tetap ada (jangan dihapus saat edit profil)
            'user_google_avatar' => $updatedUser->google_avatar ?? session('user_google_avatar'),
        ]);

        return redirect()->route('home')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Tampilkan halaman complete profile (setelah Google OAuth jika data belum lengkap).
     */
    public function showComplete()
    {
        $userId = $this->getUserId();
        if (! $userId) {
            return redirect()->route('login');
        }

        $user = DB::table('users')->where('id', $userId)->first();
        if ($user && $user->umur && $user->berat_badan && $user->tinggi_badan) {
            return redirect()->route('home');
        }

        return view('auth.complete_profile');
    }

    /**
     * Simpan data profil yang dilengkapi setelah Google OAuth.
     */
    public function complete(Request $request)
    {
        $userId = $this->getUserId();
        if (! $userId) {
            return redirect()->route('login');
        }

        $request->validate([
            'umur'           => 'required|integer|min:1|max:120',
            'berat_badan'    => 'required|numeric|min:1|max:500',
            'tinggi_badan'   => 'required|numeric|min:1|max:300',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'target'         => 'required|in:maintenance,loss,gain',
            'activity_level' => 'required|numeric',
        ]);

        DB::table('users')
            ->where('id', $userId)
            ->update([
                'umur'           => $request->umur,
                'berat_badan'    => $request->berat_badan,
                'tinggi_badan'   => $request->tinggi_badan,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'target'         => $request->target,
                'activity_level' => $request->activity_level,
            ]);

        return redirect()->route('home')->with('success', 'Profil berhasil dilengkapi!');
    }
}