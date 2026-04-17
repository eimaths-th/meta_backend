@extends ('layouts.app')
<style>
  .card-header-custom {
    background-image: url('{{
    asset(
      'images/school_309241295.jpg',
    )
  }}');
    height: 420px;
    background-repeat: no-repeat;
  }

  .div_center {
    margin: auto;
    text-align: center;
  }

  .aaa {
    color: #d8e8b0;
    font-weight: 1000;
  }
</style>

<head>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
  />
</head>
@section ('content')
  @isset ($url)
    <body style="background-color: #d8e8b0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-9">
            <div
              class="card"
              style="
                -webkit-box-shadow: 0 30px 50px rgba(0, 0, 0, 0.2);
                box-shadow: 0 30px 50px rgba(0, 0, 0, 0.2);
              "
            >
              <div
                class="card-header card-header-custom"
                style="background-color: #fff; margin-bottom: 100px"
              >
                <div class="div_center avatar white mx-auto">
                  <img
                    class="rounded-circle img-responsive image bg-white p-3"
                    style="margin-top: 300px; border: solid #eeeded 1px"
                    src="{{ asset('images/infinite.jpg') }}"
                    alt="..."
                    height="200"
                  />
                </div>
              </div>

              <div class="card-header form_header">
                <h2
                  class="aaa text-center"
                  style="text-shadow: 2px 2px 4px black"
                >
                  {{
                    isset($url)
                      ? ucwords($url)
                      : ''
                  }} {{ __('Login') }}
                </h2>
              </div>

              <div class="card-body" style="padding-bottom: 70px">
                <form
                  method="POST"
                  action='{{ url("login/$url") }}'
                  aria-label="{{ __('Login') }}"
                >
                  @csrf
                  <div class="row mb-3">
                    <label
                      for="success"
                      class="col-md-4 col-form-label text-md-end"
                    ></label>

                    <div class="col-md-6">
                      @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                          <p>{{ $message }}</p>
                        </div>
                      @endif

                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <p>{{ $errors->first() }}</p>
                        </div>
                      @endif
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label
                      for="email"
                      class="col-md-4 col-form-label text-md-end"
                      >{{
                        __(
                          'Email Address',
                        )
                      }}</label
                    >

                    <div class="col-md-5">
                      <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                      />

                      @error ('email')
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
                      >{{ __('Password') }}</label
                    >

                    <div class="col-md-5">
                      <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="current-password"
                      />

                      @error ('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-3 offset-md-4">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          name="remember"
                          id="remember"
                          {{
                            old('remember')
                              ? 'checked'
                              : ''
                          }}
                        />

                        <label class="form-check-label" for="remember">
                          {{
                            __(
                              'Remember Me',
                            )
                          }}
                        </label>
                      </div>
                    </div>

                    <div class="col-md-5">
                      <div class="checkbox">
                        <label>
                          <a href="{{ route('forget.password.get') }}"
                            >Reset Password</a
                          >
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-0" style="margin-top: 30px">
                    <div class="col-md-3"></div>

                    <div class="col-md-2">
                      <button
                        type="submit"
                        class="btn btn-primary"
                        style="
                          box-shadow: 5px 5px 10px gray;
                          text-shadow: 2px 2px 4px #000000;
                          width: 100%;
                          border-radius: 100px;
                        "
                      >
                        {{ __('Login') }}
                      </button>
                    </div>

                    <div class="col-md-3">
                      <a
                        href="{{ route('google.login') }}"
                        class="btn btn-google btn-user btn-block"
                        style="
                          box-shadow: 5px 5px 10px gray;
                          text-shadow: 2px 2px 4px #000000;
                          background-color: red;
                          color: white;
                          width: 100%;
                          border-radius: 100px;
                        "
                      >
                        <i class="fa fa-google"></i> Login with Google
                      </a>
                    </div>
                    <div class="col-md-2">
                      <a
                        class="btn btn-success"
                        style="
                          box-shadow: 5px 5px 10px gray;
                          color: #fff;
                          width: 100%;
                          border-radius: 100px;
                          text-shadow: 2px 2px 4px #000000;
                        "
                        href="{{ route('parentregister') }}"
                        >{{ __('Register') }}</a
                      >
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>

  @else
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              {{
                isset($url)
                  ? ucwords($url)
                  : ''
              }} {{ __('Login') }}
            </div>

            <div class="card-body">
              <form
                method="POST"
                action="{{ route('login.custom') }}"
                aria-label="{{ __('Login') }}"
              >
                @csrf
                <div class="row mb-3">
                  <label
                    for="success"
                    class="col-md-4 col-form-label text-md-end"
                  ></label>

                  <div class="col-md-6">
                    @if ($message = Session::get('success'))
                      <div class="alert alert-success">
                        <p>{{ $message }}</p>
                      </div>
                    @endif

                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <p>{{ $errors->first() }}</p>
                      </div>
                    @endif
                  </div>
                </div>

                <div class="row mb-3">
                  <label
                    for="email"
                    class="col-md-4 col-form-label text-md-end"
                    >{{
                      __(
                        'Email Address',
                      )
                    }}</label
                  >

                  <div class="col-md-6">
                    <input
                      id="email"
                      type="email"
                      class="form-control @error('email') is-invalid @enderror"
                      name="email"
                      value="{{ old('email') }}"
                      required
                      autocomplete="email"
                      autofocus
                    />

                    @error ('email')
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
                    >{{ __('Password') }}</label
                  >

                  <div class="col-md-6">
                    <input
                      id="password"
                      type="password"
                      class="form-control @error('password') is-invalid @enderror"
                      name="password"
                      required
                      autocomplete="current-password"
                    />

                    @error ('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-3 offset-md-4">
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{
                          old('remember')
                            ? 'checked'
                            : ''
                        }}
                      />

                      <label class="form-check-label" for="remember">
                        {{
                          __(
                            'Remember Me',
                          )
                        }}
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row mb-0">
                  <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                      <a
                        class="btn btn-link"
                        href="{{ route('password.request') }}"
                      >
                        {{
                          __(
                            'Forgot Your Password?',
                          )
                        }}
                      </a>
                    @endif
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      </body>

  @endisset
@endsection
