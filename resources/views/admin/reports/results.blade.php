@extends('admin.layouts.admin_layout')
@section('pageTitle', $title ?? __('admin.report_results'))
@section('pageBreadcrumbTitle', $title ?? __('admin.reports'))

@section('content')
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h5 class="mb-0">{{ $title }}</h5>
    <a class="btn btn-sm btn-light border ms-auto" href="{{ route('admin.reports.index') }}"><i class="bx bx-arrow-back"></i> {{ __('admin.back') }}</a>
  </div>
  <div class="card-body">
    @php
      $cols = $columns ?? (empty($rows) ? [] : array_keys((array) $rows[0]));
    @endphp
    @if(!empty($summary))
      <div class="mb-3 small text-muted">
        @foreach($summary as $k=>$v)
          <span class="badge bg-light text-dark me-1"><strong>{{ $k }}:</strong> {{ is_array($v) ? json_encode($v) : $v }}</span>
        @endforeach
      </div>
    @endif
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle table-sm">
        <thead>
          <tr>
            @foreach($cols as $col)<th>{{ $col }}</th>@endforeach
          </tr>
        </thead>
        <tbody>
          @forelse($rows as $r)
            @php $r = (array) $r; @endphp
            <tr>
              @foreach($cols as $col)
                <td>{{ is_array($r[$col] ?? null) ? json_encode($r[$col]) : ($r[$col] ?? '') }}</td>
              @endforeach
            </tr>
          @empty
            <tr><td colspan="{{ max(1, count($cols)) }}" class="text-center text-muted">{{ __('admin.no_data') }}</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
