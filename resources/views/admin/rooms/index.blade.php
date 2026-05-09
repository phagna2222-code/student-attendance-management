@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.rooms'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.rooms'),
    'createUrl' => route('admin.rooms.create'),
    'datatableUrl' => route('admin.rooms.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'branch_name', 'title'=>'Branch', 'name'=>'branch.name_en'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'capacity', 'title'=>'Capacity'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
