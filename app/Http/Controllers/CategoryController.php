<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\Software;
use App\Models\Locale;
use App\Models\Platform;
use App\Models\SiteTranslation;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        $settings = SiteSetting::first(['locale_id', 'platform_id']);
        $default_locale = Locale::find($settings->locale_id);
        $default_platform = Platform::find($settings->platform_id);

        $q = $param3 ?? $param2 ?? $param1;



        $params = array_values(array_filter([$param1, $param2, $param3]));
        array_pop($params);

        $locale = null;
        $platform = null;

        foreach ($params as $param) {
            $loc = $locale ? null : Locale::where('slug', $param)->first();
            $plat = $platform ? null : Platform::where('slug', $param)->first();
            if ($loc) $locale = $loc;
            if ($plat) $platform = $plat;
        }

        $locale = $locale ?? $default_locale;
        $platform = $platform ?? $default_platform;
        app()->setLocale($locale->key);

        $locale_id = $locale->id;
        $platform_id = $platform->id;
        $platform_name = $platform->name;

        $default_locale_slug = $default_locale->slug;
        $default_platform_slug = $default_platform->slug;
        $default_locale_key = $default_locale->key;

        $locale_slug = $locale_id === $default_locale->id ? null : $locale->slug;
        $platform_slug = $platform_id === $default_platform->id ? null : $platform->slug;

        $trns = SiteTranslation::where('locale_id', $locale_id)->first([
            'category_meta_description', 'category_meta_title', 'related', 'latest',
            'for', 'free', 'download', 'version', 'popular', 'category', 'search_results', 'nothing_found'
        ]);

        $ads = SiteSetting::first(['results_page_ad', 'results_page_ad_2', 'site_name', 'site_logo']);

        $cat = Category::with(['categoryTranslations' => fn($q) => $q->where('locale_id', $locale_id)])
        ->where('slug', $q)
        ->first();
        
        if(!$cat)
        {
            abort('404');
        }

        $softwares = Software::with([
            'softwareTranslations' => fn($q2) => $q2->where('locale_id', $locale_id)
                                                  ->select('id', 'software_id', 'locale_id', 'tagline'),
            'license.licenseTranslations' => fn($q3) => $q3->where('locale_id', $locale_id)
                                                          ->select('id', 'license_id', 'locale_id', 'name')
        ])
        ->select(['id', 'name', 'slug', 'file_size', 'version', 'platform_id', 'license_id', 'logo', 'updated_at'])
        ->where('platform_id', $platform_id)
        ->whereHas('softwareTranslations', fn($q4) => $q4->where('locale_id', $locale_id))
        ->when($cat, function ($query) use ($cat) {
            $query->where('category_id', $cat->id);
        })
        ->latest('id')
        ->paginate(12);

        $softwares->getCollection()->transform(function ($item) use (
            $locale_slug, $platform_slug, $default_locale_slug, $default_platform_slug
        ) {
            return [
                'id'       => $item->id,
                'name'     => $item->name,
                'tagline'  => $item->softwareTranslations->first()?->tagline ?? '',
                'license'  => $item->license->licenseTranslations->first()?->name ?? '',
                'fileSize' => $item->readableFilesize,
                'logo'     => $item->logo,
                'updated'  => Carbon::parse($item->updated_at)->format('F, d Y'),
                'url'      => $this->generateSingleUrl(
                    $locale_slug, $platform_slug, $item->slug,
                    $default_locale_slug, $default_platform_slug
                )
            ];
        });

        $cannonical = $this->generateHelpUrl($locale_slug, $platform_slug, $q, $default_locale_slug, $default_platform_slug);

        $locales = Locale::get(['name', 'slug', 'key']);

        $meta_title = $meta_description = '';
        if ($q && $trns) {
            $meta_title = $this->parseShortcodes($trns->category_meta_title ?? '', $cat, $trns, $platform_name);
            $meta_description = $this->parseShortcodes($trns->category_meta_description ?? '', $cat, $trns, $platform_name);
        }

        $alternateUrls = collect($locales)->map(fn($loc) => [
            'hreflang' => $loc->key,
            'url' => $this->generateHelpUrl(
                $loc->slug === $default_locale_slug ? null : $loc->slug,
                $platform_slug, $q, $default_locale_slug, $default_platform_slug
            )
        ])->toArray();

        $localeSwitchUrls = collect($locales)->mapWithKeys(fn($loc) => [
            $loc->key => $this->generateHelpUrl(
                $loc->slug === $default_locale_slug ? null : $loc->slug,
                $platform_slug, $q, $default_locale_slug, $default_platform_slug
            )
        ])->toArray();

        $cat_name = $cat->categoryTranslations->first()?->name ?? '';
        $cat_description = $cat->categoryTranslations->first()?->description ?? '';

        return view('results', compact(
            'softwares', 'trns', 'platform_slug', 'locale_slug', 'localeSwitchUrls', 'cannonical',
            'default_locale_slug', 'default_platform_slug', 'locales', 'default_locale_key',
            'ads', 'meta_title', 'meta_description', 'alternateUrls', 'platform_name', 'cat_name', 'cat_description'
        ));
    }

    private function generateSingleUrl($locale_slug, $platform_slug, $app_slug, $default_locale_slug, $default_platform_slug)
    {
        $segments = ['download'];
        if ($locale_slug && $locale_slug !== $default_locale_slug) $segments[] = $locale_slug;
        if ($platform_slug && $platform_slug !== $default_platform_slug) $segments[] = $platform_slug;
        $segments[] = $app_slug;
        return url('/') . '/' . implode('/', $segments);
    }

    private function generateHelpUrl($locale_slug, $platform_slug, $q, $default_locale_slug, $default_platform_slug)
    {
        $segments = ['category'];
        if ($locale_slug && $locale_slug !== $default_locale_slug) $segments[] = $locale_slug;
        if ($platform_slug && $platform_slug !== $default_platform_slug) $segments[] = $platform_slug;
        $segments[] = $q;
        return url('/') . '/' . implode('/', $segments);
    }

    function parseShortcodes(string $text, object $cat, object $siteTranslations, string $platform): string
    {
        $replacements = [
            '[download]' => $siteTranslations->download ?? '',
            '[category_name]' => $cat->categoryTranslations->first()?->name ?? '',
            '[category_description]' => $cat->categoryTranslations->first()?->description ?? '',
            '[for]' => $siteTranslations->for ?? '',
            '[free]' => $siteTranslations->free ?? '',
            '[latest]' => $siteTranslations->latest ?? '',
            '[popular]' => $siteTranslations->popular ?? '',
            '[search_results]' => $siteTranslations->search_results ?? '',
            '[category]' => $siteTranslations->category ?? '',
            '[year]' => date('Y'),
            '[version]' => $siteTranslations->version ?? '',
            '[platform]' => $platform ?? '',

        ];

        $cleanReplacements = array_map(fn($val) => strip_tags($val), $replacements);
        return str_replace(array_keys($cleanReplacements), array_values($cleanReplacements), $text);
    }
}
