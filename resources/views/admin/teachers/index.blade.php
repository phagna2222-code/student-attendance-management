@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.teachers'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.teachers'),
    'createUrl' => route('admin.teachers.create'),
    'datatableUrl' => route('admin.teachers.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'teacher_code', 'title'=>'Code'],
      ['data'=>'name_en', 'title'=>'Name (EN)'],
      ['data'=>'name_kh', 'title'=>'Name (KH)'],
      ['data'=>'branch_name', 'title'=>'Branch', 'name'=>'branch.name_en'],
      ['data'=>'phone', 'title'=>'Phone'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
