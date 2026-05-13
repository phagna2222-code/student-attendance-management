<?php

namespace App\Providers;

use App\Models\AcademicYear;
use App\Models\AttendanceEditRequest;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\AttendanceStatus;
use App\Models\Branch;
use App\Models\LeaveRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SchoolClass;
use App\Models\SchoolProfile;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Subject;
use App\Models\SystemSetting;
use App\Models\Teacher;
use App\Models\User;
use App\Observers\AuditObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $auditable = [
            Branch::class,
            SchoolProfile::class,
            AcademicYear::class,
            User::class,
            Role::class,
            Permission::class,
            Teacher::class,
            StudentParent::class,
            Student::class,
            SchoolClass::class,
            Subject::class,
            AttendanceStatus::class,
            AttendanceSession::class,
            AttendanceRecord::class,
            AttendanceEditRequest::class,
            LeaveRequest::class,
            SystemSetting::class,
        ];

        foreach ($auditable as $model) {
            $model::observe(AuditObserver::class);
        }
    }
}
