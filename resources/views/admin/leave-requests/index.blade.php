@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.leave_requests'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.leave_requests'),
    'createUrl' => route('admin.leave-requests.create'),
    'datatableUrl' => route('admin.leave-requests.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'request_no', 'title'=>'Request #'],
      ['data'=>'student_name', 'title'=>'Student', 'name'=>'student.name_en'],
      ['data'=>'start_date', 'title'=>'Start'],
      ['data'=>'end_date', 'title'=>'End'],
      ['data'=>'leave_type', 'title'=>'Type'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
