@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.student_documents'))
@section('pageBreadcrumbTitle', $student->localizedName())

@section('content')
<div class="row g-3">
  <div class="col-lg-5">
    <div class="card">
      <div class="card-header">{{ __('admin.upload_document') }}</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.students.documents.store', $student->id) }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-2">
            <label class="form-label">{{ __('admin.document_type') }}</label>
            <select name="document_type" class="form-select tom-select">
              <option value="birth_certificate">Birth Certificate</option>
              <option value="id_card">ID Card</option>
              <option value="previous_transcript">Previous Transcript</option>
              <option value="medical">Medical Record</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">{{ __('admin.title') }}</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="mb-2">
            <label class="form-label">{{ __('admin.file') }}</label>
            <input type="file" name="file" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100" type="submit"><i class="bx bx-upload"></i> {{ __('admin.upload') }}</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header">{{ __('admin.documents') }} ({{ $student->documents->count() }})</div>
      <ul class="list-group list-group-flush">
        @forelse($student->documents as $doc)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <strong>{{ $doc->title }}</strong>
              <span class="badge bg-light text-muted">{{ $doc->document_type }}</span>
              <div class="small text-muted">{{ $doc->mime_type }} · {{ number_format(($doc->file_size ?? 0)/1024, 1) }} KB · {{ $doc->uploader?->name }}</div>
            </div>
            <div class="btn-group btn-group-sm">
              <a class="btn btn-outline-secondary" href="{{ route('admin.students.documents.download', [$student->id, $doc->id]) }}"><i class="bx bx-download"></i></a>
              <form method="POST" action="{{ route('admin.students.documents.destroy', [$student->id, $doc->id]) }}" class="d-inline js-confirm-action" data-confirm="{{ __('admin.confirm_delete') }}">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger" type="submit"><i class="bx bx-trash"></i></button>
              </form>
            </div>
          </li>
        @empty
          <li class="list-group-item text-muted">{{ __('admin.no_documents') }}</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
@endsection
