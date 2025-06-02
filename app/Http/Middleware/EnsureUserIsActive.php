<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();

            // Regenerate session to prevent issues
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Flash a simple error like invalid credentials
            return redirect()->route('filament.admin.auth.login');
        }

        return $next($request);
    }
}
