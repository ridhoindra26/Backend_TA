<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices',
            'icon' => 'electronics_icon.png',
        ]);

        Category::create([
            'name' => 'Phones',
            'description' => 'Mobile phones and accessories',
            'icon' => 'phones_icon.png',
        ]);
    }
}
