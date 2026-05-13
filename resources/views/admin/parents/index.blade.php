@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.parents'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.parents'),
      'createUrl' => route('admin.parents.create'),
      'datatableUrl' => route('admin.parents.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'parent_code', 'title' => __('admin.code')],
          ['data' => 'name_en', 'title' => __('admin.name_en')],
          ['data' => 'name_kh', 'title' => __('admin.name_kh')],
          ['data' => 'phone', 'title' => __('admin.phone')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
