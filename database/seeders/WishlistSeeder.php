<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Wishlist;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wishlist::create([
            'customer_id' => 3,
            'product_id' => 1,
        ]);

        Wishlist::create([
            'customer_id' => 3,
            'product_id' => 2,
        ]);
    }
}
