<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'MORN',  'name' => 'Morning',   'start_time' => '07:00:00', 'end_time' => '12:00:00', 'status' => 'active'],
            ['code' => 'AFTER', 'name' => 'Afternoon', 'start_time' => '13:00:00', 'end_time' => '17:00:00', 'status' => 'active'],
            ['code' => 'EVE',   'name' => 'Evening',   'start_time' => '17:30:00', 'end_time' => '20:30:00', 'status' => 'active'],
        ];

        foreach ($rows as $r) {
            Shift::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
