<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::composer('layouts.app', function ($view) {
            // Get current app locale (e.g. 'en', 'fr')
            $localeKey = app()->getLocale();

            // Get default locale ID from settings
            $settings = SiteSetting::select('footer_code', 'header_code', 'site_theme')->first();


            // Pass to view
            $view->with(compact('settings'));
        }); 
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
