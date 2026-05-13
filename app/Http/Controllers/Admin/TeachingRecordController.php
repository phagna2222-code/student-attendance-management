<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttendanceSession;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingRecord;
use App\Services\BranchContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TeachingRecordController extends ResourceController
{
    protected string $modelClass = TeachingRecord::class;
    protected string $viewPath = 'admin.teaching-records';
    protected string $routePrefix = 'admin.teaching-records';

    public function __construct(private readonly BranchContext $branchContext) {}

    protected function validationRules(?Model $model = null): array
    {
        return [
            'class_id'              => ['required', 'exists:school_classes,id'],
            'subject_id'            => ['nullable', 'exists:subjects,id'],
            'teacher_id'            => ['nullable', 'exists:teachers,id'],
            'attendance_session_id' => ['nullable', 'exists:attendance_sessions,id'],
            'teaching_date'         => ['required', 'date'],
            'lesson_title'          => ['nullable', 'string', 'max:255'],
            'lesson_content'        => ['nullable', 'string'],
            'homework'              => ['nullable', 'string'],
            'notes'                 => ['nullable', 'string'],
        ];
    }

    protected function extraData(): array
    {
        $branchId = $this->branchContext->currentId();
        return [
            'classes'  => SchoolClass::query()->when($branchId, fn ($q) => $q->where('branch_id', $branchId))->orderBy('name')->get(),
            'subjects' => Subject::orderBy('name_en')->get(),
            'teachers' => Teacher::orderBy('name_en')->get(),
            'sessions' => AttendanceSession::query()
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->latest('attendance_date')->limit(50)->get(),
        ];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        $q = TeachingRecord::query()->with([
            'schoolClass:id,name',
            'subject:id,name_en,name_kh',
            'teacher:id,name_en,name_kh',
        ]);
        $branchId = $this->branchContext->currentId();
        if ($branchId) {
            $q->whereHas('schoolClass', fn ($x) => $x->where('branch_id', $branchId));
        }
        return $q;
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('class_name', fn ($r) => $r->schoolClass?->name)
            ->addColumn('subject_name', fn ($r) => $r->subject?->localizedName())
            ->addColumn('teacher_name', fn ($r) => $r->teacher?->localizedName())
            ->editColumn('teaching_date', fn ($r) => $r->teaching_date?->format('Y-m-d'));
    }
}
