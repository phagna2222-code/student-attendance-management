@php
  $name = $name ?? '';
  $label = $label ?? $name;
  $value = old($name, $value ?? '');
  $rows = $rows ?? 3;
  $col = $col ?? 12;
  $required = $required ?? false;
@endphp
<div class="col-md-{{ $col }} mb-3">
  <label class="form-label">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>
  <textarea name="{{ $name }}" rows="{{ $rows }}" class="form-control @error($name) is-invalid @enderror" {{ $required ? 'required' : '' }}>{{ $value }}</textarea>
  @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
