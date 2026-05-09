<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use App\Models\ClassTeacherSubject;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassTeacherSubjectController extends ResourceController
{
    protected string $modelClass = ClassTeacherSubject::class;
    protected string $viewPath = 'admin.class-teacher-subjects';
    protected string $routePrefix = 'admin.class-teacher-subjects';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'class_id'         => ['required', 'exists:school_classes,id'],
            'teacher_id'       => ['required', 'exists:teachers,id'],
            'subject_id'       => ['nullable', 'exists:subjects,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'status'           => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    protected function extraData(): array
    {
        return [
            'classes'       => SchoolClass::orderBy('name')->get(),
            'teachers'      => Teacher::orderBy('name_en')->get(),
            'subjects'      => Subject::orderBy('name_en')->get(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
        ];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return ClassTeacherSubject::query()->with([
            'schoolClass:id,name',
            'teacher:id,name_en,name_kh',
            'subject:id,name_en,name_kh',
            'academicYear:id,name',
        ]);
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('class_name', fn ($r) => $r->schoolClass?->name)
            ->addColumn('teacher_name', fn ($r) => $r->teacher?->localizedName())
            ->addColumn('subject_name', fn ($r) => $r->subject?->localizedName())
            ->addColumn('academic_year_name', fn ($r) => $r->academicYear?->name);
    }
}
