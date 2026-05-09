    <header class="top-header">
      <nav class="navbar navbar-expand">
        <div class="mobile-toggle-icon d-xl-none">
          <i class="bi bi-list"></i>
        </div>
        <div class="top-navbar d-none d-xl-block">
          <ul class="navbar-nav align-items-center">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.dashboard') }}" data-i18n="nav.dashboard">{{ __('admin.dashboard') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.attendance-records.index') }}" data-i18n="nav.attendance">{{ __('admin.attendance') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.students.index') }}" data-i18n="nav.students">{{ __('admin.students') }}</a>
            </li>
            <li class="nav-item d-none d-xxl-block">
              <a class="nav-link" href="{{ route('admin.classes.index') }}" data-i18n="nav.classes">{{ __('admin.classes') }}</a>
            </li>
            <li class="nav-item d-none d-xxl-block">
              <a class="nav-link" href="{{ route('admin.reports.index') }}" data-i18n="nav.reports">{{ __('admin.reports') }}</a>
            </li>
          </ul>
        </div>

        <div class="search-toggle-icon d-xl-none ms-auto">
          <i class="bi bi-search"></i>
        </div>
        <form class="searchbar d-none d-xl-flex ms-auto">
          <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
          <input class="form-control" type="text" placeholder="{{ __('admin.search_placeholder') }}" data-i18n-placeholder="search.placeholder">
          <div class="position-absolute top-50 translate-middle-y d-block d-xl-none search-close-icon"><i class="bi bi-x-lg"></i></div>
        </form>

        <div class="top-navbar-right ms-3">
          <ul class="navbar-nav align-items-center">

            {{-- Branch selector --}}
            @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" title="{{ __('admin.branch') }}">
                <i class="bi bi-building"></i>
                <span class="d-none d-md-inline ms-1">
                  @php $current = app(\App\Services\BranchContext::class)->current(); @endphp
                  {{ $current ? $current->localizedName() : __('admin.all_branches') }}
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" style="min-width: 240px;">
                <li>
                  <form method="POST" action="{{ route('admin.branch.set') }}">
                    @csrf
                    <input type="hidden" name="branch_id" value="">
                    <button type="submit" class="dropdown-item d-flex align-items-center">
                      <i class="bi bi-globe me-2"></i>
                      <span data-i18n="branch.all">{{ __('admin.all_branches') }}</span>
                    </button>
                  </form>
                </li>
                <li><hr class="dropdown-divider"></li>
                @foreach(\App\Models\Branch::orderBy('name_en')->get() as $branch)
                  <li>
                    <form method="POST" action="{{ route('admin.branch.set') }}">
                      @csrf
                      <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                      <button type="submit" class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-{{ $branch->is_main ? 'star-fill text-warning' : 'building' }} me-2"></i>
                        {{ $branch->localizedName() }}
                        <small class="text-muted ms-auto">{{ $branch->code }}</small>
                      </button>
                    </form>
                  </li>
                @endforeach
              </ul>
            </li>
            @endauth

            {{-- Language switcher (no refresh) --}}
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" title="{{ __('admin.language') }}">
                <i class="bi bi-translate"></i>
                <span class="d-none d-md-inline ms-1" id="current-locale-label">{{ strtoupper(app()->getLocale()) }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <button type="button" class="dropdown-item js-set-locale" data-locale="en">
                    <span class="me-2">🇬🇧</span> English
                  </button>
                </li>
                <li>
                  <button type="button" class="dropdown-item js-set-locale" data-locale="km">
                    <span class="me-2">🇰🇭</span> ខ្មែរ
                  </button>
                </li>
              </ul>
            </li>

            {{-- User menu --}}
            @auth
            <li class="nav-item dropdown dropdown-large">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                <div class="user-setting d-flex align-items-center gap-1">
                  <img src="{{ auth()->user()->avatar_path ?: asset('assets/backend/assets/images/avatars/avatar-1.png') }}" class="user-img" alt="">
                  <div class="user-name d-none d-sm-block">{{ auth()->user()->name }}</div>
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item" href="#">
                    <div class="d-flex align-items-center">
                      <img src="{{ auth()->user()->avatar_path ?: asset('assets/backend/assets/images/avatars/avatar-1.png') }}" alt="" class="rounded-circle" width="60" height="60">
                      <div class="ms-3">
                        <h6 class="mb-0 dropdown-user-name">{{ auth()->user()->name }}</h6>
                        <small class="mb-0 dropdown-user-designation text-secondary">{{ ucfirst(str_replace('_',' ', auth()->user()->user_type ?? '')) }}</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                    <div class="d-flex align-items-center">
                      <div class="setting-icon"><i class="bi bi-speedometer"></i></div>
                      <div class="setting-text ms-3"><span data-i18n="nav.dashboard">{{ __('admin.dashboard') }}</span></div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('admin.system-settings.index') }}">
                    <div class="d-flex align-items-center">
                      <div class="setting-icon"><i class="bi bi-gear-fill"></i></div>
                      <div class="setting-text ms-3"><span data-i18n="nav.settings">{{ __('admin.settings') }}</span></div>
                    </div>
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                      <div class="d-flex align-items-center">
                        <div class="setting-icon"><i class="bi bi-box-arrow-right"></i></div>
                        <div class="setting-text ms-3"><span data-i18n="auth.logout">{{ __('admin.logout') }}</span></div>
                      </div>
                    </button>
                  </form>
                </li>
              </ul>
            </li>
            @endauth
          </ul>
        </div>
      </nav>
    </header>
