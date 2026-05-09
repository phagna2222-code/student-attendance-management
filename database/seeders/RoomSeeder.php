<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Branch::all() as $branch) {
            $template = [
                ['code' => 'A101', 'name' => 'Room A101', 'capacity' => 40, 'building' => 'A', 'floor' => '1'],
                ['code' => 'A102', 'name' => 'Room A102', 'capacity' => 40, 'building' => 'A', 'floor' => '1'],
                ['code' => 'A201', 'name' => 'Room A201', 'capacity' => 35, 'building' => 'A', 'floor' => '2'],
                ['code' => 'B101', 'name' => 'Room B101', 'capacity' => 30, 'building' => 'B', 'floor' => '1'],
                ['code' => 'LAB1', 'name' => 'Science Lab 1', 'capacity' => 25, 'building' => 'B', 'floor' => '2'],
            ];
            foreach ($template as $r) {
                Room::updateOrCreate(
                    ['branch_id' => $branch->id, 'code' => $r['code']],
                    $r + ['branch_id' => $branch->id, 'status' => 'active']
                );
            }
        }
    }
}
