@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.shifts'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.shifts'),
      'createUrl' => route('admin.shifts.create'),
      'datatableUrl' => route('admin.shifts.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'start_time', 'title' => __('admin.start')],
          ['data' => 'end_time', 'title' => __('admin.end')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
