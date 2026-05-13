<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveRequestAttachmentController extends Controller
{
    public function store(Request $request, int $leaveId)
    {
        $leave = LeaveRequest::findOrFail($leaveId);
        $data = $request->validate([
            'file' => ['required', 'file', 'max:10240'],
        ]);
        $file = $request->file('file');
        $path = $file->store('leave-attachments/'.$leave->id, 'public');
        LeaveRequestAttachment::create([
            'leave_request_id' => $leave->id,
            'uploaded_by'      => auth()->id(),
            'file_path'        => $path,
            'original_name'    => $file->getClientOriginalName(),
            'mime_type'        => $file->getMimeType(),
            'file_size'        => $file->getSize(),
        ]);
        flash()->success(__('admin.attachment_uploaded'));
        return back();
    }

    public function download(int $leaveId, int $id)
    {
        $att = LeaveRequestAttachment::where('leave_request_id', $leaveId)->findOrFail($id);
        if (! Storage::disk('public')->exists($att->file_path)) {
            abort(404);
        }
        return Storage::disk('public')->download($att->file_path, $att->original_name ?? 'attachment');
    }

    public function destroy(int $leaveId, int $id)
    {
        $att = LeaveRequestAttachment::where('leave_request_id', $leaveId)->findOrFail($id);
        if ($att->file_path && Storage::disk('public')->exists($att->file_path)) {
            Storage::disk('public')->delete($att->file_path);
        }
        $att->delete();
        flash()->success(__('admin.attachment_deleted'));
        return back();
    }
}
