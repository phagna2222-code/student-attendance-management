@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.permissions'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.permissions'),
    'createUrl' => route('admin.permissions.create'),
    'datatableUrl' => route('admin.permissions.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'group', 'title'=>'Group'],
      ['data'=>'slug', 'title'=>'Slug'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
