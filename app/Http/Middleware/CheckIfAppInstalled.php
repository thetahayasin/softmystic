<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class CheckIfAppInstalled
{
    public function handle(Request $request, Closure $next)
    {
        $isInstalled = config('app.installed'); // Use config, not env()


        // Check if the APP_INSTALLED environment variable is set to 'true'
        if ($isInstalled) 
        {
            // return $next($request);
            if (str_starts_with($request->path(), 'install'))
            {
                abort('404');                
            }else
            {
                return $next($request);   
            }

        }
        else
        {
            if(str_starts_with($request->path(), 'install'))
            {
                return $next($request);   

            }else
            {
                        Artisan::call('key:generate');

                abort('403', 'Not installed. Go to ('.route('install.step1').') for installation');                
            }
        }

        
    }
}
