<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Software::factory(10)->create();
    }
}
