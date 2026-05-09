@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.records'))
@section('pageActions')
  <a href="{{ route('admin.attendance-records.entry') }}" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-lg me-1"></i> {{ __('admin.entry') }}
  </a>
@endsection
@section('content')
  @include('admin.partials._card_index', [
    'title' => __('admin.records'),
    'createUrl' => null,
    'datatableUrl' => route('admin.attendance-records.datatable'),
    'columns' => [
      ['data'=>'id','title'=>'#'],
      ['data'=>'class_name','title'=>__('admin.classes')],
      ['data'=>'attendance_date','title'=>'Date'],
      ['data'=>'student_name','title'=>__('admin.students')],
      ['data'=>'student_code','title'=>'Code'],
      ['data'=>'status_name','title'=>'Status'],
      ['data'=>'is_late','title'=>'Late'],
      ['data'=>'method','title'=>'Method'],
    ],
  ])
@endsection
