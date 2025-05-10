<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SoftwareTranslation>
 */
class SoftwareTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tagline' => fake()->text(50),
            'content' => fake()->text(50),
            'change_log' => fake()->text(50),

        ];
    }
}
