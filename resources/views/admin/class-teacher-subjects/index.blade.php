@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.class_teacher_subjects'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.class_teacher_subjects'),
      'createUrl' => route('admin.class-teacher-subjects.create'),
      'datatableUrl' => route('admin.class-teacher-subjects.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'class_name', 'title' => __('admin.class'), 'name' => 'schoolClass.name'],
          ['data' => 'teacher_name', 'title' => __('admin.teacher'), 'name' => 'teacher.name_en'],
          ['data' => 'subject_name', 'title' => __('admin.subject'), 'name' => 'subject.name_en'],
          ['data' => 'academic_year_name', 'title' => __('admin.year'), 'name' => 'academicYear.name'],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
