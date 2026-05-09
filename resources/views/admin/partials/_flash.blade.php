@if ($errors->any())
  <div class="alert alert-danger alert-dismissible fade show">
    <strong>{{ __('Whoops!') }}</strong>
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif
