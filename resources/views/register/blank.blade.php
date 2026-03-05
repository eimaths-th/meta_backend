@extends('layouts.form')

@section('style')
  <style>
    body {
      background-color: #d8e8b0;
    }

    .bg-light2 {
      background-color: #fff;
    }

    hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid #112d53;
    }

    .div_center {
      margin: auto;
    }
  </style>
@endsection

@section('content')
  <div id="loader"></div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card bg-light2 mb-3">
          {{-- <div class="card-header">{{ __('Login') }}</div> --}}

          <div align="center">
            <img
              class=""
              src="{{ asset('images/infinite.jpg') }}"
              alt="..."
              height="300"
            />
          </div>

          <div class="card-body">
            <br />
            <div class="text-center">
              <h2 class="card-title form_header">Registration Form</h2>
            </div>
            <br />
            <hr />
          </div>
          <div class="card-footer text-center"></div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {});
  </script>
@endsection
