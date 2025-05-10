<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ScreenshotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Screenshot::factory(10)->create();
    }
}
