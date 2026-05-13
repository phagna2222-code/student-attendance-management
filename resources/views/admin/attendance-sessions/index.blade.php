@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.sessions'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.sessions'),
      'createUrl' => route('admin.attendance-sessions.create'),
      'datatableUrl' => route('admin.attendance-sessions.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'branch_name', 'title' => __('admin.branch'), 'name' => 'branch.name_en'],
          ['data' => 'class_name', 'title' => __('admin.class'), 'name' => 'schoolClass.name'],
          ['data' => 'attendance_date', 'title' => __('admin.date'), 'name' => 'attendance_date'],
          ['data' => 'session_type', 'title' => __('admin.type')],
          ['data' => 'submission_status', 'title' => __('admin.submission')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
