<?php

namespace App\Providers;

use App\Models\Locale;
use App\Models\SiteSetting;
use App\Models\SiteTranslation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class FooterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (!app()->runningInConsole() || Schema::hasTable('site_settings')) {
            View::composer('includes.footer', function ($view) {
                // Get current app locale (e.g. 'en', 'fr')
                $localeKey = app()->getLocale();
                // Get default locale ID from settings
                $defaultLocaleId = SiteSetting::value('locale_id');

                // Resolve current locale ID or use default
                $localeId = Locale::where('key', $localeKey)->value('id') ?? $defaultLocaleId;

                // Fetch footer text for the resolved locale
                $footer = SiteTranslation::where('locale_id', $localeId)->value('footer_text');

                // Pass to view
                $view->with(compact('footer'));
                
            }); 
        }
   
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
