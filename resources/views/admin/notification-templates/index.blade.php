@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.templates'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.templates'),
      'createUrl' => route('admin.notification-templates.create'),
      'datatableUrl' => route('admin.notification-templates.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'code', 'title' => __('admin.code')],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'channel', 'title' => __('admin.channel')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
