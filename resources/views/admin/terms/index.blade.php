@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.terms'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.terms'),
      'createUrl' => route('admin.terms.create'),
      'datatableUrl' => route('admin.terms.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'academic_year_name', 'title' => __('admin.academic_year'), 'name' => 'academicYear.name'],
          ['data' => 'start_date', 'title' => __('admin.start')],
          ['data' => 'end_date', 'title' => __('admin.end')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
