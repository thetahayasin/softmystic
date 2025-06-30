<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class CheckIfAppInstalled
{
    public function handle(Request $request, Closure $next)
    {
        $isInstalled = config('app.installed');
        $isInstallRoute = str_starts_with($request->path(), 'install');
        $appKey = config('app.key');
        $keyValid = !empty($appKey) && strlen($appKey) >= 32;
        $keyMarker = storage_path('app/.key_generated');

        // If app is installed
        if ($isInstalled) {
            if ($isInstallRoute) {
                abort(404);
            }
            return $next($request);
        }

        // If accessing /install route
        if ($isInstallRoute) {
            // If key is missing or invalid, try to generate it
            if (!$keyValid) {
                try {
                    Artisan::call('key:generate', ['--force' => true]);
                    Artisan::call('config:clear');
                    // Double-check if key is now valid
                    $newKey = config('app.key');
                    if (!empty($newKey) && strlen($newKey) >= 32) {
                        @file_put_contents($keyMarker, now()->toDateTimeString());
                        return $next($request);
                    } else {
                        // Key generation failed, show not installed
                        return response()->view('install.not-installed', [
                            'installationUrl' => route('install.step1'),
                            'error' => 'Application key could not be generated. Please check file permissions.'
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('App key generation failed: ' . $e->getMessage());
                    return response()->view('install.not-installed', [
                        'installationUrl' => route('install.step1'),
                        'error' => 'Application key generation failed: ' . $e->getMessage()
                    ]);
                }
            }
            // Key is valid, allow install route
            return $next($request);
        }

        // Not installed and not accessing /install
        return response()->view('install.not-installed', [
            'installationUrl' => route('install.step1'),
        ]);
    }
}