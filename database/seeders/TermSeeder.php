<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    public function run(): void
    {
        $matrix = [
            '2024-2025' => [
                ['code' => 'T1', 'name' => 'Semester 1', 'term_no' => 1, 'start_date' => '2024-09-01', 'end_date' => '2025-01-31', 'status' => 'closed'],
                ['code' => 'T2', 'name' => 'Semester 2', 'term_no' => 2, 'start_date' => '2025-02-01', 'end_date' => '2025-07-31', 'status' => 'closed'],
            ],
            '2025-2026' => [
                ['code' => 'T1', 'name' => 'Semester 1', 'term_no' => 1, 'start_date' => '2025-09-01', 'end_date' => '2026-01-31', 'status' => 'active'],
                ['code' => 'T2', 'name' => 'Semester 2', 'term_no' => 2, 'start_date' => '2026-02-01', 'end_date' => '2026-07-31', 'status' => 'planned'],
            ],
            '2026-2027' => [
                ['code' => 'T1', 'name' => 'Semester 1', 'term_no' => 1, 'start_date' => '2026-09-01', 'end_date' => '2027-01-31', 'status' => 'planned'],
                ['code' => 'T2', 'name' => 'Semester 2', 'term_no' => 2, 'start_date' => '2027-02-01', 'end_date' => '2027-07-31', 'status' => 'planned'],
            ],
        ];

        foreach ($matrix as $yearCode => $terms) {
            $year = AcademicYear::where('code', $yearCode)->first();
            if (! $year) continue;

            foreach ($terms as $t) {
                Term::updateOrCreate(
                    ['academic_year_id' => $year->id, 'code' => $t['code']],
                    $t + ['academic_year_id' => $year->id]
                );
            }
        }
    }
}
