<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Google Inc.',
                'slug' => Str::slug('Google Inc.'),
                'description' => 'Google is a technology company focused on internet services and products.',
                'url' => 'https://google.com',
            ],
            [
                'name' => 'Microsoft Corporation',
                'slug' => Str::slug('Microsoft Corporation'),
                'description' => 'Microsoft develops, licenses, and supports a wide range of software products.',
                'url' => 'https://microsoft.com',
            ],
            [
                'name' => 'Apple Inc.',
                'slug' => Str::slug('Apple Inc.'),
                'description' => 'Apple designs and manufactures consumer electronics, software, and services.',
                'url' => 'https://apple.com',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
