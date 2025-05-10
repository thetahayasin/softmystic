<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteTranslation>
 */
class SiteTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'home_meta_title' => fake()->text(50),
            'home_meta_description' => fake()->text(50),
            'category_meta_title' => fake()->text(50),
            'category_meta_description' => fake()->text(50),
            'search_meta_title' => fake()->text(50),
            'search_meta_description' => fake()->text(50),
            'download_meta_title' => fake()->text(50),
            'download_meta_description' => fake()->text(50),
            'single_meta_title' => fake()->text(50),
            'single_meta_description' => fake()->text(50),
            'search_results' => fake()->text(50),
            'category' => fake()->text(50),
            'download_button' => fake()->text(50),
            'footer_text' => fake()->text(50),
            'latest' => fake()->text(50),
            'popular' => fake()->text(50),
            'related' => fake()->text(50),
            'download' => fake()->text(50),
            'for' => fake()->text(50),
            'free' => fake()->text(50),
            'version' => fake()->text(50),

        ];
    }
}
