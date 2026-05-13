@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.leave_requests'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.leave_requests'),
      'createUrl' => route('admin.leave-requests.create'),
      'datatableUrl' => route('admin.leave-requests.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'request_no', 'title' => __('admin.request_number')],
          ['data' => 'student_name', 'title' => __('admin.student'), 'name' => 'student.name_en'],
          ['data' => 'start_date', 'title' => __('admin.start')],
          ['data' => 'end_date', 'title' => __('admin.end')],
          ['data' => 'leave_type', 'title' => __('admin.type')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
