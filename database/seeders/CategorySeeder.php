<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cats',
                'slug' => Str::slug('Cats'),
                'description' => 'Products and supplies for cats',
            ],

            [
                'name' => 'Dogs',
                'slug' => Str::slug('Dogs'),
                'description' => 'Products and supplies for dogs',
            ],

            [
                'name' => 'Fish',
                'slug' => Str::slug('Fish'),
                'description' => 'Products and supplies for fish',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
