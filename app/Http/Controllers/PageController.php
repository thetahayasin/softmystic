<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Software;
use App\Models\Locale;
use App\Models\Page;
use App\Models\Platform;
use App\Models\SiteTranslation;

class PageController extends Controller
{

    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        // Site-wide default locale and platform
        $settings = SiteSetting::first(['locale_id', 'platform_id']);
        $default_locale = Locale::find($settings->locale_id);
        $default_platform = Platform::find($settings->platform_id);

        // Determine which param is the software slug (always last one)
        $slug = $param3 ?? $param2 ?? $param1;

        // Extract params into array and remove slug
        $params = array_filter([$param1, $param2, $param3]);
        $params = array_values($params);
        array_pop($params); // Remove last (slug)

        // Try to detect locale/platform
        $locale = null;
        $platform = null;

        foreach ($params as $param) {
            if (!$locale) {
                $loc = Locale::where('slug', $param)->first();
                if ($loc) {
                    $locale = $loc;
                    continue;
                }
            }
            if (!$platform) {
                $plat = Platform::where('slug', $param)->first();
                if ($plat) {
                    $platform = $plat;
                }
            }
        }

        // Fallbacks
        $locale = $locale ?? $default_locale;
        $platform = $platform ?? $default_platform;

        // Set Laravel locale
        app()->setLocale($locale->key);

        // IDs for convenience
        $locale_id = $locale->id;
        $platform_id = $platform->id;

        // Generate slugs for dynamic URLs BEFORE related apps query
        $default_locale_slug = $default_locale->slug;
        $default_locale_key = $default_locale->key;
        $default_platform_slug = $default_platform->slug;

        $locale_slug = $locale_id === $default_locale->id ? null : $locale->slug;
        $platform_slug = $platform_id === $default_platform->id ? null : $platform->slug;


        // Fetch ads and site info
        $ads = SiteSetting::first([
            'single_page_ad',
            'single_page_ad_2',
            'site_name',
            'site_logo'
        ]);

        // Current page details
        $page = Page::where('slug', $slug)
        ->whereHas('translations', function ($q) use ($locale_id) {
            $q->where('locale_id', $locale_id);
        })
        ->with(['translations' => fn($q) => $q->where('locale_id', $locale_id)])
        ->firstOrFail();

        //get url
        //$software->url = $this->generateSingleUrl($locale_slug, $platform_slug, $software->slug, $default_locale_slug, $default_platform_slug);

        

        // Get all locales
        $locales = Locale::get(['name', 'slug', 'key']);


        //Generate alternate URLs for all locales (ignore platforms for alternate)
        $alternateUrls = [];

        foreach ($locales as $loc) {
            // If this locale is default, no slug in URL
            $alt_locale_slug = $loc->slug === $default_locale_slug ? null : $loc->slug;

            // For alternate URLs, platform slug is null (ignore platform)
            $url = $this->generateSingleUrl($alt_locale_slug, $platform_slug, $page->slug, $default_locale_slug, $default_platform_slug);

            $alternateUrls[] = [
                'hreflang' => $loc->key,   // e.g. 'en', 'fr', 'de'
                'url'      => $url,
            ];
        }

        $localeSwitchUrls = [];

        foreach ($locales as $loc) {
            $alt_locale_slug = $loc->slug === $default_locale_slug ? null : $loc->slug;
        
            $localeSwitchUrls[$loc->key] = $this->generateSingleUrl(
                $alt_locale_slug,
                $platform_slug,
                $page->slug,
                $default_locale_slug,
                $default_platform_slug
            );
        }

        // Pass all data to view
        return view('page', compact(
            'page',
            'platform_slug',
            'locale_slug',
            'localeSwitchUrls',
            'locale_slug',
            'default_locale_slug',
            'default_platform_slug',
            'locales',
            'default_locale_key',
            'ads',
            'alternateUrls'

        ));
    }

    private function generateSingleUrl($locale_slug, $platform_slug, $app_slug, $default_locale_slug, $default_platform_slug)
    {
        $segments = ['page'];
    
        if ($locale_slug !== $default_locale_slug && $locale_slug !== null) {
            $segments[] = $locale_slug;
        }
    
        if ($platform_slug !== $default_platform_slug && $platform_slug !== null) {
            $segments[] = $platform_slug;
        }
    
        $segments[] = $app_slug;
    
        return url('/') . '/' . implode('/', $segments);
    }
}
