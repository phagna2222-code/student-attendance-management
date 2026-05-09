@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.shifts'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.shifts'),
    'createUrl' => route('admin.shifts.create'),
    'datatableUrl' => route('admin.shifts.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'start_time', 'title'=>'Start'],
      ['data'=>'end_time', 'title'=>'End'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
