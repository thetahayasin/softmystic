<?php

namespace Database\Seeders;

use App\Models\Software;
use App\Models\SoftwareTranslation;
use App\Models\Locale;
use App\Models\Requirement;
use Illuminate\Database\Seeder;

class SoftwareSeeder extends Seeder
{
    public function run(): void
    {
        $locales = Locale::all();

        Software::factory()
            ->count(10)
            ->create()
            ->each(function ($software) use ($locales) {
                // Create translations for each locale
                foreach ($locales as $locale) {
                    SoftwareTranslation::factory()->create([
                        'software_id' => $software->id,
                        'locale_id' => $locale->id,
                    ]);
                }

                // Attach random requirements to each software
                $requirements = Requirement::inRandomOrder()->take(2)->pluck('id');
                $software->requirements()->attach($requirements);
            });
    }
}
