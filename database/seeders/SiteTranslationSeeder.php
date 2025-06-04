<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch a valid locale_id from the existing locales table
        $localeId = Locale::first()->id; // You can change this to select a specific locale if needed

        DB::table('site_translations')->insert([
            'home_meta_title' => 'Welcome to Our Website',
            'home_meta_description' => 'This is the home page of our website where you can find everything.',
            'hero_title' => 'Welcome to App Galaxy',
            'hero_text' => 'Discover the latest and greatest apps in one place.',
            'featured_apps' => 'Featured Apps',
            'latest_updates' => 'Latest Updates',
            'new_releases' => 'New Releases',
            'trending_apps' => 'Trending Apps',
            'category_meta_title' => 'Category Page',
            'category_meta_description' => 'Explore various categories on our website.',
            'search_meta_title' => 'Search Results',
            'search_meta_description' => 'Search through our extensive collection of products and services.',
            'download_meta_title' => 'Download Resources',
            'download_meta_description' => 'Download various resources available on our website.',
            'single_meta_title' => 'Single Product Page',
            'single_meta_description' => 'Learn more about this product on its dedicated page.',
            'search_results' => 'Showing search results for your query.',
            'category' => 'All Categories',
            'download_button' => 'Click to Download',
            'footer_text' => 'Thank you for visiting our website!',
            'latest' => 'Latest Products',
            'popular' => 'Popular Products',
            'related' => 'Related Products',
            'download' => 'Download Now',
            'for' => 'For Everyone',
            'free' => 'Free Download',
            'version' => 'Version',
            'locale_id' => $localeId,  // Dynamically set locale_id from the existing locales table
        ]);
    }
}
