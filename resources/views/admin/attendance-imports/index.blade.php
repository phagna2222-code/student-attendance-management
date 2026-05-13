@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.attendance_imports'))
@section('pageBreadcrumbTitle', __('admin.attendance_imports'))

@section('content')
<div class="row g-3">
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">{{ __('admin.upload_csv') }}</div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.attendance-imports.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-2">
            <label class="form-label">{{ __('admin.class') }}</label>
            <select name="class_id" class="form-select tom-select" required>
              <option value="">{{ __('admin.select_class') }}</option>
              @foreach($classes as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">{{ __('admin.attendance_date') }}</label>
            <input type="text" name="attendance_date" class="form-control flatpickr" required>
          </div>
          <div class="mb-2">
            <label class="form-label">{{ __('admin.session_type') }}</label>
            <select name="session_type" class="form-select">
              <option value="daily">daily</option>
              <option value="morning">morning</option>
              <option value="afternoon">afternoon</option>
              <option value="evening">evening</option>
              <option value="period">period</option>
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">{{ __('admin.csv_file') }}</label>
            <input type="file" name="file" class="form-control" accept=".csv,text/csv" required>
            <small class="text-muted d-block">{{ __('admin.csv_format_help') }}: student_code,date,status_code,late_minutes,note</small>
          </div>
          <button class="btn btn-primary w-100" type="submit"><i class="bx bx-upload"></i> {{ __('admin.upload') }}</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">{{ __('admin.import_history') }}</div>
      <div class="card-body">
        <table id="dt-imports" class="table table-hover w-100">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('admin.class') }}</th>
              <th>{{ __('admin.total') }}</th>
              <th>{{ __('admin.success') }}</th>
              <th>{{ __('admin.failed') }}</th>
              <th>{{ __('admin.imported_by') }}</th>
              <th>{{ __('admin.status') }}</th>
              <th>{{ __('admin.created_at') }}</th>
              <th class="text-end">{{ __('admin.actions') }}</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
$(function(){
  $('#dt-imports').DataTable({
    serverSide:true, processing:true,
    ajax: "{{ route('admin.attendance-imports.datatable') }}",
    columns:[
      {data:'id'},
      {data:'class_name'},
      {data:'total_rows'},
      {data:'success_rows'},
      {data:'failed_rows'},
      {data:'imported_by_name'},
      {data:'status'},
      {data:'created_at'},
      {data:'actions', orderable:false, searchable:false, className:'text-end'},
    ],
    order:[[0,'desc']],
    pagingType:'full_numbers',
  });

  $(document).on('click', '.js-view-errors', function(){
    const id = $(this).data('id');
    $.getJSON("{{ url('admin/attendance-imports') }}/"+id+"/errors", function(res){
      const html = res.errors.map(e => `<li>Row ${e.row}: ${e.message}</li>`).join('') || '<li>none</li>';
      Swal.fire({title: '{{ __("admin.errors") }}', html: `<ul class="text-start">${html}</ul>`});
    });
  });
});
</script>
@endpush
@endsection
