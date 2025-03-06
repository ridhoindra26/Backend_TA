<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Station;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Station::create([
            'longitude' => 123.4567,
            'latitude' => 89.1234,
            'name' => 'Station 1',
        ]);

        Station::create([
            'longitude' => 234.5678,
            'latitude' => 78.2345,
            'name' => 'Station 2',
        ]);
    }
}
