@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.attendance_statuses'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.attendance_statuses'),
      'createUrl' => route('admin.attendance-statuses.create'),
      'datatableUrl' => route('admin.attendance-statuses.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name_en', 'title' => __('admin.name_en')],
          ['data' => 'name_kh', 'title' => __('admin.name_kh')],
          ['data' => 'color', 'title' => __('admin.color')],
          ['data' => 'sort_order', 'title' => __('admin.order')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
