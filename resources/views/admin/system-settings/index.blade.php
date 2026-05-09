@extends('admin.layouts.admin_layout')
@section('pageTitle', __('admin.settings'))
@section('content')
  <x-admin.form-card :title="__('admin.settings')" :action="route('admin.system-settings.update')" method="PUT" :cancel-url="null">
    @php $byGroup = $settings->groupBy('group'); @endphp
    @foreach($byGroup as $group => $rows)
      <h6 class="text-uppercase text-muted mt-3">{{ $group }}</h6>
      <div class="row">
        @foreach($rows as $row)
          <div class="col-md-6 mb-3">
            <label class="form-label">{{ ucwords(str_replace(['_','.'], ' ', $row->key)) }}</label>
            @if($row->value_type === 'boolean')
              <div class="form-check form-switch">
                <input type="hidden" name="settings[{{ $row->key }}]" value="0">
                <input type="checkbox" class="form-check-input" name="settings[{{ $row->key }}]" value="1" {{ $row->value ? 'checked' : '' }}>
              </div>
            @else
              <input type="text" class="form-control" name="settings[{{ $row->key }}]"
                     value="{{ is_array($row->value) ? json_encode($row->value) : $row->value }}">
            @endif
            <small class="text-muted">{{ $row->key }}</small>
          </div>
        @endforeach
      </div>
    @endforeach
  </x-admin.form-card>
@endsection
