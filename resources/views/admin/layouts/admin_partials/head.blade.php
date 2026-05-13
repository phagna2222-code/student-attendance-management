<!doctype html>
<html lang="{{ app()->getLocale() }}" class="minimal-theme" data-locale="{{ app()->getLocale() }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('assets/backend') }}/assets/images/favicon-32x32.png" type="image/png" />
  <!--plugins-->
  <link href="{{ asset('assets/backend') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
    rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/style.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
  <link href="{{ asset('assets/backend') }}/assets/css/pace.min.css" rel="stylesheet" />

  <!--Theme Styles-->
  <link href="{{ asset('assets/backend') }}/assets/css/dark-theme.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/light-theme.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/semi-dark.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/header-colors.css" rel="stylesheet" />

  {{-- Vite-bundled JS and app-specific plugin styles. The core admin shell CSS now comes from public/assets/backend/assets. --}}
  @viteReactRefresh
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])

  <title>@yield('pageTitle', config('app.name', 'SAMS'))</title>

  @stack('styles')
</head>
