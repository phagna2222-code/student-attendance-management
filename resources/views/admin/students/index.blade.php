@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.students'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.students'),
      'createUrl' => route('admin.students.create'),
      'datatableUrl' => route('admin.students.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'student_code', 'title' => __('admin.code')],
          ['data' => 'name_en', 'title' => __('admin.name_en')],
          ['data' => 'name_kh', 'title' => __('admin.name_kh')],
          ['data' => 'branch_name', 'title' => __('admin.branch'), 'name' => 'branch.name_en'],
          ['data' => 'class_name', 'title' => __('admin.class'), 'name' => 'currentClass.name'],
          ['data' => 'phone', 'title' => __('admin.phone')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
