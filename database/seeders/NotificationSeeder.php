<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\AttendanceStatus;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $absentTpl = NotificationTemplate::where('code', 'ABSENT_ALERT_SMS')->first();
        $lateTpl   = NotificationTemplate::where('code', 'LATE_ALERT_SMS')->first();
        $absentSt  = AttendanceStatus::where('code', 'A')->first();
        $lateSt    = AttendanceStatus::where('code', 'L')->first();
        $primaryParent = StudentParent::orderBy('id')->first();

        // For each absent record, queue an SMS notification
        if ($absentTpl && $absentSt) {
            AttendanceRecord::with('student')->where('attendance_status_id', $absentSt->id)->limit(20)->get()
                ->each(function (AttendanceRecord $record) use ($absentTpl, $primaryParent, $admin) {
                    $student = $record->student;
                    if (! $student) return;
                    Notification::updateOrCreate(
                        ['template_id' => $absentTpl->id, 'student_id' => $student->id, 'message' => 'Dear parent, '.$student->name_en.' is absent on '.$record->attendance_session_id.'.'],
                        [
                            'parent_id'         => optional($primaryParent)->id,
                            'class_id'          => $student->current_class_id,
                            'created_by'        => optional($admin)->id,
                            'type'              => 'absent_alert',
                            'channel'           => 'sms',
                            'recipient_name'    => optional($primaryParent)->name_en,
                            'recipient_contact' => optional($primaryParent)->phone,
                            'subject'           => null,
                            'payload'           => ['student_id' => $student->id, 'record_id' => $record->id],
                            'status'            => 'sent',
                            'scheduled_at'      => now()->subHours(2),
                            'sent_at'           => now()->subHours(1),
                        ]
                    );
                });
        }

        // For each late record, queue a late SMS
        if ($lateTpl && $lateSt) {
            AttendanceRecord::with('student')->where('attendance_status_id', $lateSt->id)->limit(20)->get()
                ->each(function (AttendanceRecord $record) use ($lateTpl, $primaryParent, $admin) {
                    $student = $record->student;
                    if (! $student) return;
                    Notification::updateOrCreate(
                        ['template_id' => $lateTpl->id, 'student_id' => $student->id, 'message' => 'Dear parent, '.$student->name_en.' was late at '.$record->check_in_time.'.'],
                        [
                            'parent_id'         => optional($primaryParent)->id,
                            'class_id'          => $student->current_class_id,
                            'created_by'        => optional($admin)->id,
                            'type'              => 'late_alert',
                            'channel'           => 'sms',
                            'recipient_name'    => optional($primaryParent)->name_en,
                            'recipient_contact' => optional($primaryParent)->phone,
                            'subject'           => null,
                            'payload'           => ['student_id' => $student->id, 'record_id' => $record->id],
                            'status'            => 'sent',
                            'scheduled_at'      => now()->subHours(2),
                            'sent_at'           => now()->subHours(1),
                        ]
                    );
                });
        }
    }
}
