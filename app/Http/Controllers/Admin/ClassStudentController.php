<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClassStudentController extends Controller
{
    public function index()
    {
        return view('admin.class-students.index', [
            'classes'  => SchoolClass::orderBy('name')->get(),
            'students' => Student::orderBy('name_en')->limit(500)->get(),
        ]);
    }

    public function datatable(Request $request)
    {
        $query = DB::table('class_students')
            ->join('school_classes', 'class_students.class_id', '=', 'school_classes.id')
            ->join('students', 'class_students.student_id', '=', 'students.id')
            ->select(
                'class_students.id',
                'class_students.class_id',
                'class_students.student_id',
                'class_students.enrolled_at',
                'class_students.left_at',
                'class_students.status',
                'school_classes.name as class_name',
                'students.name_en as student_name',
                'students.student_code'
            );
        return DataTables::of($query)
            ->addColumn('actions', function ($row) {
                return '<form method="POST" action="'.route('admin.class-students.destroy', $row->id).'" class="d-inline">'.csrf_field().method_field('DELETE').'<button class="btn btn-sm btn-light border text-danger js-confirm-delete"><i class="bi bi-trash"></i></button></form>';
            })
            ->editColumn('status', fn ($r) => '<span class="badge bg-info">'.e($r->status).'</span>')
            ->rawColumns(['actions', 'status'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id'    => ['required', 'exists:school_classes,id'],
            'student_id'  => ['required', 'exists:students,id'],
            'enrolled_at' => ['nullable', 'date'],
            'status'      => ['required', 'in:active,transferred,left,completed'],
        ]);
        DB::table('class_students')->updateOrInsert([
            'class_id' => $data['class_id'],
            'student_id' => $data['student_id'],
        ], [
            'enrolled_at' => $data['enrolled_at'] ?? now()->toDateString(),
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        flash()->success(__('admin.class_students').' — '.__('Saved successfully'));
        return redirect()->route('admin.class-students.index');
    }

    public function destroy(int $id)
    {
        DB::table('class_students')->where('id', $id)->delete();
        flash()->success(__('admin.class_students').' — '.__('Deleted successfully'));
        return back();
    }
}
