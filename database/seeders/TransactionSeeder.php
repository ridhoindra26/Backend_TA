<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::create([
            'customer_id' => 1,
            'status' => 'Completed',
            'total_price' => 18000,
            'payment_method' => 'Credit Card',
            'admin_id' => 1,
            'operator_id' => 1,
            'drone_id' => 1,
            'station_id' => 1
        ]);

        Transaction::create([
            'customer_id' => 2,
            'status' => 'Pending',
            'total_price' => 26000,
            'payment_method' => 'QRIS',
            'admin_id' => 1,
            'operator_id' => 2,
            'drone_id' => 2,
            'station_id' => 2
        ]);
    }
}
