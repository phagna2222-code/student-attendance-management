@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.grade_levels'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.grade_levels'),
      'createUrl' => route('admin.grade-levels.create'),
      'datatableUrl' => route('admin.grade-levels.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name_en', 'title' => __('admin.name_en')],
          ['data' => 'name_kh', 'title' => __('admin.name_kh')],
          ['data' => 'level_order', 'title' => __('admin.order')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
