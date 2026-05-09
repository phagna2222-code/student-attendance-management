@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.class_attendance_settings'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.class_attendance_settings'),
    'createUrl' => route('admin.class-attendance-settings.create'),
    'datatableUrl' => route('admin.class-attendance-settings.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'class_name', 'title'=>'Class', 'name'=>'schoolClass.name'],
      ['data'=>'check_in_start_time', 'title'=>'Check-in Start'],
      ['data'=>'check_in_end_time', 'title'=>'Check-in End'],
      ['data'=>'late_grace_minutes', 'title'=>'Grace'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
