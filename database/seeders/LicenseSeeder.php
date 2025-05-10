<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\License::factory(10)->create();
    }
}
