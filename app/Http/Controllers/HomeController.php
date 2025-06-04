<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Software;
use App\Models\SoftwareTranslation;
use Illuminate\Http\Request;
use App\Models\Locale;
use App\Models\Platform;

class HomeController extends Controller
{

    public function index($param1 = null, $param2 = null)
    {
        // Get site-wide default locale and platform
        $settings = SiteSetting::first(['locale_id', 'platform_id']);
        $default_locale = $settings->locale_id;
        $default_platform = $settings->platform_id;
    
        // Try to detect what param1 and param2 are
        $param1_locale = Locale::where('slug', $param1)->first();
        $param1_platform = Platform::where('slug', $param1)->first();
        $param2_platform = Platform::where('slug', $param2)->first();
    
        // Determine final locale and platform
        if ($param1_locale) {
            $locale_id = $param1_locale->id;
            $platform_id = $param2_platform?->id ?? $default_platform;
        } elseif ($param1_platform) {
            $locale_id = $default_locale;
            $platform_id = $param1_platform->id;
        } else {
            $locale_id = $default_locale;
            $platform_id = $default_platform;
        }
    
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
    
        return view('home', compact('featured', 'updates', 'newreleases', 'popular'));
    }
    
}
