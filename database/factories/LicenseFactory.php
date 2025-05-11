<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\License>
 */
class LicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     public function definition(): array
     {
         $name = $this->faker->unique()->words(2, true); // e.g., "web utility"
         
         return [
             'slug' => Str::slug($name), // e.g., "web-utility"
         ];
     }
     
}
