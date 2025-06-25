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
        // Get site settings with necessary fields
        $settings = SiteSetting::first([
            'locale_id', 'platform_id',
            'home_page_ad', 'home_page_ad_2',
            'site_name', 'site_logo'
        ]);

        [$default_locale_id, $default_platform_id] = [$settings->locale_id, $settings->platform_id];

        // Fetch both default models in one query
        [$default_locale, $default_platform] = collect(
            Locale::whereIn('id', [$default_locale_id])
                ->get()
                ->concat(Platform::whereIn('id', [$default_platform_id])->get())
        )->partition(fn ($model) => $model instanceof Locale);

        $default_locale = $default_locale->first();
        $default_platform = $default_platform->first();

        // Match params by slug in one go
        $all_locales = Locale::get(['id', 'slug', 'key', 'name']);
        $all_platforms = Platform::get(['id', 'slug', 'name']);

        $param1_locale = $all_locales->firstWhere('slug', $param1);
        $param1_platform = $all_platforms->firstWhere('slug', $param1);
        $param2_platform = $all_platforms->firstWhere('slug', $param2);

        // Decide locale/platform from params
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

        app()->setLocale($locale->key);
        $locale_id = $locale->id;
        $platform_id = $platform->id;

        // Site translation for selected locale
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

        // Generate slug vars
        $locale_slug = $locale_id !== $default_locale_id ? $locale->slug : null;
        $platform_slug = $platform_id !== $default_platform_id ? $platform->slug : null;
        $default_locale_slug = $default_locale->slug;
        $default_platform_slug = $default_platform->slug;

        // Software lists
        $updates = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'latest' => 'updated_at', 'take' => 8
        ]);

        $newreleases = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'latest' => 'created_at', 'take' => 8
        ]);

        $popular = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'order_by' => 'downloads', 'take' => 16
        ]);

        $featured = $this->getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, [
            'is_featured' => true, 'latest' => 'updated_at', 'take' => 2
        ]);

        return view('home', [
            'featured' => $featured,
            'updates' => $updates,
            'newreleases' => $newreleases,
            'popular' => $popular,
            'trns' => $trns,
            'platform_slug' => $platform_slug,
            'locale_slug' => $locale_slug,
            'default_locale_slug' => $default_locale_slug,
            'default_platform_slug' => $default_platform_slug,
            'locales' => $all_locales,
            'ads' => $settings
        ]);
    }

    private function generateSingleUrl($locale_slug, $platform_slug, $app_slug)
    {
        return '/' . implode('/', array_filter(['download', $locale_slug, $platform_slug, $app_slug]));
    }

    private function getTranslatedSoftware($platform_id, $locale_id, $locale_slug, $platform_slug, array $options = [])
    {
        $query = Software::with([
            'softwareTranslations' => fn ($q) =>
                $q->where('locale_id', $locale_id)->select('id', 'software_id', 'tagline', 'locale_id'),
            'author:id,name'
        ])
        ->select('id', 'name', 'slug', 'version', 'logo', 'platform_id', 'downloads', 'created_at', 'updated_at')
        ->where('platform_id', $platform_id);

        if (!empty($options['is_featured'])) {
            $query->where('is_featured', true);
        }

        if (!empty($options['order_by'])) {
            $query->orderByDesc($options['order_by']);
        } elseif (!empty($options['latest'])) {
            $query->latest($options['latest']);
        }

        if (!empty($options['take'])) {
            $query->take($options['take']);
        }

        return $query->get()
            ->filter(fn ($software) => $software->softwareTranslations->isNotEmpty())
            ->map(fn ($software) => [
                'name'    => $software->name,
                'slug'    => $software->slug,
                'version' => $software->version,
                'logo'    => $software->logo,
                'tagline' => $software->softwareTranslations->first()->tagline ?? null,
                'author'  => $software->author->name ?? null,
                'url'     => $this->generateSingleUrl($locale_slug, $platform_slug, $software->slug),
            ])
            ->values();
    }
}
