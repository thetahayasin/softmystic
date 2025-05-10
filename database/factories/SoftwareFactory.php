<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Software>
 */
class SoftwareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(50),
            'slug' => fake()->text(50),
            'version' => fake()->text(50),
            'logo' => fake()->text(50),
            'download_url' => fake()->text(50),
            'buy_url' => fake()->text(50),

        ];
    }
}
