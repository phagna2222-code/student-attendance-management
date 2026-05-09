@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.users'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.users'),
    'createUrl' => route('admin.users.create'),
    'datatableUrl' => route('admin.users.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'email', 'title'=>'Email'],
      ['data'=>'username', 'title'=>'Username'],
      ['data'=>'branch_name', 'title'=>'Branch', 'name'=>'branch.name_en', 'orderable'=>false],
      ['data'=>'user_type', 'title'=>'Type'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
