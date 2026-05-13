@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.audit_logs'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.audit_logs'),
      'createUrl' => null,
      'datatableUrl' => route('admin.audit-logs.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'created_at', 'title' => __('admin.time')],
          ['data' => 'user_name', 'title' => __('admin.user'), 'orderable' => false],
          ['data' => 'event', 'title' => __('admin.event')],
          ['data' => 'auditable_type', 'title' => __('admin.object')],
          ['data' => 'description', 'title' => __('admin.description')],
          ['data' => 'ip_address', 'title' => __('admin.ip')],
      ],
  ])
@endsection
