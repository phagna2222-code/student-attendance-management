@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.subjects'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.subjects'),
      'createUrl' => route('admin.subjects.create'),
      'datatableUrl' => route('admin.subjects.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name_en', 'title' => __('admin.name_en')],
          ['data' => 'name_kh', 'title' => __('admin.name_kh')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
