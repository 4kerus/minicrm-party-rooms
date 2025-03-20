<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::query()->create(['name' => 'Party Room 1', 'description' => 'Small room', 'price_per_hour' => 50.00, 'capacity' => 10]);
        Room::query()->create(['name' => 'Party Room 2', 'description' => 'Medium room', 'price_per_hour' => 75.00, 'capacity' => 5]);
    }
}
