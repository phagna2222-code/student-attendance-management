@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.users'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.users'),
      'createUrl' => route('admin.users.create'),
      'datatableUrl' => route('admin.users.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'name', 'title' => __('admin.name')],
          ['data' => 'email', 'title' => __('admin.email')],
          ['data' => 'username', 'title' => __('admin.username')],
          [
              'data' => 'branch_name',
              'title' => __('admin.branch'),
              'name' => 'branch.name_en',
              'orderable' => false,
          ],
          ['data' => 'user_type', 'title' => __('admin.type')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
