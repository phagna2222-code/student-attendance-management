<?php

namespace Database\Seeders;

use App\Models\AttendanceStatus;
use Illuminate\Database\Seeder;

class AttendanceStatusSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'P',  'name_kh' => 'មានវត្តមាន', 'name_en' => 'Present',     'color' => '#16a34a', 'counts_as_present' => true,  'counts_as_absent' => false, 'requires_approval' => false, 'sort_order' => 1],
            ['code' => 'A',  'name_kh' => 'អវត្តមាន',    'name_en' => 'Absent',      'color' => '#dc2626', 'counts_as_present' => false, 'counts_as_absent' => true,  'requires_approval' => false, 'sort_order' => 2],
            ['code' => 'L',  'name_kh' => 'មកយឺត',       'name_en' => 'Late',        'color' => '#f59e0b', 'counts_as_present' => true,  'counts_as_absent' => false, 'requires_approval' => false, 'sort_order' => 3],
            ['code' => 'PM', 'name_kh' => 'មានច្បាប់',    'name_en' => 'Permission',  'color' => '#2563eb', 'counts_as_present' => false, 'counts_as_absent' => false, 'requires_approval' => true,  'sort_order' => 4],
            ['code' => 'LV', 'name_kh' => 'ឈប់សម្រាក',   'name_en' => 'Leave',       'color' => '#7c3aed', 'counts_as_present' => false, 'counts_as_absent' => false, 'requires_approval' => true,  'sort_order' => 5],
            ['code' => 'EL', 'name_kh' => 'ចេញមុនម៉ោង',   'name_en' => 'Early Leave', 'color' => '#9333ea', 'counts_as_present' => true,  'counts_as_absent' => false, 'requires_approval' => true,  'sort_order' => 6],
        ];

        foreach ($rows as $row) {
            AttendanceStatus::updateOrCreate(
                ['code' => $row['code']],
                $row + ['is_system' => true, 'status' => 'active']
            );
        }
    }
}
