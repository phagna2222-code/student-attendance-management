{{--
  $name, $label, $value (default), $type (default text), $placeholder, $col (default 6), $required, $help
--}}
@php
  $name        = $name ?? '';
  $label       = $label ?? $name;
  $type        = $type ?? 'text';
  $placeholder = $placeholder ?? '';
  $col         = $col ?? 6;
  $required    = $required ?? false;
  $value       = old($name, $value ?? '');
  $help        = $help ?? null;
  $class       = $class ?? '';
  if ($type === 'date') $class .= ' flatpickr';
  if ($type === 'time') $class .= ' flatpickr-time';
  if ($type === 'datetime-local') $class .= ' flatpickr-datetime';
@endphp
<div class="col-md-{{ $col }} mb-3">
  <label class="form-label">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>
  <input type="{{ $type === 'datetime-local' ? 'text' : ($type === 'date' || $type === 'time' ? 'text' : $type) }}"
         class="form-control {{ $class }} @error($name) is-invalid @enderror"
         name="{{ $name }}"
         value="{{ $value }}"
         placeholder="{{ $placeholder }}"
         {{ $required ? 'required' : '' }}>
  @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
  @if($help) <small class="form-text text-muted">{{ $help }}</small> @endif
</div>
