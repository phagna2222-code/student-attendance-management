@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.attendance_statuses'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.attendance_statuses'),
    'createUrl' => route('admin.attendance-statuses.create'),
    'datatableUrl' => route('admin.attendance-statuses.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name_en', 'title'=>'Name (EN)'],
      ['data'=>'name_kh', 'title'=>'Name (KH)'],
      ['data'=>'color', 'title'=>'Color'],
      ['data'=>'sort_order', 'title'=>'Order'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
