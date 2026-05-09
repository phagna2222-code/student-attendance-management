@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.terms'))
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.terms'),
    'createUrl' => route('admin.terms.create'),
    'datatableUrl' => route('admin.terms.datatable'),
    'columns' => [
      ['data'=>'id', 'title'=>'#'],
      ['data'=>'code', 'title'=>'Code'],
      ['data'=>'name', 'title'=>'Name'],
      ['data'=>'academic_year_name', 'title'=>'Academic Year', 'name'=>'academicYear.name'],
      ['data'=>'start_date', 'title'=>'Start'],
      ['data'=>'end_date', 'title'=>'End'],
      ['data'=>'status', 'title'=>'Status'],
      ['data'=>'actions', 'title'=>'Actions', 'orderable'=>false, 'searchable'=>false],
    ],
  ])
@endsection
