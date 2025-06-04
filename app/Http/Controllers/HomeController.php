<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Software;
use App\Models\SoftwareTranslation;
use Illuminate\Http\Request;
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
    
        // Fetch featured apps
        $featured = Software::with([
            'softwareTranslations' => fn ($q) => $q->where('locale_id', $locale_id),
            'author'
        ])
        ->where('is_featured', true)
        ->where('platform_id', $platform_id)
        ->latest('updated_at')
        ->take(3)
        ->get()
        ->map(fn ($software) => [
            'name'     => $software->name,
            'slug'     => $software->slug,
            'version'  => $software->version,
            'logo'     => $software->logo,
            'tagline'  => optional($software->softwareTranslations->first())->tagline,
            'author'   => optional($software->author)->name,
        ]);
    
        // Latest updates
        $updates = Software::with([
            'softwareTranslations' => fn ($q) => $q->where('locale_id', $locale_id),
            'author'
        ])
        ->latest('updated_at')
        ->where('platform_id', $platform_id)
        ->take(8)
        ->get()
        ->map(fn ($software) => [
            'name'     => $software->name,
            'slug'     => $software->slug,
            'logo'     => $software->logo,
            'tagline'  => optional($software->softwareTranslations->first())->tagline,
        ]);
    
        // New releases
        $newreleases = Software::with([
            'softwareTranslations' => fn ($q) => $q->where('locale_id', $locale_id),
            'author'
        ])
        ->latest('created_at')
        ->where('platform_id', $platform_id)
        ->take(8)
        ->get()
        ->map(fn ($software) => [
            'name'     => $software->name,
            'slug'     => $software->slug,
            'logo'     => $software->logo,
            'tagline'  => optional($software->softwareTranslations->first())->tagline,
        ]);
    
        // Popular
        $popular = Software::with([
            'softwareTranslations' => fn ($q) => $q->where('locale_id', $locale_id),
            'author'
        ])
        ->orderByDesc('downloads')
        ->where('platform_id', $platform_id)
        ->take(16)
        ->get()
        ->map(fn ($software) => [
            'name'     => $software->name,
            'slug'     => $software->slug,
            'logo'     => $software->logo,
            'tagline'  => optional($software->softwareTranslations->first())->tagline,
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

        // Get all locales
        $locales = Locale::get(['name', 'slug', 'key']);




        return view('home', compact('featured', 'updates', 'newreleases', 'popular', 'trns', 'platform_slug', 'locale_slug', 'default_locale_slug', 'default_platform_slug', 'locales'));
    }
    
    
}
