<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DetailTransaction;

class DetailTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailTransaction::create([
            'transaction_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
            'price' => 50.25,
        ]);

        DetailTransaction::create([
            'transaction_id' => 2,
            'product_id' => 2,
            'quantity' => 1,
            'price' => 150.75,
        ]);
    }
}
