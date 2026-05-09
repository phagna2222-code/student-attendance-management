@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.parents'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.parents'),
    'createUrl' => route('admin.parents.create'),
    'datatableUrl' => route('admin.parents.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'parent_code', 'title'=>'Code'],
      ['data'=>'name_en', 'title'=>'Name (EN)'],
      ['data'=>'name_kh', 'title'=>'Name (KH)'],
      ['data'=>'phone', 'title'=>'Phone'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
