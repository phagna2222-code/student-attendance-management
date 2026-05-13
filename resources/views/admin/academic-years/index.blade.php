@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.academic_years'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.academic_years'),
      'createUrl' => route('admin.academic-years.create'),
      'datatableUrl' => route('admin.academic-years.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'start_date', 'title' => __('admin.start')],
          ['data' => 'end_date', 'title' => __('admin.end')],
          ['data' => 'is_current', 'title' => __('admin.current')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
