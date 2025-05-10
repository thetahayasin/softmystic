<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Platform::factory(10)->create();
    }
}
