@include('admin.layouts.admin_partials.head')

<body data-app-locale="{{ app()->getLocale() }}">

  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
    @include('admin.layouts.admin_partials.header')
    <!--end top header-->

    <!--start sidebar -->
    @include('admin.layouts.admin_partials.left_sidebar')
    <!--end sidebar -->

    <!--start content-->
    <main class="page-content">
      <!--breadcrumb-->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3" data-i18n="admin.pages">@yield('pageBreadcrumbTitle', __('admin.pages'))</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
              </li>
              @yield('breadcrumbs')
              <li class="breadcrumb-item active" aria-current="page">@yield('pageTitle', __('admin.dashboard'))</li>
            </ol>
          </nav>
        </div>
        <div class="ms-auto d-flex align-items-center gap-2">
          @yield('pageActions')
        </div>
      </div>
      <!--end breadcrumb-->

      @include('admin.partials._flash')

      @yield('content')
    </main>
    <!--end page main-->

    <!--start overlay-->
    <div class="overlay nav-toggle-icon"></div>
    <!--end overlay-->

    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->

    <!--start switcher-->
    <div class="switcher-body">
      <button class="btn btn-primary btn-switcher shadow-sm" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#themeSwitcher" aria-controls="themeSwitcher" title="{{ __('admin.theme_customizer') }}">
        <i class="bi bi-paint-bucket me-0"></i>
      </button>
      <div class="offcanvas offcanvas-end shadow border-start-0 p-2"
           data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="themeSwitcher">
        <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title" data-i18n="admin.theme_customizer">{{ __('admin.theme_customizer') }}</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
          <h6 class="mb-0" data-i18n="admin.theme_variation">{{ __('admin.theme_variation') }}</h6>
          <hr>
          <div class="form-check form-check-inline">
            <input class="form-check-input js-theme-mode" type="radio" name="themeMode" id="LightTheme" value="light">
            <label class="form-check-label" for="LightTheme" data-i18n="admin.theme_light">{{ __('admin.theme_light') }}</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input js-theme-mode" type="radio" name="themeMode" id="DarkTheme" value="dark">
            <label class="form-check-label" for="DarkTheme" data-i18n="admin.theme_dark">{{ __('admin.theme_dark') }}</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input js-theme-mode" type="radio" name="themeMode" id="SemiDarkTheme" value="semi-dark">
            <label class="form-check-label" for="SemiDarkTheme" data-i18n="admin.theme_semi_dark">{{ __('admin.theme_semi_dark') }}</label>
          </div>
          <hr>
          <div class="form-check form-check-inline">
            <input class="form-check-input js-theme-mode" type="radio" name="themeMode" id="MinimalTheme" value="minimal" checked>
            <label class="form-check-label" for="MinimalTheme" data-i18n="admin.theme_minimal">{{ __('admin.theme_minimal') }}</label>
          </div>
          <hr/>
          <h6 class="mb-0" data-i18n="admin.theme_header_colors">{{ __('admin.theme_header_colors') }}</h6>
          <hr/>
          <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
              @for ($i = 1; $i <= 8; $i++)
                <div class="col">
                  <div class="indigator headercolor{{ $i }} js-header-color"
                       data-color="headercolor{{ $i }}" id="headercolor{{ $i }}" role="button"></div>
                </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end switcher-->

  </div>
  <!--end wrapper-->

  @include('admin.layouts.admin_partials.scripts')

</body>

</html>
