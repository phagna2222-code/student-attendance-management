@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.classes'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.classes'),
      'createUrl' => route('admin.classes.create'),
      'datatableUrl' => route('admin.classes.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'branch_name', 'title' => __('admin.branch'), 'name' => 'branch.name_en'],
          ['data' => 'grade_level_name', 'title' => __('admin.grade'), 'name' => 'gradeLevel.name_en'],
          ['data' => 'academic_year_name', 'title' => __('admin.year'), 'name' => 'academicYear.name'],
          ['data' => 'teacher_name', 'title' => __('admin.teacher'), 'name' => 'classTeacher.name_en'],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
