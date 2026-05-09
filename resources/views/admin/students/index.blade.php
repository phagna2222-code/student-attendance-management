@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.students'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.students'),
    'createUrl' => route('admin.students.create'),
    'datatableUrl' => route('admin.students.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'student_code', 'title'=>'Code'],
      ['data'=>'name_en', 'title'=>'Name (EN)'],
      ['data'=>'name_kh', 'title'=>'Name (KH)'],
      ['data'=>'branch_name', 'title'=>'Branch', 'name'=>'branch.name_en'],
      ['data'=>'class_name', 'title'=>'Class', 'name'=>'currentClass.name'],
      ['data'=>'phone', 'title'=>'Phone'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
