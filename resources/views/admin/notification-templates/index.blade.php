@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.templates'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.templates'),
    'createUrl' => route('admin.notification-templates.create'),
    'datatableUrl' => route('admin.notification-templates.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'channel', 'title'=>'Channel'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
