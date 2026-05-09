<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => '2024-2025', 'name' => 'Academic Year 2024-2025', 'start_date' => '2024-09-01', 'end_date' => '2025-07-31', 'is_current' => false, 'status' => 'closed'],
            ['code' => '2025-2026', 'name' => 'Academic Year 2025-2026', 'start_date' => '2025-09-01', 'end_date' => '2026-07-31', 'is_current' => true,  'status' => 'active'],
            ['code' => '2026-2027', 'name' => 'Academic Year 2026-2027', 'start_date' => '2026-09-01', 'end_date' => '2027-07-31', 'is_current' => false, 'status' => 'planned'],
        ];

        foreach ($rows as $r) {
            AcademicYear::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
