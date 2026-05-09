<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'code' => 'ABSENT_ALERT_SMS',
                'name' => 'Absent Alert SMS',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'Dear parent, {student_name} is absent from {class_name} on {date}. Please contact the school if needed.',
                'variables' => ['student_name', 'class_name', 'date'],
            ],
            [
                'code' => 'LATE_ALERT_SMS',
                'name' => 'Late Alert SMS',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'Dear parent, {student_name} arrived late at {check_in_time} on {date}.',
                'variables' => ['student_name', 'check_in_time', 'date'],
            ],
            [
                'code' => 'MONTHLY_SUMMARY_EMAIL',
                'name' => 'Monthly Attendance Summary Email',
                'channel' => 'email',
                'subject' => 'Monthly Attendance Summary for {student_name}',
                'body' => 'Present: {present_count}, Absent: {absent_count}, Late: {late_count}, Permission: {permission_count}.',
                'variables' => ['student_name', 'present_count', 'absent_count', 'late_count', 'permission_count'],
            ],
            [
                'code' => 'LEAVE_APPROVED_PORTAL',
                'name' => 'Leave Approved Portal',
                'channel' => 'portal',
                'subject' => 'Leave request approved',
                'body' => 'Your leave request {request_no} from {start_date} to {end_date} has been approved.',
                'variables' => ['request_no', 'start_date', 'end_date'],
            ],
            [
                'code' => 'LEAVE_REJECTED_PORTAL',
                'name' => 'Leave Rejected Portal',
                'channel' => 'portal',
                'subject' => 'Leave request rejected',
                'body' => 'Your leave request {request_no} was rejected. Reason: {reject_reason}.',
                'variables' => ['request_no', 'reject_reason'],
            ],
            [
                'code' => 'CONSECUTIVE_ABSENT_TELEGRAM',
                'name' => 'Consecutive Absent Warning (Telegram)',
                'channel' => 'telegram',
                'subject' => null,
                'body' => '⚠️ {student_name} has been absent for {days} consecutive days. Please contact the school.',
                'variables' => ['student_name', 'days'],
            ],
        ];

        foreach ($rows as $r) {
            NotificationTemplate::updateOrCreate(
                ['code' => $r['code']],
                $r + ['status' => 'active']
            );
        }
    }
}
