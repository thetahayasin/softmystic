<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Software;
use App\Models\Locale;
use App\Models\Platform;
use App\Models\SiteTranslation;

class PostDownloadController extends Controller
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

        // Fetch site-wide translations
        $trns = SiteTranslation::where('locale_id', $locale_id)->first([
            'download_meta_description',
            'download_meta_title',
            'related',
            'latest',
            'for',
            'free',
            'download',
            'buy_now',
            'downloading_text',
            'version',
            'popular',
            'category',
            'search_results'

        ]);

        // Fetch ads and site info
        $ads = SiteSetting::first([
            'download_page_ad',
            'download_page_ad_2',
            'site_name',
            'site_logo'
        ]);

        // Current software details
        $software = Software::with([
            'category.categoryTranslations' => function ($q2) use ($locale_id) {
                $q2->select('id', 'category_id', 'locale_id', 'name')
                   ->where('locale_id', $locale_id);
            }
        ])
        ->select([
            'id', 'name', 'version',
            'platform_id', 'category_id', 'logo', 'download_url', 'slug'
        ])
        ->where('slug', $slug)
        ->where('platform_id', $platform_id)
        ->firstOrFail();
        //increase downloads by 1    
        $software->timestamps = false;
        $software->increment('downloads');


        //get url
        $software->url = $this->generateSingleUrl($locale_slug, $platform_slug, $software->slug, $default_locale_slug, $default_platform_slug);


        // trending apps query
        $related = Software::select(['id', 'name', 'slug', 'logo', 'platform_id'])
        ->with([
            'softwareTranslations' => fn ($q) => $q->select('id', 'software_id', 'locale_id', 'tagline')
                                                   ->where('locale_id', $locale_id),
        ])
        ->where('platform_id', $software->platform_id)
        ->where('id', '!=', $software->id)
        ->take(12)
        ->orderBy('downloads', 'desc')
        ->get()
        ->filter(fn ($item) => $item->softwareTranslations->isNotEmpty()) // ✅ skip untranslated
        ->map(function ($item) use ($locale_slug, $platform_slug, $default_locale_slug, $default_platform_slug) {
            return [
                'url'     => $this->generateSingleUrl($locale_slug, $platform_slug, $item->slug, $default_locale_slug, $default_platform_slug),
                'name'    => $item->name,
                'tagline' => $item->softwareTranslations->first()?->tagline ?? '',
                'logo'    => $item->logo,
            ];
        })
        
        ->values();
    
        

        // Get all locales
        $locales = Locale::get(['name', 'slug', 'key']);

        //meta title and description
        if($software != null && $trns != null)
        {
            $meta_title = $this->parseShortcodes($trns->download_meta_title ?? '', $software, $trns);
            $meta_description = $this->parseShortcodes($trns->download_meta_description ?? '', $software, $trns);
        }
        else
        {
            $meta_title = '';
            $meta_description = '';
        }

        // Generate alternate URLs for all locales (ignore platforms for alternate)
        $alternateUrls = [];

        foreach ($locales as $loc) {
            // If this locale is default, no slug in URL
            $alt_locale_slug = $loc->slug === $default_locale_slug ? null : $loc->slug;

            // For alternate URLs, platform slug is null (ignore platform)
            $url = $this->generateDownloadingUrl($alt_locale_slug, $platform_slug, $software->slug, $default_locale_slug, $default_platform_slug);

            $alternateUrls[] = [
                'hreflang' => $loc->key,   // e.g. 'en', 'fr', 'de'
                'url'      => $url,
            ];
        }

        $localeSwitchUrls = [];

        foreach ($locales as $loc) {
            $alt_locale_slug = $loc->slug === $default_locale_slug ? null : $loc->slug;
        
            $localeSwitchUrls[$loc->key] = $this->generateDownloadingUrl(
                $alt_locale_slug,
                $platform_slug,
                $software->slug,
                $default_locale_slug,
                $default_platform_slug
            );
        }
        if (!$trns) {
            $trns = (object) [];
        }
        $category_url = $this->generateCategoryUrl($locale_slug, $platform_slug, $software->category?->slug, $default_locale_slug, $default_platform_slug);
        $downloading_text = $this->parseShortcodes($trns->downloading_text ?? '', $software, $trns);

        // Pass all data to view
        return view('postdownload', compact(
            'software',
            'trns',
            'platform_slug',
            'locale_slug',
            'localeSwitchUrls',
            'locale_slug',
            'default_locale_slug',
            'downloading_text',
            'default_platform_slug',
            'locales',
            'default_locale_key',
            'ads',
            'related',
            'meta_title',
            'meta_description',
            'alternateUrls',
            'category_url'
        ));
    }

    private function generateSingleUrl($locale_slug, $platform_slug, $app_slug, $default_locale_slug, $default_platform_slug)
    {
        $segments = ['download'];
    
        if ($locale_slug !== $default_locale_slug && $locale_slug !== null) {
            $segments[] = $locale_slug;
        }
    
        if ($platform_slug !== $default_platform_slug && $platform_slug !== null) {
            $segments[] = $platform_slug;
        }
    
        $segments[] = $app_slug;
    
        return url('/') . '/' . implode('/', $segments);
    }

    function parseShortcodes(string $text, object $software, object $siteTranslations): string
    {

        $replacements = [
            '[software_name]'        => $software->name ?? '',
            '[download]'             => $siteTranslations->download ?? '',
            '[for]'                  => $siteTranslations->for ?? '',
            '[free]'                 => $siteTranslations->free ?? '',
            '[software_version]'     => $software->version ?? '',
            '[latest]'               => $siteTranslations->latest ?? '',
            '[popular]'              => $siteTranslations->popular ?? '',
            '[search_results]'       => $siteTranslations->search_results ?? '',
            '[category]'             => $siteTranslations->category ?? '',
            '[year]'                 => date('Y'),
            '[version]'              => $siteTranslations->version ?? '',
            '[software_description]' => $software->softwareTranslations->first()->content ?? '',
            '[software_tagline]'     => $software->softwareTranslations->first()->tagline ?? '',
            '[software_platform]'     => $software->platform->first()->name ?? '',

        ];

        
    
        // Apply strip_tags to each replacement value
        $cleanReplacements = array_map(fn($value) => strip_tags($value), $replacements);
    
        return str_replace(array_keys($cleanReplacements), array_values($cleanReplacements), $text);
    }

    private function generateDownloadingUrl($locale_slug, $platform_slug, $q, $default_locale_slug, $default_platform_slug)
    {
        $segments = ['downloading'];
        if ($locale_slug && $locale_slug !== $default_locale_slug) $segments[] = $locale_slug;
        if ($platform_slug && $platform_slug !== $default_platform_slug) $segments[] = $platform_slug;
        $segments[] = $q;
        return url('/') . '/' . implode('/', $segments);
    }

    private function generateCategoryUrl($locale_slug, $platform_slug, $q, $default_locale_slug, $default_platform_slug)
    {
        $segments = ['category'];
        if ($locale_slug && $locale_slug !== $default_locale_slug) $segments[] = $locale_slug;
        if ($platform_slug && $platform_slug !== $default_platform_slug) $segments[] = $platform_slug;
        $segments[] = $q;
        return url('/') . '/' . implode('/', $segments);
    }
}
