<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Operator;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Operator::create([
            'name' => 'Alice Johnson',
            'status' => 'Active',
            'username' => 'alice123',
            'password' => bcrypt('password123'),
        ]);

        Operator::create([
            'name' => 'Bob Williams',
            'status' => 'Inactive',
            'username' => 'bob456',
            'password' => bcrypt('password456'),
        ]);
    }
}
