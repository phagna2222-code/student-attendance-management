@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.timetables'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.timetables'),
      'createUrl' => route('admin.timetables.create'),
      'datatableUrl' => route('admin.timetables.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'class_name', 'title' => __('admin.class'), 'name' => 'schoolClass.name'],
          ['data' => 'subject_name', 'title' => __('admin.subject'), 'name' => 'subject.name_en'],
          ['data' => 'teacher_name', 'title' => __('admin.teacher'), 'name' => 'teacher.name_en'],
          ['data' => 'day_of_week', 'title' => __('admin.day')],
          ['data' => 'start_time', 'title' => __('admin.start')],
          ['data' => 'end_time', 'title' => __('admin.end')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
