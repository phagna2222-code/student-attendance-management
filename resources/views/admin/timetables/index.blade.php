@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.timetables'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.timetables'),
    'createUrl' => route('admin.timetables.create'),
    'datatableUrl' => route('admin.timetables.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'class_name', 'title'=>'Class', 'name'=>'schoolClass.name'],
      ['data'=>'subject_name', 'title'=>'Subject', 'name'=>'subject.name_en'],
      ['data'=>'teacher_name', 'title'=>'Teacher', 'name'=>'teacher.name_en'],
      ['data'=>'day_of_week', 'title'=>'Day'],
      ['data'=>'start_time', 'title'=>'Start'],
      ['data'=>'end_time', 'title'=>'End'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
