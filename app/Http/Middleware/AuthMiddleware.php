<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $loggedIn = session('user_id') || Auth::check();

        if (!$loggedIn) {
            // Kalau request AJAX (fetch dari JS), return JSON bukan redirect
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}