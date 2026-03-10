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
        background-color: #F0F0F0;
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

    input:required:focus:invalid~.form-error-message {
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
        background-color: #d8e8b0;
    }

    .bg-light2 {
        background-color: #fff;
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

    .form-group>[class*=col-] {
        padding-right: 5px;
        padding-left: 5px;
    }

    .form-row>.col,
    .form-row>[class*=col-] {
        padding-right: 5px;
        padding-left: 5px
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



    .form-error-message {
        color: #fff;
        background-color: #f23a3c;
        background-image: url(data:image/svg+xml;charset=utf-8,%3Csvg width='14' height='15' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M7 14.515a7 7 0 110-14 7 7 0 010 14zm-.814-5.86h1.628v-5.21H6.186v5.21zM7 11.259a.82.82 0 00.814-.824A.816.816 0 007 9.631a.813.813 0 100 1.628z' fill='%23fff'/%3E%3C/svg%3E);
        font-size: .75em;
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

    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.75) url(images/loading2.gif) no-repeat center center;
        z-index: 10000;
    }

    .form2 {
        background-color: #d8e8b0;
        margin-bottom: 50px;
    }

    .form3 {
        background-color: #f8cccd;
        /* margin-bottom: 50px; */
    }

    .card-header-custom {
        background-image: url("{{ asset('images/school_309241295.jpg') }}");
        height: 420px;
        background-repeat: no-repeat;
    }
</style>
@endsection

@section ('content')
  <div id="loader"></div>
  <div class="error_div" id="error_div">
    <br />There are errors in this page. Please correct them before moving on.
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div
          class="card bg-light2 mb-3"
          style="
            -webkit-box-shadow: 0 30px 50px rgba(0, 0, 0, 0.2);
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.2);
          "
        >
          {{-- <div class="card-header">{{ __('Login') }}
            </div> --}}
          <div
            class="card-header card-header-custom"
            style="background-color: #fff; margin-bottom: 100px"
          >
            <div class="avatar white mx-auto text-center">
              <img
                class="rounded-circle img-responsive image bg-white p-3"
                style="margin-top: 300px; border: solid #eeeded 1px"
                src="{{ asset('images/infinite.jpg') }}"
                alt="..."
                height="200"
              />
            </div>
          </div>
          <!-- <div align="center"><img class="" src="{{ asset('images/infinite.jpg') }}" alt="..." height="300"></div> -->
          <form
            id="infinite"
            method="POST"
            action="{{ route('parentregister.store') }}"
          >
            @csrf
            <div class="card-body">
              <br />
              <div class="text-center">
                <h2
                  class="card-title form_header"
                  style="text-shadow: 2px 2px 4px"
                >
                  Registration Form
                </h2>
              </div>
              <br />
              <hr />

              <div class="col-md-12 div_center">
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

                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="parent"
                        >Email<span class="form-required">*</span></label
                      >
                      <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        maxlength="100"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Email</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        for="parent"
                        >Parent's name / ชื่อและนามสกุลผู้ปกครอง<span
                          class="form-required"
                          >*</span
                        ></label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="parent"
                        id="parent"
                        value="{{ old('parent') }}"
                        maxlength="100"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Parent's name</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6 col-sm-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="password"
                        >Password <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="password"
                        class="AddPassword form-control"
                        name="password"
                        placeholder="ความยาวขั้นต่ำ 8 ตัว"
                        id="password"
                        value=""
                        maxlength="20"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Password</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        for="password_confirmation"
                        >Password Confirm <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="password"
                        class="AddPassword form-control"
                        name="password_confirmation"
                        placeholder="ความยาวขั้นต่ำ 8 ตัว"
                        id="password_confirmation"
                        value=""
                        maxlength="20"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >password_confirmation</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6 col-sm-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="phone"
                        >Phone Number / เบอร์โทรศัพท์
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="AddPhone form-control"
                        name="phone"
                        id="phone"
                        value="{{ old('phone') }}"
                        maxlength="20"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Phone Number</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row form-focus">
                    <div class="col-md-12 col-sm-12">
                      <div class="form-group">
                        <label
                          class="form-label form-label-top form-label-auto"
                          for="address"
                          >Address / ที่อยู่ภาษาไทย
                          <span class="form-required">*</span></label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="address"
                          id="address"
                          value="{{ old('address') }}"
                          maxlength="150"
                          minlength="2"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >Street Address</label
                        >
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
                          value="{{ old('postcode') }}"
                          maxlength="50"
                          minlength="2"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >Postal / Zip Code / รหัสไปรษณีย์
                        </label>
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
                          <div class="form-error-arrow">
                            <div class="form-error-arrow-inner"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr />

                <div class="aaa">
                  <div class="form-row form-focus">
                    <h3 class="form-label form-label-top form-label-auto ps-4">
                      นักเรียนคนที่ 1</h2>
                      <label
                        style="padding-left: 20px"
                        class="form-label form-label-top form-label-auto"
                        >Name-Surname (English) / ชื่อ - นามสกุล ภาษาอังกฤษ
                        <span class="form-required">*</span></label
                      >
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
                            name="firstname[]"
                            id="firstname"
                            value="{{ old('firstname.0') }}"
                            maxlength="50"
                            minlength="2"
                            required
                          />
                          <label
                            class="form-sub-label"
                            style="min-height: 13px"
                            aria-hidden="false"
                            >First Name</label
                          >
                          <div class="form-error-message" role="alert">
                            <img
                              src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                              height="10"
                            />
                            <span class="error-navigation-message"
                              >This field is required.</span
                            >
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
                            name="lastname[]"
                            id="lastname"
                            value="{{ old('lastname.0') }}"
                            maxlength="50"
                            minlength="2"
                            required
                          />
                          <label
                            class="form-sub-label"
                            style="min-height: 13px"
                            aria-hidden="false"
                            >Last Name</label
                          >
                          {{-- <div class="form-error-message" role="alert"><img
                                                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                    height="10"> <span class="error-navigation-message">This field is
                                                    required.</span>
                                                <div class="form-error-arrow">
                                                    <div class="form-error-arrow-inner"></div>
                                                </div>
                                            </div> --}}
                        </div>
                      </div>
                  </div>

                  <div class="form-row form-focus">
                    <div class="col-md-6 col-sm-12">
                      <div class="position-relative form-group">
                        <label
                          class="form-label form-label-top form-label-auto"
                          for="nickname"
                          >Nickname (English)/ ชื่อเล่น (ภาษาอังกฤษ)
                          <span class="form-required">*</span>
                          <div style="width: 270px"></div>
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          name="nickname[]"
                          id="nickname"
                          value="{{ old('nickname.0') }}"
                          maxlength="50"
                          minlength="1"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >Nick Name</label
                        >
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
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
                          >Birth Date / วันเกิด
                          <span class="form-required">*</span>
                          <div style="width: 270px"></div>
                        </label>
                        <input
                          type="date"
                          class="AddDate form-control"
                          name="birthdate[]"
                          id="birthdate"
                          value="{{ old('birthdate.0') }}"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >Date</label
                        >
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
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
                          >School name (English) / ชื่อโรงเรียน
                          (ภาษาอังกฤษ)<span class="form-required"
                            >*</span
                          ></label
                        >
                        <input
                          type="text"
                          class="form-control"
                          name="schoolname[]"
                          id="schoolname"
                          value="{{ old('schoolname.0') }}"
                          maxlength="100"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >School Name</label
                        >
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
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
                          >Grade / ระดับชั้น (ปัจจุบัน)
                          <span class="form-required">*</span>
                          <div style="width: 270px"></div>
                        </label>
                        <select
                          style="width: 100%"
                          class="form-control"
                          id="grade"
                          name="grade[]"
                          data-component="dropdown"
                          aria-label="Grade / ระดับชั้น"
                          required
                        >
                          <option value="">Please Select</option>
                          <option
                            value="Nursery"
                            {{
                              old('grade.0') == 'Nursery'
                                ? 'selected'
                                : ''
                            }}
                            >Nursery
                          </option>
                          <option
                            value="Kindergarten"
                            {{
                              old('grade.0') == 'Kindergarten'
                                ? 'selected'
                                : ''
                            }}
                            >Kindergarten
                          </option>
                          <option
                            value="Grade 1"
                            {{
                              old('grade.0') == 'Grade 1'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 1
                          </option>
                          <option
                            value="Grade 2"
                            {{
                              old('grade.0') == 'Grade 2'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 2
                          </option>
                          <option
                            value="Grade 3"
                            {{
                              old('grade.0') == 'Grade 3'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 3
                          </option>
                          <option
                            value="Grade 4"
                            {{
                              old('grade.0') == 'Grade 4'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 4
                          </option>
                          <option
                            value="Grade 5"
                            {{
                              old('grade.0') == 'Grade 5'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 5
                          </option>
                          <option
                            value="Grade 6"
                            {{
                              old('grade.0') == 'Grade 6'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 6
                          </option>
                          <option
                            value="Grade 7"
                            {{
                              old('grade.0') == 'Grade 7'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 7
                          </option>
                          <option
                            value="Grade 8"
                            {{
                              old('grade.0') == 'Grade 8'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 8
                          </option>
                          <option
                            value="Grade 9"
                            {{
                              old('grade.0') == 'Grade 9'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 9
                          </option>
                          <option
                            value="Grade 10"
                            {{
                              old('grade.0') == 'Grade 10'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 10
                          </option>
                          <option
                            value="Grade 11"
                            {{
                              old('grade.0') == 'Grade 11'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 11
                          </option>
                          <option
                            value="Grade 12"
                            {{
                              old('grade.0') == 'Grade 12'
                                ? 'selected'
                                : ''
                            }}
                            >Grade 12
                          </option>
                        </select>
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >Grade</label
                        >
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
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
                          for="sex"
                          >Gender / เพศ <span class="form-required">*</span>
                          <div style="width: 270px"></div>
                        </label>
                        <select
                          style="width: 100%"
                          class="form-control"
                          id="sex"
                          name="sex[]"
                          data-component="dropdown"
                          aria-label="Gender / เพศ"
                          required
                        >
                          <option value="">Please Select</option>
                          <option
                            value="Male"
                            {{
                              old('sex.0') == 'Male'
                                ? 'selected'
                                : ''
                            }}
                            >Male
                          </option>
                          <option
                            value="Female"
                            {{
                              old('sex.0') == 'Female'
                                ? 'selected'
                                : ''
                            }}
                            >Female
                          </option>
                        </select>
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >sex</label
                        >
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
                          <div class="form-error-arrow">
                            <div class="form-error-arrow-inner"></div>
                          </div>
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
                        >อัพโหลดรูปภาพนักเรียน
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
                        <div class="fallback">
                          {{-- <input name="file" id="file" type="file" multiple
                                                        class="form-control" /> --}}
                        </div>
                      </div>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Photo</label
                      >
                      <div
                        id="dropzone-photo-error"
                        class="form-error-message"
                        role="alert"
                      >
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
              </div>

              <div class="form2">
                <div class="form-row form-focus">
                  <h3 class="form-label form-label-top form-label-auto ps-4">
                    นักเรียนคนที่ 2</h2>
                    <label
                      style="padding-left: 20px"
                      class="form-label form-label-top form-label-auto"
                      >Name-Surname (English) / ชื่อ - นามสกุล ภาษาอังกฤษ
                      <span class="form-required">*</span></label
                    >
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
                          name="firstname[]"
                          id="firstname"
                          value="{{ old('firstname.1') }}"
                          maxlength="50"
                          minlength="2"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >First Name</label
                        >
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
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
                          name="lastname[]"
                          id="lastname"
                          value="{{ old('lastname.1') }}"
                          maxlength="50"
                          minlength="2"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >Last Name</label
                        >
                        {{-- <div class="form-error-message" role="alert"><img
                                                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                    height="10"> <span class="error-navigation-message">This field is
                                                    required.</span>
                                                <div class="form-error-arrow">
                                                    <div class="form-error-arrow-inner"></div>
                                                </div>
                                            </div> --}}
                      </div>
                    </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6 col-sm-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="nickname"
                        >Nickname (English)/ ชื่อเล่น (ภาษาอังกฤษ)
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="nickname[]"
                        id="nickname"
                        value="{{ old('nickname.1') }}"
                        maxlength="50"
                        minlength="1"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Nick Name</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >Birth Date / วันเกิด
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="date"
                        class="AddDate form-control"
                        name="birthdate[]"
                        id="birthdate"
                        value="{{ old('birthdate.1') }}"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Date</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >School name (English) / ชื่อโรงเรียน (ภาษาอังกฤษ)<span
                          class="form-required"
                          >*</span
                        ></label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="schoolname[]"
                        id="schoolname"
                        value="{{ old('schoolname.1') }}"
                        maxlength="100"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >School Name</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >Grade / ระดับชั้น (ปัจจุบัน)<span class="form-required"
                          >*</span
                        >
                        <div style="width: 270px"></div>
                      </label>
                      <select
                        style="width: 100%"
                        class="form-control"
                        id="grade"
                        name="grade[]"
                        data-component="dropdown"
                        aria-label="Grade / ระดับชั้น"
                        required
                      >
                        <option value="">Please Select</option>
                        <option
                          value="Nursery"
                          {{
                            old('grade.1') == 'Nursery'
                              ? 'selected'
                              : ''
                          }}
                          >Nursery
                        </option>
                        <option
                          value="Kindergarten"
                          {{
                            old('grade.1') == 'Kindergartens'
                              ? 'selected'
                              : ''
                          }}
                          >Kindergarten
                        </option>
                        <option
                          value="Grade 1"
                          {{
                            old('grade.1') == 'Grade 1'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 1
                        </option>
                        <option
                          value="Grade 2"
                          {{
                            old('grade.1') == 'Grade 2'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 2
                        </option>
                        <option
                          value="Grade 3"
                          {{
                            old('grade.1') == 'Grade 3'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 3
                        </option>
                        <option
                          value="Grade 4"
                          {{
                            old('grade.1') == 'Grade 4'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 4
                        </option>
                        <option
                          value="Grade 5"
                          {{
                            old('grade.1') == 'Grade 5'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 5
                        </option>
                        <option
                          value="Grade 6"
                          {{
                            old('grade.1') == 'Grade 6'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 6
                        </option>
                        <option
                          value="Grade 7"
                          {{
                            old('grade.1') == 'Grade 7'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 7
                        </option>
                        <option
                          value="Grade 8"
                          {{
                            old('grade.1') == 'Grade 8'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 8
                        </option>
                        <option
                          value="Grade 9"
                          {{
                            old('grade.1') == 'Grade 9'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 9
                        </option>
                        <option
                          value="Grade 10"
                          {{
                            old('grade.1') == 'Grade 10'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 10
                        </option>
                        <option
                          value="Grade 11"
                          {{
                            old('grade.1') == 'Grade 11'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 11
                        </option>
                        <option
                          value="Grade 12"
                          {{
                            old('grade.1') == 'Grade 12'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 12
                        </option>
                      </select>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Grade</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        for="sex"
                        >Gender / เพศ <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <select
                        style="width: 100%"
                        class="form-control"
                        id="sex"
                        name="sex[]"
                        data-component="dropdown"
                        aria-label="Gender / เพศ"
                        required
                      >
                        <option value="">Please Select</option>
                        <option
                          value="Male"
                          {{
                            old('sex.1') == 'Male'
                              ? 'selected'
                              : ''
                          }}
                          >Male
                        </option>
                        <option
                          value="Female"
                          {{
                            old('sex.1') == 'Female'
                              ? 'selected'
                              : ''
                          }}
                          >Female
                        </option>
                      </select>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >sex</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >อัพโหลดรูปภาพนักเรียน
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
                        id="my-awesome-dropzone2"
                        style="font-size: 1.5em"
                      >
                        <div class="fallback">
                          {{-- <input name="file" id="file" type="file" multiple
                                                        class="form-control" /> --}}
                        </div>
                      </div>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Photo</label
                      >
                      <div
                        id="dropzone-photo-error"
                        class="form-error-message"
                        role="alert"
                      >
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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

                <br />
              </div>
              <div class="form3">
                <div class="form-row form-focus">
                  <h3 class="form-label form-label-top form-label-auto ps-4">
                    นักเรียนคนที่ 3</h2>
                    <label
                      style="padding-left: 20px"
                      class="form-label form-label-top form-label-auto"
                      >Name-Surname (English) / ชื่อ - นามสกุล ภาษาอังกฤษ
                      <span class="form-required">*</span></label
                    >
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
                          name="firstname[]"
                          id="firstname"
                          value="{{ old('firstname.2') }}"
                          maxlength="50"
                          minlength="2"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >First Name</label
                        >
                        <div class="form-error-message" role="alert">
                          <img
                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                            height="10"
                          />
                          <span class="error-navigation-message"
                            >This field is required.</span
                          >
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
                          name="lastname[]"
                          id="lastname"
                          value="{{ old('lastname.2') }}"
                          maxlength="50"
                          minlength="2"
                          required
                        />
                        <label
                          class="form-sub-label"
                          style="min-height: 13px"
                          aria-hidden="false"
                          >Last Name</label
                        >
                        {{-- <div class="form-error-message" role="alert"><img
                                                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                    height="10"> <span class="error-navigation-message">This field is
                                                    required.</span>
                                                <div class="form-error-arrow">
                                                    <div class="form-error-arrow-inner"></div>
                                                </div>
                                            </div> --}}
                      </div>
                    </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6 col-sm-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="nickname"
                        >Nickname (English)/ ชื่อเล่น (ภาษาอังกฤษ)
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="nickname[]"
                        id="nickname"
                        value="{{ old('nickname.2') }}"
                        maxlength="50"
                        minlength="1"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Nick Name</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >Birth Date / วันเกิด
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="date"
                        class="AddDate form-control"
                        name="birthdate[]"
                        id="birthdate"
                        value="{{ old('birthdate.2') }}"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Date</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >School name (English) / ชื่อโรงเรียน (ภาษาอังกฤษ)<span
                          class="form-required"
                          >*</span
                        ></label
                      >
                      <input
                        type="text"
                        class="form-control"
                        name="schoolname[]"
                        id="schoolname"
                        value="{{ old('schoolname.2') }}"
                        maxlength="100"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >School Name</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >Grade / ระดับชั้น (ปัจจุบัน)<span class="form-required"
                          >*</span
                        >
                        <div style="width: 270px"></div>
                      </label>
                      <select
                        style="width: 100%"
                        class="form-control"
                        id="grade"
                        name="grade[]"
                        data-component="dropdown"
                        aria-label="Grade / ระดับชั้น"
                        required
                      >
                        <option value="">Please Select</option>
                        <option
                          value="Nursery"
                          {{
                            old('grade.2') == 'Nursery'
                              ? 'selected'
                              : ''
                          }}
                          >Nursery
                        </option>
                        <option
                          value="Kindergarten"
                          {{
                            old('grade.2') == 'Kindergarten'
                              ? 'selected'
                              : ''
                          }}
                          >Kindergarten
                        </option>
                        <option
                          value="Grade 1"
                          {{
                            old('grade.2') == 'Grade 1'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 1
                        </option>
                        <option
                          value="Grade 2"
                          {{
                            old('grade.2') == 'Grade 2'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 2
                        </option>
                        <option
                          value="Grade 3"
                          {{
                            old('grade.2') == 'Grade 3'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 3
                        </option>
                        <option
                          value="Grade 4"
                          {{
                            old('grade.2') == 'Grade 4'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 4
                        </option>
                        <option
                          value="Grade 5"
                          {{
                            old('grade.2') == 'Grade 5'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 5
                        </option>
                        <option
                          value="Grade 6"
                          {{
                            old('grade.2') == 'Grade 6'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 6
                        </option>
                        <option
                          value="Grade 7"
                          {{
                            old('grade.2') == 'Grade 7'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 7
                        </option>
                        <option
                          value="Grade 8"
                          {{
                            old('grade.2') == 'Grade 8'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 8
                        </option>
                        <option
                          value="Grade 9"
                          {{
                            old('grade.2') == 'Grade 9'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 9
                        </option>
                        <option
                          value="Grade 10"
                          {{
                            old('grade.2') == 'Grade 10'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 10
                        </option>
                        <option
                          value="Grade 11"
                          {{
                            old('grade.2') == 'Grade 11'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 11
                        </option>
                        <option
                          value="Grade 12"
                          {{
                            old('grade.2') == 'Grade 12'
                              ? 'selected'
                              : ''
                          }}
                          >Grade 12
                        </option>
                      </select>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Grade</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        for="sex"
                        >Gender / เพศ <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <select
                        style="width: 100%"
                        class="form-control"
                        id="sex"
                        name="sex[]"
                        data-component="dropdown"
                        aria-label="Gender / เพศ"
                        required
                      >
                        <option value="">Please Select</option>
                        <option
                          value="Male"
                          {{
                            old('sex.2') == 'Male'
                              ? 'selected'
                              : ''
                          }}
                          >Male
                        </option>
                        <option
                          value="Female"
                          {{
                            old('sex.2') == 'Female'
                              ? 'selected'
                              : ''
                          }}
                          >Female
                        </option>
                      </select>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >sex</label
                      >
                      <div class="form-error-message" role="alert">
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
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
                        >อัพโหลดรูปภาพผู้สมัคร
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
                        id="my-awesome-dropzone3"
                        style="font-size: 1.5em"
                      >
                        <div class="fallback">
                          {{-- <input name="file" id="file" type="file" multiple
                                                        class="form-control" /> --}}
                        </div>
                      </div>
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                        >Photo</label
                      >
                      <div
                        id="dropzone-photo-error"
                        class="form-error-message"
                        role="alert"
                      >
                        <img
                          src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                          height="10"
                        />
                        <span class="error-navigation-message"
                          >This field is required.</span
                        >
                        <div class="form-error-arrow">
                          <div class="form-error-arrow-inner"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="dropzonex dz-default dz-message"
                  id="dropzone_preview3"
                  style="font-size: 1.5em"
                >
                  <h3 class="dropzone-previews ui"></h3>
                </div>

                <br />
              </div>

              <input type="text" name="val" id="val" hidden value="1" />
              <input type="text" name="field" id="field" hidden />

              <button
                type="button"
                id="addbtn"
                class="btn btn-lg btn-success"
                style="
                  box-shadow: 5px 5px 10px gray;
                  color: #fff;
                  text-shadow: 2px 2px 4px #000000;
                "
              >
                เพิ่มนักเรียนคนที่2
              </button>
              <button
                type="button"
                id="addbtn3"
                class="btn btn-lg btn-success"
                style="
                  box-shadow: 5px 5px 10px gray;
                  color: #fff;
                  text-shadow: 2px 2px 4px #000000;
                "
              >
                เพิ่มนักเรียนคนที่3</button
              ><br /><br />
              <button
                type="button"
                id="bbtn"
                class="btn btn-lg btn-danger"
                style="
                  box-shadow: 5px 5px 10px gray;
                  color: #fff;
                  text-shadow: 2px 2px 4px #000000;
                "
              >
                ลบนักเรียนคนที่2
              </button>
              <button
                type="button"
                id="bbtn3"
                class="btn btn-lg btn-danger"
                style="
                  box-shadow: 5px 5px 10px gray;
                  color: #fff;
                  text-shadow: 2px 2px 4px #000000;
                "
              >
                ลบนักเรียนคนที่3</button
              ><br /><br /><br />
              <div class="text-center">
                <input
                  type="submit"
                  style="
                    box-shadow: 5px 5px 10px gray;
                    color: #fff;
                    border-radius: 100px;
                    text-shadow: 2px 2px 4px #000000;
                    width: 200px;
                  "
                  class="btn btn-lg btn-primary me-3"
                  value="Register"
                />
                <button
                  type="reset"
                  style="
                    box-shadow: 5px 5px 10px gray;
                    color: #fff;
                    border-radius: 100px;
                    text-shadow: 2px 2px 4px #000000;
                    width: 200px;
                  "
                  class="btn btn-lg btn-danger"
                >
                  Clear Form</button
                ><br /><br /><br />
              </div>
            </div>
        </div>
      </div>

      </form>
    </div>
  </div>
  </div>
  <script>
    $(document).ready(function () {
      $('.form2').hide();
      $('#bbtn').hide();
      $('.form3').hide();
      $('#bbtn3').hide();
      $('#addbtn3').hide();

      $('#bbtn3').click(function () {
        $('.form3').hide();
        $('#val').val('2');
        $('#bbtn3').hide();
        $('#addbtn3').show();
        $('#bbtn').show();
      });
      $('#addbtn3').click(function () {
        $('.form3').show();
        $('#val').val('3');
        $('#bbtn3').show();
        $('#addbtn3').hide();
        $('#bbtn').hide();
      });
      $('#addbtn').click(function () {
        $('.form2').show();
        $('#val').val('2');
        $('#bbtn').show();
        $('#addbtn').hide();
        $('.form3').hide();
        $('#addbtn3').show();
      });
      $('#bbtn').click(function () {
        $('.form2').hide();
        $('#val').val('1');
        $('#bbtn').hide();
        $('#addbtn').show();
        $('#addbtn3').hide();
      });

      var inputlist = [
        'firstname',
        'lastname',
        'address',
        'postcode',
        'password'
      ];
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
      parallelUploads: 1, // ให้ทำงานพร้อมกัน 10 ไฟล์
      maxFiles: 1, // ไฟล์สูงสุด 5 ไฟล์

      /*maxfilesexceeded: function(file) {
        this.removeAllFiles();
        },*/
      addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
      maxFilesize: 10, // MB
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
            alert('allow maximum 1 file');
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
      parallelUploads: 1, // ให้ทำงานพร้อมกัน 10 ไฟล์
      maxFiles: 1, // ไฟล์สูงสุด 5 ไฟล์
      /*maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
        },*/
      addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
      maxFilesize: 10, // MB
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
            alert('allow maximum 1 file');
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
            if (document.getElementsByName('imgFiles[]').length) {
              //$('#error_div').css('display', 'none');
            }
          })
          .on('success', function (file) {
            //var responseText = file.id // or however you would point to your assigned file ID here;
            //console.log(response); // console should show the ID you pointed to
            // do stuff with file.id ...
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
    Dropzone.options.myAwesomeDropzone3 = {
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
      parallelUploads: 1, // ให้ทำงานพร้อมกัน 10 ไฟล์
      maxFiles: 1, // ไฟล์สูงสุด 5 ไฟล์
      /*maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
        },*/
      addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
      maxFilesize: 10, // MB
      renameFile: function (file) {
        let newName = new Date().getTime() + '_' + file.name;
        file.newName = newName;
        return newName;
      },
      previewsContainer: '#dropzone_preview3', // ระบุ element เป้าหลาย
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
                  //alert();
                  $('#dropzone_preview3').css('display', 'none');
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
            alert('allow maximum 1 file');
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
            $('#dropzone_preview3').css('display', 'block');
            $('#dropzone-att').removeClass('form-focus-error');
            $('#dropzone-att').find('.form-error-message').css('display', 'none');
            $('#dropzone-att').css('border', 'solid 1px green');
            if (document.getElementsByName('imgFiles[]').length) {
              //$('#error_div').css('display', 'none');
            }
          })
          .on('success', function (file) {
            //var responseText = file.id // or however you would point to your assigned file ID here;
            //console.log(response); // console should show the ID you pointed to
            // do stuff with file.id ...
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
      }
      /*  submitHandler: function() {
            var spinner = $('#loader');
            spinner.show();
            return true;
         }  */
    };

    $(document).ready(function () {
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
        if (!document.getElementsByName('imgFiles[]').length) {
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
@endsection
