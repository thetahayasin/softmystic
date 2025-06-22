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
    public function register(): void
    {
        if (!app()->runningInConsole() || Schema::hasTable('site_settings')) {
            View::composer('includes.navbar', function ($view) {
                // Get default locale ID
                $settings = SiteSetting::first(['locale_id', 'platform_id']);
                $defaultLocaleId = $settings->locale_id;
                $defaultPlatformId = $settings->platform_id;

                $default_locale = Locale::find($defaultLocaleId);
                $default_platform = Platform::find($defaultPlatformId);

                $default_locale_slug = $default_locale->slug;
                $default_platform_slug = $default_platform->slug;

                // Get current app locale key (e.g., 'en')
                $localeKey = app()->getLocale();

                // Determine current locale ID
                $localeId = Locale::where('key', $localeKey)->value('id') ?? $defaultLocaleId;
                $locale_slug = Locale::where('id', $localeId)->value('slug') ?? $default_locale_slug;

                // Detect platform from URL segments
                $segments = request()->segments();
                $allPlatformSlugs = Platform::pluck('slug')->toArray();

                $platform_slug = null;
                foreach ($segments as $segment) {
                    if (in_array($segment, $allPlatformSlugs)) {
                        $platform_slug = $segment;
                        break;
                    }
                }

                $platform_slug = $platform_slug ?? $default_platform_slug;

                // Fetch categories with translations
                $categories = Category::whereHas('categoryTranslations', fn($q) => $q->where('locale_id', $localeId))
                    ->with(['categoryTranslations' => fn($q) => $q->where('locale_id', $localeId)])
                    ->get()
                    ->map(function ($category) use ($locale_slug, $platform_slug, $default_locale_slug, $default_platform_slug) {
                        $translation = $category->categoryTranslations->first();
                        return [
                            'url' => $this->generateHelpUrl($locale_slug, $platform_slug, $category->slug, $default_locale_slug, $default_platform_slug),
                            'name' => $translation->name,
                        ];
                    });

                // Get all platforms
                $platforms = Platform::get(['name', 'slug']);

                $view->with(compact('categories', 'platforms'));
            });
        }
    }

    private function generateHelpUrl($locale_slug, $platform_slug, $q, $default_locale_slug, $default_platform_slug)
    {
        $segments = ['category'];
        if ($locale_slug && $locale_slug !== $default_locale_slug) {
            $segments[] = $locale_slug;
        }
        if ($platform_slug && $platform_slug !== $default_platform_slug) {
            $segments[] = $platform_slug;
        }
        $segments[] = $q;

        return url('/') . '/' . implode('/', $segments);
    }

    public function boot(): void
    {
        //
    }
}
