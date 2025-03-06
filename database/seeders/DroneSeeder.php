<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Drone;

class DroneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Drone::create([
            'longitude' => 123.4567,
            'latitude' => 89.1234,
            'altitude' => 100.5,
            'ground_speed' => 50.5,
            'vertical_speed' => 10.2,
            'distance' => 500.0,
            'batt_volt' => 80.5,
            'link_quality' => 90,
            'GPSSat' => 'Active',
        ]);

        Drone::create([
            'longitude' => 234.5678,
            'latitude' => 78.2345,
            'altitude' => 150.7,
            'ground_speed' => 60.0,
            'vertical_speed' => 12.3,
            'distance' => 600.0,
            'batt_volt' => 85.2,
            'link_quality' => 95,
            'GPSSat' => 'Active',
        ]);
    }
}
