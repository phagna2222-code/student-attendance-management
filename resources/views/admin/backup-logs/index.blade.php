@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.backup_logs'))
@section('content')
<div class="card mb-3">
  <div class="card-body d-flex align-items-center gap-2">
    <form method="POST" action="{{ route('admin.backup-logs.run') }}" class="d-flex gap-2 align-items-end">
      @csrf
      <div>
        <label class="form-label mb-1">{{ __('admin.backup_type') }}</label>
        <select name="type" class="form-select form-select-sm">
          <option value="database">database</option>
          <option value="files">files</option>
          <option value="full">full</option>
        </select>
      </div>
      <button class="btn btn-primary btn-sm" type="submit"><i class="bx bx-cloud-upload"></i> {{ __('admin.run_backup_now') }}</button>
    </form>
  </div>
</div>

@include('admin.partials._card_index', [
  'title' => __('admin.backup_logs'),
  'createUrl' => null,
  'datatableUrl' => route('admin.backup-logs.datatable'),
  'columns' => [
    ['data'=>'id','title'=>'#'],
    ['data'=>'type','title'=>__('admin.type')],
    ['data'=>'destination','title'=>__('admin.destination')],
    ['data'=>'file_size','title'=>__('admin.size')],
    ['data'=>'requested_by_name','title'=>__('admin.requested_by')],
    ['data'=>'started_at','title'=>__('admin.started_at')],
    ['data'=>'finished_at','title'=>__('admin.finished_at')],
    ['data'=>'status','title'=>__('admin.status')],
    ['data'=>'actions','title'=>__('admin.actions'),'orderable'=>false,'searchable'=>false],
  ],
])
@endsection
