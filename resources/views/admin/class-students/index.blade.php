@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.class_students'))
@section('content')
  <div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">{{ __('admin.class_students') }} — {{ __('admin.create_new') }}</h5>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.class-students.store') }}">
        @csrf
        <div class="row">
          @include('admin.partials._select', [
              'name' => 'class_id',
              'label' => __('admin.classes'),
              'options' => $classes,
              'labelKey' => 'name',
              'required' => true,
              'col' => 4,
          ])
          @include('admin.partials._select', [
              'name' => 'student_id',
              'label' => __('admin.students'),
              'options' => $students,
              'labelKey' => 'name_en',
              'required' => true,
              'col' => 4,
          ])
          @include('admin.partials._input', [
              'name' => 'enrolled_at',
              'label' => 'Enrolled At',
              'type' => 'date',
              'col' => 3,
          ])
          @include('admin.partials._select', [
              'name' => 'status',
              'label' => __('admin.status'),
              'options' => [
                  ['id' => 'active', 'display' => 'Active'],
                  ['id' => 'transferred', 'display' => 'Transferred'],
                  ['id' => 'left', 'display' => 'Left'],
                  ['id' => 'completed', 'display' => 'Completed'],
              ],
              'required' => true,
              'col' => 3,
          ])
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> {{ __('admin.save') }}</button>
      </form>
    </div>
  </div>

  @include('admin.partials._card_index', [
      'title' => __('admin.class_students'),
      'createUrl' => null,
      'datatableUrl' => route('admin.class-students.datatable'),
      'columns' => [
          ['data' => 'id', 'title' => '#'],
          ['data' => 'class_name', 'title' => __('admin.classes')],
          ['data' => 'student_name', 'title' => __('admin.students')],
          ['data' => 'student_code', 'title' => __('admin.code')],
          ['data' => 'enrolled_at', 'title' => __('admin.enrolled')],
          ['data' => 'status', 'title' => __('admin.status')],
          ['data' => 'actions', 'title' => __('admin.actions'), 'orderable' => false, 'searchable' => false],
      ],
  ])
@endsection
