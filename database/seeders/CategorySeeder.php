<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['slug' => 'technology'],
            ['slug' => 'business'],
            ['slug' => 'science'],
            ['slug' => 'health'],
            ['slug' => 'entertainment'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
