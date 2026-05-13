<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentParent;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index', [
            'templates' => NotificationTemplate::orderBy('name')->get(),
            'classes'   => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function datatable(Request $request)
    {
        $q = Notification::query()->with([
            'template:id,name',
            'student:id,name_en,name_kh',
            'parent:id,name_en,name_kh',
            'schoolClass:id,name',
        ]);
        return DataTables::eloquent($q)
            ->addColumn('template_name', fn ($r) => $r->template?->name)
            ->addColumn('student_name', fn ($r) => $r->student?->localizedName())
            ->addColumn('parent_name', fn ($r) => $r->parent?->localizedName())
            ->addColumn('class_name', fn ($r) => $r->schoolClass?->name)
            ->editColumn('status', fn ($r) => '<span class="badge bg-'.match($r->status){'sent','read'=>'success','queued','scheduled'=>'warning','cancelled'=>'secondary','failed'=>'danger',default=>'info'}.'">'.e($r->status).'</span>')
            ->editColumn('created_at', fn ($r) => $r->created_at?->format('Y-m-d H:i'))
            ->addColumn('actions', function ($r) {
                $retry = $r->status === 'failed' || $r->status === 'queued';
                return view('admin.notifications._actions', [
                    'id' => $r->id,
                    'retryUrl' => $retry ? route('admin.notifications.send', $r->id) : null,
                ])->render();
            })
            ->rawColumns(['status', 'actions'])
            ->toJson();
    }

    public function compose()
    {
        return view('admin.notifications.compose', [
            'templates' => NotificationTemplate::where('status', 'active')->get(),
            'classes'   => SchoolClass::orderBy('name')->get(),
            'students'  => Student::orderBy('name_en')->limit(500)->get(),
        ]);
    }

    public function store(Request $request, NotificationDispatcher $dispatcher)
    {
        $data = $request->validate([
            'template_id'        => ['nullable', 'exists:notification_templates,id'],
            'channel'            => ['required', Rule::in(['sms','email','telegram','portal','push'])],
            'type'               => ['required', Rule::in(['absent_alert','late_alert','early_leave_alert','leave_approved','leave_rejected','monthly_summary','consecutive_absent_warning','general'])],
            'class_id'           => ['nullable', 'exists:school_classes,id'],
            'student_ids'        => ['nullable', 'array'],
            'student_ids.*'      => ['integer', 'exists:students,id'],
            'subject'            => ['nullable', 'string', 'max:255'],
            'message'            => ['required', 'string'],
            'scheduled_at'       => ['nullable', 'date'],
            'send_immediately'   => ['nullable', 'boolean'],
        ]);

        $targets = [];

        if (! empty($data['student_ids'])) {
            $targets = Student::with('parents')->whereIn('id', $data['student_ids'])->get();
        } elseif (! empty($data['class_id'])) {
            $targets = Student::with('parents')->whereHas('classes', fn ($q) => $q->where('class_id', $data['class_id']))->get();
        }

        if (count($targets) === 0) {
            flash()->error(__('admin.no_recipients_selected'));
            return back();
        }

        $created = 0;
        foreach ($targets as $student) {
            $parent = $student->parents->first();
            $contact = match ($data['channel']) {
                'email'    => $parent?->email ?? $student->user?->email,
                'telegram' => $parent?->telegram_chat_id,
                'sms'      => $parent?->phone ?? $student->phone,
                default    => null,
            };

            $notification = Notification::create([
                'template_id'       => $data['template_id'] ?? null,
                'student_id'        => $student->id,
                'parent_id'         => $parent?->id,
                'class_id'          => $data['class_id'] ?? null,
                'created_by'        => auth()->id(),
                'type'              => $data['type'],
                'channel'           => $data['channel'],
                'recipient_name'    => $parent?->localizedName() ?? $student->localizedName(),
                'recipient_contact' => $contact,
                'subject'           => $data['subject'] ?? null,
                'message'           => $data['message'],
                'status'            => 'queued',
                'scheduled_at'      => $data['scheduled_at'] ?? null,
            ]);
            $created++;

            if (! empty($data['send_immediately'])) {
                $dispatcher->send($notification);
            }
        }

        flash()->success(__('admin.notifications_queued').": {$created}");
        return redirect()->route('admin.notifications.index');
    }

    public function send(int $id, NotificationDispatcher $dispatcher)
    {
        $n = Notification::findOrFail($id);
        $ok = $dispatcher->send($n);
        if ($ok) {
            flash()->success(__('admin.notification_sent'));
        } else {
            flash()->error(__('admin.notification_failed').': '.$n->failure_reason);
        }
        return back();
    }
}
