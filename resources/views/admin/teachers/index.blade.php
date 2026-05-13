@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.teachers'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.teachers'),
      'createUrl' => route('admin.teachers.create'),
      'datatableUrl' => route('admin.teachers.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'teacher_code', 'title' => __('admin.code')],
          ['data' => 'name_en', 'title' => __('admin.name_en')],
          ['data' => 'name_kh', 'title' => __('admin.name_kh')],
          ['data' => 'branch_name', 'title' => __('admin.branch'), 'name' => 'branch.name_en'],
          ['data' => 'phone', 'title' => __('admin.phone')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
