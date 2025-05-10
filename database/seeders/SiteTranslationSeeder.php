<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SiteTranslation::factory(10)->create();
    }
}
