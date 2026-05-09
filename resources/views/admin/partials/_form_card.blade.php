{{--
  Reusable form card wrapper.
  $title       string
  $action      string  (form action URL)
  $method      string  POST|PUT
  $cancelUrl   string|null
  Form body should be rendered in $slot.
--}}
<div class="card">
  <div class="card-header"><h5 class="mb-0">{{ $title }}</h5></div>
  <div class="card-body">
    <form method="POST" action="{{ $action }}">
      @csrf
      @if(strtoupper($method) !== 'POST') @method($method) @endif
      {{ $slot ?? '' }}
      <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> {{ __('admin.save') }}</button>
        @if(!empty($cancelUrl))
          <a href="{{ $cancelUrl }}" class="btn btn-light border">{{ __('admin.cancel') }}</a>
        @endif
      </div>
    </form>
  </div>
</div>
