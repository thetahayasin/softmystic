<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View; // Import the View facade

class CheckIfAppInstalled
{
    public function handle(Request $request, Closure $next)
    {
        $isInstalled = config('app.installed');

        if ($isInstalled) {
            // If installed, prevent access to install routes
            if (str_starts_with($request->path(), 'install')) {
                abort(404);
            }
            return $next($request);
        } else {
            // If not installed
            if (str_starts_with($request->path(), 'install')) {
                // Allow access to install routes
                return $next($request);
            } else {
                // App is not installed and user is trying to access other routes
                // Ensure the application key is generated if it hasn't been (optional, but good practice)
                // You might want to move this to a more appropriate place in a real installer
                // if (!config('app.key')) {
                //     Artisan::call('key:generate');
                // }

                // Return a custom view for the "app not installed" message
                return response()->view('install.not-installed', [
                    'installationUrl' => route('install.step1') // Assuming you have this route defined
                ]);
            }
        }
    }
}