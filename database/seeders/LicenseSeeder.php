<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $licenses = [
            ['slug' => 'mit'],
            ['slug' => 'gpl'],
            ['slug' => 'apache'],
        ];

        foreach ($licenses as $license) {
            License::create($license);
        }
    }
}
