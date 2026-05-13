@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.notifications_list'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.notifications_list'),
      'createUrl' => route('admin.notifications.compose'),
      'datatableUrl' => route('admin.notifications.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'type', 'title' => __('admin.type')],
          ['data' => 'channel', 'title' => __('admin.channel')],
          ['data' => 'recipient_name', 'title' => __('admin.recipient')],
          ['data' => 'subject', 'title' => __('admin.subject')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'created_at', 'title' => __('admin.created_at')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
