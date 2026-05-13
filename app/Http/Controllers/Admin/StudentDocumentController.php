<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentDocumentController extends Controller
{
    public function index(int $studentId)
    {
        $student = Student::with('documents.uploader:id,name')->findOrFail($studentId);
        return view('admin.student-documents.index', compact('student'));
    }

    public function store(Request $request, int $studentId)
    {
        $student = Student::findOrFail($studentId);
        $data = $request->validate([
            'document_type' => ['nullable', 'string', 'max:100'],
            'title'         => ['required', 'string', 'max:255'],
            'file'          => ['required', 'file', 'max:10240'],
        ]);
        $file = $request->file('file');
        $path = $file->store('student-documents/'.$student->id, 'public');
        StudentDocument::create([
            'student_id'  => $student->id,
            'uploaded_by' => auth()->id(),
            'document_type' => $data['document_type'] ?? null,
            'title'       => $data['title'],
            'file_path'   => $path,
            'mime_type'   => $file->getMimeType(),
            'file_size'   => $file->getSize(),
        ]);
        flash()->success(__('admin.document_uploaded'));
        return back();
    }

    public function destroy(int $studentId, int $id)
    {
        $doc = StudentDocument::where('student_id', $studentId)->findOrFail($id);
        if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        flash()->success(__('admin.document_deleted'));
        return back();
    }

    public function download(int $studentId, int $id)
    {
        $doc = StudentDocument::where('student_id', $studentId)->findOrFail($id);
        if (! Storage::disk('public')->exists($doc->file_path)) {
            abort(404);
        }
        return Storage::disk('public')->download($doc->file_path, $doc->title);
    }
}
