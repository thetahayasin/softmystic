<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Requirement::factory(10)->create();
    }
}
