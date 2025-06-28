<?php

namespace App\Providers;

use App\Models\Locale;
use App\Models\Page;
use App\Models\Platform;
use App\Models\SiteSetting;
use App\Models\SiteTranslation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FooterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (!app()->runningInConsole() || Schema::hasTable('site_settings')) {
            View::composer('includes.footer', function ($view) {
                // Get app locale key (e.g. 'en') and resolve locale model
                $localeKey = app()->getLocale();
                $currentLocale = Locale::where('key', $localeKey)->first();

                // Fallback to defaults if necessary
                $settings = SiteSetting::first(['locale_id', 'platform_id']);
                $defaultLocale = Locale::find($settings->locale_id);
                $defaultPlatform = Platform::find($settings->platform_id);

                $localeSlug = $currentLocale?->slug ?? $defaultLocale?->slug;
                $localeId = $currentLocale?->id ?? $defaultLocale?->id;

                $defaultLocaleSlug = $defaultLocale?->slug;
                $defaultPlatformSlug = $defaultPlatform?->slug;

                // Use platform from settings (or hardcode detection logic if needed)
                $platformSlug = $defaultPlatformSlug;

                // Footer content
                $footer = SiteTranslation::where('locale_id', $localeId)->value('footer_text');

                // Fetch pages with translations
                $pages = Page::select('id', 'slug')
                    ->whereHas('translations', function ($q) use ($localeId) {
                        $q->where('locale_id', $localeId);
                    })
                    ->with(['translations' => function ($q) use ($localeId) {
                        $q->select('id', 'page_id', 'locale_id', 'title')
                          ->where('locale_id', $localeId);
                    }])
                    ->get()
                    ->map(function ($page) use ($localeSlug, $defaultLocaleSlug, $platformSlug, $defaultPlatformSlug) {
                        $segments = ['page'];

                        if ($localeSlug !== $defaultLocaleSlug) {
                            $segments[] = $localeSlug;
                        }

                        if ($platformSlug !== $defaultPlatformSlug) {
                            $segments[] = $platformSlug;
                        }

                        $segments[] = $page->slug;

                        return (object)[
                            'title' => $page->translations->first()?->title ?? '',
                            'url' => url(implode('/', $segments)),
                        ];
                    });

                $view->with(compact('footer', 'pages'));
            });
        }
    }

    public function boot(): void
    {
        // No boot logic needed here
    }
}
