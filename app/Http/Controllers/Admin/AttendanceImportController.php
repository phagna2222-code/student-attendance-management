<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceImport;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\AttendanceStatus;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Services\BranchContext;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

/**
 * Bulk attendance import via CSV.
 * Format (header row required): student_code,date,status_code,late_minutes,note
 *  - date: YYYY-MM-DD
 *  - status_code: P / A / L / E / EL / P+  (any active AttendanceStatus.code)
 *  - late_minutes: integer (optional)
 */
class AttendanceImportController extends Controller
{
    public function __construct(private readonly BranchContext $branchContext) {}

    public function index()
    {
        return view('admin.attendance-imports.index', [
            'classes' => SchoolClass::query()
                ->when($this->branchContext->currentId(), fn ($q, $bid) => $q->where('branch_id', $bid))
                ->orderBy('name')->get(),
        ]);
    }

    public function datatable(Request $request)
    {
        $q = AttendanceImport::query()->with([
            'schoolClass:id,name',
            'importedBy:id,name',
        ]);
        return DataTables::eloquent($q)
            ->addColumn('class_name', fn ($r) => $r->schoolClass?->name)
            ->addColumn('imported_by_name', fn ($r) => $r->importedBy?->name)
            ->editColumn('status', fn ($r) => '<span class="badge bg-'.($r->status === 'completed' ? 'success' : ($r->status === 'failed' ? 'danger' : 'warning')).'">'.e($r->status).'</span>')
            ->editColumn('created_at', fn ($r) => $r->created_at?->format('Y-m-d H:i'))
            ->addColumn('actions', function ($r) {
                if (empty($r->errors)) {
                    return '<span class="text-muted small">—</span>';
                }
                return '<button class="btn btn-sm btn-outline-secondary js-view-errors" data-id="'.$r->id.'">'.__('admin.view_errors').'</button>';
            })
            ->rawColumns(['status', 'actions'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:school_classes,id'],
            'attendance_date' => ['required', 'date'],
            'session_type' => ['required', 'in:daily,period,morning,afternoon,evening'],
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ]);

        $class = SchoolClass::findOrFail($data['class_id']);
        $branchId = $class->branch_id;

        $session = AttendanceSession::firstOrCreate(
            [
                'class_id'        => $class->id,
                'attendance_date' => $data['attendance_date'],
                'session_type'    => $data['session_type'],
                'period_no'       => null,
            ],
            [
                'branch_id'        => $branchId,
                'submission_status'=> 'draft',
                'created_by'       => auth()->id(),
            ]
        );

        $path = $request->file('file')->store('imports', 'local');
        $absolute = Storage::disk('local')->path($path);

        $totalRows = 0; $successRows = 0; $failedRows = 0; $errors = [];

        $statuses = AttendanceStatus::pluck('id', 'code')->all();
        $students = Student::query()->whereHas('classes', fn ($q) => $q->where('class_id', $class->id))->pluck('id', 'student_code')->all();

        DB::beginTransaction();
        try {
            if (($h = fopen($absolute, 'r')) === false) {
                throw new \RuntimeException('Failed to open file');
            }
            $header = fgetcsv($h);
            if (! $header || ! in_array('student_code', array_map('strtolower', $header))) {
                throw new \RuntimeException('CSV header must include student_code');
            }
            $header = array_map('strtolower', $header);

            while (($row = fgetcsv($h)) !== false) {
                $totalRows++;
                $r = array_combine($header, $row + array_fill(0, count($header), null));
                $code   = trim((string) ($r['student_code'] ?? ''));
                $status = strtoupper(trim((string) ($r['status_code'] ?? '')));
                if (! isset($students[$code])) {
                    $failedRows++;
                    $errors[] = ['row' => $totalRows + 1, 'message' => "Student code not found: {$code}"];
                    continue;
                }
                if (! isset($statuses[$status])) {
                    $failedRows++;
                    $errors[] = ['row' => $totalRows + 1, 'message' => "Unknown status code: {$status}"];
                    continue;
                }
                $lateMin = (int) ($r['late_minutes'] ?? 0);
                AttendanceRecord::updateOrCreate(
                    [
                        'attendance_session_id' => $session->id,
                        'student_id' => $students[$code],
                    ],
                    [
                        'attendance_status_id' => $statuses[$status],
                        'method' => 'import',
                        'is_late' => $lateMin > 0,
                        'late_minutes' => $lateMin,
                        'teacher_note' => $r['note'] ?? null,
                        'marked_by' => auth()->id(),
                        'marked_at' => now(),
                    ]
                );
                $successRows++;
            }
            fclose($h);

            AttendanceImport::create([
                'class_id' => $class->id,
                'attendance_session_id' => $session->id,
                'imported_by' => auth()->id(),
                'file_path' => $path,
                'total_rows' => $totalRows,
                'success_rows' => $successRows,
                'failed_rows' => $failedRows,
                'errors' => $errors ?: null,
                'status' => $failedRows === 0 ? 'completed' : ($successRows === 0 ? 'failed' : 'completed'),
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            AttendanceImport::create([
                'class_id' => $class->id ?? null,
                'attendance_session_id' => $session->id ?? null,
                'imported_by' => auth()->id(),
                'file_path' => $path ?? '',
                'total_rows' => $totalRows,
                'success_rows' => $successRows,
                'failed_rows' => $failedRows + 1,
                'errors' => array_merge($errors, [['row' => 0, 'message' => $e->getMessage()]]),
                'status' => 'failed',
            ]);
            flash()->error(__('admin.import_failed').': '.$e->getMessage());
            return back();
        }

        flash()->success(__('admin.import_completed').": {$successRows}/{$totalRows}");
        return redirect()->route('admin.attendance-imports.index');
    }

    public function errors(int $id)
    {
        $import = AttendanceImport::findOrFail($id);
        return response()->json(['errors' => $import->errors ?? []]);
    }
}
