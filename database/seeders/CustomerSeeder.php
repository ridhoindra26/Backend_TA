<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'John Doe',
            'photo' => 'profile.jpg',
            'phone' => '1234567890',
            'password' => bcrypt('password123'),
            'email' => 'john@example.com',
        ]);

        Customer::create([
            'name' => 'Jane Smith',
            'photo' => 'profile2.jpg',
            'phone' => '0987654321',
            'password' => bcrypt('password456'),
            'email' => 'jane@example.com',
        ]);
    }
}
