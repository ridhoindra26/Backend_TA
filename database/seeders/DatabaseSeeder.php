<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // CustomerSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
            // OperatorSeeder::class,
            // AdminSeeder::class,
            // StationSeeder::class,
            // DroneSeeder::class,
            // TransactionSeeder::class,
            // DetailTransactionSeeder::class,
            WishlistSeeder::class
        ]);
    }
}
