<div class="app-header header-shadow">
  <div class="app-header__logo">
    @if (Auth::user()->level >= 0 && Auth::user()->level < 3)
      <a
        href="{{ route('home') }}"
        style="
          display: flex;
          align-items: center;
          gap: 10px;
          text-decoration: none;
        "
      >
        <div class="logo-meta">
          <img src="{{ asset('images/logo_meta.png') }}" alt="Meta Logo" />
        </div>
        <div style="display: flex; flex-direction: column; line-height: 1.1">
          <span
            style="
              margin: 0;
              background: linear-gradient(135deg, #ff8c42, #fe8a06);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
              background-clip: text;
              font-weight: 700;
              font-size: 20px;
              letter-spacing: 0.5px;
            "
          >
            META
          </span>
          <span
            style="
              margin: 0;
              background: linear-gradient(135deg, #ff8c42, #fe8a06);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
              background-clip: text;
              font-weight: 500;
              font-size: 18px;
              letter-spacing: 0px;
            "
          >
            Knowledge
          </span>
        </div>
      </a>
    @elseif (Auth::user()->level == 3)
      <a
        href="{{ route('formsControl') }}"
        style="
          display: flex;
          align-items: center;
          gap: 10px;
          text-decoration: none;
        "
      >
        <div class="logo-meta">
          <img src="{{ asset('images/logo_meta.png') }}" alt="Meta Logo" />
        </div>
        <div style="display: flex; flex-direction: column; line-height: 1.1">
          <span
            style="
              margin: 0;
              background: linear-gradient(135deg, #ff8c42, #fe8a06);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
              background-clip: text;
              font-weight: 700;
              font-size: 20px;
              letter-spacing: 0.5px;
            "
          >
            META
          </span>
          <span
            style="
              margin: 0;
              background: linear-gradient(135deg, #ff8c42, #fe8a06);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
              background-clip: text;
              font-weight: 500;
              font-size: 18px;
              letter-spacing: 0px;
            "
          >
            Knowledge
          </span>
        </div>
      </a>
    @elseif (Auth::user()->level > 3 && Auth::user()->level < 6)
      <a
        href="{{ route('home2') }}"
        style="
          display: flex;
          align-items: center;
          gap: 10px;
          text-decoration: none;
        "
      >
        <div class="logo-meta">
          <img src="{{ asset('images/logo_meta.png') }}" alt="Meta Logo" />
        </div>
        <div style="display: flex; flex-direction: column; line-height: 1.1">
          <span
            style="
              margin: 0;
              background: linear-gradient(135deg, #ff8c42, #fe8a06);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
              background-clip: text;
              font-weight: 700;
              font-size: 20px;
              letter-spacing: 0.5px;
            "
          >
            META
          </span>
          <span
            style="
              margin: 0;
              background: linear-gradient(135deg, #ff8c42, #fe8a06);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
              background-clip: text;
              font-weight: 500;
              font-size: 18px;
              letter-spacing: 0px;
            "
          >
            Knowledge
          </span>
        </div>
      </a>
    @endif

    <div class="header__pane ms-auto">
      <div>
        <button
          type="button"
          class="hamburger close-sidebar-btn hamburger--elastic"
          data-class="closed-sidebar"
        >
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </div>
    </div>
  </div>
  <div class="app-header__mobile-menu">
    <div>
      <button
        type="button"
        class="hamburger hamburger--elastic mobile-toggle-nav"
      >
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
    </div>
  </div>
  <div class="app-header__menu">
    <span>
      <button
        type="button"
        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav"
      >
        <span class="btn-icon-wrapper">
          <i class="fa fa-ellipsis-v fa-w-6"></i>
        </span>
      </button>
    </span>
  </div>
  <div class="app-header__content">
    <div class="app-header-left">
      <!--<div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon"><span></span></button>
                </div>
                <button class="btn-close"></button>
            </div>
            <ul class="header-menu nav">
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-database"> </i>
                        Statistics
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-edit"></i>
                        Projects
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-cog"></i>
                        Settings
                    </a>
                </li>
            </ul>-->
    </div>
    <div class="app-header-right">
      <div class="header-btn-lg pe-0">
        <div class="widget-content p-0">
          <div class="widget-content-wrapper">
            <div class="widget-content-left">
              <div class="btn-group">
                <a
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                  class="btn p-0"
                >
                  <img
                    width="42"
                    class="rounded-circle"
                    src="{{ asset('images/user.png') }}"
                    alt=""
                  />
                  <i class="fa fa-angle-down ms-2 opacity-8"></i>
                </a>
                <div
                  tabindex="-1"
                  role="menu"
                  aria-hidden="true"
                  class="dropdown-menu dropdown-menu-right"
                >
                  <button
                    type="button"
                    tabindex="0"
                    class="dropdown-item"
                    data-toggle="modal"
                    data-target=".bd-example-modal-lg"
                    id="EditUserButton"
                    onclick="$('#EditUserModal').modal('show')"
                  >
                    User Account
                  </button>
                  <!--<button type="button" tabindex="0" class="dropdown-item">Settings</button>
                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                    <button type="button" tabindex="0" class="dropdown-item">Actions</button>-->
                  <div tabindex="-1" class="dropdown-divider"></div>
                  <a
                    class="dropdown-item"
                    href="{{ route('logout') }}"
                    onclick="
                      event.preventDefault();
                      document.getElementById('logout-form').submit();
                    "
                  >
                    {{ __('Logout') }}
                  </a>

                  <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="d-none"
                  >
                    @csrf
                  </form>
                </div>
              </div>
            </div>
            <div class="widget-content-left header-user-info ms-3">
              <div class="widget-heading">
                {{
                  Str::upper(
                    Auth::user()->name,
                  )
                }}
              </div>
              <div class="widget-subheading">
                @if (Auth::user()->level == 1)
                  Admin
                @elseif (Auth::user()->level == 2)
                  Teacher
                @elseif (Auth::user()->level == 3)
                  Account
                @elseif (Auth::user()->level == 0)
                  Owner
                @elseif (Auth::user()->level == 4)
                  Officer
                @elseif (Auth::user()->level == 5)
                  Normal
                @else
                  Non
                @endif
              </div>
            </div>
            <!--<div class="widget-content-right header-user-info ms-3">
                            <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                <i class="fa text-white fa-calendar pe-1 ps-1"></i>
                            </button>-
                        </div>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
