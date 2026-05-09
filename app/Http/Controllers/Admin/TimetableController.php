<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\Timetable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TimetableController extends ResourceController
{
    protected string $modelClass = Timetable::class;
    protected string $viewPath = 'admin.timetables';
    protected string $routePrefix = 'admin.timetables';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'class_id'     => ['required', 'exists:school_classes,id'],
            'subject_id'   => ['nullable', 'exists:subjects,id'],
            'teacher_id'   => ['nullable', 'exists:teachers,id'],
            'room_id'      => ['nullable', 'exists:rooms,id'],
            'term_id'      => ['nullable', 'exists:terms,id'],
            'day_of_week'  => ['required', 'integer', 'min:0', 'max:6'],
            'session_name' => ['nullable', 'string', 'max:100'],
            'period_no'    => ['nullable', 'integer', 'min:1'],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i'],
            'status'       => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    protected function extraData(): array
    {
        return [
            'classes'  => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name_en')->get(),
            'teachers' => Teacher::orderBy('name_en')->get(),
            'rooms'    => Room::orderBy('name')->get(),
            'terms'    => Term::orderBy('name')->get(),
        ];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return Timetable::query()->with([
            'schoolClass:id,name',
            'subject:id,name_en,name_kh',
            'teacher:id,name_en,name_kh',
        ]);
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('class_name', fn ($r) => $r->schoolClass?->name)
            ->addColumn('subject_name', fn ($r) => $r->subject?->localizedName())
            ->addColumn('teacher_name', fn ($r) => $r->teacher?->localizedName());
    }
}
