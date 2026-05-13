@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.rooms'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.rooms'),
      'createUrl' => route('admin.rooms.create'),
      'datatableUrl' => route('admin.rooms.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'branch_name', 'title' => __('admin.branch'), 'name' => 'branch.name_en'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'capacity', 'title' => __('admin.capacity')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
