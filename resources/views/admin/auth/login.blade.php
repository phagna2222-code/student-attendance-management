<!doctype html>
<html lang="{{ app()->getLocale() }}" data-locale="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ __('admin.login') }} — {{ config('app.name') }}</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="login-bg">
  <div class="login-card">
    <div class="text-center mb-4">
      <h3 class="mb-1">{{ config('app.name') }}</h3>
      <p class="text-muted mb-0" data-i18n="auth.subtitle">{{ __('admin.login_to_account') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif
      <div class="mb-3">
        <label class="form-label" data-i18n="auth.email_or_username">{{ __('admin.email') }} / Username</label>
        <input type="text" class="form-control" name="email" required autofocus value="{{ old('email') }}">
      </div>
      <div class="mb-3">
        <label class="form-label" data-i18n="auth.password">{{ __('admin.password') }}</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <div class="form-check mb-3">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label for="remember" class="form-check-label" data-i18n="auth.remember">{{ __('admin.remember_me') }}</label>
      </div>
      <button type="submit" class="btn btn-primary w-100"><span data-i18n="auth.signin">{{ __('admin.sign_in') }}</span></button>
    </form>

    <div class="text-center mt-3 d-flex justify-content-center gap-2">
      <button class="btn btn-sm btn-light js-set-locale" data-locale="en">English</button>
      <button class="btn btn-sm btn-light js-set-locale" data-locale="km">ខ្មែរ</button>
    </div>

    @if(app()->environment('local') || true)
      <div class="alert alert-info mt-3 small mb-0">
        <strong>Default admin:</strong> admin@example.com / password
      </div>
    @endif
  </div>
</body>
</html>
