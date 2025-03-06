<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'category_id' => 1,
            // 'restaurant_id' => 1,
            'description' => 'High performance laptop',
            'photo' => 'laptop.jpg',
            'price' => 500.00,
        ]);

        Product::create([
            'name' => 'Smartphone',
            'category_id' => 2,
            // 'restaurant_id' => 1,
            'description' => 'Latest model smartphone',
            'photo' => 'smartphone.jpg',
            'price' => 300.00,
        ]);
    }
}
