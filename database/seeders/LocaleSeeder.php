<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = [
            ['key' => 'en', 'name' => 'English'],

        ];
    
        foreach ($locales as $locale) {
            \App\Models\Locale::create([
                'key' => $locale['key'],
                'name' => $locale['name'],
                'slug' => Str::slug($locale['name']),
            ]);
        }
    }
}
