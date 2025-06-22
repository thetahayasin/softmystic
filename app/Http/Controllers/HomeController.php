<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Software;
use App\Models\Locale;
use App\Models\Platform;
use App\Models\SiteTranslation;

class HomeController extends Controller
{

    public function index($param1 = null, $param2 = null)
    {
        // Get site-wide default locale and platform
        $settings = SiteSetting::first(['locale_id', 'platform_id']);
        $default_locale_id = $settings->locale_id;
        $default_platform_id = $settings->platform_id;
        $default_platform = Platform::find($default_platform_id);
        $default_locale = Locale::find($default_locale_id);
    
        // Try to detect what param1 and param2 are
        $param1_locale = Locale::where('slug', $param1)->first();
        $param1_platform = Platform::where('slug', $param1)->first();
        $param2_platform = Platform::where('slug', $param2)->first();
    
        // Determine final locale and platform
        if ($param1_locale) {
            $locale = $param1_locale;
            $platform = $param2_platform ?? $default_platform;
        } elseif ($param1_platform) {
            $locale = $default_locale;
            $platform = $param1_platform;
        } else {
            $locale = $default_locale;
            $platform = $default_platform;
        }
    
        // ✅ Set the Laravel app locale for translations
        app()->setLocale($locale->key);
    
        $locale_id = $locale->id;
        $platform_id = $platform->id;

    
        // Fetch site-wide translations
        $trns = SiteTranslation::where('locale_id', $locale_id)->first([
            'hero_title',
            'hero_text',
            'featured_apps',
            'latest_updates',
            'new_releases',
            'trending_apps',
            'home_meta_title',
            'home_meta_description'
        ]);

        // Fetch ads
        $ads = SiteSetting::first([
            'home_page_ad',
            'home_page_ad_2',
            'site_name',
            'site_logo'
        ]);

        //url generation vars
        $default_locale_slug = $default_locale->slug;
        $default_platform_slug = $default_platform->slug;

        if($platform_id == $default_platform_id)
        {
            $platform_slug = null;
        }
        else
        {
            $platform_slug = $platform->slug;
        }

        if($locale_id == $default_locale_id)
        {
            $locale_slug = null;
        }
        else
        {
            $locale_slug = $locale->slug;
        }
    
        $updates = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'latest' => 'updated_at',
            'take'   => 8,
        ]);
        
        $newreleases = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'latest' => 'created_at',
            'take'   => 8,
        ]);
        
        $popular = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'order_by' => 'downloads',
            'take'     => 16,
        ]);
        
        $featured = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'is_featured' => true,
            'latest'      => 'updated_at',
            'take'        => 2,
        ]);        
    

        // Get all locales
        $locales = Locale::get(['name', 'slug', 'key']);

        return view('home', compact('featured', 'updates', 'newreleases', 'popular', 'trns', 'platform_slug', 'locale_slug', 'default_locale_slug', 'default_platform_slug', 'locales', 'ads'));
    }

    private function generateSingleUrl($locale_slug, $platform_slug, $app_slug)
    {
        $segments = array_filter(['download', $locale_slug, $platform_slug, $app_slug]);
        return '/' . implode('/', $segments);
    }

    private function getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, array $options = [])
    {
        $query = Software::with([
            'softwareTranslations' => fn ($q) => $q->where('locale_id', $locale_id),
            'author'
        ])
        ->where('platform_id', $platform_id);
    
        if (isset($options['is_featured'])) {
            $query->where('is_featured', true);
        }
    
        if (isset($options['order_by'])) {
            $query->orderByDesc($options['order_by']);
        } elseif (isset($options['latest'])) {
            $query->latest($options['latest']);
        }
    
        if (isset($options['take'])) {
            $query->take($options['take']);
        }
    
        return $query->get()
            ->filter(fn ($software) => $software->softwareTranslations->isNotEmpty())
            ->map(fn ($software) => [
                'name'     => $software->name,
                'slug'     => $software->slug,
                'version'  => $software->version ?? null,
                'logo'     => $software->logo,
                'tagline'  => optional($software->softwareTranslations->first())->tagline,
                'author'   => optional($software->author)->name ?? null,
                'url'      => $this->generateSingleUrl($locale_slug, $platform_slug, $software->slug),
            ])
            ->values();
    }
    
    
    
}