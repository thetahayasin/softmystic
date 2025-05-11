<?php

namespace Database\Factories;

use App\Models\License;
use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LicenseTranslation>
 */
class LicenseTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(100),
            'locale_id' => Locale::inRandomOrder()->value('id') ?? Locale::factory(),
            'license_id' => License::factory(),
        ];
    }
}
