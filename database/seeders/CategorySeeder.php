<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::truncate();
        // Insert job types
        $category = ['Designer', 'Telecaller', 'IT/CE', 'Engineering', 'Accountant'];
        foreach ($category as $category) {
            Category::create(['cat_name' => $category]);
        }
    }
}
