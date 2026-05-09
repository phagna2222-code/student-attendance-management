<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['dashboard',     'dashboard.view',                'View Dashboard'],
            ['students',      'students.view',                 'View Students'],
            ['students',      'students.create',               'Create Students'],
            ['students',      'students.update',               'Update Students'],
            ['students',      'students.delete',               'Delete Students'],
            ['classes',       'classes.manage',                'Manage Classes'],
            ['attendance',    'attendance.view',               'View Attendance'],
            ['attendance',    'attendance.mark',               'Mark Attendance'],
            ['attendance',    'attendance.submit',             'Submit Attendance'],
            ['attendance',    'attendance.lock',               'Lock Attendance'],
            ['attendance',    'attendance.edit-after-lock',    'Edit Attendance After Lock'],
            ['leave',         'leave.request',                 'Request Leave'],
            ['leave',         'leave.approve',                 'Approve Leave'],
            ['notifications', 'notifications.send',            'Send Notifications'],
            ['reports',       'reports.view',                  'View Reports'],
            ['reports',       'reports.export',                'Export Reports'],
            ['analytics',     'analytics.view',                'View Analytics'],
            ['settings',      'settings.manage',               'Manage Settings'],
            ['security',      'audit.view',                    'View Audit Logs'],
            ['backup',        'backup.manage',                 'Manage Backups'],
        ];

        foreach ($permissions as [$group, $slug, $name]) {
            Permission::updateOrCreate(['slug' => $slug], compact('group', 'slug', 'name'));
        }
    }
}
