<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin One',
            'username' => 'admin1',
            'password' => bcrypt('adminpassword'),
        ]);

        Admin::create([
            'name' => 'Admin Two',
            'username' => 'admin2',
            'password' => bcrypt('adminpassword2'),
        ]);
    }
}
