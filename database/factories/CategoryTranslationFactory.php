<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryTranslation>
 */
class CategoryTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(), // Optional if you're calling it standalone
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'locale_id' => Locale::inRandomOrder()->first()->id,
        ];
    }
}
