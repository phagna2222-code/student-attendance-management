<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\AttendanceRecordController;
use App\Http\Controllers\Admin\AttendanceSessionController;
use App\Http\Controllers\Admin\AttendanceStatusController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ClassAttendanceSettingController;
use App\Http\Controllers\Admin\ClassStudentController;
use App\Http\Controllers\Admin\ClassTeacherSubjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentParentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', \App\Http\Middleware\EnsureAdminAuthenticated::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/', DashboardController::class)->name('dashboard');

    // Branch context
    Route::post('branch/set', [BranchController::class, 'setActive'])->name('branch.set');

    /**
     * Standard CRUD resources. The shorthand below registers:
     *   GET    {prefix}.index, datatable
     *   GET    {prefix}.create
     *   POST   {prefix}.store
     *   GET    {prefix}.edit
     *   PUT    {prefix}.update
     *   DELETE {prefix}.destroy
     */
    $resources = [
        'branches'                  => BranchController::class,
        'school-profiles'           => SchoolProfileController::class,
        'academic-years'            => AcademicYearController::class,
        'terms'                     => TermController::class,
        'shifts'                    => ShiftController::class,
        'rooms'                     => RoomController::class,
        'grade-levels'              => GradeLevelController::class,
        'subjects'                  => SubjectController::class,
        'attendance-statuses'       => AttendanceStatusController::class,
        'roles'                     => RoleController::class,
        'permissions'               => PermissionController::class,
        'users'                     => UserController::class,
        'teachers'                  => TeacherController::class,
        'parents'                   => StudentParentController::class,
        'students'                  => StudentController::class,
        'classes'                   => SchoolClassController::class,
        'class-teacher-subjects'    => ClassTeacherSubjectController::class,
        'class-attendance-settings' => ClassAttendanceSettingController::class,
        'timetables'                => TimetableController::class,
        'attendance-sessions'       => AttendanceSessionController::class,
        'leave-requests'            => LeaveRequestController::class,
        'notification-templates'    => NotificationTemplateController::class,
    ];

    foreach ($resources as $slug => $controller) {
        Route::get($slug.'/datatable', [$controller, 'datatable'])->name($slug.'.datatable');
        Route::resource($slug, $controller)->parameters([$slug => 'id'])->except(['show']);
    }

    // Attendance records (no plain CRUD; uses bulk entry + datatable)
    Route::get('attendance-records', [AttendanceRecordController::class, 'index'])->name('attendance-records.index');
    Route::get('attendance-records/datatable', [AttendanceRecordController::class, 'datatable'])->name('attendance-records.datatable');
    Route::get('attendance-records/entry', [AttendanceRecordController::class, 'entry'])->name('attendance-records.entry');
    Route::post('attendance-records/entry', [AttendanceRecordController::class, 'submitEntry'])->name('attendance-records.submit');

    // Class students (pivot)
    Route::get('class-students', [ClassStudentController::class, 'index'])->name('class-students.index');
    Route::get('class-students/datatable', [ClassStudentController::class, 'datatable'])->name('class-students.datatable');
    Route::post('class-students', [ClassStudentController::class, 'store'])->name('class-students.store');
    Route::delete('class-students/{id}', [ClassStudentController::class, 'destroy'])->name('class-students.destroy');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/datatable', [NotificationController::class, 'datatable'])->name('notifications.datatable');

    // Audit logs (read-only)
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('audit-logs/datatable', [AuditLogController::class, 'datatable'])->name('audit-logs.datatable');

    // Reports (placeholder UI)
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // System settings
    Route::get('system-settings', [SystemSettingController::class, 'index'])->name('system-settings.index');
    Route::put('system-settings', [SystemSettingController::class, 'update'])->name('system-settings.update');
});
