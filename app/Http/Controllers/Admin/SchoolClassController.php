<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use App\Models\Branch;
use App\Models\GradeLevel;
use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Shift;
use App\Models\Teacher;
use App\Models\Term;
use App\Services\BranchContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolClassController extends ResourceController
{
    protected string $modelClass = SchoolClass::class;
    protected string $viewPath = 'admin.classes';
    protected string $routePrefix = 'admin.classes';

    public function __construct(private readonly BranchContext $branchContext)
    {
    }

    protected function validationRules(?Model $model = null): array
    {
        return [
            'branch_id'         => ['required', 'exists:branches,id'],
            'grade_level_id'    => ['nullable', 'exists:grade_levels,id'],
            'academic_year_id'  => ['required', 'exists:academic_years,id'],
            'term_id'           => ['nullable', 'exists:terms,id'],
            'shift_id'          => ['nullable', 'exists:shifts,id'],
            'room_id'           => ['nullable', 'exists:rooms,id'],
            'class_teacher_id'  => ['nullable', 'exists:teachers,id'],
            'code'              => ['required', 'string', 'max:80'],
            'name'              => ['required', 'string', 'max:255'],
            'student_limit'     => ['nullable', 'integer', 'min:1'],
            'status'            => ['required', Rule::in(['planned', 'active', 'closed', 'archived'])],
        ];
    }

    protected function extraData(): array
    {
        return [
            'branches'      => Branch::orderBy('name_en')->get(),
            'gradeLevels'   => GradeLevel::orderBy('level_order')->get(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
            'terms'         => Term::orderBy('name')->get(),
            'shifts'        => Shift::orderBy('name')->get(),
            'rooms'         => Room::orderBy('name')->get(),
            'teachers'      => Teacher::orderBy('name_en')->get(),
        ];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        $q = SchoolClass::query()->with([
            'branch:id,name_en,name_kh',
            'gradeLevel:id,name_en,name_kh',
            'academicYear:id,name',
            'classTeacher:id,name_en,name_kh',
        ])->select('school_classes.*');
        $branchId = $this->branchContext->currentId();
        if ($branchId) $q->where('branch_id', $branchId);
        return $q;
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName())
            ->addColumn('grade_level_name', fn ($r) => $r->gradeLevel?->localizedName())
            ->addColumn('academic_year_name', fn ($r) => $r->academicYear?->name)
            ->addColumn('teacher_name', fn ($r) => $r->classTeacher?->localizedName());
    }
}
