<?php

namespace Database\Seeders;

use App\Models\GeneratedReport;
use App\Models\ReportExport;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportExportSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        GeneratedReport::orderBy('id')->get()->each(function (GeneratedReport $report) use ($admin) {
            foreach (['pdf', 'excel'] as $format) {
                ReportExport::updateOrCreate(
                    ['generated_report_id' => $report->id, 'format' => $format],
                    [
                        'file_path'   => 'reports/'.$report->report_no.'.'.($format === 'excel' ? 'xlsx' : $format),
                        'exported_by' => optional($admin)->id,
                        'exported_at' => now()->subMinutes(15),
                    ]
                );
            }
        });
    }
}
