<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // ── 1. Tampilkan form Forgot Password ──────────────────────────────
    public function showForgotForm()
    {
        return view('auth.forgot_password');
    }

    // ── 2. Kirim link reset ke email ───────────────────────────────────
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Selalu tampilkan pesan sukses meski email tidak ada (security best practice)
        if (!$user) {
            return back()->with('success', 'If that email exists, a reset link has been sent.');
        }

        // Hapus token lama jika ada
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => hash('sha256', $token),
            'created_at' => Carbon::now(),
        ]);

        $resetUrl = route('password.reset.form', ['token' => $token, 'email' => $request->email]);

        // Kirim email
        Mail::send('emails.reset_password', ['resetUrl' => $resetUrl, 'user' => $user], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('NutriPlan – Reset Your Password');
        });

        return back()->with('success', 'A password reset link has been sent to your email.');
    }

    // ── 3. Tampilkan form Reset Password ──────────────────────────────
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset_password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // ── 4. Proses reset password baru ─────────────────────────────────
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email',
            'token'                 => 'required',
            'password'              => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Validasi token & expiry (60 menit)
        if (
            !$record ||
            !hash_equals($record->token, hash('sha256', $request->token)) ||
            Carbon::parse($record->created_at)->addMinutes(60)->isPast()
        ) {
            return back()->withErrors(['email' => 'This password reset link is invalid or has expired.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password reset successful! Please log in.');
    }
}