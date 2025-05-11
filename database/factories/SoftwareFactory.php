<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use App\Models\License;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SoftwareFactory extends Factory
{
    public function definition(): array
    {
        // Ensure directories exist
        Storage::disk('public')->makeDirectory('software_logos');
        Storage::disk('public')->makeDirectory('software_screenshots');

        // Dummy image sources
        $dummyLogo = 'dummy_images/dummy_logo.png';
        $dummyScreenshot = 'dummy_images/dummy_screenshot.png';

        // Unique filenames
        $logoFilename = Str::uuid() . '.png';
        $screenshot1 = Str::uuid() . '.png';
        $screenshot2 = Str::uuid() . '.png';

        // Destination paths
        $logoPath = "software_logos/{$logoFilename}";
        $screenshotPath1 = "software_screenshots/{$screenshot1}";
        $screenshotPath2 = "software_screenshots/{$screenshot2}";

        // Copy dummy images
        Storage::disk('public')->copy($dummyLogo, $logoPath);
        Storage::disk('public')->copy($dummyScreenshot, $screenshotPath1);
        Storage::disk('public')->copy($dummyScreenshot, $screenshotPath2);

        return [
            'name' => $this->faker->company,
            'slug' => Str::slug($this->faker->unique()->company),
            'file_size' => $this->faker->numberBetween(50_000_000, 100_000_000),
            'version' => $this->faker->randomFloat(null, 2, 4),
            'author_id' => Author::inRandomOrder()->first()->id,
            'logo' => $logoPath,
            'download_url' => $this->faker->url,
            'buy_url' => $this->faker->url,
            'downloads' => $this->faker->numberBetween(100, 10000),
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'license_id' => License::inRandomOrder()->first()->id,
            'platform_id' => Platform::inRandomOrder()->first()->id,
            'is_sponsored' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'screenshots' => [
                $screenshotPath1,
                $screenshotPath2,
            ],
        ];
    }
}
