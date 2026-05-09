@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.subjects'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.subjects'),
    'createUrl' => route('admin.subjects.create'),
    'datatableUrl' => route('admin.subjects.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name_en', 'title'=>'Name (EN)'],
      ['data'=>'name_kh', 'title'=>'Name (KH)'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
