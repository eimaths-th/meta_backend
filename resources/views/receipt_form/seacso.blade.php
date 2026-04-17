@extends ('layouts.form')

@section ('style')
  <style>
    :root {
      --color-default: grey;
      --color-invalid: red;
      --color-valid: green;
    }

    input {
      border: 2px solid var(--color-default);
      /*text-align: center;*/
    }

    .error_div {
      background: rgb(240, 89, 83);
      color: white;
      height: 70px;
      text-align: center;
      margin: 0;
      top: 50%;
      width: 100%;
      margin-top: 0;
      margin-left: 0;
      position: absolute;
      z-index: 999999;
      opacity: 0.89;
      display: none;
    }

    .error-rounded-bg {
      background-clip: padding-box;
      border-radius: 20px;
      background-color: #f0f0f0;
      color: #000000;
      padding: 5px 10px;
      display: inline;
    }

    .error-message {
      display: none;
      font-weight: bold;
      color: var(--color-invalid);
    }

    /* To demonstrate that the validations only happen on blur, we apply this malpractice */
    input:focus {
      outline: none;
    }

    /*fucus empty color*/
    /*input:required:focus:invalid {
                                                                                                                                                                                                        background: url("https://assets.digitalocean.com/labs/icons/exclamation-triangle-fill.svg") no-repeat 95% 40% rgb(247, 213, 213);
                                                                                                                                                                                                        background-size: 15px;
                                                                                                                                                                                                    }*/

    input:required:focus:invalid ~ .form-error-message {
      display: block;
    }

    /* Only show invalid ring while not focused
                                                                                                                                                                                                    input:not(:focus):not(:placeholder-shown):invalid {
                                                                                                                                                                                                        border-color: var(--color-invalid);
                                                                                                                                                                                                    }*/

    /*input:not(:focus):not(:placeholder-shown):invalid~.error-message {
                                                                                                                                                                                                        display: block;
                                                                                                                                                                                                    }*/

    /* Only show valid ring while not focused and if a value is entered */
    /* :empty won't work here as that targets elements that have no childeren. Therefore we abuse :placeholder-shown */
    input:not(:focus):not(:placeholder-shown):valid {
      border-color: var(--color-valid);
    }

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

    .form-row {
      display: flex;
      flex-wrap: wrap;
      margin-right: -5px;
      margin-left: -5px;
      margin-bottom: 10px;
    }

    .form-group {
      margin-bottom: 10px;
      padding-left: 15px;
      padding-right: 15px;
      padding-top: 15px;
      padding-bottom: 15px;
    }

    .form-group > [class*='col-'] {
      padding-right: 5px;
      padding-left: 5px;
    }

    .form-row > .col,
    .form-row > [class*='col-'] {
      padding-right: 5px;
      padding-left: 5px;
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

    .form-label.form-label-auto {
      display: block;
      float: none;
      text-align: left;
      width: 100%;
      color: #082d5f;
    }

    .form-label-top {
      width: 100%;
      margin-left: 2px;
      margin-top: 10px;
      margin-bottom: 14px;
    }

    .form-label {
      display: inline-block;
      font-weight: 500;
      word-break: break-word;
    }

    .form-required {
      color: #f23a3c;
    }

    .form-required {
      margin-left: 4px;
    }

    .form-group:focus-within {
      background-color: white;
    }

    .form-focus-error {
      background-color: #f8cccd;
    }

    .bg-light2 {
      background-color: #e4efff;
    }

    .form-error-message {
      color: #fff;
      background-color: #f23a3c;
      background-image: url(
        data:image/svg + xml;charset=utf-8,
        %3Csvgwidth='14'height='15'fill='none'xmlns='http://www.w3.org/2000/svg'%3E%3Cpathfill-rule='evenodd'clip-rule='evenodd'd='M7 14.515a7 7 0 110-14 7 7 0 010 14zm-.814-5.86h1.628v-5.21H6.186v5.21zM7 11.259a.82.82 0 00.814-.824A.816.816 0 007 9.631a.813.813 0 100 1.628z'fill='%23fff'/%3E%3C/svg%3E
      );
      font-size: 0.75em;
      margin-top: 8px;
      border-radius: 4px;
      background-size: 0.875em;
      background-position: 0.375em;
      background-repeat: no-repeat;
      display: none;
      width: 200px;
      padding: 0.25em 0.5em 0.25em 1.625em;
    }

    .form_none {
      display: none;
    }

    .dropzone {
      width: 100%;
      height: 180px;
      min-height: 0px !important;
    }

    .dropzonex,
    .dropzonex * {
      box-sizing: border-box;
    }

    .dropzonex {
      min-height: 150px;
      background: #e4efff;
      padding: 20px 20px;
      display: none;
    }

    .dropzonex.dz-clickable {
      cursor: pointer;
    }

    .dropzonex.dz-clickable * {
      cursor: default;
    }

    .dropzonex.dz-clickable .dz-message,
    .dropzonex.dz-clickable .dz-message * {
      cursor: pointer;
    }

    .dropzonex.dz-started .dz-message {
      display: none;
    }

    .dropzonex.dz-drag-hover {
      border-style: solid;
    }

    .dropzonex.dz-drag-hover .dz-message {
      opacity: 0.5;
    }

    .dropzonex .dz-message {
      text-align: center;
      margin: 2em 0;
    }

    .dropzonex .dz-preview {
      position: relative;
      display: inline-block;
      vertical-align: top;
      margin: 16px;
      min-height: 100px;
    }

    .dropzonex .dz-preview:hover {
      z-index: 1000;
    }

    .dropzonex .dz-preview:hover .dz-details {
      opacity: 1;
    }

    .dropzonex .dz-preview.dz-file-preview .dz-image {
      border-radius: 20px;
      background: #999;
      background: linear-gradient(to bottom, #eee, #ddd);
    }

    .dropzonex .dz-preview.dz-file-preview .dz-details {
      opacity: 1;
    }

    .dropzonex .dz-preview.dz-image-preview {
      background: #e4efff;
    }

    .dropzonex .dz-preview.dz-image-preview .dz-details {
      -webkit-transition: opacity 0.2s linear;
      -moz-transition: opacity 0.2s linear;
      -ms-transition: opacity 0.2s linear;
      -o-transition: opacity 0.2s linear;
      transition: opacity 0.2s linear;
    }

    .dropzonex .dz-preview .dz-remove {
      font-size: 14px;
      text-align: center;
      display: block;
      cursor: pointer;
      border: none;
    }

    .dropzonex .dz-preview .dz-remove:hover {
      text-decoration: underline;
    }

    .dropzonex .dz-preview:hover .dz-details {
      opacity: 1;
    }

    .dropzonex .dz-preview .dz-details {
      z-index: 20;
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      font-size: 13px;
      min-width: 100%;
      max-width: 100%;
      padding: 2em 1em;
      text-align: center;
      color: rgba(0, 0, 0, 0.9);
      line-height: 150%;
    }

    .dropzonex .dz-preview .dz-details .dz-size {
      margin-bottom: 1em;
      font-size: 16px;
    }

    .dropzonex .dz-preview .dz-details .dz-filename {
      white-space: nowrap;
    }

    .dropzonex .dz-preview .dz-details .dz-filename:hover span {
      border: 1px solid rgba(200, 200, 200, 0.8);
      background-color: rgba(255, 255, 255, 0.8);
    }

    .dropzonex .dz-preview .dz-details .dz-filename:not(:hover) {
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .dropzonex .dz-preview .dz-details .dz-filename:not(:hover) span {
      border: 1px solid transparent;
    }

    .dropzonex .dz-preview .dz-details .dz-filename span,
    .dropzonex .dz-preview .dz-details .dz-size span {
      background-color: rgba(255, 255, 255, 0.4);
      padding: 0 0.4em;
      border-radius: 3px;
    }

    .dropzonex .dz-preview:hover .dz-image img {
      -webkit-transform: scale(1.05, 1.05);
      -moz-transform: scale(1.05, 1.05);
      -ms-transform: scale(1.05, 1.05);
      -o-transform: scale(1.05, 1.05);
      transform: scale(1.05, 1.05);
      -webkit-filter: blur(8px);
      filter: blur(8px);
    }

    .dropzonex .dz-preview .dz-image {
      border-radius: 20px;
      overflow: hidden;
      width: 120px;
      height: 120px;
      position: relative;
      display: block;
      z-index: 10;
    }

    .dropzonex .dz-preview .dz-image img {
      display: block;
    }

    .dropzonex .dz-preview.dz-success .dz-success-mark {
      -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .dropzonex .dz-preview.dz-error .dz-error-mark {
      opacity: 1;
      -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
      animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .dropzonex .dz-preview .dz-success-mark,
    .dropzonex .dz-preview .dz-error-mark {
      pointer-events: none;
      opacity: 0;
      z-index: 500;
      position: absolute;
      display: block;
      top: 50%;
      left: 50%;
      margin-left: -27px;
      margin-top: -27px;
    }

    .dropzonex .dz-preview .dz-success-mark svg,
    .dropzonex .dz-preview .dz-error-mark svg {
      display: block;
      width: 54px;
      height: 54px;
    }

    .dropzonex .dz-preview.dz-processing .dz-progress {
      opacity: 1;
      -webkit-transition: all 0.2s linear;
      -moz-transition: all 0.2s linear;
      -ms-transition: all 0.2s linear;
      -o-transition: all 0.2s linear;
      transition: all 0.2s linear;
    }

    .dropzonex .dz-preview.dz-complete .dz-progress {
      opacity: 0;
      -webkit-transition: opacity 0.4s ease-in;
      -moz-transition: opacity 0.4s ease-in;
      -ms-transition: opacity 0.4s ease-in;
      -o-transition: opacity 0.4s ease-in;
      transition: opacity 0.4s ease-in;
    }

    .dropzonex .dz-preview:not(.dz-processing) .dz-progress {
      -webkit-animation: pulse 6s ease infinite;
      -moz-animation: pulse 6s ease infinite;
      -ms-animation: pulse 6s ease infinite;
      -o-animation: pulse 6s ease infinite;
      animation: pulse 6s ease infinite;
    }

    .dropzonex .dz-preview .dz-progress {
      opacity: 1;
      z-index: 1000;
      pointer-events: none;
      position: absolute;
      height: 16px;
      left: 50%;
      top: 50%;
      margin-top: -8px;
      width: 80px;
      margin-left: -40px;
      background: rgba(255, 255, 255, 0.9);
      -webkit-transform: scale(1);
      border-radius: 8px;
      overflow: hidden;
    }

    .dropzonex .dz-preview .dz-progress .dz-upload {
      background: #333;
      background: linear-gradient(to bottom, #666, #444);
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      width: 0;
      -webkit-transition: width 300ms ease-in-out;
      -moz-transition: width 300ms ease-in-out;
      -ms-transition: width 300ms ease-in-out;
      -o-transition: width 300ms ease-in-out;
      transition: width 300ms ease-in-out;
    }

    .dropzonex .dz-preview.dz-error .dz-error-message {
      display: block;
    }

    .dropzonex .dz-preview.dz-error:hover .dz-error-message {
      opacity: 1;
      pointer-events: auto;
    }

    .dropzonex .dz-preview .dz-error-message {
      pointer-events: none;
      z-index: 1000;
      position: absolute;
      display: block;
      display: none;
      opacity: 0;
      -webkit-transition: opacity 0.3s ease;
      -moz-transition: opacity 0.3s ease;
      -ms-transition: opacity 0.3s ease;
      -o-transition: opacity 0.3s ease;
      transition: opacity 0.3s ease;
      border-radius: 8px;
      font-size: 13px;
      top: 130px;
      left: -10px;
      width: 140px;
      background: #be2626;
      background: linear-gradient(to bottom, #be2626, #a92222);
      padding: 0.5em 1.2em;
      color: white;
    }

    .dropzonex .dz-preview .dz-error-message:after {
      content: '';
      position: absolute;
      top: -6px;
      left: 64px;
      width: 0;
      height: 0;
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-bottom: 6px solid #be2626;
    }

    .form-control {
      width: 100%;
    }

    /* #loader {
                                                                                display: none;
                                                                                position: fixed;
                                                                                top: 0;
                                                                                left: 0;
                                                                                right: 0;
                                                                                bottom: 0;
                                                                                width: 100%;
                                                                                background: rgba(0, 0, 0, 0.75) url(images/loading2.gif) no-repeat center center;
                                                                                z-index: 10000;
                                                                            } */
    #loader-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      /* Semi-transparent background */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      z-index: 1000;
    }

    .spinner {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #3498db;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1s linear infinite;
      margin-bottom: 10px;
    }
    @keyframes
    spin {
         0% {
           transform: rotate(0deg);
         }

         100% {
           transform: rotate(360deg);
         }
       }

       #loading-message {
         font-size: 18px;
         color: #fff;
         /* White color for the message to contrast with the dark background */
       }
  </style>
@endsection

@section ('content')
  <div id="loader-container" style="display: none">
    <div id="loader" class="spinner"></div>
    <p id="loading-message">Please wait, your request is being processed...</p>
  </div>
  <div class="error_div" id="error_div">
    <br />
    There are errors in this page. Please correct them before moving on.
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card bg-light2 mb-3">
          {{-- <div class="card-header">{{ __('Login') }}</div> --}}
          <div align="center">
            <img
              class="card-img"
              src="{{ asset('images/seacso.jpg') }}"
              alt="..."
              height="360"
            />
          </div>
          <form
            id="infinite"
            method="POST"
            action="{{ route('form.store') }}"
            onsubmit="return check_input();"
          >
            @csrf
            <div class="card-body">
              <br />

              <div class="text-center">
                <h2 class="card-title form_header">
                  SEACSO {{ date('Y') }} Registration Form
                </h2>
                <p class="card-text form_sub_header">
                  <b>Fill out the form carefully for registration</b>
                </p>
              </div>

              <br />

              <hr />

              <div class="col-md-10 div_center" data-layout="full">
                @if (session('warning'))
                  <div class="alert alert-warning">
                    {!!
                      nl2br(
                        e(session('warning')),
                      )
                    !!}
                  </div>
                @endif

                @if (session('error'))
                  <div class="alert alert-danger">
                    {!!
                      nl2br(
                        e(session('error')),
                      )
                    !!}
                  </div>
                @endif

                <div class="form-html" data-component="text" tabindex="0">
                  <p style="text-align: center">
                    <span style="color: #6351a2">
                      <strong>
                        <span style="text-decoration: underline">
                          SEACSO {{ date('Y') }} Registration Form
                        </span>
                      </strong>
                    </span>
                  </p>
                  <p style="text-align: left">
                    <span style="color: #6351a2">
                      <strong>Registration Date:</strong>
                      @if ($date)
                        {{ $date }}
                      @else
                        Today - 25 October 2024
                        <br />
                      @endif
                    </span>
                  </p>
                  <p>
                    <span style="color: #6351a2">
                      <strong>Contest Date:</strong>
                      &nbsp;18 January 2025
                    </span>
                  </p>
                  {{--
                    <p><span style="color: #6351a2;"><strong>Result Release:&nbsp;</strong>19 April
                    2023</span>
                    </p>
                  --}}
                  {{--
                    <p><span style="color: #6351a2;"><strong>Venue:</strong>&nbsp;Online Competition</span>
                    </p>
                  --}}
                  <p>
                    <strong>
                      <span style="color: #6351a2">
                        Registration Fee:&nbsp;
                      </span>
                    </strong>
                  </p>
                  <p>
                    <span style="color: #6351a2">
                      <strong>Test:</strong>
                      1490 baht
                    </span>
                  </p>
                  {{--
                    <p>
                    <span style="color: #6351a2;">
                    <strong>
                    Test+tutoring class:
                    </strong>
                    </span>
                    <span style="color: #6351a2;">
                    1250 baht
                    </span>
                    <br>
                    </p>
                  --}}
                  {{--
                    <p>
                    <span style="color: #6351a2;">
                    <b>เกณฑ์การรับสมัคร GELOSEA</b> <br>
                    
                    รร.ไทยใช้ระดับชั้นปัจจุบัน ณ วันสอบเท่านั้น <br>
                    
                    
                    รร.นานาชาติที่พึ่งเปิดเทอม August/ September
                    อนุญาตให้ลงทะเบียนเป็นระดับชั้นสำหรับปีการศึกษาที่แล้ว หรือ
                    สามารถเลือกลงตามระดับชั้นปัจจุบันได้ <br>
                    
                    ถ้าได้รับการร้องเรียนเรื่องระดับชั้นแล้วทางเราตรวจสอบ <br>
                    เราจะยึดตามเกณฑ์นี้ หากไม่ปฏิบัติตามจะถูกตัดสิทธิ์
                    </span>
                    </p>
                  --}}
                  {{--
                    <span style="color: #6351a2;">
                    <strong>เวลาสอบ:</strong>
                    <ul>
                    <li>
                    <span class="color: #6351a2;">
                    10.30-12.00 Kindergarten - Grade 6
                    </span>
                    </li>
                    <li>
                    <span class="color: #6351a2;">
                    13.30-15.00 Grade 7 - 12
                    </span>
                    </li>
                    </ul>
                    
                    </span>
                  --}}
                  <p>
                    <span style="color: #6351a2">
                      <b>เกณฑ์การเทียบระดับชั้น SEACSO</b>
                      <br />
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="text-center">
                            <img
                              src="images/condition-01.jpg"
                              class="custom-image2 my-3"
                              alt="Image 2"
                              hight="20px"
                            />
                          </div>
                        </div>
                      </div>
                    </span>
                  </p>
                  <p>&nbsp;</p>
                </div>
              </div>

              <div class="col-md-11 div_center">
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
                <input type="hidden" name="sfield" id="sfield" value="25" />
                <input
                  type="hidden"
                  name="routeName"
                  id="routeName"
                  value="{{ request()->route()->getName() }}"
                />
                <input
                  type="hidden"
                  name="referent_code"
                  id="referent_code"
                  value="{{ request()->referent_code }}"
                />

                <div class="form-row form-focus">
                  <label
                    style="padding-left: 20px"
                    class="form-label form-label-top form-label-auto"
                  >
                    Name-Surname (English) / ชื่อ - นามสกุล ภาษาอังกฤษ
                    <span class="form-required">*</span>
                  </label>
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="firstname"
                      >
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="firstname"
                        id="firstname"
                        value=""
                        maxlength="50"
                        minlength="2"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        First Name
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="lastname"
                      >
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="lastname"
                        id="lastname"
                        value=""
                        maxlength="50"
                        minlength="2"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Last Name
                      </label>
                      {{--
                        <div class="form-error-message" role="alert"><img
                        src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                        height="10"> <span class="error-navigation-message">This field is
                        required.</span>
                        <div class="form-error-arrow">
                        <div class="form-error-arrow-inner"></div>
                        </div>
                        </div>
                      --}}
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6 col-sm-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="nickname"
                      >
                        Nickname (English)/ ชื่อเล่น (ภาษาอังกฤษ)
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="nickname"
                        id="nickname"
                        value=""
                        maxlength="50"
                        minlength="1"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Nick Name
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="birthdate"
                      >
                        Birth Date / วันเกิด
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="date"
                        class="AddDate form-control"
                        name="birthdate"
                        id="birthdate"
                        value=""
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Date
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="schoolname"
                      >
                        School name (English) / ชื่อโรงเรียน (ภาษาอังกฤษ)
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="schoolname"
                        id="schoolname"
                        value=""
                        maxlength="100"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        School Name
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="grade"
                      >
                        Grade / ระดับชั้น
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <select
                        style="width: 100%"
                        class="form-control"
                        id="grade"
                        name="grade"
                        data-component="dropdown"
                        aria-label="Grade / ระดับชั้น"
                        required
                      >
                        <option value="">Please Select</option>
                        <option value="Kindergarten">Kindergarten</option>
                        <option value="Grade 1">Grade 1</option>
                        <option value="Grade 2">Grade 2</option>
                        <option value="Grade 3">Grade 3</option>
                        <option value="Grade 4">Grade 4</option>
                        <option value="Grade 5">Grade 5</option>
                        <option value="Grade 6">Grade 6</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option>
                        <option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                      </select>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        {{-- Grade as per Academic Year 2022 --}}
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="package"
                      >
                        แพคเกจในการสอบ / Packages
                        <span class="form-required">*</span>
                      </label>
                      <select
                        class="form-control"
                        id="package"
                        name="package"
                        aria-label="แพคเกจในการสอบ / Packages"
                        required
                      >
                        <option value="">Please Select</option>
                        <option value="Test: 1490 baht">Test: 1490 baht</option>
                        {{--
                          <option value="Test + tutoring class: 1250 bath">Test +
                          tutoring class: 1250 bath</option>
                        --}}
                      </select>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Packages
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{--
                    <div class="col-md-6">
                    <div class="position-relative form-group">
                    <label class="form-label form-label-top form-label-auto" for="contest">Choose
                    Contest Category<span class="form-required">*</span></label>
                    <select class="form-control" id="contest" name="contest"
                    aria-label="Choose Contest Category" required>
                    <option value="">Please Select</option>
                    <option value="Science Category 1 (Kindergarten ,Grades 1)">Science
                    Category 1 (Kindergarten ,Grades 1) </option>
                    <option value="Science Category 2 (Grades 2-3)">Science Category 2 (Grades
                    2-3)</option>
                    <option value="Science Category 3 (Grades 4-5)">Science Category 3 (Grades
                    4-5)</option>
                    <option value="Science Category 4 (Grades 6-7)">Science Category 4
                    (Grades6-7)</option>
                    <option value="Science Category 5 (Grades 8-9)">Science Category 5 (Grades
                    8-9)</option>
                    <option value="Science Category 6 (Grades 10-12)">Science Category 6
                    (Grades 10-12)</option>
                    </select>
                    <label class="form-sub-label" style="min-height:13px"
                    aria-hidden="false">Contest Category</label>
                    <div class="form-error-message" role="alert"><img
                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                    height="10"> <span class="error-navigation-message">This field is
                    required.</span>
                    <div class="form-error-arrow">
                    <div class="form-error-arrow-inner"></div>
                    </div>
                    </div>
                    </div>
                    </div>
                  --}}
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="address"
                      >
                        Address / ที่อยู่ภาษาไทยสำหรับจัดส่งของรางวัล
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="address"
                        id="address"
                        maxlength="150"
                        minlength="2"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Street Address
                      </label>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="postcode"
                      >
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="postcode"
                        id="postcode"
                        maxlength="50"
                        minlength="2"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Postal / Zip Code / รหัสไปรษณีย์
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <div
                      class="position-relative form-group"
                      style="padding-top: 24px"
                    >
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="parent"
                      >
                        Parent's name / ชื่อและนามสกุลผู้ปกครอง
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="parent"
                        id="parent"
                        value=""
                        maxlength="100"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Parent's name
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div
                      class="position-relative form-group"
                      style="padding-top: 24px"
                    >
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="phone"
                      >
                        Phone Number / เบอร์โทรศัพท์
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="AddPhone form-control"
                        name="phone"
                        id="phone"
                        value=""
                        maxlength="20"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Phone Number
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row form-focus">
                  <div class="col-md-6 col-sm-12">
                    <div
                      class="position-relative form-group"
                      style="padding-top: 0px"
                    >
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="grade"
                      >
                        E-mail (กรุณาใช้
                        @gmail
                        .com เท่านั้น เพื่อที่จะสามารถส่งข้อมูลสำหรับเข้าสอบได้)
                        **สำหรับผู้ที่สมัครมากกว่า 1 คน
                        รบกวนไม่ใช้อีเมลเดิมในการสมัครสอบ**
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        value=""
                        maxlength="70"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        example@example.com
                      </label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          Please input correct email.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus" id="dropzone-photo">
                  <div class="col-md-12 col-sm-12">
                    <a id="dphoto"></a>
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="photo"
                      >
                        อัพโหลดรูปภาพผู้สมัคร
                        <span class="form-required">*</span>
                        <div style="width: 280px"></div>
                      </label>
                      <input
                        type="text"
                        id="drop1"
                        name="drop1"
                        class="form-control form_none"
                        value=""
                        required
                      />
                      <div
                        class="dropzone"
                        id="my-awesome-dropzone"
                        style="font-size: 1.5em"
                      >
                        <div class="fallback"></div>
                      </div>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Photo ขนาดไม่เกิน 5mb
                      </label>
                      <div
                        id="dropzone-photo-error"
                        class="form-error-message"
                        role="alert"
                      >
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="dropzonex dz-default dz-message"
                  id="dropzone_preview"
                  style="font-size: 1.5em"
                >
                  <h3 class="dropzone-previews ui"></h3>
                </div>

                <br />
                <div align="center">
                  <img
                    src="{{ asset('images/PayMent.png') }}"
                    alt="..."
                    height="300"
                  />
                </div>
                <br />

                <div class="form-row form-focus" id="dropzone-att">
                  <div class="col-md-12 col-sm-12">
                    <a id="datt"></a>
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="att"
                      >
                        อัพโหลดหลักฐานการชำระเงิน
                        <span class="form-required">*</span>
                        <div style="width: 280px"></div>
                      </label>
                      <input
                        type="text"
                        id="drop2"
                        name="drop2"
                        class="form-control form_none"
                        value=""
                        required
                      />
                      <div
                        class="dropzone"
                        id="my-awesome-dropzone2"
                        style="font-size: 1.5em"
                      >
                        <div class="fallback">
                          {{--
                            <input name="file2" id="file2" type="file" multiple
                            class="form-control" />
                          --}}
                        </div>
                      </div>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Receipt Photo ขนาดไม่เกิน 5mb
                      </label>
                      <div
                        id="dropzone-att-error"
                        class="form-error-message"
                        role="alert"
                      >
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="dropzonex dz-default dz-message"
                  id="dropzone_preview2"
                  style="font-size: 1.5em"
                >
                  <h3 class="dropzone-previews ui"></h3>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="newsf"
                      >
                        ท่านทราบข่าวสารการจัดสอบ SEACSO จากช่องทางใด
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="newsf"
                        id="newsf"
                        value=""
                        maxlength="50"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      ></label>
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message">
                          This field is required.
                        </span>
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-center">
              <br />
              <div class="text-danger">
                **กรุณาตรวจสอบข้อมูลให้ถูกต้อง ก่อนทำการชำระเงินค่าสมัครสอบ
                หากตรวจสอบข้อมูล และ พบว่าผู้สมัครไม่มีสิทธิ์เข้าสอบตามกฎ**
                <br />
                **ของสนามสอบหรือด้วยสาเหตุอื่นๆของทางผู้สมัคร
                ทางบริษัทขอสงวนสิทธิ์ในการคืนเงินทุกกรณี**
                <br />
              </div>
              <br />
              <div class="form-group form-check">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="agreeCheckbox"
                  required
                  style="float: none; margin-right: 3px"
                />
                <label class="form-check-label" for="agreeCheckbox">
                  ตกลงและยอมรับข้อกำหนดและเงื่อนไข
                  รวมถึงตรวจสอบข้อมูลและเนื้อหาต่างๆเรียบร้อยแล้ว
                </label>
              </div>
              <br />
              <input
                type="submit"
                id="send_data"
                class="btn btn-lg btn-primary"
                value="Submit Application"
              />
              <button type="reset" class="btn btn-lg btn-primary">
                Clear Form
              </button>
              <br />
              <br />
              <br />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      var inputlist = ['firstname', 'lastname', 'address', 'postcode'];
      $('.form-control').focusout(function () {
        //$(".form-control").focus();
        let inputxx;
        let nameinput = $(this).attr('name');

        if (inputlist.indexOf($(this).attr('name')) >= 0) {
          inputxx = '.form-focus';
        } else {
          inputxx = '.form-group';
        }

        if (nameinput == 'firstname') {
          if ($(this).val() == '' || $('#lastname').val() == '') {
            //alert();
            $(this).closest(inputxx).addClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'block');
            if ($(this).val() == '') {
              $(this).css('border', 'solid 1px red');
            } else {
              $(this).css('border', 'solid 1px green');
            }

            if ($('#lastname').val() == '') {
              $('#lastname').css('border', 'solid 1px red');
            } else {
              $('#lastname').css('border', 'solid 1px green');
            }

            //$(this).parents().css( "background-color", "red" );
          } else {
            // If it is not blank.
            $(this).css('border', 'solid 1px green');
            $('#lastname').css('border', 'solid 1px green');
            $(this).closest(inputxx).removeClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'none');
          }
        } else if (nameinput == 'lastname') {
          if ($(this).val() == '' || $('#firstname').val() == '') {
            //alert();
            $(this).closest(inputxx).addClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'block');
            if ($(this).val() == '') {
              $(this).css('border', 'solid 1px red');
            } else {
              $(this).css('border', 'solid 1px green');
            }

            if ($('#firstname').val() == '') {
              $('#firstname').css('border', 'solid 1px red');
            } else {
              $('#firstname').css('border', 'solid 1px green');
            }
            //$(this).parents().css( "background-color", "red" );
          } else {
            // If it is not blank.
            $(this).css('border', 'solid 1px green');
            $('#firstname').css('border', 'solid 1px green');
            $(this).closest(inputxx).removeClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'none');
          }
        } else if (nameinput == 'address') {
          if ($(this).val() == '' || $('#postcode').val() == '') {
            //alert();
            $(this).closest(inputxx).addClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'block');
            if ($(this).val() == '') {
              $(this).css('border', 'solid 1px red');
            } else {
              $(this).css('border', 'solid 1px green');
            }

            if ($('#postcode').val() == '') {
              $('#postcode').css('border', 'solid 1px red');
            } else {
              $('#postcode').css('border', 'solid 1px green');
            }
            //$(this).parents().css( "background-color", "red" );
          } else {
            // If it is not blank.
            $(this).css('border', 'solid 1px green');
            $('#postcode').css('border', 'solid 1px green');
            $(this).closest(inputxx).removeClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'none');
          }
        } else if (nameinput == 'postcode') {
          if ($(this).val() == '' || $('#address').val() == '') {
            //alert();
            $(this).closest(inputxx).addClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'block');
            if ($(this).val() == '') {
              $(this).css('border', 'solid 1px red');
            } else {
              $(this).css('border', 'solid 1px green');
            }

            if ($('#address').val() == '') {
              $('#address').css('border', 'solid 1px red');
            } else {
              $('#address').css('border', 'solid 1px green');
            }
            //$(this).parents().css( "background-color", "red" );
          } else {
            // If it is not blank.
            $(this).css('border', 'solid 1px green');
            $('#address').css('border', 'solid 1px green');
            $(this).closest(inputxx).removeClass('form-focus-error');
            $(this)
              .closest(inputxx)
              .find('.form-error-message')
              .css('display', 'none');
          }
        } else {
          if ($(this).attr('type') == 'email') {
            var validRegex =
              /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if ($(this).val() == '' || !$(this).val().match(validRegex)) {
              $(this).closest(inputxx).addClass('form-focus-error');
              $(this)
                .closest(inputxx)
                .find('.form-error-message')
                .css('display', 'block');
              $(this).css('border', 'solid 1px red');
              //$(this).parents().css( "background-color", "red" );
            } else {
              // If it is not blank.
              $(this).css('border', 'solid 1px green');
              $(this).closest(inputxx).removeClass('form-focus-error');
              $(this)
                .closest(inputxx)
                .find('.form-error-message')
                .css('display', 'none');
            }
          } else {
            if ($(this).val() == '') {
              $(this).closest(inputxx).addClass('form-focus-error');
              $(this)
                .closest(inputxx)
                .find('.form-error-message')
                .css('display', 'block');
              $(this).css('border', 'solid 1px red');
              //$(this).parents().css( "background-color", "red" );
            } else {
              // If it is not blank.
              $(this).css('border', 'solid 1px green');
              $(this).closest(inputxx).removeClass('form-focus-error');
              $(this)
                .closest(inputxx)
                .find('.form-error-message')
                .css('display', 'none');
            }
          }
        }
      });
      //.trigger("focusout");

      /* $("#infinite").validate({
                onfocusout: function(element) {
                    //this.element(element);
                    element.parent().css( "background-color", "red" );
                },
            });*/
    });
  </script>
  <script type="text/javascript">
    var myDropzone = {};
    let imgFiles = document.getElementsByName('imgFiles[]');
    let imgFiles2 = document.getElementsByName('imgFiles2[]');

    Dropzone.options.myAwesomeDropzone = {
      url: '{{
      route(
        'form.upload',
      )
    }}',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      paramName: 'file', // ชื่อไฟล์ปลายทางเมื่อ upload แบบ mutiple จะเป็น array
      autoProcessQueue: true, // ใส่เพื่อไม่ให้อัพโหลดทันที หลังจากเลือกไฟล์
      uploadMultiple: true, // อัพโหลดไฟล์หลายไฟล์
      parallelUploads: 2, // ให้ทำงานพร้อมกัน 10 ไฟล์
      maxFiles: 2, // ไฟล์สูงสุด 5 ไฟล์
      maxfilesexceeded: function (file) {
        this.removeAllFiles();
        this.addFile(file);
      },
      addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
      maxFilesize: 5, // MB
      previewsContainer: '#dropzone_preview', // ระบุ element เป้าหลาย
      //previewTemplate: $('#template-preview').html(),
      dictRemoveFile: 'Remove', // ชื่อ ปุ่ม remove
      renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        file.newName = newName;
        return newName;
      },
      dictCancelUpload: 'Cancel', // ชื่อ ปุ่ม ยกเลิก
      dictDefaultMessage:
        "<img height='60' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNsug8XTE5KVJEMECVvm8p43BZTdvZExoQ9Q&usqp=CAU'><br><font size='3'>Browse File</font>", // ข้อความบนพื้นที่แสดงรูปจะแสดงหลังจากโหลดเพจเสร็จ
      dictFileTooBig: 'ไม่อนุญาตให้อัพโหลดไฟล์เกิน 2 MB', //ข้อความแสดงเมื่อเลือกไฟล์ขนาดเกินที่กำหนด
      acceptedFiles: 'image/*', // อนุญาตให้เลือกไฟล์ประเภทรูปภาพได้

      // The setting up of the dropzone
      init: function () {
        myDropzone = this;
        this.on('addedfile', function (file) {
          //$('#infinite').append("<input type='text' class='form_none' name='imgFiles[]' value='" + file.newName + "'/>");
          $('#infinite').append(
            "<input type='text' id='" +
              file.newName +
              "' class='form_none' name='imgFiles[]' value='" +
              file.newName +
              "'/>"
          );
          file.previewElement.id = file.newName;
        })
          .on('removedfile', function (file) {
            //alert(file.id);
            //var name = file.name;
            var name = file.previewElement.id;

            $.ajax({
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              type: 'POST',
              url: '{{
      route(
        'form.delete',
      )
    }}',
              data: {
                name: name
              },
              success: function (data) {
                console.log('success: ' + data);
                var element = document.getElementById('infinite');
                var child = document.getElementById(name);
                element.removeChild(child);
                if (!document.getElementsByName('imgFiles[]').length) {
                  $('#dropzone_preview').css('display', 'none');
                  $('#dropzone-photo').addClass('form-focus-error');
                  $('#dropzone-photo')
                    .find('.form-error-message')
                    .css('display', 'block');
                  $('#dropzone-photo').css('border', 'solid 1px red');
                }
              }
            });

            //var _ref;
            //return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
          })
          .on('maxfilesexceeded', function (file, response) {
            alert('allow maximum 2 file');
            this.removeFile(file);
          })
          .on('complete', function (file) {
            let val = file.accepted;
            if (file.accepted == true) {
              obj = JSON.parse(file.xhr.response);
              //file.previewElement.id = obj.success;
              console.log(obj.success);
              //$('#infinite').append("<input type='text' id='" + obj.success +
              //    "' class='form_none' name='imgFiles[]' value='" + obj.success + "'/>");
            }
            let val1 = file.name;
            $('#dropzone_preview').css('display', 'block');
            $('#dropzone-photo').removeClass('form-focus-error');
            $('#dropzone-photo').find('.form-error-message').css('display', 'none');
            $('#dropzone-photo').css('border', 'solid 1px green');
            if (document.getElementsByName('imgFiles[]').length) {
              //$('#error_div').css('display', 'none');
            }
          })
          .on('success', function (file) {
            //var responseText = file.id // or however you would point to your assigned file ID here;
            //console.log(response); // console should show the ID you pointed to
            // do stuff with file.id ...
          })
          .on('error', function (file) {
            alert('ไม่อนุญาตให้อัพโหลดไฟล์เกิน 5 MB');
            while (imgFiles.length > 0) {
              imgFiles[0].parentNode.removeChild(imgFiles[0]);
            }
            this.removeFile(file);
            // alert(dictFileTooBig);
          });
        /*this.on("addedfile", function(file) {

                }).on("removedfile", function(file) {

                }).on("thumbnail", function(file) {

                }).on("error", function(file) {

                }).on("processing", function(file) {

                }).on("uploadprogress", function(file) {

                });*/
      }
    };

    Dropzone.options.myAwesomeDropzone2 = {
      url: '{{
      route(
        'form.upload',
      )
    }}',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      paramName: 'file', // ชื่อไฟล์ปลายทางเมื่อ upload แบบ mutiple จะเป็น array
      autoProcessQueue: true, // ใส่เพื่อไม่ให้อัพโหลดทันที หลังจากเลือกไฟล์
      uploadMultiple: true, // อัพโหลดไฟล์หลายไฟล์
      parallelUploads: 2, // ให้ทำงานพร้อมกัน 10 ไฟล์
      maxFiles: 1, // ไฟล์สูงสุด 5 ไฟล์
      maxfilesexceeded: function (file) {
        this.removeAllFiles();
        this.addFile(file);
      },
      addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
      maxFilesize: 5, // MB
      renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        file.newName = newName;
        return newName;
      },
      previewsContainer: '#dropzone_preview2', // ระบุ element เป้าหลาย
      //previewTemplate: $('#template-preview').html(),
      dictRemoveFile: 'Remove', // ชื่อ ปุ่ม remove
      dictCancelUpload: 'Cancel', // ชื่อ ปุ่ม ยกเลิก
      dictDefaultMessage:
        "<img height='60' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNsug8XTE5KVJEMECVvm8p43BZTdvZExoQ9Q&usqp=CAU'><br><font size='3'>Browse File</font>", // ข้อความบนพื้นที่แสดงรูปจะแสดงหลังจากโหลดเพจเสร็จ
      dictFileTooBig: 'ไม่อนุญาตให้อัพโหลดไฟล์เกิน 2 MB', //ข้อความแสดงเมื่อเลือกไฟล์ขนาดเกินที่กำหนด
      acceptedFiles: 'image/*', // อนุญาตให้เลือกไฟล์ประเภทรูปภาพได้
      // The setting up of the dropzone
      init: function () {
        myDropzone = this;
        this.on('addedfile', function (file) {
          //$('#infinite').append("<input type='text' class='form_none' name='imgFiles[]' value='" + file.name + "'/>");
          $('#infinite').append(
            "<input type='text' id='" +
              file.newName +
              "' class='form_none' name='imgFiles2[]' value='" +
              file.newName +
              "'/>"
          );
          file.previewElement.id = file.newName;
        })
          .on('removedfile', function (file) {
            //alert(file.id);
            //var name = file.name;
            var name = file.previewElement.id;

            $.ajax({
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              type: 'POST',
              url: '{{
      route(
        'form.delete',
      )
    }}',
              data: {
                name: name
              },
              success: function (data) {
                console.log('success: ' + data);
                var element = document.getElementById('infinite');
                var child = document.getElementById(name);
                element.removeChild(child);
                if (!document.getElementsByName('imgFiles2[]').length) {
                  //alert();
                  $('#dropzone_preview2').css('display', 'none');
                  $('#dropzone-att').addClass('form-focus-error');
                  $('#dropzone-att')
                    .find('.form-error-message')
                    .css('display', 'block');
                  $('#dropzone-att').css('border', 'solid 1px red');
                }
              }
            });

            //var _ref;
            //return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
          })
          .on('maxfilesexceeded', function (file) {
            alert('allow maximum 2 file');
            this.removeFile(file);
          })
          .on('complete', function (file) {
            let val = file.accepted;
            if (file.accepted == true) {
              obj = JSON.parse(file.xhr.response);
              //file.previewElement.id = obj.success;
              console.log(obj.success);
              //alert(obj.success);
              //$('#infinite').append("<input type='text' id='" + obj.success +
              //   "' class='form_none' name='imgFiles2[]' value='" + obj.success + "'/>");
            }
            let val1 = file.name;
            $('#dropzone_preview2').css('display', 'block');
            $('#dropzone-att').removeClass('form-focus-error');
            $('#dropzone-att').find('.form-error-message').css('display', 'none');
            $('#dropzone-att').css('border', 'solid 1px green');
            if (document.getElementsByName('imgFiles2[]').length) {
              //$('#error_div').css('display', 'none');
            }
          })
          .on('success', function (file) {
            //var responseText = file.id // or however you would point to your assigned file ID here;
            //console.log(response); // console should show the ID you pointed to
            // do stuff with file.id ...
          })
          .on('error', function (file) {
            this.removeFile(file);
            // this.removeFile(file);
            console.log(file);
            $('#imgFiles2').val('');
            while (imgFiles2.length > 0) {
              imgFiles2[0].parentNode.removeChild(imgFiles2[0]);
            }
            // document.getElementsByName('imgFiles2[]').length = 0;
            alert('ไม่อนุญาตให้อัพโหลดไฟล์เกิน 5 MB');
          });
        /*this.on("addedfile", function(file) {

                }).on("removedfile", function(file) {

                }).on("thumbnail", function(file) {

                }).on("error", function(file) {

                }).on("processing", function(file) {

                }).on("uploadprogress", function(file) {

                });*/
      }
    };

    const valid_option = {
      ignore: ':hidden:not([required]), :disabled',
      onkeyup: false,
      showErrors: function (errorMap, errorList) {
        var errors = this.numberOfInvalids();
        /* if (!document.getElementsByName('imgFiles[]').length) {
                    errors = errors + 1;
                }
                if (!document.getElementsByName('imgFiles2[]').length) {
                    errors = errors + 1;
                } */
        if (errors) {
          var message =
            errors == 1
              ? '<br>You missed <span class="error-rounded-bg">1</span> field. It has been highlighted'
              : '<br>You have missed <span class="error-rounded-bg">' +
                errors +
                '</span> fields. Please fill before submitted.';
          $('#error_div').html(message);
          $('.error_div').show();
        } else {
          $('.error_div').hide();
        }
        this.defaultShowErrors();
      },

      submitHandler: function (form) {
        $('#loader-container').show();

        $('#send_data').attr('disabled', true);

        if (
          document.getElementsByName('imgFiles[]').length &&
          document.getElementsByName('imgFiles2[]').length
        ) {
          $(form).submit();
          return true;
        }

        $('#loader-container').hide();
        $('#send_data').attr('disabled', false);
        return false;
      }
    };

    $(document).ready(function () {
      // $('#loader-container').show();

      $('.AddDate').inputmask('99-99-9999');
      $('.AddPhone').inputmask('(999) 999-9999');

      $('#infinite').validate(valid_option);

      $('#btnUpload').on('click', function () {
        myDropzone.processQueue();
      });
    });

    function check_input() {
      $('.form-control').focus();
      //$('.form-control').focus({ preventScroll: false });
      //$('input').focus();
      //$('input').focus({ preventScroll: false });

      if (!document.getElementById('agreeCheckbox').checked) {
        alert(
          'กรุณาติ๊ก "ตกลงและยอมรับข้อกำหนดและเงื่อนไข รวมถึงตรวจสอบข้อมูลและเนื้อหาต่างๆเรียบร้อยแล้ว" ก่อนส่งฟอร์ม'
        );
        return false;
      }

      if (
        document.getElementsByName('imgFiles[]').length &&
        document.getElementsByName('imgFiles2[]').length
      ) {
        //$('#error_div').css('display', 'none');

        return true;
      } else {
        if (!document.getElementsByName('imgFiles[]').length) {
          $('#dropzone-photo').addClass('form-focus-error');
          $('#dropzone-photo').find('.form-error-message').css('display', 'block');
          $('#dropzone-photo').css('border', 'solid 1px red');
          jumpTo('dphoto');
        }
        if (!document.getElementsByName('imgFiles2[]').length) {
          $('#dropzone-att').addClass('form-focus-error');
          $('#dropzone-att').find('.form-error-message').css('display', 'block');
          $('#dropzone-att').css('border', 'solid 1px red');
          jumpTo('datt');
        }

        //$('#error_div').css('display', 'block');
        return false;
      }
    }

    function jumpTo(id) {
      var get = location.href;
      location.href = '#' + id;
    }

    var fixmeTop = $('.error_div').offset().top;
    $(window).scroll(function () {
      var currentScroll = $(window).scrollTop();
      if (currentScroll >= fixmeTop) {
        $('.error_div').css({
          position: 'fixed',
          top: '0',
          left: '0'
        });
      } else {
        $('.error_div').css({
          position: 'absolute'
        });
      }
    });
  </script>
  <script type="text/javascript">
    const warningTitleCSS =
      'color:red; font-size:60px; font-weight: bold; -webkit-text-stroke: 1px black;';
    const warningDescCSS = 'font-size: 18px;';

    console.log('%cหยุด!', warningTitleCSS);
    console.log(
      '%cนี่เป็นคุณสมบัติการทำงานของเบราว์เซอร์ที่มีจุดมุ่งหมายให้ใช้สำหรับผู้พัฒนา หากผู้ใดบอกให้คุณคัดลอกแล้ววางข้อความบางอย่างที่นี่เพื่อเปิดใช้งานคุณสมบัติการทำงานของ ระบบ หรือเพื่อเข้าถึงบัญชีของบุคคลใดบุคคลหนึ่ง โดยมิชอบ คำบอกกล่าวเช่นนี้เป็นกลลวงและจะทำให้ผู้นั้นมีสิทธิ์เข้าถึงบัญชี ของคุณ',
      warningDescCSS
    );
    //console.log('%cSee https://www.facebook.com/selfxss for more information.', warningDescCSS);
  </script>
@endsection
