<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\Locale;
use App\Models\Platform;

class SiteSettingSeeder extends Seeder
{
    public function run()
    {
        $locale = Locale::inRandomOrder()->first();
        $platform = Platform::inRandomOrder()->first();

        if (! $locale || ! $platform) {
            $this->command->error('No locale or platform found. Please seed those tables first.');
            return;
        }

        SiteSetting::create([
            'site_name' => 'Softimystic',
            'locale_id' => $locale->id,
            'platform_id' => $platform->id,
            'site_logo' => '',
            'header_code' => '',
            'footer_code' => '',
            'home_page_ad' => '',
            'home_page_ad_2' => '',
            'results_page_ad' => '',
            'results_page_ad_2' => '',
            'single_page_ad' => '',
            'single_page_ad_2' => '',
            'download_page_ad' => '',
            'download_page_ad_2' => '',
        ]);
    }
}
