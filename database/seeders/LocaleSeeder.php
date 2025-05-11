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
            ['key' => 'fr', 'name' => 'French'],
            ['key' => 'de', 'name' => 'German'],
            ['key' => 'es', 'name' => 'Spanish'],
            ['key' => 'it', 'name' => 'Italian'],
            ['key' => 'pt', 'name' => 'Portuguese'],
            ['key' => 'ar', 'name' => 'Arabic'],
            ['key' => 'zh', 'name' => 'Chinese'],
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
