<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SoftwareRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SoftwareRequirement::factory(10)->create();
    }
}
