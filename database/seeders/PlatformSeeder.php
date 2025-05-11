<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['name' => 'Android'],
            ['name' => 'Windows'],
            ['name' => 'iOS'],
            ['name' => 'MacOS'],
            ['name' => 'Linux'],
        ];

        foreach ($platforms as $platform) {
            $platform['slug'] = Str::slug($platform['name']);
            Platform::create($platform);
        }
    }
}
