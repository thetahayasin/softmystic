<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SoftwareTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SoftwareTranslation::factory(10)->create();
    }
}
