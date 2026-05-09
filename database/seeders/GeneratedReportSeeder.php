<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\GeneratedReport;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class GeneratedReportSeeder extends Seeder
{
    public function run(): void
    {
        $admin  = User::where('email', 'admin@example.com')->first();
        $branch = Branch::where('code', 'MAIN')->first();
        $class  = SchoolClass::where('branch_id', optional($branch)->id)->first();

        $rows = [
            [
                'report_no'   => 'RPT-2025-0001',
                'report_type' => 'daily_attendance',
                'date_from'   => now()->subDays(7)->toDateString(),
                'date_to'     => now()->toDateString(),
                'summary'     => ['present' => 240, 'absent' => 18, 'late' => 12, 'permission' => 6],
            ],
            [
                'report_no'   => 'RPT-2025-0002',
                'report_type' => 'monthly_attendance',
                'date_from'   => now()->startOfMonth()->toDateString(),
                'date_to'     => now()->endOfMonth()->toDateString(),
                'summary'     => ['present' => 1850, 'absent' => 92, 'late' => 78, 'permission' => 24],
            ],
            [
                'report_no'   => 'RPT-2025-0003',
                'report_type' => 'class_summary',
                'date_from'   => now()->subDays(30)->toDateString(),
                'date_to'     => now()->toDateString(),
                'summary'     => ['attendance_rate' => 94.5, 'absence_rate' => 4.2, 'late_rate' => 1.3],
            ],
            [
                'report_no'   => 'RPT-2025-0004',
                'report_type' => 'absent_students',
                'date_from'   => now()->subDays(7)->toDateString(),
                'date_to'     => now()->toDateString(),
                'summary'     => ['count' => 18],
            ],
        ];

        foreach ($rows as $r) {
            GeneratedReport::updateOrCreate(
                ['report_no' => $r['report_no']],
                [
                    'report_type'  => $r['report_type'],
                    'branch_id'    => optional($branch)->id,
                    'class_id'     => $r['report_type'] === 'class_summary' ? optional($class)->id : null,
                    'date_from'    => $r['date_from'],
                    'date_to'      => $r['date_to'],
                    'filters'      => ['branch' => 'MAIN'],
                    'summary'      => $r['summary'],
                    'generated_by' => optional($admin)->id,
                    'generated_at' => now()->subHour(),
                ]
            );
        }
    }
}
