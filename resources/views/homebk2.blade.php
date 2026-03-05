@extends('layouts.main_template')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Register') }}</div>

          <div class="card-body">
            <form method="POST" action="">
              @csrf

              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">
                  {{ __('Name') }}
                </label>

                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    autofocus
                  />

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">
                  {{ __('Email Address') }}
                </label>

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                  />

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-end"
                >
                  {{ __('Password') }}
                </label>

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    required
                    autocomplete="new-password"
                  />

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label
                  for="password-confirm"
                  class="col-md-4 col-form-label text-md-end"
                >
                  {{ __('Confirm Password') }}
                </label>

                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                  />
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
        <div class="page-title-icon">
          <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
        </div>
        <div>
          Analytics Dashboard
          <div class="page-title-subheading">
            This is an example dashboard created using build-in elements and
            components.
          </div>
        </div>
      </div>
      <div class="page-title-actions">
        <button
          type="button"
          data-bs-toggle="tooltip"
          title="Example Tooltip"
          data-bs-placement="bottom"
          class="btn-shadow btn btn-dark me-3"
        >
          <i class="fa fa-star"></i>
        </button>
        <div class="d-inline-block dropdown">
          <button
            type="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            class="btn-shadow dropdown-toggle btn btn-info"
          >
            <span class="btn-icon-wrapper pe-2 opacity-7">
              <i class="fa fa-business-time fa-w-20"></i>
            </span>
            Buttons
          </button>
          <div
            tabindex="-1"
            role="menu"
            aria-hidden="true"
            class="dropdown-menu dropdown-menu-right"
          >
            <ul class="nav flex-column">
              <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link">
                  <i class="nav-link-icon lnr-inbox"></i>
                  <span>Inbox</span>
                  <div class="badge rounded-pill bg-secondary ms-auto">86</div>
                </a>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link">
                  <i class="nav-link-icon lnr-book"></i>
                  <span>Book</span>
                  <div class="badge rounded-pill bg-danger ms-auto">5</div>
                </a>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link">
                  <i class="nav-link-icon lnr-picture"></i>
                  <span>Picture</span>
                </a>
              </li>
              <li class="nav-item">
                <a
                  disabled
                  href="javascript:void(0);"
                  class="nav-link disabled"
                >
                  <i class="nav-link-icon lnr-file-empty"></i>
                  <span>File Disabled</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-midnight-bloom mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Total Orders</div>
            <div class="widget-subheading">Last year expenses</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-white"><span>1896</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-arielle-smile mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Clients</div>
            <div class="widget-subheading">Total Clients Profit</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-white"><span>$ 568</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-grow-early mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Followers</div>
            <div class="widget-subheading">People Interested</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-white"><span>46%</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
      <div class="card widget-content bg-premium-dark mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Products Sold</div>
            <div class="widget-subheading">Revenue streams</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-warning"><span>$14M</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-lg-6">
      <div class="card mb-3">
        <div class="card-header-tab card-header-tab-animation card-header">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            Sales Report
          </div>
          <ul class="nav">
            <li class="nav-item">
              <a href="javascript:void(0);" class="active nav-link">Last</a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0);" class="nav-link second-tab-toggle">
                Current
              </a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane fade show active" id="tabs-eg-77">
              <div
                class="card widget-chart widget-chart2 mb-3 w-100 text-start"
              >
                <div class="widget-chat-wrapper-outer">
                  <div
                    class="widget-chart-wrapper widget-chart-wrapper-lg m-0 opacity-10"
                  >
                    <canvas id="canvas"></canvas>
                  </div>
                </div>
              </div>
              <h6
                class="text-muted text-uppercase font-size-md fw-normal opacity-5"
              >
                Top Authors
              </h6>
              <div class="scroll-area-sm">
                <div class="scrollbar-container">
                  <ul
                    class="rm-list-borders rm-list-borders-scroll list-group list-group-flush"
                  >
                    <li class="list-group-item">
                      <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                          <div class="widget-content-left me-3">
                            <img
                              width="42"
                              class="rounded-circle"
                              src="{{ asset('architectui/assets/images/avatars/9.jpg') }}"
                              alt=""
                            />
                          </div>
                          <div class="widget-content-left">
                            <div class="widget-heading">Ella-Rose Henry</div>
                            <div class="widget-subheading">Web Developer</div>
                          </div>
                          <div class="widget-content-right">
                            <div class="font-size-xlg text-muted">
                              <small class="pe-1 opacity-5">$</small>
                              <span>129</span>
                              <small class="text-danger ps-2">
                                <i class="fa fa-angle-down"></i>
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                          <div class="widget-content-left me-3">
                            <img
                              width="42"
                              class="rounded-circle"
                              src="{{ asset('architectui/assets/images/avatars/5.jpg') }}"
                              alt=""
                            />
                          </div>
                          <div class="widget-content-left">
                            <div class="widget-heading">Ruben Tillman</div>
                            <div class="widget-subheading">UI Designer</div>
                          </div>
                          <div class="widget-content-right">
                            <div class="font-size-xlg text-muted">
                              <small class="pe-1 opacity-5">$</small>
                              <span>54</span>
                              <small class="text-success ps-2">
                                <i class="fa fa-angle-up"></i>
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                          <div class="widget-content-left me-3">
                            <img
                              width="42"
                              class="rounded-circle"
                              src="{{ asset('architectui/assets/images/avatars/4.jpg') }}"
                              alt=""
                            />
                          </div>
                          <div class="widget-content-left">
                            <div class="widget-heading">Vinnie Wagstaff</div>
                            <div class="widget-subheading">Java Programmer</div>
                          </div>
                          <div class="widget-content-right">
                            <div class="font-size-xlg text-muted">
                              <small class="pe-1 opacity-5">$</small>
                              <span>429</span>
                              <small class="text-warning ps-2">
                                <i class="fa fa-dot-circle"></i>
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                          <div class="widget-content-left me-3">
                            <img
                              width="42"
                              class="rounded-circle"
                              src="{{ asset('architectui/assets/images/avatars/3.jpg') }}"
                              alt=""
                            />
                          </div>
                          <div class="widget-content-left">
                            <div class="widget-heading">Ella-Rose Henry</div>
                            <div class="widget-subheading">Web Developer</div>
                          </div>
                          <div class="widget-content-right">
                            <div class="font-size-xlg text-muted">
                              <small class="pe-1 opacity-5">$</small>
                              <span>129</span>
                              <small class="text-danger ps-2">
                                <i class="fa fa-angle-down"></i>
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                          <div class="widget-content-left me-3">
                            <img
                              width="42"
                              class="rounded-circle"
                              src="{{ asset('architectui/assets/images/avatars/2.jpg') }}'"
                              alt=""
                            />
                          </div>
                          <div class="widget-content-left">
                            <div class="widget-heading">Ruben Tillman</div>
                            <div class="widget-subheading">UI Designer</div>
                          </div>
                          <div class="widget-content-right">
                            <div class="font-size-xlg text-muted">
                              <small class="pe-1 opacity-5">$</small>
                              <span>54</span>
                              <small class="text-success ps-2">
                                <i class="fa fa-angle-up"></i>
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-6">
      <div class="card mb-3">
        <div class="card-header-tab card-header">
          <div class="card-header-title">
            <i
              class="header-icon lnr-rocket icon-gradient bg-tempting-azure"
            ></i>
            Bandwidth Reports
          </div>
          <div class="btn-actions-pane-right">
            <div class="nav">
              <a
                href="javascript:void(0);"
                class="btn-pill btn-wide btn-transition active btn btn-outline-alternate border-0"
              >
                Tab 1
              </a>
              <a
                href="javascript:void(0);"
                class="btn-pill btn-wide btn-transition btn btn-outline-alternate second-tab-toggle-alt ms-1 border-0"
              >
                Tab 2
              </a>
            </div>
          </div>
        </div>
        <div class="tab-content">
          <div class="tab-pane fade active show" id="tab-eg-55">
            <div class="widget-chart p-3">
              <div style="height: 350px">
                <canvas id="line-chart"></canvas>
              </div>
              <div class="widget-chart-content mt-5 text-center">
                <div class="widget-description text-warning mt-0">
                  <i class="fa fa-arrow-left"></i>
                  <span class="ps-1">175.5%</span>
                  <span class="text-muted ps-1 opacity-8">
                    increased server resources
                  </span>
                </div>
              </div>
            </div>
            <div class="card-body pt-2">
              <div class="row">
                <div class="col-md-6">
                  <div class="widget-content">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-numbers fsize-3 text-muted">
                            63%
                          </div>
                        </div>
                        <div class="widget-content-right">
                          <div class="text-muted opacity-6">
                            Generated Leads
                          </div>
                        </div>
                      </div>
                      <div class="widget-progress-wrapper mt-1">
                        <div
                          class="progress-bar-sm progress-bar-animated-alt progress"
                        >
                          <div
                            class="progress-bar bg-danger"
                            role="progressbar"
                            aria-valuenow="63"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: 63%"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="widget-content">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-numbers fsize-3 text-muted">
                            32%
                          </div>
                        </div>
                        <div class="widget-content-right">
                          <div class="text-muted opacity-6">
                            Submitted Tickers
                          </div>
                        </div>
                      </div>
                      <div class="widget-progress-wrapper mt-1">
                        <div
                          class="progress-bar-sm progress-bar-animated-alt progress"
                        >
                          <div
                            class="progress-bar bg-success"
                            role="progressbar"
                            aria-valuenow="32"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: 32%"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="widget-content">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-numbers fsize-3 text-muted">
                            71%
                          </div>
                        </div>
                        <div class="widget-content-right">
                          <div class="text-muted opacity-6">
                            Server Allocation
                          </div>
                        </div>
                      </div>
                      <div class="widget-progress-wrapper mt-1">
                        <div
                          class="progress-bar-sm progress-bar-animated-alt progress"
                        >
                          <div
                            class="progress-bar bg-primary"
                            role="progressbar"
                            aria-valuenow="71"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: 71%"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="widget-content">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-numbers fsize-3 text-muted">
                            41%
                          </div>
                        </div>
                        <div class="widget-content-right">
                          <div class="text-muted opacity-6">
                            Generated Leads
                          </div>
                        </div>
                      </div>
                      <div class="widget-progress-wrapper mt-1">
                        <div
                          class="progress-bar-sm progress-bar-animated-alt progress"
                        >
                          <div
                            class="progress-bar bg-warning"
                            role="progressbar"
                            aria-valuenow="41"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: 41%"
                          ></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content mb-3">
        <div class="widget-content-outer">
          <div class="widget-content-wrapper">
            <div class="widget-content-left">
              <div class="widget-heading">Total Orders</div>
              <div class="widget-subheading">Last year expenses</div>
            </div>
            <div class="widget-content-right">
              <div class="widget-numbers text-success">1896</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content mb-3">
        <div class="widget-content-outer">
          <div class="widget-content-wrapper">
            <div class="widget-content-left">
              <div class="widget-heading">Products Sold</div>
              <div class="widget-subheading">Revenue streams</div>
            </div>
            <div class="widget-content-right">
              <div class="widget-numbers text-warning">$3M</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content mb-3">
        <div class="widget-content-outer">
          <div class="widget-content-wrapper">
            <div class="widget-content-left">
              <div class="widget-heading">Followers</div>
              <div class="widget-subheading">People Interested</div>
            </div>
            <div class="widget-content-right">
              <div class="widget-numbers text-danger">45,9%</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
      <div class="card widget-content mb-3">
        <div class="widget-content-outer">
          <div class="widget-content-wrapper">
            <div class="widget-content-left">
              <div class="widget-heading">Income</div>
              <div class="widget-subheading">Expected totals</div>
            </div>
            <div class="widget-content-right">
              <div class="widget-numbers text-focus">$147</div>
            </div>
          </div>
          <div class="widget-progress-wrapper">
            <div class="progress-bar-sm progress-bar-animated-alt progress">
              <div
                class="progress-bar bg-info"
                role="progressbar"
                aria-valuenow="54"
                aria-valuemin="0"
                aria-valuemax="100"
                style="width: 54%"
              ></div>
            </div>
            <div class="progress-sub-label">
              <div class="sub-label-left">Expenses</div>
              <div class="sub-label-right">100%</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="main-card card mb-3">
        <div class="card-header">
          Active Users
          <div class="btn-actions-pane-right">
            <div role="group" class="btn-group-sm btn-group">
              <button class="active btn btn-focus">Last Week</button>
              <button class="btn btn-focus">All Month</button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table
            class="table-borderless table-striped table-hover mb-0 table align-middle"
          >
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Name</th>
                <th class="text-center">City</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-muted text-center">#345</td>
                <td>
                  <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                      <div class="widget-content-left me-3">
                        <div class="widget-content-left">
                          <img
                            width="40"
                            class="rounded-circle"
                            src="{{ asset('architectui/assets/images/avatars/4.jpg') }}"
                            alt=""
                          />
                        </div>
                      </div>
                      <div class="widget-content-left flex2">
                        <div class="widget-heading">John Doe</div>
                        <div class="widget-subheading opacity-7">
                          Web Developer
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="text-center">Madrid</td>
                <td class="text-center">
                  <div class="badge bg-warning">Pending</div>
                </td>
                <td class="text-center">
                  <button
                    type="button"
                    id="PopoverCustomT-1"
                    class="btn btn-primary btn-sm"
                  >
                    Details
                  </button>
                </td>
              </tr>
              <tr>
                <td class="text-muted text-center">#347</td>
                <td>
                  <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                      <div class="widget-content-left me-3">
                        <div class="widget-content-left">
                          <img
                            width="40"
                            class="rounded-circle"
                            src="{{ asset('architectui/assets/images/avatars/3.jpg') }}"
                            alt=""
                          />
                        </div>
                      </div>
                      <div class="widget-content-left flex2">
                        <div class="widget-heading">Ruben Tillman</div>
                        <div class="widget-subheading opacity-7">
                          Etiam sit amet orci eget
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="text-center">Berlin</td>
                <td class="text-center">
                  <div class="badge bg-success">Completed</div>
                </td>
                <td class="text-center">
                  <button
                    type="button"
                    id="PopoverCustomT-2"
                    class="btn btn-primary btn-sm"
                  >
                    Details
                  </button>
                </td>
              </tr>
              <tr>
                <td class="text-muted text-center">#321</td>
                <td>
                  <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                      <div class="widget-content-left me-3">
                        <div class="widget-content-left">
                          <img
                            width="40"
                            class="rounded-circle"
                            src="{{ asset('architectui/assets/images/avatars/2.jpg') }}"
                            alt=""
                          />
                        </div>
                      </div>
                      <div class="widget-content-left flex2">
                        <div class="widget-heading">Elliot Huber</div>
                        <div class="widget-subheading opacity-7">
                          Lorem ipsum dolor sic
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="text-center">London</td>
                <td class="text-center">
                  <div class="badge bg-danger">In Progress</div>
                </td>
                <td class="text-center">
                  <button
                    type="button"
                    id="PopoverCustomT-3"
                    class="btn btn-primary btn-sm"
                  >
                    Details
                  </button>
                </td>
              </tr>
              <tr>
                <td class="text-muted text-center">#55</td>
                <td>
                  <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                      <div class="widget-content-left me-3">
                        <div class="widget-content-left">
                          <img
                            width="40"
                            class="rounded-circle"
                            src="{{ asset('architectui/assets/images/avatars/1.jpg') }}"
                            alt=""
                          />
                        </div>
                      </div>
                      <div class="widget-content-left flex2">
                        <div class="widget-heading">Vinnie Wagstaff</div>
                        <div class="widget-subheading opacity-7">
                          UI Designer
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="text-center">Amsterdam</td>
                <td class="text-center">
                  <div class="badge bg-info">On Hold</div>
                </td>
                <td class="text-center">
                  <button
                    type="button"
                    id="PopoverCustomT-4"
                    class="btn btn-primary btn-sm"
                  >
                    Details
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="d-block card-footer text-center">
          <button class="btn-icon btn-icon-only btn btn-outline-danger me-2">
            <i class="pe-7s-trash btn-icon-wrapper"></i>
          </button>
          <button class="btn-wide btn btn-success">Save</button>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div
        class="card-shadow-danger widget-chart widget-chart2 card mb-3 text-start"
      >
        <div class="widget-content">
          <div class="widget-content-outer">
            <div class="widget-content-wrapper">
              <div class="widget-content-left fsize-1 pe-2">
                <div class="widget-numbers fsize-3 text-danger mt-0">71%</div>
              </div>
              <div class="widget-content-right w-100">
                <div class="progress-bar-xs progress">
                  <div
                    class="progress-bar bg-danger"
                    role="progressbar"
                    aria-valuenow="71"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style="width: 71%"
                  ></div>
                </div>
              </div>
            </div>
            <div class="widget-content-left fsize-1">
              <div class="text-muted opacity-6">Income Target</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div
        class="card-shadow-success widget-chart widget-chart2 card mb-3 text-start"
      >
        <div class="widget-content">
          <div class="widget-content-outer">
            <div class="widget-content-wrapper">
              <div class="widget-content-left fsize-1 pe-2">
                <div class="widget-numbers fsize-3 text-success mt-0">54%</div>
              </div>
              <div class="widget-content-right w-100">
                <div class="progress-bar-xs progress">
                  <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    aria-valuenow="54"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style="width: 54%"
                  ></div>
                </div>
              </div>
            </div>
            <div class="widget-content-left fsize-1">
              <div class="text-muted opacity-6">Expenses Target</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div
        class="card-shadow-warning widget-chart widget-chart2 card mb-3 text-start"
      >
        <div class="widget-content">
          <div class="widget-content-outer">
            <div class="widget-content-wrapper">
              <div class="widget-content-left fsize-1 pe-2">
                <div class="widget-numbers fsize-3 text-warning mt-0">32%</div>
              </div>
              <div class="widget-content-right w-100">
                <div class="progress-bar-xs progress">
                  <div
                    class="progress-bar bg-warning"
                    role="progressbar"
                    aria-valuenow="32"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style="width: 32%"
                  ></div>
                </div>
              </div>
            </div>
            <div class="widget-content-left fsize-1">
              <div class="text-muted opacity-6">Spendings Target</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div
        class="card-shadow-info widget-chart widget-chart2 card mb-3 text-start"
      >
        <div class="widget-content">
          <div class="widget-content-outer">
            <div class="widget-content-wrapper">
              <div class="widget-content-left fsize-1 pe-2">
                <div class="widget-numbers fsize-3 text-info mt-0">89%</div>
              </div>
              <div class="widget-content-right w-100">
                <div class="progress-bar-xs progress">
                  <div
                    class="progress-bar bg-info"
                    role="progressbar"
                    aria-valuenow="89"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style="width: 89%"
                  ></div>
                </div>
              </div>
            </div>
            <div class="widget-content-left fsize-1">
              <div class="text-muted opacity-6">Totals Target</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
