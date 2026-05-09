@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.grade_levels'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.grade_levels'),
    'createUrl' => route('admin.grade-levels.create'),
    'datatableUrl' => route('admin.grade-levels.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name_en', 'title'=>'Name (EN)'],
      ['data'=>'name_kh', 'title'=>'Name (KH)'],
      ['data'=>'level_order', 'title'=>'Order'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
