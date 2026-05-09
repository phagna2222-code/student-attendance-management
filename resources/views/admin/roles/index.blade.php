@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.roles'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.roles'),
    'createUrl' => route('admin.roles.create'),
    'datatableUrl' => route('admin.roles.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'slug', 'title'=>'Slug'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'description', 'title'=>'Description'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
