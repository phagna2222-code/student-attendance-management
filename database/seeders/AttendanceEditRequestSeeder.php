<?php

namespace Database\Seeders;

use App\Models\AttendanceEditRequest;
use App\Models\AttendanceRecord;
use App\Models\AttendanceStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceEditRequestSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = User::where('email', 'teacher@example.com')->first();
        $admin   = User::where('email', 'admin@example.com')->first();
        $present = AttendanceStatus::where('code', 'P')->first();
        if (! $teacher || ! $present) return;

        $records = AttendanceRecord::orderBy('id')->limit(3)->get();
        foreach ($records as $i => $record) {
            AttendanceEditRequest::updateOrCreate(
                ['attendance_record_id' => $record->id, 'requested_by' => $teacher->id],
                [
                    'approved_by'         => $i === 0 ? optional($admin)->id : null,
                    'requested_status_id' => $present->id,
                    'reason'              => 'Marked incorrectly during sync.',
                    'old_values'          => ['attendance_status_id' => $record->attendance_status_id],
                    'new_values'          => ['attendance_status_id' => $present->id],
                    'status'              => $i === 0 ? 'approved' : 'pending',
                    'approved_at'         => $i === 0 ? now()->subHours(2) : null,
                    'approval_note'       => $i === 0 ? 'Confirmed by class teacher.' : null,
                ]
            );
        }
    }
}
