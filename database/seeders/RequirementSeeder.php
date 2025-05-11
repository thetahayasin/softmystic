<?php

namespace Database\Seeders;

use App\Models\Requirement;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requirements = [
            ['name' => 'Windows 10'],
            ['name' => 'Android 11'],
            ['name' => 'iOS 13'],
            ['name' => 'MacOS 10.15'],
            ['name' => 'Linux Ubuntu 20.04'],
        ];

        foreach ($requirements as $requirement) {
            Requirement::create($requirement);
        }
    }
}
