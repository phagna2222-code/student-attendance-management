@php
  $name = $name ?? '';
  $label = $label ?? $name;
  $value = old($name, $value ?? false);
  $col = $col ?? 6;
@endphp
<div class="col-md-{{ $col }} mb-3 d-flex align-items-end">
  <div class="form-check form-switch">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" value="1" id="cb_{{ $name }}" class="form-check-input" {{ $value ? 'checked' : '' }}>
    <label for="cb_{{ $name }}" class="form-check-label">{{ $label }}</label>
  </div>
</div>
