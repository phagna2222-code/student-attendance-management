@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.entry'))
@section('content')
  <div class="card mb-3">
    <div class="card-header"><h5 class="mb-0">{{ __('admin.entry') }}</h5></div>
    <div class="card-body">
      <form method="GET" action="{{ route('admin.attendance-records.entry') }}">
        <div class="row align-items-end">
          <div class="col-md-6 mb-2">
            <label class="form-label">{{ __('admin.sessions') }}</label>
            <select name="session_id" class="form-select tom-select" onchange="this.form.submit()">
              <option value="">— {{ __('admin.sessions') }} —</option>
              @foreach($sessions as $s)
                <option value="{{ $s->id }}" {{ optional($session)->id === $s->id ? 'selected' : '' }}>
                  {{ $s->attendance_date?->format('Y-m-d') }} — {{ $s->schoolClass?->name }} — {{ $s->session_type }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 mb-2">
            <a href="{{ route('admin.attendance-sessions.create') }}" class="btn btn-light border">
              <i class="bi bi-plus-lg me-1"></i> Create Session
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>

  @if(!$session)
    <div class="alert alert-info">{{ __('Select a session above to start marking attendance.') }}</div>
  @else
    @php
      $studentList = $students->map(function ($s) {
        return ['id' => $s->id, 'name' => $s->name_en, 'code' => $s->student_code];
      })->values();
      $statusList = $statuses->map(function ($st) {
        return [
          'id'    => $st->id,
          'code'  => $st->code,
          'name'  => app()->getLocale() === 'km' ? $st->name_kh : $st->name_en,
          'color' => $st->color,
        ];
      })->values();
      $reactProps = [
        'sessionId'  => $session->id,
        'students'   => $studentList,
        'statuses'   => $statusList,
        'initial'    => $initial,
        'submitUrl'  => route('admin.attendance-records.submit'),
        'csrfToken'  => csrf_token(),
      ];
    @endphp
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
          <div>
            <h5 class="mb-1">{{ $session->schoolClass?->name }}</h5>
            <small class="text-muted">{{ $session->attendance_date?->format('Y-m-d') }} • {{ $session->session_type }} • {{ $session->subject?->name_en }}</small>
          </div>
          <span class="badge bg-info align-self-start">{{ $session->submission_status }}</span>
        </div>
        <div data-react="attendance-entry" data-props='@json($reactProps)'></div>
      </div>
    </div>
  @endif
@endsection
