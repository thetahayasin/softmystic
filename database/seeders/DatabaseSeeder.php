<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            LocaleSeeder::class,
            AuthorSeeder::class,
            CategorySeeder::class,
            CategoryTranslationSeeder::class,
            PlatformSeeder::class,
            RequirementSeeder::class,
            LicenseSeeder::class,
            LicenseTranslationSeeder::class,
            SoftwareSeeder::class,
            SiteSettingSeeder::class,
            SiteTranslationSeeder::class,
            //SoftwareTranslationSeeder::class,






        ]);

    }
}
