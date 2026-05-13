@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.permissions'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.permissions'),
      'createUrl' => route('admin.permissions.create'),
      'datatableUrl' => route('admin.permissions.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'group', 'title' => __('admin.group')],
          ['data' => 'slug', 'title' => __('admin.slug')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
