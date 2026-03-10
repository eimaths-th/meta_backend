@extends ('layout')
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
    font-size: 35px;
  }
</style>
@section ('content')
  <body style="background-color: #d8e8b0">
    <main class="login-form">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-10">
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
              <div
                class="card-header aaa text-center"
                style="text-shadow: 2px 2px 4px black"
              >
                Reset Password
              </div>
              <div class="card-body" style="margin-bottom: 50px">
                @if (Session::has('message'))
                  <div class="alert alert-success" role="alert">
                    {{
                      Session::get(
                        'message',
                      )
                    }}
                  </div>
                @endif

                <form
                  action="{{ route('forget.password.post') }}"
                  method="POST"
                >
                  @csrf
                  <div class="form-group row" style="padding-top: 30px">
                    <label
                      for="email_address"
                      class="col-md-4 col-form-label text-md-right"
                      >E-Mail Address</label
                    >
                    <div class="col-md-6">
                      <input
                        type="text"
                        id="email_address"
                        class="form-control"
                        name="email"
                        required
                        autofocus
                      />
                      @if ($errors->has('email'))
                        <span class="text-danger">{{
                          $errors->first(
                            'email',
                          )
                        }}</span>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6 offset-md-4" style="padding-top: 20px">
                    <button
                      type="submit"
                      class="btn btn-primary"
                      style="
                        box-shadow: 5px 5px 10px gray;
                        text-shadow: 2px 2px 4px #000000;
                        width: 80%;
                        border-radius: 100px;
                      "
                    >
                      Send Password Reset Link
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
