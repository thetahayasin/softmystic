<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use App\Models\Software;
use App\Models\Page;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\Locale;
use App\Models\Platform;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate full sitemap with hreflang entries and default locale/platform primary URL';

    protected int $maxUrlsPerFile = 40000;
    protected int $urlCounter = 0;
    protected int $fileCounter = 1;
    protected ?Sitemap $currentSitemap = null;
    protected ?SitemapIndex $sitemapIndex = null;
    protected string $basePath = '/sitemap/';

    protected $defaultLocaleId;
    protected $defaultPlatformId;
    protected $locales;
    protected $platforms;

    public function handle()
    {
        $this->info('🔄 Generating sitemap...');

        $this->basePath = public_path('/sitemap/');
        if (!is_dir($this->basePath)) mkdir($this->basePath, 0755, true);

        $this->sitemapIndex = SitemapIndex::create();
        $settings = SiteSetting::first();
        if (!$settings) return $this->error('❌ SiteSetting not found.');

        $this->defaultLocaleId = (int)$settings->locale_id;
        $this->defaultPlatformId = (int)$settings->platform_id;
        $this->locales = Locale::all()->keyBy('id');
        $this->platforms = Platform::all()->keyBy('id');

        $this->openNewSitemap();
        $now = now();

        // === HOMEPAGE ===
        foreach ($this->platforms as $platform) {
            $mainUrl = $this->buildHomepageUrl($this->defaultLocaleId, $platform->id);
            $entry = Url::create($mainUrl)
                ->setLastModificationDate($now)
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY);

            foreach ($this->locales as $locale) {
                $altUrl = $this->buildHomepageUrl($locale->id, $platform->id);
                $hreflang = $locale->id === $this->defaultLocaleId ? 'x-default' : $locale->slug;
                $entry->addAlternate($altUrl, $hreflang);
            }

            $this->addUrlToSitemap($entry);
        }

        // === SOFTWARES ===
        Software::with(['platform', 'softwareTranslations'])->chunk(500, function ($softwares) {
            foreach ($softwares as $software) {
                $translations = $software->softwareTranslations->keyBy('locale_id');
                $this->addTranslatedUrls('software', $software, $translations, 1.0, Url::CHANGE_FREQUENCY_DAILY);
            }
        });

        // === CATEGORIES ===
        Category::with('categoryTranslations')->chunk(500, function ($categories) {
            foreach ($categories as $category) {
                $translations = $category->categoryTranslations->keyBy('locale_id');
                $this->addTranslatedUrls('category', $category, $translations, 0.7, Url::CHANGE_FREQUENCY_WEEKLY);
            }
        });

        // === PAGES ===
        Page::with('translations')->chunk(500, function ($pages) {
            foreach ($pages as $page) {
                $translations = $page->translations->keyBy('locale_id');
                $this->addTranslatedUrls('page', $page, $translations, 0.5, Url::CHANGE_FREQUENCY_MONTHLY);
            }
        });

        $this->closeSitemap();
        $this->sitemapIndex->writeToFile(public_path('sitemap.xml'));
        $this->info('✅ Sitemap and index generated successfully.');
    }

    protected function addTranslatedUrls(string $type, $model, $translations, float $priority, string $freq)
    {
        $availableLocales = $translations->keys();

        // Main URL = default locale
        if (!$availableLocales->contains($this->defaultLocaleId)) return;

        $mainLocaleId = $this->defaultLocaleId;
        $mainUrl = $this->buildModelUrl($type, $model, $mainLocaleId);

        $entry = Url::create($mainUrl)
            ->setLastModificationDate($model->updated_at)
            ->setPriority($priority)
            ->setChangeFrequency($freq);

        foreach ($availableLocales as $localeId) {
            $locale = $this->locales[$localeId] ?? null;
            if (!$locale) continue;

            $altUrl = $this->buildModelUrl($type, $model, $localeId);
            $hreflang = $localeId === $this->defaultLocaleId ? 'x-default' : $locale->slug;
            $entry->addAlternate($altUrl, $hreflang);
        }

        $this->addUrlToSitemap($entry);
    }

    protected function buildModelUrl(string $type, $model, int $localeId): string
    {
        $locale = $this->locales[$localeId];
        $localeSegment = $localeId === $this->defaultLocaleId ? '' : '/' . $locale->slug;

        if ($type === 'software') {
            $platform = $model->platform;
            $platformSegment = ($platform && $platform->id !== $this->defaultPlatformId) ? '/' . $platform->slug : '';
            return url("/download{$localeSegment}{$platformSegment}/{$model->slug}");
        }

        return url("/{$type}{$localeSegment}/{$model->slug}");
    }

    protected function buildHomepageUrl(int $localeId, int $platformId): string
    {
        $locale = $this->locales[$localeId];
        $platform = $this->platforms[$platformId];

        $localeSegment = $localeId === $this->defaultLocaleId ? '' : '/' . $locale->slug;
        $platformSegment = $platformId === $this->defaultPlatformId ? '' : '/' . $platform->slug;

        return url("{$localeSegment}{$platformSegment}");
    }

    protected function addUrlToSitemap(Url $url)
    {
        if ($this->urlCounter >= $this->maxUrlsPerFile) {
            $this->closeSitemap();
            $this->openNewSitemap();
        }

        $this->currentSitemap->add($url);
        $this->urlCounter++;
    }

    protected function openNewSitemap()
    {
        $this->urlCounter = 0;
        $this->currentSitemap = Sitemap::create();
    }

    protected function closeSitemap()
    {
        if ($this->currentSitemap && $this->urlCounter > 0) {
            $filename = "sitemap-{$this->fileCounter}.xml";
            $this->currentSitemap->writeToFile($this->basePath . $filename);
            $this->sitemapIndex->add(url("/sitemap/{$filename}"));
            $this->fileCounter++;
        }
    }
}
