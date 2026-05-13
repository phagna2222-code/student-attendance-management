@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.compose_notification'))
@section('pageBreadcrumbTitle', __('admin.compose_notification'))

@section('content')
<form method="POST" action="{{ route('admin.notifications.store') }}">
  @csrf
  <div class="card">
    <div class="card-body row g-3">
      <div class="col-md-4">
        <label class="form-label">{{ __('admin.template') }}</label>
        <select name="template_id" class="form-select tom-select" id="tplPicker">
          <option value="">—</option>
          @foreach($templates as $t)
            <option value="{{ $t->id }}"
              data-channel="{{ $t->channel }}"
              data-subject="{{ $t->subject }}"
              data-body="{{ $t->body }}">{{ $t->name }} ({{ $t->channel }})</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">{{ __('admin.channel') }}</label>
        <select name="channel" class="form-select" required>
          <option value="email">email</option>
          <option value="telegram">telegram</option>
          <option value="sms">sms</option>
          <option value="portal">portal</option>
          <option value="push">push</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">{{ __('admin.type') }}</label>
        <select name="type" class="form-select" required>
          <option value="general">general</option>
          <option value="absent_alert">absent_alert</option>
          <option value="late_alert">late_alert</option>
          <option value="early_leave_alert">early_leave_alert</option>
          <option value="leave_approved">leave_approved</option>
          <option value="leave_rejected">leave_rejected</option>
          <option value="monthly_summary">monthly_summary</option>
          <option value="consecutive_absent_warning">consecutive_absent_warning</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">{{ __('admin.class') }}</label>
        <select name="class_id" class="form-select tom-select">
          <option value="">{{ __('admin.no_class_filter') }}</option>
          @foreach($classes as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">{{ __('admin.individual_students') }}</label>
        <select name="student_ids[]" multiple class="form-select tom-select">
          @foreach($students as $s)
            <option value="{{ $s->id }}">{{ $s->localizedName() }} — {{ $s->student_code }}</option>
          @endforeach
        </select>
        <small class="text-muted">{{ __('admin.recipients_help') }}</small>
      </div>

      <div class="col-12">
        <label class="form-label">{{ __('admin.subject') }}</label>
        <input type="text" name="subject" id="subjField" class="form-control" maxlength="255">
      </div>
      <div class="col-12">
        <label class="form-label">{{ __('admin.message') }}</label>
        <textarea name="message" id="bodyField" class="form-control" rows="6" required></textarea>
      </div>

      <div class="col-md-6">
        <label class="form-label">{{ __('admin.scheduled_at') }}</label>
        <input type="text" name="scheduled_at" class="form-control flatpickr-datetime">
      </div>
      <div class="col-md-6 d-flex align-items-end">
        <label class="form-check-label">
          <input type="checkbox" name="send_immediately" value="1" class="form-check-input"> {{ __('admin.send_now') }}
        </label>
      </div>
    </div>
    <div class="card-footer text-end">
      <a class="btn btn-light" href="{{ route('admin.notifications.index') }}">{{ __('admin.cancel') }}</a>
      <button class="btn btn-primary" type="submit"><i class="bx bx-send"></i> {{ __('admin.queue') }}</button>
    </div>
  </div>
</form>

@push('scripts')
<script>
$(function(){
  $('#tplPicker').on('change', function(){
    const o = this.options[this.selectedIndex];
    if (!o.value) return;
    const channel = o.getAttribute('data-channel');
    if (channel) $('select[name=channel]').val(channel);
    $('#subjField').val(o.getAttribute('data-subject') || '');
    $('#bodyField').val(o.getAttribute('data-body') || '');
  });
});
</script>
@endpush
@endsection
