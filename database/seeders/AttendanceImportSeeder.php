<?php

namespace Database\Seeders;

use App\Models\AttendanceImport;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceImportSeeder extends Seeder
{
    public function run(): void
    {
        $admin   = User::where('email', 'admin@example.com')->first();
        $session = AttendanceSession::orderBy('id')->first();
        if (! $session) return;

        AttendanceImport::updateOrCreate(
            ['file_path' => 'imports/2025-09-15-attendance.xlsx'],
            [
                'class_id'              => $session->class_id,
                'attendance_session_id' => $session->id,
                'imported_by'           => optional($admin)->id,
                'total_rows'            => 35,
                'success_rows'          => 33,
                'failed_rows'           => 2,
                'errors'                => [
                    ['row' => 7,  'message' => 'Student code not found: STD-XXXX'],
                    ['row' => 22, 'message' => 'Invalid date format'],
                ],
                'status'                => 'completed',
            ]
        );
    }
}
