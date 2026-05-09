<?php

namespace App\Http\Controllers\Admin;

use App\Models\LeaveRequest;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveRequestController extends ResourceController
{
    protected string $modelClass = LeaveRequest::class;
    protected string $viewPath = 'admin.leave-requests';
    protected string $routePrefix = 'admin.leave-requests';

    protected function validationRules(?Model $model = null): array
    {
        return [
            'request_no'  => ['required', 'string', 'max:80', Rule::unique('leave_requests', 'request_no')->ignore($model?->id)],
            'student_id'  => ['required', 'exists:students,id'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'total_days'  => ['nullable', 'numeric', 'min:0'],
            'leave_type'  => ['required', Rule::in(['permission', 'leave', 'sick', 'family', 'other'])],
            'reason'      => ['required', 'string'],
            'status'      => ['required', Rule::in(['pending', 'approved', 'rejected', 'need_more_info', 'cancelled'])],
            'reject_reason' => ['nullable', 'string'],
        ];
    }

    protected function extraData(): array
    {
        return ['students' => Student::orderBy('name_en')->limit(500)->get()];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        return LeaveRequest::query()->with('student:id,name_en,name_kh,student_code');
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('student_name', fn ($r) => $r->student?->localizedName())
            ->editColumn('start_date', fn ($r) => $r->start_date?->format('Y-m-d'))
            ->editColumn('end_date', fn ($r) => $r->end_date?->format('Y-m-d'));
    }
}
