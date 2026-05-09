@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.sessions'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.sessions'),
    'createUrl' => route('admin.attendance-sessions.create'),
    'datatableUrl' => route('admin.attendance-sessions.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'branch_name', 'title'=>'Branch', 'name'=>'branch.name_en'],
      ['data'=>'class_name', 'title'=>'Class', 'name'=>'schoolClass.name'],
      ['data'=>'attendance_date', 'title'=>'Date', 'name'=>'attendance_date'],
      ['data'=>'session_type', 'title'=>'Type'],
      ['data'=>'submission_status', 'title'=>'Submission'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
