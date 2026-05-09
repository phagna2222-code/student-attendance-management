<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use App\Models\Branch;
use App\Models\SchoolClass;
use App\Models\Shift;
use App\Models\Student;
use App\Services\BranchContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends ResourceController
{
    protected string $modelClass = Student::class;
    protected string $viewPath = 'admin.students';
    protected string $routePrefix = 'admin.students';

    public function __construct(private readonly BranchContext $branchContext)
    {
    }

    protected function validationRules(?Model $model = null): array
    {
        return [
            'branch_id'         => ['required', 'exists:branches,id'],
            'current_class_id'  => ['nullable', 'exists:school_classes,id'],
            'academic_year_id'  => ['nullable', 'exists:academic_years,id'],
            'shift_id'          => ['nullable', 'exists:shifts,id'],
            'student_code'      => ['required', 'string', 'max:80', Rule::unique('students', 'student_code')->ignore($model?->id)],
            'student_no'        => ['nullable', 'string', 'max:80'],
            'name_kh'           => ['nullable', 'string', 'max:255'],
            'name_en'           => ['required', 'string', 'max:255'],
            'gender'            => ['nullable', Rule::in(['male', 'female', 'other'])],
            'date_of_birth'     => ['nullable', 'date'],
            'phone'             => ['nullable', 'string', 'max:50'],
            'address'           => ['nullable', 'string'],
            'qr_code_value'     => ['nullable', 'string', 'max:255', Rule::unique('students', 'qr_code_value')->ignore($model?->id)],
            'barcode_value'     => ['nullable', 'string', 'max:255', Rule::unique('students', 'barcode_value')->ignore($model?->id)],
            'rfid_uid'          => ['nullable', 'string', 'max:255', Rule::unique('students', 'rfid_uid')->ignore($model?->id)],
            'status'            => ['required', Rule::in(['active', 'studying', 'suspended', 'dropout', 'graduated', 'transferred'])],
            'admission_date'    => ['nullable', 'date'],
            'exit_date'         => ['nullable', 'date'],
        ];
    }

    protected function extraData(): array
    {
        $branchId = $this->branchContext->currentId();
        return [
            'branches'      => Branch::orderBy('name_en')->get(),
            'classes'       => SchoolClass::query()
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->orderBy('name')->get(),
            'academicYears' => AcademicYear::orderBy('name')->get(),
            'shifts'        => Shift::orderBy('name')->get(),
        ];
    }

    protected function dataTableQuery(Request $request): Builder
    {
        $q = Student::query()->with(['branch:id,name_en,name_kh', 'currentClass:id,name'])->select('students.*');
        $branchId = $this->branchContext->currentId();
        if ($branchId) $q->where('branch_id', $branchId);
        return $q;
    }

    protected function buildDataTable(Builder $query)
    {
        return parent::buildDataTable($query)
            ->addColumn('branch_name', fn ($r) => $r->branch?->localizedName())
            ->addColumn('class_name', fn ($r) => $r->currentClass?->name);
    }
}
