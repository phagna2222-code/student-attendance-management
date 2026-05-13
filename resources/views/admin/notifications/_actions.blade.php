@if(!empty($retryUrl))
  <form method="POST" action="{{ $retryUrl }}" class="d-inline">
    @csrf
    <button class="btn btn-sm btn-outline-primary" type="submit" title="{{ __('admin.send_or_retry') }}"><i class="bx bx-send"></i></button>
  </form>
@else
  <span class="text-muted small">—</span>
@endif
