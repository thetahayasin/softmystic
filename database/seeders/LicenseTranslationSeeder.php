<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LicenseTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\LicenseTranslation::factory(10)->create();
    }
}
