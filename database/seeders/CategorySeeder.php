<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Living Room'],
            ['name' => 'Bedroom'],
            ['name' => 'Dining Room'],
            ['name' => 'Office'],
            ['name' => 'Kitchen'],
            ['name' => 'Bathroom'],
            ['name' => 'Outdoor'],
            ['name' => 'Storage'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
