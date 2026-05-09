<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['slug' => 'super-admin',  'name' => 'Super Admin',  'description' => 'Full system management access.'],
            ['slug' => 'school-admin', 'name' => 'School Admin', 'description' => 'Manage students, classes, attendance, and reports.'],
            ['slug' => 'teacher',      'name' => 'Teacher',      'description' => 'Mark and submit attendance for assigned classes.'],
            ['slug' => 'secretary',    'name' => 'Secretary',    'description' => 'Assist with student lists, reports, and notifications.'],
            ['slug' => 'parent',       'name' => 'Parent',       'description' => 'View child attendance and request leave.'],
            ['slug' => 'student',      'name' => 'Student',      'description' => 'View own attendance, timetable, and leave status.'],
            ['slug' => 'auditor',      'name' => 'Auditor',      'description' => 'Read-only reporting and audit access.'],
        ];
        foreach ($roles as $r) {
            Role::updateOrCreate(['slug' => $r['slug']], $r + ['is_system' => true]);
        }
    }
}
