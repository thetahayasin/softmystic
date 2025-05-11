<?php

namespace Database\Seeders;
use App\Models\Software;
use App\Models\SoftwareTranslation;
use App\Models\Locale;
use Illuminate\Database\Seeder;

class SoftwareSeeder extends Seeder
{
    public function run(): void
    {
        // Get all available locales
        $locales = Locale::all();

        // Create 10 software entries
        Software::factory()
            ->count(10)
            ->create()
            ->each(function ($software) use ($locales) {
                foreach ($locales as $locale) {
                    SoftwareTranslation::factory()->create([
                        'software_id' => $software->id,
                        'locale_id' => $locale->id,
                    ]);
                }
            });
    }
}

