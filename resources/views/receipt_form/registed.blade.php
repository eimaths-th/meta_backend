@extends('layouts.form')

@section('style')
  <style>
    body {
      background-color: #112d53;
    }

    .form_header {
      color: #082d5f;
    }

    .form_sub_header {
      color: #12458d;
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

    .form-sub-label {
      color: #224779;
    }

    .form-sub-label {
      font-size: 0.75em;
      margin-top: 11px;
      margin-left: 2px;
      display: block;
      word-break: break-word;
    }

    .bg-light2 {
      background-color: #e4efff;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card bg-light2 mb-3">
          <div class="card-body">
            <br />

            <div class="text-center">
              <h1 class="card-title form_header">
                You have already registered.!
              </h1>
            </div>

            <br />

            <div class="container">
              <table class="table-bordered table">
                <tr>
                  <th>Submission Date</th>
                  <td>{{ $receipt->submission_date }}</td>
                </tr>
                <tr>
                  <th>First Name</th>
                  <td>{{ $receipt->first_name }}</td>
                </tr>
                <tr>
                  <th>Last Name</th>
                  <td>{{ $receipt->last_name }}</td>
                </tr>
                <tr>
                  <th>Nick Name</th>
                  <td>{{ $receipt->nick_name }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $receipt->email }}</td>
                </tr>
                <tr>
                  <th>Mobile</th>
                  <td>{{ $receipt->mobile }}</td>
                </tr>
                <tr>
                  <th>School Name</th>
                  <td>{{ $receipt->school_name }}</td>
                </tr>
                <tr>
                  <th>Parent Name</th>
                  <td>{{ $receipt->name_parent }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="card-footer text-center">
            <br />
            <br />
            <a class="btn btn-lg btn-primary" href="{{ route($route) }}">
              Go Back To Form
            </a>
            <br />
            <br />
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
