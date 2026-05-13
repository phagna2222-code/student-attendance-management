@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.teaching_records'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.teaching_records'),
    'createUrl' => route('admin.teaching-records.create'),
    'datatableUrl' => route('admin.teaching-records.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'teaching_date', 'title'=>__('admin.teaching_date')],
      ['data'=>'class_name', 'title'=>__('admin.class')],
      ['data'=>'subject_name', 'title'=>__('admin.subject')],
      ['data'=>'teacher_name', 'title'=>__('admin.teacher')],
      ['data'=>'lesson_title', 'title'=>__('admin.lesson_title')],
      ['data'=>'actions', 'title'=>__('admin.actions'), 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
