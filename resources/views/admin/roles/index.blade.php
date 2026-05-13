@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.roles'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.roles'),
      'createUrl' => route('admin.roles.create'),
      'datatableUrl' => route('admin.roles.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'slug', 'title' => __('admin.slug')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'description', 'title' => __('admin.description')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
