<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteSetting>
 */
class SiteSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'default_locale' => fake()->text(50),
            'default_platform' => fake()->text(50),
            'site_logo' => fake()->text(50),
            'header_code' => fake()->text(50),
            'footer_code' => fake()->text(50),
            'home_page_ad' => fake()->text(50),
            'home_page_ad_2' => fake()->text(50),
            'results_page_ad' => fake()->text(50),
            'results_page_ad_2' => fake()->text(50),
            'single_page_ad' => fake()->text(50),
            'single_page_ad_2' => fake()->text(50),
            'download_page_ad' => fake()->text(50),
            'download_page_ad_2' => fake()->text(50),

        ];
    }
}
