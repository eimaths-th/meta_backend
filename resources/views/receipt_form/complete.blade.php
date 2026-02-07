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
            color: #12458D;
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
            font-size: .75em;
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
                <div class="card bg-light2 mb-3 ">

                    <div class="card-body">
                        <br>
                        <div align="center"><img src="{{ asset('images/Thankyou-iconV2.png') }}" alt="..." height="200">
                        </div>
                        <div class="text-center">
                            <h1 class="card-title form_header">Thank You!</h1>
                            @if ($sfield == 'test_field')
                                <p class="card-text form_sub_header"><b>กรุณารอรับ Email ตอบกลับภายใน 72 ชม.</b></p>
                            @else
                                <p class="card-text form_sub_header"><b>Your submission has been received.</b></p>
                            @endif
                        </div>
                        <br>

                    </div>
                    <div class="card-footer text-center">
                        <br><br>
                        <a class="btn btn-lg btn-primary" href="{{ route('form.show', ['slug' => $sfield]) }}">Go Back To
                            Form</a><br><br>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
