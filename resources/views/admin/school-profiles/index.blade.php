@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.school_profiles'))
@section('content')
  @include('admin.partials._card_index', [
      'title' => __('admin.school_profiles'),
      'createUrl' => route('admin.school-profiles.create'),
      'datatableUrl' => route('admin.school-profiles.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'branch_name', 'title' => __('admin.branch'), 'name' => 'branch.name_en'],
          ['data' => 'school_name_en', 'title' => __('admin.name_en')],
          ['data' => 'school_name_kh', 'title' => __('admin.name_kh')],
          ['data' => 'phone', 'title' => __('admin.phone')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
