{{--
  $name, $label, $options (collection or array of [value=>label] or objects with id+display), $value, $col, $required, $multiple, $valueKey, $labelKey
--}}
@php
  $name      = $name ?? '';
  $label     = $label ?? $name;
  $col       = $col ?? 6;
  $required  = $required ?? false;
  $multiple  = $multiple ?? false;
  $value     = old($name, $value ?? ($multiple ? [] : ''));
  $help      = $help ?? null;
  $valueKey  = $valueKey ?? 'id';
  $labelKey  = $labelKey ?? 'display';
  $placeholder = $placeholder ?? '';
@endphp
<div class="col-md-{{ $col }} mb-3">
  <label class="form-label">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>
  <select name="{{ $name }}{{ $multiple ? '[]' : '' }}"
          class="form-select tom-select{{ $multiple ? '-multi' : '' }} @error($name) is-invalid @enderror"
          {{ $multiple ? 'multiple' : '' }}
          {{ $required ? 'required' : '' }}>
    @if(!$multiple)
      <option value="">{{ $placeholder ?: '— '.__('admin.select').' —' }}</option>
    @endif
    @foreach(($options ?? []) as $opt)
      @php
        if (is_array($opt)) {
          $val = $opt[$valueKey] ?? null;
          $lbl = $opt[$labelKey] ?? $val;
        } elseif (is_object($opt)) {
          $val = data_get($opt, $valueKey);
          $lbl = data_get($opt, $labelKey, $opt->name_en ?? $opt->name ?? $val);
        } else {
          $val = $opt; $lbl = $opt;
        }
        $isSel = $multiple ? in_array($val, (array) $value) : ((string) $value === (string) $val);
      @endphp
      <option value="{{ $val }}" {{ $isSel ? 'selected' : '' }}>{{ $lbl }}</option>
    @endforeach
  </select>
  @error($name) <div class="invalid-feedback">{{ $message }}</div> @enderror
  @if($help) <small class="form-text text-muted">{{ $help }}</small> @endif
</div>
