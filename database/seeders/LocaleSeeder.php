<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Locale::factory(10)->create();
    }
}
