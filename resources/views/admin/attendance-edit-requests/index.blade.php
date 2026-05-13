@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.attendance_edit_requests'))
@section('pageBreadcrumbTitle', __('admin.attendance_edit_requests'))

@section('content')
<div class="card">
  <div class="card-body">
    <table id="dt-edit-requests" class="table table-hover w-100">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('admin.student') }}</th>
          <th>{{ __('admin.class') }}</th>
          <th>{{ __('admin.date') }}</th>
          <th>{{ __('admin.requested_status') }}</th>
          <th>{{ __('admin.reason') }}</th>
          <th>{{ __('admin.requested_by') }}</th>
          <th>{{ __('admin.status') }}</th>
          <th class="text-end">{{ __('admin.actions') }}</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

@push('scripts')
<script>
$(function(){
  $('#dt-edit-requests').DataTable({
    serverSide:true, processing:true,
    ajax: "{{ route('admin.attendance-edit-requests.datatable') }}",
    columns:[
      {data:'id'},
      {data:'student_name'},
      {data:'class_name'},
      {data:'attendance_date'},
      {data:'requested_status_name'},
      {data:'reason'},
      {data:'requested_by_name'},
      {data:'status'},
      {data:'actions', orderable:false, searchable:false, className:'text-end'},
    ],
    order:[[0,'desc']],
    pagingType:'full_numbers',
  });
});
</script>
@endpush
@endsection
