@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.entry'))
@section('content')
  <div class="attendance-entry-page">
    <section class="attendance-entry-shell">
      <div class="attendance-entry-toolbar">
        <div>
          <p class="attendance-entry-kicker">Teacher Attendance Workspace</p>
          <h4 class="attendance-entry-title mb-0">{{ __('admin.entry') }}</h4>
        </div>
        <form method="GET" action="{{ route('admin.attendance-records.entry') }}" class="attendance-entry-session-form">
          <div class="attendance-entry-session-select">
            <label class="form-label mb-1">{{ __('admin.sessions') }}</label>
            <select name="session_id" class="form-select tom-select" onchange="this.form.submit()">
              <option value="">— {{ __('admin.sessions') }} —</option>
              @foreach ($sessions as $s)
                <option value="{{ $s->id }}" {{ optional($session)->id === $s->id ? 'selected' : '' }}>
                  {{ $s->attendance_date?->format('Y-m-d') }} — {{ $s->schoolClass?->name }} —
                  {{ strtoupper($s->session_type) }}
                </option>
              @endforeach
            </select>
          </div>
          <a href="{{ route('admin.attendance-sessions.create') }}"
            class="btn btn-outline-primary attendance-entry-create-btn">
            <i class="bi bi-plus-lg me-1"></i> Create Session
          </a>
        </form>
      </div>

      <ul class="nav nav-tabs attendance-mode-tabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link active">Students Attendance</button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link">Teaching Hours</button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link">Notes</button>
        </li>
        <li class="nav-item" role="presentation">
          <button type="button" class="nav-link">Assessment 1</button>
        </li>
      </ul>

      @if (!$session)
        <div class="attendance-empty-state">
          <div class="attendance-empty-icon"><i class="bi bi-calendar2-week"></i></div>
          <h5>Select a session to start marking attendance</h5>
          <p class="mb-0 text-muted">Choose an attendance session above and the teacher-style attendance sheet will load
            here.</p>
        </div>
      @else
        @php
          $formatTime = static function (?string $time): ?string {
              return $time ? \Illuminate\Support\Carbon::parse($time)->format('H:i') : null;
          };
          $studentList = $students
              ->map(function ($s) {
                  return [
                      'id' => $s->id,
                      'code' => $s->student_code,
                      'studentNo' => $s->student_no,
                      'nameEn' => $s->name_en,
                      'nameKh' => $s->name_kh,
                      'gender' => $s->gender,
                  ];
              })
              ->values();
          $statusList = $statuses
              ->map(function ($st) {
                  return [
                      'id' => $st->id,
                      'code' => strtoupper($st->code),
                      'name' => app()->getLocale() === 'km' ? $st->name_kh : $st->name_en,
                      'color' => $st->color,
                      'countsAsPresent' => (bool) $st->counts_as_present,
                      'countsAsAbsent' => (bool) $st->counts_as_absent,
                  ];
              })
              ->values();
          $classroom = $session->schoolClass;
          $academicYearLabel = $classroom?->academicYear?->code ?? $classroom?->academicYear?->name;
          $termLabel = $classroom?->term?->name;
          $shiftLabel = $classroom?->shift?->name;
          $roomLabel = $classroom?->room?->name ?? $classroom?->room?->code;
          $subjectLabel = $session->subject?->localizedName() ?? $session->subject?->name_en;
          $teacherLabel = $session->teacher?->localizedName() ?? $session->teacher?->name_en;
          $timeRange = collect([$formatTime($session->start_time), $formatTime($session->end_time)])
              ->filter()
              ->implode(' - ');
          $reactProps = [
              'sessionId' => $session->id,
              'students' => $studentList,
              'statuses' => $statusList,
              'initial' => $initial,
              'submitUrl' => route('admin.attendance-records.submit'),
              'csrfToken' => csrf_token(),
              'submissionStatus' => $session->submission_status,
          ];
        @endphp

        <div class="attendance-sheet-card">
          <div class="attendance-sheet-header">
            <p class="attendance-sheet-title-km mb-1">សន្លឹកកត់វត្តមានសិស្សប្រចាំម៉ោងសិក្សា</p>
            <h5 class="attendance-sheet-title-en mb-1">
              Attendance Sheet for {{ $classroom?->name ?? 'Selected Class' }}
            </h5>
            <div class="attendance-sheet-meta">
              @if ($academicYearLabel)
                <span><strong>Academic Year:</strong> {{ $academicYearLabel }}</span>
              @endif
              @if ($termLabel)
                <span><strong>Term:</strong> {{ $termLabel }}</span>
              @endif
              @if ($shiftLabel)
                <span><strong>Shift:</strong> {{ $shiftLabel }}</span>
              @endif
              @if ($roomLabel)
                <span><strong>Room:</strong> {{ $roomLabel }}</span>
              @endif
              @if ($timeRange)
                <span><strong>Time:</strong> {{ $timeRange }}</span>
              @endif
            </div>
            <div class="attendance-sheet-meta attendance-sheet-meta--secondary">
              <span><strong>Date:</strong> {{ $session->attendance_date?->format('M d, Y') }}</span>
              @if ($subjectLabel)
                <span><strong>Subject:</strong> {{ $subjectLabel }}</span>
              @endif
              @if ($teacherLabel)
                <span><strong>Teacher:</strong> {{ $teacherLabel }}</span>
              @endif
              <span><strong>Status:</strong> {{ ucfirst($session->submission_status) }}</span>
            </div>
          </div>

          <div class="attendance-sheet-body">
            <div data-react="attendance-entry" data-props='@json($reactProps)'></div>
          </div>
        </div>
      @endif
    </section>
  </div>
@endsection
