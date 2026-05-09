<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'super-admin'  => ['*'],
            'school-admin' => [
                'dashboard.view', 'students.view', 'students.create', 'students.update', 'students.delete',
                'classes.manage', 'attendance.view', 'attendance.mark', 'attendance.submit', 'attendance.lock',
                'attendance.edit-after-lock', 'leave.approve', 'notifications.send',
                'reports.view', 'reports.export', 'analytics.view', 'settings.manage', 'audit.view',
            ],
            'teacher'      => ['dashboard.view', 'students.view', 'attendance.view', 'attendance.mark', 'attendance.submit', 'leave.request', 'reports.view'],
            'secretary'    => ['dashboard.view', 'students.view', 'students.create', 'students.update', 'attendance.view', 'leave.request', 'notifications.send', 'reports.view'],
            'parent'       => ['leave.request'],
            'student'      => [],
            'auditor'      => ['dashboard.view', 'attendance.view', 'reports.view', 'analytics.view', 'audit.view'],
        ];

        $roles       = Role::all()->keyBy('slug');
        $permissions = Permission::all();

        foreach ($map as $roleSlug => $slugs) {
            $role = $roles[$roleSlug] ?? null;
            if (! $role) continue;

            $allow = collect($slugs)->contains('*')
                ? $permissions
                : $permissions->whereIn('slug', $slugs);

            foreach ($allow as $perm) {
                DB::table('permission_role')->updateOrInsert(
                    ['permission_id' => $perm->id, 'role_id' => $role->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
