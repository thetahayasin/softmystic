<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Locale;
use App\Models\Platform;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class NavbarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        if (!app()->runningInConsole() || Schema::hasTable('site_settings')) {
            View::composer('includes.navbar', function ($view) {
                // Get site-wide default locale ID
                $settings = SiteSetting::first(['locale_id']);
                $defaultLocaleId = $settings->locale_id;

                // Get current app locale key (slug), e.g., 'en', 'fr'
                $localeKey = app()->getLocale();

                // Resolve locale ID or fallback to default
                $localeId = Locale::where('key', $localeKey)->value('id') ?? $defaultLocaleId;

                // Fetch categories with translations for the resolved locale only
                $categories = Category::whereHas('categoryTranslations', fn($q) => $q->where('locale_id', $localeId))
                    ->with(['categoryTranslations' => fn($q) => $q->where('locale_id', $localeId)])
                    ->get()
                    ->map(function ($category) {
                        $translation = $category->categoryTranslations->first();
                        return [
                            'slug' => $category->slug,
                            'name' => $translation->name,
                        ];
                    });

                // Get all platforms
                $platforms = Platform::get(['name', 'slug']);

                // Pass data to view
                $view->with(compact('categories', 'platforms'));
            });
        }

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
