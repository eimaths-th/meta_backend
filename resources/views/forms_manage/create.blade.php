@extends ('layouts.form')

@section ('style')
  @include ('forms_manage.css')
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
  />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link
    rel="stylesheet"
    href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"
  />
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section ('content')
  <div id="loader-container" style="display: none">
    <div id="loader" class="spinner"></div>
    <p id="loading-message">Please wait, your request is being processed...</p>
  </div>
  {{-- <div id="loader"></div> --}}
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
            @if (isset($data->brand))
              <div
                class="show-image-brand-default"
                id="show-image-brand-default"
              >
                <img
                  class="card-img"
                  src="{{ asset('form_manage/brand/' . $data->brand) }}"
                  alt="..."
                  width="100%"
                  height="auto"
                />
              </div>
            @else
              <div
                class="show-image-brand-default"
                id="show-image-brand-default"
              ></div>
            @endif
          </div>
          <script>
            $(document).ready(function () {
              //show image brand
              $('#brand').on('change', function () {
                var file = this.files[0];
                if (file) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                    $('.show-image-brand-default')
                      .html(
                        '<img src="' +
                          e.target.result +
                          '" class=" my-3" alt="Preview" width="100%" height="auto">'
                      )
                      .show();
                  };
                  reader.readAsDataURL(file);
                }
              });
            });
          </script>
          <form
            id="infinite"
            method="POST"
            action="{{ route('form-manage.store') }}"
            enctype="multipart/form-data"
            {{-- onsubmit="return check_input();" --}}
          >
            <input
              type="hidden"
              name="form_id"
              id="form_id"
              value="{{ $data->id ?? '' }}"
            />
            <input
              type="hidden"
              name="form_route"
              id="form_route"
              value="{{ $form_route }}"
            />
            <input
              type="hidden"
              name="form_name"
              id="form_name"
              value="{{ $data->form_name }}"
            />
            <input
              type="hidden"
              name="referent_code"
              id="referent_code"
              value="{{ request()->referent_code }}"
            />
            <input
              type="hidden"
              name="sfield"
              id="sfield"
              value="{{ $data->sfield ?? '' }}"
            />
            @csrf
            <div class="card-body">
              <br />

              <div class="text-center">
                <h2 class="card-title form_header">
                  {{ $data->form_name }} {{
                    $data->title ??
                      ''
                  }}
                </h2>
                <p class="card-text form_sub_header">
                  <b>{{
                    $data->sub_title ??
                      ''
                  }}</b>
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

                @php
                  $fieldSettings = $data->field_settings ?? [];
                @endphp

                @if (!empty($fieldConfig))
                  <div class="card mb-4 shadow-sm">
                    <div class="card-header py-2">
                      <strong>Field visibility & validation</strong>
                    </div>
                    <div class="card-body p-0">
                      <div class="table-responsive">
                        <table class="table-sm mb-0 table align-middle">
                          <thead>
                            <tr>
                              <th>Field</th>
                              <th>Description</th>
                              <th class="text-center" style="width: 140px">
                                Enabled
                                <div>
                                  <label class="small mb-0">
                                    <input
                                      type="checkbox"
                                      id="toggle-all-enabled"
                                      class="form-check-input me-1"
                                    />
                                    Check all
                                  </label>
                                </div>
                              </th>
                              <th class="text-center" style="width: 140px">
                                Required
                                <div>
                                  <label class="small mb-0">
                                    <input
                                      type="checkbox"
                                      id="toggle-all-required"
                                      class="form-check-input me-1"
                                    />
                                    Check all
                                  </label>
                                </div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($fieldConfig as $fieldKey => $config)
                              @php
                                $settings = $fieldSettings[$fieldKey] ?? [
                                  'enabled' => $config['default_enabled'] ?? true,
                                  'required' => $config['default_required'] ?? false,
                                ];
                              @endphp
                              <tr>
                                <td>
                                  <strong>{{
                                    $config[
                                      'label'
                                    ]
                                  }}</strong>
                                </td>
                                <td class="text-muted small">
                                  {{
                                    $config['description'] ??
                                      ''
                                  }}
                                </td>
                                <td class="text-center">
                                  <input
                                    type="hidden"
                                    name="field_settings[{{ $fieldKey }}][enabled]"
                                    value="0"
                                  />
                                  <input
                                    type="checkbox"
                                    class="form-check-input field-toggle-enabled"
                                    data-field="{{ $fieldKey }}"
                                    data-field-enabled="{{ $fieldKey }}"
                                    name="field_settings[{{ $fieldKey }}][enabled]"
                                    value="1"
                                    {{
                                      $settings['enabled'] ?? true
                                        ? 'checked'
                                        : ''
                                    }}
                                  />
                                </td>
                                <td class="text-center">
                                  <input
                                    type="hidden"
                                    name="field_settings[{{ $fieldKey }}][required]"
                                    value="0"
                                  />
                                  <input
                                    type="checkbox"
                                    class="form-check-input field-toggle-required"
                                    data-field="{{ $fieldKey }}"
                                    data-field-required="{{ $fieldKey }}"
                                    name="field_settings[{{ $fieldKey }}][required]"
                                    value="1"
                                    {{
                                      $settings['required'] ?? false
                                        ? 'checked'
                                        : ''
                                    }}
                                  />
                                </td>
                              </tr>
                            @endforeach

                            {{-- Footer Visibility Control --}}
                            <tr
                              style="
                                background-color: #fff8f0;
                                border-top: 2px solid #ff8c42;
                              "
                            >
                              <td colspan="2">
                                <strong style="color: #d84315">
                                  <i class="fas fa-building"></i>
                                  Show Meta Knowledge Footer
                                </strong>
                                <br />
                                <small class="text-muted">
                                  Display company footer with logo and contact
                                  information
                                </small>
                              </td>
                              <td class="text-center">
                                <input
                                  type="hidden"
                                  name="show_footer"
                                  value="0"
                                />
                                <input
                                  type="checkbox"
                                  class="form-check-input"
                                  name="show_footer"
                                  value="1"
                                  {{
                                    $data->show_footer ?? true
                                      ? 'checked'
                                      : ''
                                  }}
                                />
                              </td>
                              <td class="text-center">
                                <span class="text-muted">-</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                @endif

                <div
                  class="alert alert-danger"
                  id="error_alert"
                  style="display: none"
                ></div>

                <div class="form-html" data-component="text" tabindex="0">
                  <p style="text-align: center">
                    <span style="color: #6351a2">
                      <strong>
                        <span style="text-decoration: underline">
                          {{
                            $data->head_title ??
                              ''
                          }}
                        </span>
                      </strong>
                    </span>
                  </p>

                  <div class="row">
                    <div class="col-md-6">
                      <p style="text-align: left">
                        <span style="color: #6351a2">
                          <label for="brand">
                            <strong>Form Name :</strong>
                          </label>

                          <input
                            type="text"
                            name="form_name"
                            id="form_name"
                            class="form-control"
                            value="{{ $data->form_name }}"
                            placeholder="Form Name"
                          />
                        </span>
                      </p>
                    </div>
                    <div class="col-md-6">
                      <p style="text-align: left">
                        <span style="color: #6351a2">
                          <label for="brand">
                            <strong>Title Form :</strong>
                          </label>

                          <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control"
                            value="{{ $data->title }}"
                            placeholder="Title Form"
                          />
                        </span>
                      </p>
                    </div>

                    <div class="col-md-6">
                      <p style="text-align: left">
                        <span style="color: #6351a2">
                          <label for="brand">
                            <strong>Sub Title Form :</strong>
                          </label>

                          <input
                            type="text"
                            name="sub_title"
                            id="sub_title"
                            class="form-control"
                            value="{{ $data->sub_title }}"
                            placeholder="Sub Title Form"
                          />
                        </span>
                      </p>
                    </div>

                    <div class="col-md-6">
                      <p style="text-align: left">
                        <span style="color: #6351a2">
                          <label for="brand">
                            <strong>Head Form :</strong>
                          </label>

                          <input
                            type="text"
                            name="head_title"
                            id="head_title"
                            class="form-control"
                            value="{{ $data->head_title }}"
                            placeholder="Head Title Form"
                          />
                        </span>
                      </p>
                    </div>

                    <div class="col-md-6">
                      <p style="text-align: left">
                        <span style="color: #6351a2">
                          <label for="brand">
                            <strong>Brand Image :</strong>
                          </label>

                          <input
                            type="file"
                            name="brand"
                            id="brand"
                            class="form-control"
                          />
                          @if (isset($data->brand))
                            <input
                              type="text"
                              name="oldBrand"
                              id="oldBrand"
                              value="{{ $data->brand }}"
                              hidden
                            />
                          @endif
                        </span>
                      </p>
                    </div>

                    <div class="row">
                      <p style="text-align: left">
                        <span style="color: #6351a2">
                          <label for="registration_date_label">รับสมัคร:</label>
                          <div class="col-md-3">
                            <input
                              type="text"
                              name="registration_date_label"
                              placeholder="รับสมัคร"
                              class="form-control col-md-2"
                              value="{{ $data->registration_date_label }}"
                            />
                          </div>
                          <div class="col-md-3">
                            {{--
                              <input type="text" name="registration_date"
                              class="form-control" placeholder="dd/mm/yyyy"
                              value="{{ $data->registration_date }}">
                            --}}
                          </div>
                        </span>
                      </p>
                    </div>
                    <div class="row">
                      <p style="text-align: left">
                        <span style="color: #6351a2">
                          <label for="ref_date_label">
                            Label วันที่อ้างอิง:
                          </label>
                          <div class="col-md-6">
                            <input
                              type="text"
                              name="ref_date_label"
                              id="ref_date_label"
                              placeholder="วันที่อ้างอิง"
                              class="form-control"
                              value="{{ $data->ref_date_label ?? '' }}"
                            />
                            <small class="text-muted">
                              Label นี้จะแสดงในฟอร์มสาธารณะ (Check "Enabled"
                              ในตารางด้านบนเพื่อให้ user กรอกวันที่อ้างอิง)
                            </small>
                          </div>
                        </span>
                      </p>
                    </div>
                  </div>
                  <p>
                    <span style="color: #6351a2">
                      <strong>สอบวันที่ :</strong>
                      &nbsp;
                      <div class="row">
                        <div class="col-md-3">
                          <input
                            type="text"
                            name="contest_date_label"
                            placeholder="สอบวันที่"
                            class="form-control col-md-2"
                            value="{{ $data->contest_date_label }}"
                          />
                        </div>
                        <div class="col-md-3">
                          <input
                            type="text"
                            name="contest_date"
                            id="contest_date"
                            class="form-control"
                            placeholder="MM/DD/YYYY - MM/DD/YYYY"
                            value="{{ $data->contest_date }}"
                            autocomplete="off"
                          />
                        </div>
                      </div>
                    </span>
                  </p>
                  <p>
                    <span style="color: #6351a2">
                      <strong>Registration Fee:&nbsp;</strong>
                      <br />
                      <div class="row">
                        <div class="col-md-3">
                          <input
                            type="text"
                            name="registration_fee_label"
                            placeholder="ค่าสมัคร"
                            class="form-control col-md-2"
                            value="{{ $data->registration_fee_label }}"
                          />
                        </div>
                        <div class="col-md-3"></div>
                      </div>
                      {{-- ค่าสมัครสอบพร้อมติว 1250 บาท --}}
                    </span>
                  </p>
                  <p>
                    <span style="color: #6351a2">
                      <b>
                        {{ $data->admission_criteria_text_label }} {{ $data->form_name }}
                      </b>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <div class="row">
                              <div class="col-lg-6">
                                <input
                                  type="text"
                                  name="admission_criteria_text_label"
                                  class="form-control col-lg-2"
                                  placeholder="{{ $data->admission_criteria_text_label }}"
                                  value="{{ $data->admission_criteria_text_label }}"
                                />
                              </div>
                              <div class="col-lg-6">
                                {{-- <label for="admission_criteria_text_label col-lg-1">{{ $data->form_name }}</label> --}}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br />

                      {{--
                        - หากเปิดเทอมไม่ครบ 3 เดือน (นับจากวันที่เปิดเทอม - วันสอบ)
                        ให้ใช้ระดับชั้นปีการศึกษาที่ผ่านมา<br>
                        - หากเปิดเทอมครบ 3 เดือน ให้ใช้ปีการศึกษาปัจจุบันเท่านั้น<br>
                        
                        <br><br>
                        ถ้าได้รับการร้องเรียนเรื่องระดับชั้นปีการศึกษาแล้วตรวจสอบพบทาง<br>
                        META Knowledge จะยึดตามเกณฑ์นี้<br>
                        หากไม่ปฏิบัติตามจะถูกตัดสิทธิ์ในการสอบ<br>
                        โดยสามารถตรวจสอบเทียบระดับชั้นปีการศึกษาจากเกณฑ์การเทียบระดับชั้น
                      --}}
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <textarea
                              name="admission_criteria_text"
                              id=""
                              cols="30"
                              rows="10"
                              class="form-control"
                              placeholder="{{ $data->admission_criteria_text_label }}"
                              >{{ $data->admission_criteria_text }}</textarea
                            >
                            {{-- <textarea type="text" name="admission_criteria_text" class="form-control" placeholder="{{ $data->admission_criteria_text }}" value="{{ $data->admission_criteria_text }}"></textarea> --}}
                            {{-- <textarea type="text" name="admission_criteria_text" class="form-control col-lg-2" placeholder="{{ $data->admission_criteria_text }}" value="{{ $data->admission_criteria_text }}"> --}}
                            {{-- <label for="admission_criteria_text col-lg-1">{{ $data->admission_criteria_text_label }}</label> --}}
                          </div>
                        </div>
                      </div>
                    </span>
                  </p>
                  <p>
                    <span style="color: #6351a2">
                      <b>
                        {{ $data->admission_criteria_image_label }} {{ $data->form_name }}
                      </b>
                      {{--  --}}
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <div class="row">
                              <div class="col-lg-8">
                                <input
                                  type="text"
                                  name="admission_criteria_image_label"
                                  class="form-control col-lg-2"
                                  placeholder="{{ $data->admission_criteria_image_label }}"
                                  value="{{ $data->admission_criteria_image_label }}"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <div class="row">
                              <div class="col-lg-12">
                                <input
                                  type="file"
                                  name="admission_criteria_image"
                                  id="admission_criteria_image"
                                  class="form-control col-lg-2"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- show image --}}

                      @if (isset($data->admission_criteria_image))
                        <input
                          type="text"
                          name="oldAdmissionCriteriaImage"
                          id="oldAdmissionCriteriaImage"
                          value="{{ $data->admission_criteria_image }}"
                          hidden
                        />
                        @php
                          $display = 'block';
                        @endphp
                      @else
                        @php
                          $display = 'none';
                        @endphp
                      @endif

                      <div
                        id="preview_admission_criteria_image"
                        class="text-center"
                        style="display: {{ $display }}"
                      >
                        @if (isset($data->admission_criteria_image))
                          <img
                            name="admission_criteria_image"
                            id="admission_criteria_image"
                            src="{{ asset('form_manage/admission_criteria_image/' . $data->admission_criteria_image) }}"
                            class="custom-image2 my-3"
                            alt="Image 2"
                            width="100%"
                            height="auto"
                          />
                        @endif

                        <button
                          type="button"
                          id="remove_admission_criteria_image"
                          class="btn btn-primary"
                        >
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                      <script>
                        $(document).ready(function () {
                          $('#admission_criteria_image').on(
                            'change',
                            function () {
                              var file = this.files[0];
                              if (file) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                  $('#preview_admission_criteria_image')
                                    .html(
                                      '<img src="' +
                                        e.target.result +
                                        '" class="custom-image2 my-3" alt="Preview" width="100%" height="auto">'
                                    )
                                    .show();
                                };
                                reader.readAsDataURL(file);
                              }
                            }
                          );
                          $('#remove_admission_criteria_image').on(
                            'click',
                            function () {
                              $('#preview_admission_criteria_image').hide();
                              $('#admission_criteria_image').val('');
                            }
                          );
                        });
                      </script>
                      <br />
                    </span>
                  </p>
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
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <label
                      style="padding-left: 20px"
                      class="form-label form-label-top form-label-auto"
                    >
                      Name (English) / ชื่อ (ภาษาอังกฤษ)
                      <span class="form-required">*</span>
                    </label>
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="student_first_name"
                      >
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="student_first_name"
                        id="student_first_name"
                        value="{{ $data->student_first_name }}"
                        maxlength="50"
                        minlength="2"
                        placeholder="{{ $data->student_first_name }}"
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
                    <label
                      style="padding-left: 20px"
                      class="form-label form-label-top form-label-auto"
                    >
                      Middle Name (English) / ชื่อกลาง (ภาษาอังกฤษ)
                    </label>
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="student_middle_name"
                      >
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="student_middle_name"
                        id="student_middle_name"
                        value="{{ $data->student_middle_name }}"
                        maxlength="50"
                        placeholder="{{ $data->student_middle_name }}"
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Middle Name
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <label
                      style="padding-left: 20px"
                      class="form-label form-label-top form-label-auto"
                    >
                      Last Name (English) / นามสกุล (ภาษาอังกฤษ)
                      <span class="form-required">*</span>
                    </label>
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
                        name="student_last_name"
                        id="student_last_name"
                        value="{{ $data->student_last_name }}"
                        maxlength="50"
                        minlength="2"
                        placeholder="{{ $data->student_last_name }}"
                        required
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Last Name
                      </label>
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
                        name="student_nick_name"
                        id="student_nick_name"
                        value="{{ $data->student_nick_name }}"
                        maxlength="50"
                        minlength="1"
                        placeholder="{{ $data->student_nick_name }}"
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
                        type="text"
                        class="form-control"
                        name="date_of_birth"
                        id="date_of_birth"
                        value="{{ $data->date_of_birth }}"
                        placeholder="{{ $data->date_of_birth }}"
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
                        for="student_school_name"
                      >
                        School name (English) / ชื่อโรงเรียน (ภาษาอังกฤษ)
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="student_school_name"
                        id="student_school_name"
                        value="{{ $data->student_school_name }}"
                        maxlength="100"
                        placeholder="{{ $data->student_school_name }}"
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
                  <div class="col-md-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="student_grade"
                      >
                        Grade / ระดับชั้น
                        <span class="form-required">*</span>
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control mb-3"
                        name="student_grade"
                        id="student_grade"
                        value="{{ $data->student_grade }}"
                        placeholder="{{ $data->student_grade }}"
                        required
                      />

                      <button
                        type="button"
                        id="addOptionGrade"
                        class="btn btn-primary btn-sm"
                      >
                        <i class="fa fa-plus"></i>
                        Add Grade
                      </button>
                      <button
                        type="button"
                        id="addMoreOptionGrade"
                        class="btn btn-success btn-sm"
                      >
                        <i class="fa fa-layer-group"></i>
                        Add more Grade
                      </button>
                      <button
                        type="button"
                        id="deleteAllOptionGrade"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="fa fa-trash-alt"></i>
                        Delete All Grades
                      </button>

                      <div id="options_grade" style="display: none"></div>

                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Grade
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
                  <div class="col-md-12">
                    <div class="card mb-3" style="border: 1px solid #17a2b8">
                      <div
                        class="card-header text-white"
                        style="background-color: #17a2b8"
                      >
                        <h5 class="mb-0">
                          <i class="fas fa-laptop-house"></i>
                          Exam Mode Configuration / ตั้งค่ารูปแบบการสอบ
                        </h5>
                      </div>
                      <div class="card-body">
                        <div class="form-check mb-3">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            name="enable_exam_mode"
                            id="enable_exam_mode"
                            value="1"
                            {{
                              $data->enable_exam_mode
                                ? 'checked'
                                : ''
                            }}
                          />
                          <label
                            class="form-check-label"
                            for="enable_exam_mode"
                          >
                            <strong>
                              Enable Exam Mode / เปิดใช้งานระบบเลือกรูปแบบการสอบ
                              (Online/Onsite)
                            </strong>
                          </label>
                        </div>

                        <div
                          id="exam_mode_limits_container"
                          style="
                            display: {{ $data->enable_exam_mode ? 'block' : 'none' }};
                          "
                        >
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Online Limit / จำนวนจำกัด Online:</label>
                                <input
                                  type="number"
                                  class="form-control"
                                  name="online_limit"
                                  value="{{ $data->online_limit }}"
                                  min="0"
                                  placeholder="ว่างไว้หากไม่จำกัด"
                                />
                                <small class="text-muted">
                                  จำนวนผู้สมัครปัจจุบัน: {{
                                    $data->online_registered ??
                                      0
                                  }}
                                </small>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Onsite Limit / จำนวนจำกัด Onsite:</label>
                                <input
                                  type="number"
                                  class="form-control"
                                  name="onsite_limit"
                                  value="{{ $data->onsite_limit }}"
                                  min="0"
                                  placeholder="ว่างไว้หากไม่จำกัด"
                                />
                                <small class="text-muted">
                                  จำนวนผู้สมัครปัจจุบัน: {{
                                    $data->onsite_registered ??
                                      0
                                  }}
                                </small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-row form-focus" data-field-input="package">
                  <div class="col-md-12">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="package_label"
                      >
                        Packages / แพคเกจในการสอบ
                        <span class="form-required">*</span>
                      </label>

                      <input
                        type="text"
                        class="form-control mb-3"
                        name="package"
                        id="package_label"
                        value="{{ $data->package }}"
                        placeholder="{{ $data->package }}"
                        data-no-validation="true"
                      />

                      {{-- Multi-select checkbox --}}

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-check form-group mb-3">
                            <input
                              type="hidden"
                              name="package_multiselect"
                              value="0"
                            />
                            <input
                              class="form-check-input"
                              type="checkbox"
                              name="package_multiselect"
                              id="package_multiselect"
                              value="1"
                              data-no-validation="true"
                              {{
                                $data->package_multiselect ?? false
                                  ? 'checked'
                                  : ''
                              }}
                            />
                            <label
                              class="form-check-label"
                              for="package_multiselect"
                            >
                              Enable Multi-Select / เปิดใช้งานการเลือกหลายแพคเกจ
                            </label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div
                            id="max_selection_container"
                            style="
                              display: {{ $data->package_multiselect ?? false ? 'block' : 'none' }};
                            "
                          >
                            <div class="form-group mb-3">
                              <label for="package_max_selection">
                                Maximum Selection / จำนวนสูงสุดที่เลือกได้
                              </label>
                              <input
                                type="number"
                                class="form-control"
                                name="package_max_selection"
                                id="package_max_selection"
                                min="1"
                                value="{{ $data->package_max_selection ?? '1' }}"
                                placeholder="Enter maximum number of selections"
                                data-no-validation="true"
                              />
                              <small class="form-text text-muted">
                                Leave empty for unlimited selections
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>

                      {{-- Max selection input --}}

                      {{-- add button add package --}}
                      <button
                        type="button"
                        id="addOptionPackage"
                        class="btn btn-primary btn-sm"
                      >
                        <i class="fa fa-plus"></i>
                        Add Package
                      </button>
                      <button
                        type="button"
                        id="deleteAllOptionPackage"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="fa fa-trash-alt"></i>
                        Delete All Packages
                      </button>
                      <div id="options_package" style="display: none"></div>

                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Packages
                      </label>
                      <div
                        class="form-error-message"
                        role="alert"
                        style="display: none !important"
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

                <div class="form-row form-focus">
                  <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="student_address"
                      >
                        Address / ที่อยู่ภาษาไทยสำหรับจัดส่งของรางวัล
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="student_address"
                        id="student_address"
                        value="{{ $data->student_address }}"
                        placeholder="{{ $data->student_address }}"
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
                        for="student_zip"
                      >
                        <div style="width: 270px"></div>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="student_zip"
                        id="student_zip"
                        value="{{ $data->student_zip }}"
                        placeholder="Zip Code / รหัสไปรษณีย์"
                        maxlength="150"
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
                        for="parent_name"
                      >
                        Parent's name / ชื่อและนามสกุลผู้ปกครอง
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        name="parent_name"
                        id="parent_name"
                        value="{{ $data->parent_name }}"
                        maxlength="100"
                        placeholder="Parent's name / ชื่อและนามสกุลผู้ปกครอง"
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
                        class="form-control"
                        name="parent_phone"
                        id="parent_phone"
                        value="{{ $data->parent_phone }}"
                        maxlength="20"
                        placeholder="Parent's phone number / เบอร์โทรศัพท์ผู้ปกครอง"
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
                        E-mail (กรุณาตรวจสอบที่อยู่อีเมลให้ถูกต้อง หากกรอกผิด
                        จะไม่สามารถส่งข้อมูลในการเข้าสอบได้)
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        class="form-control mb-2"
                        name="contact_email"
                        id="contact_email"
                        value="{{ $data->contact_email }}"
                        maxlength="70"
                        placeholder="Contact email / อีเมลติดต่อ"
                        required
                      />
                      {{--
                        <input type="text" class="form-control " name="contact_email_detail" id="contact_email_detail"
                        value="{{ $data->contact_email_detail }}" maxlength="70" placeholder="Contact email / อีเมลติดต่อ" required>
                      --}}
                      <textarea
                        name="contact_email_detail"
                        id="contact_email_detail"
                        class="form-control"
                        cols="30"
                        rows="5"
                        required
                        >{!! $data->contact_email_detail !!}</textarea
                      >
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
                        class="form-control mb-2"
                        name="student_photo"
                        id="student_photo"
                        value="{{ $data->student_photo }}"
                        maxlength="70"
                        placeholder="Student photo / รูปภาพผู้สมัคร"
                        required
                      />

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
                @php
                  $hasExistingPaymentImage =
                    isset($data->image_payment) && !empty($data->image_payment);
                @endphp

                <div
                  class="form-row form-focus col-md-6"
                  id="image-payment-wrapper"
                  data-field-input="image_payment"
                  @if ($hasExistingPaymentImage)
                    style="display: none !important"
                  @endif
                >
                  <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="image_payment"
                      >
                        Image Payment
                      </label>
                      <input
                        type="file"
                        class="form-control"
                        name="image_payment"
                        id="image_payment"
                        accept="image/*"
                      />
                      <label
                        class="form-sub-label"
                        style="min-height: 13px"
                        aria-hidden="false"
                      >
                        Upload payment QR code image (optional)
                      </label>
                    </div>
                  </div>
                </div>
                <br />
                @if ($hasExistingPaymentImage)
                  <input
                    type="text"
                    name="oldImagePayment"
                    id="oldImagePayment"
                    value="{{ $data->image_payment }}"
                    hidden
                  />
                @endif

                <div
                  id="preview_image_payment"
                  class="text-center"
                  data-field-related="image_payment"
                  style="
                    display: {{ $hasExistingPaymentImage ? 'block' : 'none' }};
                  "
                >
                  @if ($hasExistingPaymentImage)
                    <img
                      src="{{ asset('form_manage/payment/' . $data->image_payment) }}"
                      class="custom-image2 my-3"
                      alt="Payment Image"
                      width="100%"
                      height="auto"
                    />
                    <br />
                    <button
                      type="button"
                      id="remove_image_payment"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-times"></i>
                      Remove Image
                    </button>
                  @endif
                </div>
                <br />
                <script>
                  $(document).ready(function () {
                    // Check if there's an existing payment image
                    let oldImagePaymentEl =
                      document.getElementById('oldImagePayment');
                    let hasExistingImage =
                      oldImagePaymentEl && oldImagePaymentEl.value;
                    const $imagePaymentToggle = $(
                      '[data-field-enabled="image_payment"]'
                    );
                    const oldImagePaymentValue = oldImagePaymentEl.value;
                    console.log(
                      'oldImagePaymentValue : ',
                      oldImagePaymentValue
                    );
                    // console.log($oldImagePaymentEl);
                    function isImagePaymentEnabled() {
                      if ($imagePaymentToggle.length) {
                        return $imagePaymentToggle.is(':checked');
                      }
                      const $wrapper = $('#image-payment-wrapper');
                      return (
                        $wrapper.is(':visible') &&
                        $wrapper.css('display') !== 'none'
                      );
                    }

                    function syncPreviewWithFieldState() {
                      if (!isImagePaymentEnabled()) {
                        $('#preview_image_payment').hide();
                        return;
                      }

                      if (
                        hasExistingImage ||
                        $('#preview_image_payment').find('img').length
                      ) {
                        $('#preview_image_payment').show();
                      } else {
                        $('#preview_image_payment').hide();
                      }
                    }

                    function hideInputWrapper() {
                      $('#image-payment-wrapper').attr(
                        'style',
                        'display: none !important;'
                      );
                      $('#image-payment-wrapper').attr(
                        'data-field-visible',
                        '0'
                      );
                      $('#image_payment')
                        .prop('required', false)
                        .removeAttr('required');
                      syncPreviewWithFieldState();
                    }

                    function showInputWrapper() {
                      if (!isImagePaymentEnabled()) {
                        syncPreviewWithFieldState();
                        return;
                      }
                      $('#image-payment-wrapper').attr(
                        'style',
                        'display: block !important;'
                      );
                      $('#image-payment-wrapper').attr(
                        'data-field-visible',
                        '1'
                      );
                      $('#image_payment')
                        .prop('required', false)
                        .removeAttr('required');
                      $('#preview_image_payment').hide();
                    }

                    if (hasExistingImage) {
                      hideInputWrapper();
                    } else {
                      showInputWrapper();
                    }

                    // Re-apply after a short delay to override field toggle system
                    setTimeout(function () {
                      if (hasExistingImage) {
                        hideInputWrapper();
                      }
                      syncPreviewWithFieldState();
                    }, 100);

                    $imagePaymentToggle.on('change', function () {
                      syncPreviewWithFieldState();
                    });

                    $('#image_payment').on('change', function () {
                      var file = this.files[0];
                      if (file) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                          $('#preview_image_payment').html(
                            '<img src="' +
                              e.target.result +
                              '" class="custom-image2 my-3" alt="Preview" width="100%" height="auto"><br>' +
                              '<button type="button" id="remove_image_payment" class="btn btn-danger"><i class="fa fa-times"></i> Remove Image</button>'
                          );
                          hasExistingImage = true;
                          hideInputWrapper();

                          // Re-bind remove button
                          $('#remove_image_payment').on(
                            'click',
                            handleRemovePaymentImage
                          );
                        };
                        reader.readAsDataURL(file);
                      }
                    });

                    function handleRemovePaymentImage() {
                      $('#preview_image_payment').hide().html('');
                      $('#image_payment').val('');
                      if ($('#oldImagePayment').length) {
                        $('#oldImagePayment').val('');
                      }
                      hasExistingImage = false;
                      showInputWrapper();
                    }

                    $('#remove_image_payment').on(
                      'click',
                      handleRemovePaymentImage
                    );
                    syncPreviewWithFieldState();
                  });
                </script>

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
                        id="student_slip_photo"
                        name="student_slip_photo"
                        class="form-control"
                        value="{{ $data->student_slip_photo }}"
                        maxlength="70"
                        placeholder="Student slip photo / หลักฐานการชำระเงิน"
                        required
                      />
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
                <div class="form-row form-focus">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label
                        class="form-label form-label-top form-label-auto"
                        for="news"
                      >
                        ท่านทราบข่าวสารการจัดสอบ {{ $data->form_name }} จากช่องทางใด
                        <span class="form-required">*</span>
                      </label>
                      <input
                        type="text"
                        id="news"
                        name="news"
                        class="form-control"
                        value="{{ $data->news }}"
                        maxlength="70"
                        placeholder="News / ข่าวสาร"
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
            <div class="card-footer form-actions-footer text-center">
              <br />
              <div class="text-danger">
                <h3>{!! $data->text_warning !!}</h3>
                <textarea
                  name="text_warning"
                  id="text_warning"
                  class="form-control"
                  cols="30"
                  rows="3"
                  >{!! $data->text_warning !!}</textarea
                >
              </div>
              <br />
              <div class="text-danger">
                {!! $data->text_footer !!}
                <textarea
                  name="text_footer"
                  id="text_footer"
                  class="form-control"
                  cols="30"
                  rows="3"
                  >{!! $data->text_footer !!}</textarea
                >
              </div>
              <br />
              <div class="form-group form-check">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id=""
                  disabled
                  style="float: none; margin-right: 3px"
                />
                <label class="form-check-label" for="">
                  {!! $data->text_policy !!}
                </label>
              </div>
              <textarea
                name="text_policy"
                id="text_policy"
                class="form-control mb-5"
                cols="30"
                rows="3"
                >{!! $data->text_policy !!}</textarea
              >

              <!-- Footer Customization Section -->
              <div
                class="card mb-4 shadow-sm"
                style="border-left: 4px solid #ff6b35"
              >
                <div
                  class="card-header"
                  style="
                    background: linear-gradient(
                      135deg,
                      #fff8f0 0%,
                      #ffe0b2 100%
                    );
                  "
                >
                  <h5 class="mb-0" style="color: #d84315">
                    <i class="fas fa-edit"></i>
                    Footer Customization
                  </h5>
                  <small class="text-muted">
                    Customize the footer content that appears at the bottom of
                    the form
                  </small>
                </div>
                <div class="card-body">
                  <div class="row">
                    <!-- Column 1: Company Info -->
                    <div class="col-md-4 mb-3">
                      <h6 style="color: #d84315">
                        <i class="fas fa-building"></i>
                        Company Information
                      </h6>

                      <div class="mb-3">
                        <label class="form-label">
                          <strong>Company Name</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_company_name"
                          class="form-control"
                          value="{{ $data->footer_company_name ?? 'Meta Knowledge' }}"
                          placeholder="Meta Knowledge"
                        />
                      </div>

                      <div class="mb-3">
                        <label class="form-label">
                          <strong>Description Line 1</strong>
                        </label>
                        <textarea
                          name="footer_description_1"
                          class="form-control"
                          rows="2"
                          placeholder="ศูนย์รวมความรู้และการพัฒนาทักษะ"
                          >{{
                            $data->footer_description_1 ??
                              'ศูนย์รวมความรู้และการพัฒนาทักษะสำหรับนักเรียนและผู้ปกครอง'
                          }}</textarea
                        >
                      </div>

                      <div class="mb-3">
                        <label class="form-label">
                          <strong>Description Line 2</strong>
                        </label>
                        <textarea
                          name="footer_description_2"
                          class="form-control"
                          rows="2"
                          placeholder="พัฒนาศักยภาพ สร้างอนาคต"
                          >{{
                            $data->footer_description_2 ??
                              'พัฒนาศักยภาพ สร้างอนาคตที่ดีกว่า'
                          }}</textarea
                        >
                      </div>

                      <div class="mb-3">
                        <label class="form-label">
                          <strong>Logo Image</strong>
                        </label>
                        <input
                          type="file"
                          name="footer_logo"
                          class="form-control"
                          accept="image/*"
                        />
                        <small class="text-muted">
                          Current: {{
                            $data->footer_logo ??
                              'logo_meta.png'
                          }}
                        </small>
                        @if (isset($data->footer_logo))
                          <div class="mt-2">
                            <img
                              src="{{ asset('images/' . $data->footer_logo) }}"
                              alt="Footer Logo"
                              style="
                                max-width: 150px;
                                background: #333;
                                padding: 10px;
                                border-radius: 8px;
                              "
                            />
                          </div>
                        @endif
                      </div>
                    </div>

                    <!-- Column 2: About Us -->
                    <div class="col-md-4 mb-3">
                      <h6 style="color: #d84315">
                        <i class="fas fa-info-circle"></i>
                        About Us Section
                      </h6>

                      <div class="mb-3">
                        <label class="form-label">
                          <strong>Section Title</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_about_title"
                          class="form-control"
                          value="{{ $data->footer_about_title ?? 'เกี่ยวกับเรา' }}"
                          placeholder="เกี่ยวกับเรา"
                        />
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>Feature 1</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_feature_1"
                          class="form-control"
                          value="{{ $data->footer_feature_1 ?? 'ระบบสอบและแข่งขันออนไลน์' }}"
                          placeholder="ระบบสอบและแข่งขันออนไลน์"
                        />
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>Feature 2</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_feature_2"
                          class="form-control"
                          value="{{ $data->footer_feature_2 ?? 'หลักสูตรคุณภาพสำหรับทุกระดับชั้น' }}"
                          placeholder="หลักสูตรคุณภาพ"
                        />
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>Feature 3</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_feature_3"
                          class="form-control"
                          value="{{ $data->footer_feature_3 ?? 'พัฒนาทักษะเพื่อความสำเร็จ' }}"
                          placeholder="พัฒนาทักษะ"
                        />
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>Feature 4</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_feature_4"
                          class="form-control"
                          value="{{ $data->footer_feature_4 ?? 'ใบประกาศนียบัตรรับรอง' }}"
                          placeholder="ใบประกาศนียบัตร"
                        />
                      </div>
                    </div>

                    <!-- Column 3: Contact Info -->
                    <div class="col-md-4 mb-3">
                      <h6 style="color: #d84315">
                        <i class="fas fa-envelope"></i>
                        Contact Information
                      </h6>

                      <div class="mb-3">
                        <label class="form-label">
                          <strong>Section Title</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_contact_title"
                          class="form-control"
                          value="{{ $data->footer_contact_title ?? 'ติดต่อเรา' }}"
                          placeholder="ติดต่อเรา"
                        />
                      </div>

                      <div class="mb-2">
                        <label class="form-label"><strong>Phone</strong></label>
                        <input
                          type="text"
                          name="footer_phone"
                          class="form-control"
                          value="{{ $data->footer_phone ?? '02-XXX-XXXX' }}"
                          placeholder="02-XXX-XXXX"
                        />
                      </div>

                      <div class="mb-2">
                        <label class="form-label"><strong>Email</strong></label>
                        <input
                          type="email"
                          name="footer_email"
                          class="form-control"
                          value="{{ $data->footer_email ?? 'info@metaknowledge.com' }}"
                          placeholder="info@metaknowledge.com"
                        />
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>Address</strong>
                        </label>
                        <textarea
                          name="footer_address"
                          class="form-control"
                          rows="2"
                          placeholder="กรุงเทพมหานคร ประเทศไทย"
                          >{{
                            $data->footer_address ??
                              'กรุงเทพมหานคร ประเทศไทย'
                          }}</textarea
                        >
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>
                            <i class="fab fa-facebook"></i>
                            Facebook URL
                          </strong>
                        </label>
                        <input
                          type="url"
                          name="footer_facebook"
                          class="form-control"
                          value="{{ $data->footer_facebook ?? '' }}"
                          placeholder="https://facebook.com/yourpage"
                        />
                        <label class="form-label">
                          <small class="text-muted">
                            <span class="text-danger">*</span>
                            https://facebook.com/metaknowledge
                          </small>
                        </label>
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>
                            <i class="fab fa-line"></i>
                            Line URL
                          </strong>
                        </label>
                        <input
                          type="url"
                          name="footer_line"
                          class="form-control"
                          value="{{ $data->footer_line ?? '' }}"
                          placeholder="https://line.me/ti/p/@yourline"
                        />
                        <label class="form-label">
                          <small class="text-muted">
                            <span class="text-danger">*</span>
                            https://line.me/ti/p/
                            @yourline
                          </small>
                        </label>
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>
                            <i class="fab fa-instagram"></i>
                            Instagram URL
                          </strong>
                        </label>
                        <input
                          type="url"
                          name="footer_instagram"
                          class="form-control"
                          value="{{ $data->footer_instagram ?? '' }}"
                          placeholder="https://instagram.com/yourprofile"
                        />
                        <label class="form-label">
                          <small class="text-muted">
                            <span class="text-danger">*</span>
                            https://instagram.com/yourprofile
                          </small>
                        </label>
                      </div>

                      <div class="mb-2">
                        <label class="form-label">
                          <strong>
                            <i class="fab fa-youtube"></i>
                            YouTube URL
                          </strong>
                        </label>
                        <input
                          type="url"
                          name="footer_youtube"
                          class="form-control"
                          value="{{ $data->footer_youtube ?? '' }}"
                          placeholder="https://youtube.com/@yourchannel"
                        />
                        <label class="form-label">
                          <small class="text-muted">
                            <span class="text-danger">*</span>
                            https://youtube.com/
                            @yourchannel
                          </small>
                        </label>
                      </div>
                    </div>
                  </div>

                  <hr style="border-color: #ff8c42" />

                  <!-- Copyright Text -->
                  <div class="row">
                    <div class="col-12">
                      <h6 style="color: #d84315">
                        <i class="fas fa-copyright"></i>
                        Copyright Text
                      </h6>
                      <div class="mb-3">
                        <label class="form-label">
                          <strong>Copyright Message</strong>
                        </label>
                        <input
                          type="text"
                          name="footer_copyright"
                          class="form-control"
                          value="{{ $data->footer_copyright ?? 'Meta Knowledge. All Rights Reserved. | Empowering Education, Inspiring Excellence' }}"
                          placeholder="Company Name. All Rights Reserved."
                        />
                        <small class="text-muted">
                          Year will be added automatically (©)
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-submit-actions">
                <input
                  type="submit"
                  id="send_data"
                  class="btn btn-lg btn-primary"
                  value="Submit Application"
                />
                <button type="reset" class="btn btn-lg btn-primary">
                  Clear Form
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Meta Knowledge Footer (Preview) -->
  <footer class="meta-footer" style="margin-top: 2rem">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          @php
            $footerLogo = $data->footer_logo ?? 'logo_meta.png';
          @endphp

          <img
            src="{{ asset('images/' . $footerLogo) }}"
            alt="Footer Logo"
            class="footer-logo"
            style="
              max-width: 200px;
              margin-bottom: 1rem;
              filter: brightness(0) invert(1);
            "
          />
          <h4 style="font-weight: 700; margin-bottom: 1rem; color: #fff">
            {{
              $data->footer_company_name ??
                'Meta Knowledge'
            }}
          </h4>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            {{
              $data->footer_description_1 ??
                'ศูนย์รวมความรู้และการพัฒนาทักษะสำหรับนักเรียนและผู้ปกครอง'
            }}
          </p>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            {{
              $data->footer_description_2 ??
                'พัฒนาศักยภาพ สร้างอนาคตที่ดีกว่า'
            }}
          </p>
        </div>
        <div class="col-md-4 mb-4">
          <h4 style="font-weight: 700; margin-bottom: 1rem; color: #fff">
            <i class="fas fa-info-circle"></i>
            {{
              $data->footer_about_title ??
                'เกี่ยวกับเรา'
            }}
          </h4>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            <i class="fas fa-graduation-cap"></i>
            {{
              $data->footer_feature_1 ??
                'ระบบสอบและแข่งขันออนไลน์'
            }}
          </p>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            <i class="fas fa-book-reader"></i>
            {{
              $data->footer_feature_2 ??
                'หลักสูตรคุณภาพสำหรับทุกระดับชั้น'
            }}
          </p>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            <i class="fas fa-trophy"></i>
            {{
              $data->footer_feature_3 ??
                'พัฒนาทักษะเพื่อความสำเร็จ'
            }}
          </p>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            <i class="fas fa-certificate"></i>
            {{
              $data->footer_feature_4 ??
                'ใบประกาศนียบัตรรับรอง'
            }}
          </p>
        </div>
        <div class="col-md-4 mb-4">
          <h4 style="font-weight: 700; margin-bottom: 1rem; color: #fff">
            <i class="fas fa-envelope"></i>
            {{
              $data->footer_contact_title ??
                'ติดต่อเรา'
            }}
          </h4>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            <i class="fas fa-phone"></i>
            โทร: {{
              $data->footer_phone ??
                '02-XXX-XXXX'
            }}
          </p>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            <i class="fas fa-envelope"></i>
            Email: {{
              $data->footer_email ??
                'info@metaknowledge.com'
            }}
          </p>
          <p style="color: #bdc3c7; margin-bottom: 0.5rem">
            <i class="fas fa-map-marker-alt"></i>
            {{
              $data->footer_address ??
                'กรุงเทพมหานคร ประเทศไทย'
            }}
          </p>
          <div style="margin-top: 1rem">
            <a
              href="{{ $data->footer_facebook ?? '' }}"
              title="Facebook"
              style="
                color: white;
                font-size: 1.5rem;
                margin: 0 0.5rem;
                transition: all 0.3s ease;
              "
            >
              <i class="fab fa-facebook"></i>
            </a>
            <a
              href="{{ $data->footer_line ?? '' }}"
              title="Line"
              style="
                color: white;
                font-size: 1.5rem;
                margin: 0 0.5rem;
                transition: all 0.3s ease;
              "
            >
              <i class="fab fa-line"></i>
            </a>
            <a
              href="{{ $data->footer_instagram ?? '' }}"
              title="Instagram"
              style="
                color: white;
                font-size: 1.5rem;
                margin: 0 0.5rem;
                transition: all 0.3s ease;
              "
            >
              <i class="fab fa-instagram"></i>
            </a>
            <a
              href="{{ $data->footer_youtube ?? '' }}"
              title="YouTube"
              style="
                color: white;
                font-size: 1.5rem;
                margin: 0 0.5rem;
                transition: all 0.3s ease;
              "
            >
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>
      </div>
      <div
        style="
          border-top: 1px solid rgba(255, 255, 255, 0.1);
          padding-top: 1.5rem;
          margin-top: 2rem;
          text-align: center;
          color: #95a5a6;
        "
      >
        <p>
          &copy; {{ date('Y') }} {{
            $data->footer_copyright ??
              'Meta Knowledge. All Rights Reserved. | Empowering Education, Inspiring Excellence'
          }}
        </p>
      </div>
    </div>
  </footer>
  <style>
    /* Footer Styling for Create Page */
    .meta-footer {
      background: linear-gradient(135deg, #d84315 0%, #bf360c 100%);
      color: white;
      padding: 3rem 0 1.5rem 0;
      border-radius: 50px 50px 0 0;
      box-shadow: 0 -10px 30px rgba(216, 67, 21, 0.3);
    }

    .meta-footer a:hover {
      color: #ffb84d !important;
      transform: translateY(-3px);
    }
  </style>
  <script>
    window.fieldConfig = @json ($fieldConfig ?? []);
    window.initialFieldSettings = @json ($fieldSettings ?? []);
  </script>
  @include ('forms_manage.script')
  <script></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const contestDateInput = $('#contest_date');

      if (!contestDateInput.length || typeof contestDateInput.daterangepicker !== 'function') {
        return;
      }

      const dateFormat = 'MM/DD/YYYY';
      const parseDate = function (value) {
        const trimmedValue = (value || '').trim();
        const supportedFormats = ['MM/DD/YYYY', 'YYYY-MM-DD', 'DD/MM/YYYY'];
        const parsedDate = moment(trimmedValue, supportedFormats, true);

        return parsedDate.isValid() ? parsedDate : null;
      };
      const parseRange = function (value) {
        const dateParts = (value || '').split(/\s+-\s+/);
        const startDate = parseDate(dateParts[0]);
        const endDate = parseDate(dateParts[1] || dateParts[0]);

        if (!startDate) {
          return null;
        }

        return {
          startDate: startDate,
          endDate: endDate || startDate.clone()
        };
      };
      const selectedRange = parseRange(contestDateInput.val());
      const startDate = selectedRange ? selectedRange.startDate : moment();
      const endDate = selectedRange ? selectedRange.endDate : startDate.clone();

      contestDateInput.daterangepicker({
        autoUpdateInput: false,
        startDate: startDate,
        endDate: endDate,
        locale: {
          format: dateFormat,
          separator: ' - ',
          applyLabel: 'Apply',
          cancelLabel: 'Cancel'
        }
      });

      if (selectedRange && contestDateInput.val()) {
        contestDateInput.val(startDate.format(dateFormat) + ' - ' + endDate.format(dateFormat));
      }

      contestDateInput.on('apply.daterangepicker', function (event, picker) {
        $(this).val(
          picker.startDate.format(dateFormat) + ' - ' + picker.endDate.format(dateFormat)
        );
      });
    });

    let indexoptionPackage = 0;

    document
      .getElementById('addOptionPackage')
      .addEventListener('click', function () {
        indexoptionPackage++;
        document.getElementById('options_package').style.display = 'block';
        var option = document.createElement('div');
        option.classList.add(`option${indexoptionPackage}`, 'package-option');
        option.innerHTML = `
            <label>Option Package ${indexoptionPackage}</label>
            <div class="form-group border p-3 rounded mb-3 bg-light">
                <div class="row align-items-center mb-2">
                     <div class="col-md-12 mb-2">
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="optionPackage[${indexoptionPackage}][has_exam_mode]" value="0">
                            <input type="hidden" id="newOnlineLimit${indexoptionPackage}" name="optionPackage[${indexoptionPackage}][online_limit]" value="">
                            <input type="hidden" id="newOnsiteLimit${indexoptionPackage}" name="optionPackage[${indexoptionPackage}][onsite_limit]" value="">
                            <input type="checkbox" class="custom-control-input new-exam-mode-toggle" id="newHasExamMode${indexoptionPackage}" name="optionPackage[${indexoptionPackage}][has_exam_mode]" value="1" data-index="${indexoptionPackage}" data-no-validation="true">
                            <label class="custom-control-label" for="newHasExamMode${indexoptionPackage}">Enable Exam Mode Selection (Online/Onsite)</label>
                        </div>
                     </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="hidden" id="optionPackageId${indexoptionPackage}" name="optionPackage[${indexoptionPackage}][id]" value="">
                        <input type="number" class="form-control" id="packagePrice${indexoptionPackage}" name="optionPackage[${indexoptionPackage}][value]" placeholder="Option Value" data-no-validation="true">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="packageName${indexoptionPackage}" name="optionPackage[${indexoptionPackage}][name]" placeholder="Option Name" data-no-validation="true">
                    </div>
                    <div class="col-md-4">
                         <div class="row">
                            <div class="col-md-2">
                                <button type="button" onclick="createOptionPackage(${indexoptionPackage})" id="createPackageBtn${indexoptionPackage}" class="btn btn-primary btn-sm mt-1" title="บันทึกแพคเกจนี้">
                                    <i class="fa fa-save"></i>
                                </button>
                            </div>
                            <div class="col-md-2" id="linkGradeHidden${indexoptionPackage}" style="display: none;">
                                 <button type="button" onclick="linkGrade(0)" data-id="0" class="linkGrade btn btn-info btn-sm mt-1">
                                    <i class="fa fa-link"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" onclick="removeOptionPackage(${indexoptionPackage})" class="btn btn-danger btn-sm mt-1" title="ลบแพคเกจนี้">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('options_package').appendChild(option);
      });

    const deleteAllPackageButton = document.getElementById(
      'deleteAllOptionPackage'
    );

    function escapeDynamicAttribute(value) {
      return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    }

    if (deleteAllPackageButton) {
      deleteAllPackageButton.addEventListener('click', function () {
        deleteAllPackages();
      });
    }

    function showPackage(
      id,
      package,
      price,
      hasExamMode,
      onlineLimit,
      onsiteLimit,
      onlineRegistered,
      onsiteRegistered
    ) {
      indexoptionPackage++;
      getOptionPackage(
        indexoptionPackage,
        package,
        price,
        id,
        hasExamMode,
        onlineLimit,
        onsiteLimit,
        onlineRegistered,
        onsiteRegistered
      );
    }

    @if (isset($data->packages))
    @foreach ($data->packages as $index => $package)
    showPackage(
      @json($package->id),
      @json($package->package),
      @json($package->price),
      @json($package->has_exam_mode),
      @json($package->online_limit),
      @json($package->onsite_limit),
      @json($package->online_registered ?? 0),
      @json($package->onsite_registered ?? 0)
    );
    @endforeach
    @endif

    function getOptionPackage(
      index,
      package,
      price,
      id,
      hasExamMode,
      onlineLimit,
      onsiteLimit,
      onlineRegistered,
      onsiteRegistered
    ) {
      document.getElementById('options_package').style.display = 'block';
      let option = document.createElement('div');
      option.classList.add(`option${index}`, 'package-option');
      // Convert string '1'/'0' or boolean to checked attribute
      const isChecked =
        hasExamMode == 1 || hasExamMode == '1' || hasExamMode === true
          ? 'checked'
          : '';
      const safePackage = escapeDynamicAttribute(package);
      const safePrice = escapeDynamicAttribute(price);
      const safeOnlineLimit = escapeDynamicAttribute(onlineLimit);
      const safeOnsiteLimit = escapeDynamicAttribute(onsiteLimit);

      option.innerHTML = `
            <label>Option Package ${index}</label>
            <div class="form-group border p-3 rounded mb-3 bg-light">
                <div class="row align-items-center mb-2">
                     <div class="col-md-12 mb-2">
                        <div class="custom-control custom-switch">
                            <input type="hidden" name="optionPackage[${index}][has_exam_mode]" value="0">
                            <input type="hidden" id="onlineLimit${id}" name="optionPackage[${index}][online_limit]" value="${safeOnlineLimit}">
                            <input type="hidden" id="onsiteLimit${id}" name="optionPackage[${index}][onsite_limit]" value="${safeOnsiteLimit}">
                            <input type="checkbox" class="custom-control-input" id="hasExamModePackage${id}" name="optionPackage[${index}][has_exam_mode]" value="1" ${isChecked} onchange="togglePackageExamMode(${id})" data-no-validation="true">
                            <label class="custom-control-label" for="hasExamModePackage${id}">Enable Exam Mode Selection (Online/Onsite) for this package</label>
                        </div>
                     </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="hidden" id="optionPackageId${id}" name="optionPackage[${index}][id]" value="${id || ''}">
                        <input type="number" id="optionPackagePrice${id}" class="form-control" name="optionPackage[${index}][value]" placeholder="Option Value" value="${safePrice}" data-no-validation="true">
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="optionPackageName${id}" class="form-control" name="optionPackage[${index}][name]" placeholder="Option Name" value="${safePackage}" data-no-validation="true">
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" onclick="editOptionPackage(${id})" data-id="${id}" class="editOptionPackage btn btn-warning btn-sm mt-1">
                                    <i id="changeIconPackage${id}" class="fa fa-edit"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" onclick="linkGrade(${id})" data-id="${id}" class="linkGrade btn btn-info btn-sm mt-1">
                                    <i id="changeIcon${id}" class="fa fa-link"></i>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" onclick="deleteOptionPackage(${id}, ${index})" class="btn btn-danger btn-sm mt-1">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
      document.getElementById('options_package').appendChild(option);
    }

    function removeOptionPackage(index) {
      const container = document.getElementById('options_package');
      let optionDiv = container.querySelector(`.package-option.option${index}`);
      if (optionDiv) {
        optionDiv.remove();
      }
      // ถ้าไม่มี option เหลือ ให้ซ่อน container
      if (container.children.length === 0) {
        container.style.display = 'none';
      }
    }

    function deleteAllPackages() {
      const formId = document.getElementById('form_id').value;

      if (!formId) {
        Swal.fire({
          icon: 'error',
          title: 'ไม่พบ Form ID',
          text: 'กรุณาบันทึกฟอร์มก่อน',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#dc3545'
        });
        return;
      }

      const packageCount = document.querySelectorAll(
        '#options_package > div'
      ).length;

      if (packageCount === 0) {
        Swal.fire({
          icon: 'info',
          title: 'ไม่มีแพคเกจ',
          text: 'ไม่มีแพคเกจให้ลบ',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#6351a2'
        });
        return;
      }

      Swal.fire({
        title:
          '<div style="color: #dc3545;"><i class="fa fa-exclamation-triangle"></i> ยืนยันการลบ</div>',
        html: `
                <div style="padding: 15px;">
                    <p style="font-size: 16px; margin-bottom: 15px;">
                        คุณต้องการลบแพคเกจทั้งหมด <strong style="color: #dc3545;">${packageCount} รายการ</strong> ใช่หรือไม่?
                    </p>
                    <div style="background: #fff3cd; padding: 12px; border-radius: 6px; border-left: 4px solid #ffc107;">
                        <p style="margin: 0; font-size: 14px; color: #856404;">
                            <i class="fa fa-exclamation-circle"></i>
                            <strong>คำเตือน:</strong> การลบจะส่งผลต่อข้อมูลที่เชื่อมโยงกับแพคเกจเหล่านี้
                        </p>
                    </div>
                </div>
            `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-trash"></i> ลบทั้งหมด',
        cancelButtonText: '<i class="fa fa-times"></i> ยกเลิก',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
      }).then(result => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'กำลังลบแพคเกจ...',
            html: `<p>กำลังลบ ${packageCount} รายการ</p>`,
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          $.ajax({
            url: '{{
      route(
        'delete-all-packages',
      )
    }}',
            type: 'POST',
            data: {
              _token: '{{ csrf_token() }}',
              form_id: formId
            },
            success: function (response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'สำเร็จ!',
                  html: `<p>ลบแพคเกจ <strong>${response.deleted_count}</strong> รายการเรียบร้อยแล้ว</p>`,
                  confirmButtonText: 'ตกลง',
                  confirmButtonColor: '#28a745'
                }).then(() => {
                  const optionsContainer =
                    document.getElementById('options_package');
                  optionsContainer.innerHTML = '';
                  optionsContainer.style.display = 'none';
                  indexoptionPackage = 0;
                });
              }
            },
            error: function (xhr) {
              let errorMessage = 'ไม่สามารถลบแพคเกจได้';
              if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
              }

              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: errorMessage,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#dc3545'
              });
            }
          });
        }
      });
    }

    function ajaxErrorMessage(xhr, fallbackMessage) {
      const errors = xhr.responseJSON?.errors;
      if (errors) {
        const firstMessages = Object.values(errors)[0];
        if (Array.isArray(firstMessages) && firstMessages.length) {
          return firstMessages[0];
        }
      }

      return xhr.responseJSON?.message || fallbackMessage;
    }

    function editOptionPackage(packageId) {
      const nameInput = document.getElementById('optionPackageName' + packageId);
      const priceInput = document.getElementById('optionPackagePrice' + packageId);
      const icon = document.getElementById('changeIconPackage' + packageId);
      const editButton = icon?.closest('button');
      const value = nameInput?.value.trim() || '';
      const price = priceInput?.value.trim() || '';
      const formId = document.getElementById('form_id').value;
      const hasExamMode = document.getElementById('hasExamModePackage' + packageId)
        ?.checked
        ? 1
        : 0;
      const onlineLimit =
        document.getElementById('onlineLimit' + packageId)?.value || null;
      const onsiteLimit =
        document.getElementById('onsiteLimit' + packageId)?.value || null;

      if (!nameInput || !priceInput || !icon || !editButton) {
        Swal.fire('Error', 'Package controls were not found. Please reload the page.', 'error');
        return;
      }

      if (!value) {
        Swal.fire('Cannot save', 'Please enter a package name.', 'warning');
        nameInput.focus();
        return;
      }

      if (price === '' || Number.isNaN(Number(price)) || Number(price) < 0) {
        Swal.fire('Cannot save', 'Please enter a valid package price.', 'warning');
        priceInput.focus();
        return;
      }

      editButton.disabled = true;
      icon.classList.remove('fa-edit');
      icon.classList.add('fa-spinner', 'fa-spin');

      $.ajax({
        url: '{{
      route(
        'edit-option-package',
      )
    }}', //update option package
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          id: packageId,
          form_id: formId,
          value: value,
          price: price,
          has_exam_mode: hasExamMode,
          online_limit: onlineLimit,
          onsite_limit: onsiteLimit
        },
        success: function (response) {
          nameInput.value = response.data.package;
          priceInput.value = response.data.price;
          icon.classList.remove('fa-spinner', 'fa-spin');
          icon.classList.add('fa-check');
          editButton.classList.remove('btn-warning');
          editButton.classList.add('btn-success');

          toastr.success(response.message || 'Package updated successfully.');

          setTimeout(() => {
            icon.classList.remove('fa-check');
            icon.classList.add('fa-edit');
            editButton.classList.remove('btn-success');
            editButton.classList.add('btn-warning');
            editButton.disabled = false;
          }, 2000);
        },
        error: function (xhr) {
          icon.classList.remove('fa-spinner', 'fa-spin');
          icon.classList.add('fa-edit');
          editButton.disabled = false;

          Swal.fire({
            icon: 'error',
            title: 'Package was not updated',
            text: ajaxErrorMessage(xhr, 'Please reload the page and try again.')
          });
        }
      });
    }

    function deleteOptionPackage(id, index) {
      const formId = document.getElementById('form_id').value;

      $.ajax({
        url: '{{
      route(
        'delete-option-package',
      )
    }}', //delete option package
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          id: id,
          form_id: formId,
          index: index
        },
        success: function (response) {
          removeOptionPackage(response.index);
          toastr.success('Package deleted successfully.');
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Package was not deleted',
            text: ajaxErrorMessage(xhr, 'Please reload the page and try again.')
          });
        }
      });
    }

    // Toggle max selection input based on checkbox
    document
      .getElementById('package_multiselect')
      .addEventListener('change', function () {
        const maxSelectionContainer = document.getElementById(
          'max_selection_container'
        );
        const maxSelectionInput = document.getElementById('package_max_selection');

        if (this.checked) {
          maxSelectionContainer.style.display = 'block';
          // Don't add required, let it be optional
        } else {
          maxSelectionContainer.style.display = 'none';
          maxSelectionInput.value = '';
          // Remove required when hidden to prevent validation error
          maxSelectionInput.removeAttribute('required');
        }
      });

    // Prevent validation from adding required to package_multiselect checkbox and max_selection input
    document.addEventListener('DOMContentLoaded', function () {
      const packageMultiselectCheckbox = document.getElementById(
        'package_multiselect'
      );
      const packageMaxSelectionInput = document.getElementById(
        'package_max_selection'
      );

      // Handle checkbox
      if (packageMultiselectCheckbox) {
        // Remove required attribute if it gets added
        packageMultiselectCheckbox.removeAttribute('required');

        // Monitor for changes and remove required if added by other scripts
        const checkboxObserver = new MutationObserver(function (mutations) {
          mutations.forEach(function (mutation) {
            if (
              mutation.type === 'attributes' &&
              mutation.attributeName === 'required'
            ) {
              if (packageMultiselectCheckbox.hasAttribute('required')) {
                packageMultiselectCheckbox.removeAttribute('required');
              }
            }
          });
        });

        checkboxObserver.observe(packageMultiselectCheckbox, {
          attributes: true,
          attributeFilter: ['required']
        });
      }

      // Handle max selection input
      if (packageMaxSelectionInput) {
        // Remove required attribute if it gets added
        packageMaxSelectionInput.removeAttribute('required');

        // Monitor for changes and remove required if added by other scripts
        const inputObserver = new MutationObserver(function (mutations) {
          mutations.forEach(function (mutation) {
            if (
              mutation.type === 'attributes' &&
              mutation.attributeName === 'required'
            ) {
              if (packageMaxSelectionInput.hasAttribute('required')) {
                packageMaxSelectionInput.removeAttribute('required');
              }
            }
          });
        });

        inputObserver.observe(packageMaxSelectionInput, {
          attributes: true,
          attributeFilter: ['required']
        });
      }
    });
  </script>
  <script>
    let indexoption = 0;

    document
      .getElementById('addOptionGrade')
      .addEventListener('click', function () {
        indexoption++;
        addOptionGrade(indexoption, '');
      });

    document
      .getElementById('addMoreOptionGrade')
      .addEventListener('click', function () {
        showBulkGradeModal();
      });

    document
      .getElementById('deleteAllOptionGrade')
      .addEventListener('click', function () {
        deleteAllGrades();
      });

    function deleteAllGrades() {
      const formId = document.getElementById('form_id').value;

      if (!formId) {
        Swal.fire({
          icon: 'error',
          title: 'ไม่พบ Form ID',
          text: 'กรุณาบันทึกฟอร์มก่อน',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#dc3545'
        });
        return;
      }

      // Count grades to delete
      const gradeCount = document.querySelectorAll('#options_grade > div').length;

      if (gradeCount === 0) {
        Swal.fire({
          icon: 'info',
          title: 'ไม่มีระดับชั้น',
          text: 'ไม่มีระดับชั้นให้ลบ',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#6351a2'
        });
        return;
      }

      Swal.fire({
        title:
          '<div style="color: #dc3545;"><i class="fa fa-exclamation-triangle"></i> ยืนยันการลบ</div>',
        html: `
                <div style="padding: 15px;">
                    <p style="font-size: 16px; margin-bottom: 15px;">
                        คุณต้องการลบระดับชั้นทั้งหมด <strong style="color: #dc3545;">${gradeCount} รายการ</strong> ใช่หรือไม่?
                    </p>
                    <div style="background: #fff3cd; padding: 12px; border-radius: 6px; border-left: 4px solid #ffc107;">
                        <p style="margin: 0; font-size: 14px; color: #856404;">
                            <i class="fa fa-exclamation-circle"></i>
                            <strong>คำเตือน:</strong> การลบจะส่งผลต่อข้อมูลที่เชื่อมโยงกับระดับชั้นเหล่านี้
                        </p>
                    </div>
                </div>
            `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-trash"></i> ลบทั้งหมด',
        cancelButtonText: '<i class="fa fa-times"></i> ยกเลิก',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
      }).then(result => {
        if (result.isConfirmed) {
          // Show loading
          Swal.fire({
            title: 'กำลังลบระดับชั้น...',
            html: `<p>กำลังลบ ${gradeCount} รายการ</p>`,
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          $.ajax({
            url: '{{
      route(
        'delete-all-grades',
      )
    }}',
            type: 'POST',
            data: {
              _token: '{{ csrf_token() }}',
              form_id: formId
            },
            success: function (response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'สำเร็จ!',
                  html: `<p>ลบระดับชั้น <strong>${response.deleted_count}</strong> รายการเรียบร้อยแล้ว</p>`,
                  confirmButtonText: 'ตกลง',
                  confirmButtonColor: '#28a745'
                }).then(() => {
                  // Remove all grade options from UI
                  document.getElementById('options_grade').innerHTML = '';
                  document.getElementById('options_grade').style.display = 'none';
                  indexoption = 0;
                });
              }
            },
            error: function (xhr) {
              let errorMessage = 'ไม่สามารถลบระดับชั้นได้';
              if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
              }

              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: errorMessage,
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#dc3545'
              });
            }
          });
        }
      });
    }

    function showBulkGradeModal() {
      Swal.fire({
        title:
          '<div style="color: #6351a2; font-size: 22px;"><i class="fa fa-layer-group"></i> สร้างระดับชั้นหลายตัวพร้อมกัน</div>',
        html: `
                <div style="text-align: left; padding: 15px 20px;">
                    <div style="background: #e3f2fd; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #2196F3;">
                        <p style="margin: 0; font-size: 13px; line-height: 1.5;">
                            <i class="fa fa-info-circle" style="color: #2196F3; margin-right: 5px;"></i>
                            <strong>ตัวอย่าง:</strong> กรอก "ป." และจำนวน 6 จะได้ ป.1, ป.2, ป.3, ป.4, ป.5, ป.6
                        </p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="gradePrefix" style="font-weight: 600; margin-bottom: 8px; display: block;">
                            <i class="fa fa-text-width"></i> ข้อความนำหน้า (Prefix):
                        </label>
                        <input type="text" id="gradePrefix" class="swal2-input" placeholder="เช่น ป., ม., Grade "
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
                    </div>

                    <div class="form-group mb-3">
                        <label for="gradeCount" style="font-weight: 600; margin-bottom: 8px; display: block;">
                            <i class="fa fa-sort-numeric-up"></i> จำนวนระดับชั้น:
                        </label>
                        <input type="number" id="gradeCount" class="swal2-input" placeholder="เช่น 6" min="1" max="20"
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px;">
                    </div>

                    <div id="gradePreview" style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-top: 15px; display: none;">
                        <p style="margin: 0 0 8px 0; font-weight: 600; color: #333;">
                            <i class="fa fa-eye"></i> ตัวอย่างที่จะสร้าง:
                        </p>
                        <div id="gradePreviewList" style="max-height: 150px; overflow-y: auto; font-size: 14px; color: #666;"></div>
                    </div>
                </div>
            `,
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-save"></i> สร้างทั้งหมด',
        cancelButtonText: '<i class="fa fa-times"></i> ยกเลิก',
        confirmButtonColor: '#6351a2',
        cancelButtonColor: '#6c757d',
        width: '600px',
        didOpen: () => {
          const prefixInput = document.getElementById('gradePrefix');
          const countInput = document.getElementById('gradeCount');
          const preview = document.getElementById('gradePreview');
          const previewList = document.getElementById('gradePreviewList');

          function updatePreview() {
            const prefix = prefixInput.value.trim();
            const count = parseInt(countInput.value);

            if (prefix && count > 0 && count <= 20) {
              let previewHTML = '';
              for (let i = 1; i <= count; i++) {
                previewHTML += `<span style="display: inline-block; background: #6351a2; color: white; padding: 4px 10px; margin: 3px; border-radius: 4px; font-size: 13px;">${prefix}${i}</span>`;
              }
              previewList.innerHTML = previewHTML;
              preview.style.display = 'block';
            } else {
              preview.style.display = 'none';
            }
          }

          prefixInput.addEventListener('input', updatePreview);
          countInput.addEventListener('input', updatePreview);
        },
        preConfirm: () => {
          const prefix = document.getElementById('gradePrefix').value.trim();
          const count = parseInt(document.getElementById('gradeCount').value);

          if (!prefix) {
            Swal.showValidationMessage('กรุณากรอกข้อความนำหน้า');
            return false;
          }

          if (!count || count < 1 || count > 20) {
            Swal.showValidationMessage('กรุณากรอกจำนวน 1-20');
            return false;
          }

          return {
            prefix,
            count
          };
        }
      }).then(result => {
        if (result.isConfirmed) {
          createBulkGrades(result.value.prefix, result.value.count);
        }
      });
    }

    function createBulkGrades(prefix, count) {
      const formId = document.getElementById('form_id').value;

      if (!formId) {
        Swal.fire({
          icon: 'error',
          title: 'ไม่พบ Form ID',
          text: 'กรุณาบันทึกฟอร์มก่อนเพิ่มระดับชั้น',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#dc3545'
        });
        return;
      }

      // Show loading
      Swal.fire({
        title: 'กำลังสร้างระดับชั้น...',
        html: `<p>กำลังสร้าง ${count} ระดับชั้น</p>`,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Create grades array
      const grades = [];
      for (let i = 1; i <= count; i++) {
        grades.push(`${prefix} ${i}`);
      }

      // Send to backend
      $.ajax({
        url: '{{
      route(
        'create-bulk-grades',
      )
    }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          form_id: formId,
          grades: grades
        },
        success: function (response) {
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              html: `<p>สร้างระดับชั้น <strong>${response.created_count}</strong> รายการเรียบร้อยแล้ว</p>`,
              confirmButtonText: 'ตกลง',
              confirmButtonColor: '#6351a2'
            }).then(() => {
              // Add created grades to UI
              response.grades.forEach((grade, idx) => {
                indexoption++;
                addBulkOptionGrade(indexoption, grade.grade, grade.id);
              });
            });
          }
        },
        error: function (xhr) {
          let errorMessage = 'ไม่สามารถสร้างระดับชั้นได้';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: errorMessage,
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    }

    function addOptionGrade(index, value, gradeId = null) {
      document.getElementById('options_grade').style.display = 'block';
      let option = document.createElement('div');
      option.classList.add(`option${index}`, 'grade-option');
      option.setAttribute('data-grade-id', gradeId || '');
      const safeValue = escapeDynamicAttribute(value);
      option.innerHTML = `
        <label>Option Grade ${index}</label>
        <div class="form-group">
            <div class="row">
                <div class="col-md-8">
                    <input type="hidden" id="optionGradeId${gradeId}" name="optionGrade[${index}][id]" value="${gradeId || ''}">
                    <input type="text" class="form-control" name="optionGrade[${index}][grade]" id="gradeInput${index}" value="${safeValue}" data-grade-id="${gradeId || ''}">
                </div>
                <div class="row col-md-4">
                    <div class="col-md-2">
                        <button type="button" onclick="createOptionGrade(${index})" id="createBtn${index}" class="btn btn-primary btn-sm mt-1" title="บันทึกระดับชั้นนี้">
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" onclick="removeOptionGrade(${index})" class="btn btn-danger btn-sm mt-1" title="ลบระดับชั้นนี้">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
      document.getElementById('options_grade').appendChild(option);
    }

    function addBulkOptionGrade(index, value, gradeId) {
      document.getElementById('options_grade').style.display = 'block';
      let option = document.createElement('div');
      option.classList.add(`option${index}`, 'grade-option');
      option.setAttribute('data-grade-id', gradeId);
      const safeValue = escapeDynamicAttribute(value);
      option.innerHTML = `
        <label>Option Grade ${index}</label>
        <div class="form-group">
            <div class="row">
                <div class="col-md-8">
                    <input type="hidden" id="optionGradeId${gradeId}" name="optionGrade[${index}][id]" value="${gradeId || ''}">
                    <input type="text" class="form-control" name="optionGrade[${index}][grade]" id="optionGrade${gradeId}" value="${safeValue}" data-grade-id="${gradeId || ''}">
                </div>
                <div class="row col-md-4">
                    <div class="col-md-2">
                            <button type="button" onclick="editOptionGrade(${gradeId})" data-id="${gradeId}" class="editOptionGrade btn btn-warning btn-sm mt-1">
                                <i id="changeIcon${gradeId}" class="fa fa-edit"></i>
                            </button>
                        </div>
                    <div class="col-md-2">
                        <button type="button" onclick="deleteOptionGrade(${gradeId}, ${index})" class="btn btn-danger btn-sm mt-1" title="ลบระดับชั้นนี้">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
      document.getElementById('options_grade').appendChild(option);
    }

    function removeOptionGrade(index) {
      const container = document.getElementById('options_grade');
      let optionDiv = container.querySelector(`.grade-option.option${index}`);
      if (optionDiv) optionDiv.remove();

      if (container.children.length === 0) {
        container.style.display = 'none';
      }
    }

    function createOptionGrade(index) {
      const gradeInput = document.getElementById('gradeInput' + index);
      const gradeName = gradeInput.value.trim();
      const formId = document.getElementById('form_id').value;
      const createBtn = document.getElementById('createBtn' + index);
      const btnIcon = createBtn.querySelector('i');

      if (!gradeName) {
        Swal.fire({
          icon: 'warning',
          title: 'กรุณากรอกชื่อระดับชั้น',
          text: 'โปรดระบุชื่อระดับชั้นก่อนบันทึก',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#6351a2'
        });
        return;
      }

      if (!formId) {
        Swal.fire({
          icon: 'error',
          title: 'ไม่พบ Form ID',
          text: 'กรุณาบันทึกฟอร์มก่อนเพิ่มระดับชั้น',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#dc3545'
        });
        return;
      }

      // Disable button and show loading
      createBtn.disabled = true;
      btnIcon.classList.remove('fa-save');
      btnIcon.classList.add('fa-spinner', 'fa-spin');

      $.ajax({
        url: '{{
      route(
        'create-option-grade',
      )
    }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          form_id: formId,
          grade_name: gradeName
        },
        success: function (response) {
          if (response.success) {
            // Update input with grade ID
            gradeInput.setAttribute('data-grade-id', response.grade_id);

            // Update hidden input with the new grade ID
            const hiddenInput =
              document.getElementById('optionGradeId' + index) ||
              document.querySelector(
                `.option${index} input[name="optionGrade[${index}][id]"]`
              );
            if (hiddenInput) {
              hiddenInput.value = response.grade_id;
            }

            // Change icon to check
            btnIcon.classList.remove('fa-spinner', 'fa-spin');
            btnIcon.classList.add('fa-check');
            createBtn.classList.remove('btn-primary');
            createBtn.classList.add('btn-success');

            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              html: `<p>บันทึกระดับชั้น <strong>${gradeName}</strong> เรียบร้อยแล้ว</p>`,
              timer: 2000,
              showConfirmButton: false
            });

            // Change to edit mode after 2 seconds
            setTimeout(() => {
              btnIcon.classList.remove('fa-check');
              btnIcon.classList.add('fa-edit');
              createBtn.classList.remove('btn-success', 'btn-primary');
              createBtn.classList.add('btn-warning');
              createBtn.setAttribute('title', 'แก้ไขระดับชั้นนี้');
              createBtn.setAttribute(
                'onclick',
                `editOptionGrade(${response.grade_id}, ${index})`
              );
              createBtn.disabled = false;

              const deleteBtn = createBtn
                .closest('.grade-option')
                ?.querySelector('.btn-danger');
              if (deleteBtn) {
                deleteBtn.setAttribute(
                  'onclick',
                  `deleteOptionGrade(${response.grade_id}, ${index})`
                );
              }
            }, 2000);
          }
        },
        error: function (xhr) {
          btnIcon.classList.remove('fa-spinner', 'fa-spin');
          btnIcon.classList.add('fa-save');
          createBtn.disabled = false;

          let errorMessage = 'ไม่สามารถบันทึกระดับชั้นได้';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: errorMessage,
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    }

    function createOptionPackage(index) {
      const packageNameInput = document.getElementById('packageName' + index);
      const packagePriceInput = document.getElementById('packagePrice' + index);
      const packageName = packageNameInput.value.trim();
      const packagePrice = packagePriceInput.value.trim();
      const formId = document.getElementById('form_id').value;
      const createBtn = document.getElementById('createPackageBtn' + index);
      const btnIcon = createBtn.querySelector('i');

      if (!packageName) {
        Swal.fire({
          icon: 'warning',
          title: 'กรุณากรอกชื่อแพคเกจ',
          text: 'โปรดระบุชื่อแพคเกจก่อนบันทึก',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#6351a2'
        });
        return;
      }

      if (!packagePrice) {
        Swal.fire({
          icon: 'warning',
          title: 'กรุณากรอกราคา',
          text: 'โปรดระบุราคาแพคเกจก่อนบันทึก',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#6351a2'
        });
        return;
      }

      if (!formId) {
        Swal.fire({
          icon: 'error',
          title: 'ไม่พบ Form ID',
          text: 'กรุณาบันทึกฟอร์มก่อนเพิ่มแพคเกจ',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#dc3545'
        });
        return;
      }

      // Disable button and show loading
      createBtn.disabled = true;
      btnIcon.classList.remove('fa-save');
      btnIcon.classList.add('fa-spinner', 'fa-spin');

      const hasExamMode = document.getElementById('newHasExamMode' + index)?.checked
        ? 1
        : 0;
      const onlineLimit =
        document.getElementById('newOnlineLimit' + index)?.value || null;
      const onsiteLimit =
        document.getElementById('newOnsiteLimit' + index)?.value || null;

      if (!packageName) {
        // ... (validation code omitted for brevity, keeping original flow) ...
      }

      // ...

      $.ajax({
        url: '{{
      route(
        'create-option-package',
      )
    }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          form_id: formId,
          package_name: packageName,
          package_price: packagePrice,
          has_exam_mode: hasExamMode,
          online_limit: onlineLimit,
          onsite_limit: onsiteLimit
        },
        success: function (response) {
          if (response.success) {
            // Update hidden input with the new package ID
            const hiddenInput =
              document.getElementById('optionPackageId' + index) ||
              document.querySelector(
                `.option${index} input[name="optionPackage[${index}][id]"]`
              );
            if (hiddenInput) {
              hiddenInput.value = response.package_id;
              hiddenInput.id = 'optionPackageId' + response.package_id;
            }

            // Update input IDs to use package_id instead of index
            packageNameInput.id = 'optionPackageName' + response.package_id;
            packagePriceInput.id = 'optionPackagePrice' + response.package_id;

            const examModeInput = document.getElementById('newHasExamMode' + index);
            if (examModeInput) {
              const examModeLabel = document.querySelector(
                `label[for="newHasExamMode${index}"]`
              );
              examModeInput.id = 'hasExamModePackage' + response.package_id;
              examModeInput.setAttribute(
                'onchange',
                `togglePackageExamMode(${response.package_id})`
              );
              if (examModeLabel) {
                examModeLabel.htmlFor = examModeInput.id;
              }
            }

            const newOnlineLimit = document.getElementById('newOnlineLimit' + index);
            const newOnsiteLimit = document.getElementById('newOnsiteLimit' + index);
            if (newOnlineLimit) {
              newOnlineLimit.id = 'onlineLimit' + response.package_id;
            }
            if (newOnsiteLimit) {
              newOnsiteLimit.id = 'onsiteLimit' + response.package_id;
            }

            // Change icon to check
            btnIcon.classList.remove('fa-spinner', 'fa-spin');
            btnIcon.classList.add('fa-check');
            createBtn.classList.remove('btn-primary');
            createBtn.classList.add('btn-success');

            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              html: `<p>บันทึกแพคเกจ <strong>${packageName}</strong> เรียบร้อยแล้ว</p>`,
              timer: 2000,
              showConfirmButton: false
            });

            // Change to edit mode after 2 seconds
            setTimeout(() => {
              btnIcon.classList.remove('fa-check');
              btnIcon.classList.add('fa-edit');
              btnIcon.id = 'changeIconPackage' + response.package_id;
              createBtn.classList.remove('btn-success', 'btn-primary');
              createBtn.classList.add('btn-warning');
              createBtn.classList.add('editOptionPackage');
              createBtn.setAttribute('title', 'แก้ไขแพคเกจนี้');
              createBtn.setAttribute(
                'onclick',
                `editOptionPackage(${response.package_id})`
              );
              createBtn.id = 'editPackageBtn' + response.package_id;
              createBtn.disabled = false;

              const deleteBtn = createBtn
                .closest('.package-option')
                ?.querySelector('.btn-danger');
              if (deleteBtn) {
                deleteBtn.setAttribute(
                  'onclick',
                  `deleteOptionPackage(${response.package_id}, ${index})`
                );
              }

              // Show and update linkGrade button
              const linkGradeBtn = document.getElementById(
                'linkGradeHidden' + index
              );
              if (linkGradeBtn) {
                linkGradeBtn.style.display = 'block';
                // Update the button's onclick to use the correct package_id
                const linkBtn = linkGradeBtn.querySelector('button');
                if (linkBtn) {
                  linkBtn.setAttribute(
                    'onclick',
                    `linkGrade(${response.package_id})`
                  );
                  linkBtn.setAttribute('data-id', response.package_id);
                }
              }
            }, 2000);
          }
        },
        error: function (xhr) {
          btnIcon.classList.remove('fa-spinner', 'fa-spin');
          btnIcon.classList.add('fa-save');
          createBtn.disabled = false;

          let errorMessage = 'ไม่สามารถบันทึกแพคเกจได้';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: errorMessage,
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    }

    function showGrade(valueGrade, id) {
      indexoption++;
      getOptionGrade(indexoption, valueGrade, id);
    }
    @if (isset($data->grades))
    @foreach ($data->grades as $index => $grade)
    showGrade(
      '{{ $grade->grade }}',
      '{{ $grade->id }}'
    );
    @endforeach
    @endif

    function getOptionGrade(index, value, id) {
      document.getElementById('options_grade').style.display = 'block';
      let option = document.createElement('div');
      option.classList.add(`option${index}`, 'grade-option');
      const safeValue = escapeDynamicAttribute(value);
      option.innerHTML = `
        <label>Option Grade ${index}</label>
        <div class="form-group">
            <div class="row">
                <div class="col-md-8">
                    <input type="hidden" id="optionGradeId${id}" name="optionGrade[${index}][id]" value="${id || ''}">
                    <input type="text" class="form-control" id="optionGrade${id}" name="optionGrade[${index}][grade]" value="${safeValue}">
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" onclick="editOptionGrade(${id})" data-id="${id}" class="editOptionGrade btn btn-warning btn-sm mt-1">
                                <i id="changeIcon${id}" class="fa fa-edit"></i>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" onclick="deleteOptionGrade(${id},${index})" data-id="${id}" class="removeOptionGrade btn btn-danger btn-sm mt-1">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
      document.getElementById('options_grade').appendChild(option);
    }

    let id;

    function editOptionGrade(gradeId, index) {
      // Try to find input by different ID patterns
      let gradeInput = document.getElementById('gradeInput' + index);
      if (!gradeInput) {
        gradeInput = document.getElementById('optionGrade' + gradeId);
      }

      if (!gradeInput) {
        console.error(
          'Grade input not found for gradeId:',
          gradeId,
          'index:',
          index
        );
        return;
      }

      const gradeName = gradeInput.value.trim();
      const formId = document.getElementById('form_id').value;

      // Try to find button by different ID patterns
      let createBtn = document.getElementById('createBtn' + index);
      let btnIcon;

      if (createBtn) {
        // New grade created with addOptionGrade
        btnIcon = createBtn.querySelector('i');
      } else {
        // Existing grade loaded with getOptionGrade
        btnIcon = document.getElementById('changeIcon' + gradeId);
        if (btnIcon) {
          createBtn = btnIcon.closest('button');
        }
      }

      if (!createBtn || !btnIcon) {
        console.error('Button not found for gradeId:', gradeId, 'index:', index);
        return;
      }

      if (!gradeName) {
        Swal.fire({
          icon: 'warning',
          title: 'กรุณากรอกชื่อระดับชั้น',
          text: 'โปรดระบุชื่อระดับชั้นก่อนบันทึก',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#6351a2'
        });
        return;
      }

      // Disable button and show loading
      createBtn.disabled = true;
      btnIcon.classList.remove('fa-edit');
      btnIcon.classList.add('fa-spinner', 'fa-spin');

      $.ajax({
        url: '{{
      route(
        'edit-option-grade',
      )
    }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          id: gradeId,
          form_id: formId,
          value: gradeName
        },
        success: function (response) {
          // Change icon to check
          btnIcon.classList.remove('fa-spinner', 'fa-spin');
          btnIcon.classList.add('fa-check');
          createBtn.classList.remove('btn-warning');
          createBtn.classList.add('btn-success');

          Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            html: `<p>แก้ไขระดับชั้น <strong>${gradeName}</strong> เรียบร้อยแล้ว</p>`,
            timer: 2000,
            showConfirmButton: false
          });

          // Revert to edit mode after 2 seconds
          setTimeout(() => {
            btnIcon.classList.remove('fa-check');
            btnIcon.classList.add('fa-edit');
            createBtn.classList.remove('btn-success');
            createBtn.classList.add('btn-warning');
            createBtn.disabled = false;
          }, 2000);
        },
        error: function (xhr) {
          btnIcon.classList.remove('fa-spinner', 'fa-spin');
          btnIcon.classList.add('fa-edit');
          createBtn.disabled = false;

          let errorMessage = 'ไม่สามารถแก้ไขระดับชั้นได้';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: errorMessage,
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    }

    function deleteOptionGrade(id, index) {
      const formId = document.getElementById('form_id').value;

      $.ajax({
        url: '{{
      route(
        'delete-option-grade',
      )
    }}', //delete option grade
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          id: id,
          form_id: formId,
          index: index
        },
        success: function (response) {
          removeOptionGrade(response.index);
          toastr.success('Grade deleted successfully.');
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Grade was not deleted',
            text: ajaxErrorMessage(xhr, 'Please reload the page and try again.')
          });
        }
      });
    }

    // Link Package with Grades functionality
    let currentPackageId = null;

    function linkGrade(packageId) {
      currentPackageId = packageId;
      const formId = document.getElementById('form_id').value;

      if (!formId) {
        Swal.fire({
          icon: 'warning',
          title: 'ไม่พบ Form ID',
          text: 'กรุณาบันทึกฟอร์มก่อนเชื่อมโยงระดับชั้น',
          confirmButtonText: 'ตกลง',
          confirmButtonColor: '#6351a2'
        });
        return;
      }

      // Fetch both package data and latest grades
      Promise.all([
        $.ajax({
          url: '{{
      route(
        'get-package-linked-grades',
      )
    }}',
          type: 'GET',
          data: {
            package_id: packageId
          }
        }),
        $.ajax({
          url: '{{
      route(
        'get-form-grades',
      )
    }}',
          type: 'GET',
          data: {
            form_id: formId
          }
        })
      ])
        .then(([packageResponse, gradesResponse]) => {
          if (packageResponse.status === 'success' && gradesResponse.success) {
            showLinkGradeModal(packageResponse.data, gradesResponse.grades);
          } else {
            throw new Error('Invalid response format');
          }
        })
        .catch(error => {
          console.error('Error loading data:', error);
          let errorMessage = 'ไม่สามารถโหลดข้อมูลได้';

          if (error.responseJSON && error.responseJSON.message) {
            errorMessage = error.responseJSON.message;
          } else if (error.statusText) {
            errorMessage = `เกิดข้อผิดพลาด: ${error.statusText}`;
          }

          Swal.fire({
            icon: 'error',
            title: '<span style="color: #dc3545;">เกิดข้อผิดพลาด</span>',
            html: `<p>${errorMessage}</p>`,
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#dc3545'
          });
        });
    }

    function showLinkGradeModal(packageData, gradeOptions) {
      const linkedGrades = packageData.linked_grades || [];

      let gradeCheckboxes = '';
      if (gradeOptions.length > 0) {
        gradeOptions.forEach(grade => {
          const isChecked = linkedGrades.includes(grade.id) ? 'checked' : '';
          gradeCheckboxes += `
                    <div class="form-check mb-2" style="padding: 8px 12px; border-radius: 6px; transition: background-color 0.2s;">
                        <input class="form-check-input grade-checkbox" type="checkbox"
                               value="${grade.id}" id="grade_${grade.id}" ${isChecked}
                               style="width: 18px; height: 18px; cursor: pointer; margin-left: 5px;">
                        <label class="form-check-label" for="grade_${grade.id}"
                               style="cursor: pointer; font-size: 15px; margin-left: 8px;">
                            ${grade.grade}
                        </label>
                    </div>
                `;
        });
      } else {
        gradeCheckboxes =
          '<p class="text-muted text-center"><i class="fa fa-exclamation-circle"></i> ยังไม่มีระดับชั้นในฟอร์มนี้ กรุณาเพิ่มระดับชั้นก่อน</p>';
      }

      Swal.fire({
        title: `<div style="color: #6351a2; font-size: 22px; margin-bottom: 10px;">
                        <i class="fa fa-link"></i> เชื่อมโยงระดับชั้นกับแพคเกจ
                    </div>`,
        html: `
                <div style="text-align: left; padding: 15px 20px;">
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <p style="margin: 0; font-size: 16px; color: #333;">
                            <strong>แพคเกจ:</strong> <span style="color: #6351a2;">${packageData.package_name}</span>
                        </p>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <p style="margin: 0; font-size: 15px; color: #333; font-weight: 600;">
                                <i class="fa fa-check-square" style="margin-right: 5px;"></i> เลือกระดับชั้นที่สามารถใช้แพคเกจนี้ได้:
                            </p>

                        </div>
                    </div>

                    <div style="background: #e3f2fd; padding: 12px 15px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #2196F3;">
                        <p style="margin: 0; font-size: 13px; line-height: 1.5;">
                            <i class="fa fa-info-circle" style="color: #2196F3; margin-right: 5px;"></i>
                            <strong>หมายเหตุ:</strong> หากไม่เลือกระดับชั้นใดๆ แพคเกจนี้จะสามารถใช้ได้กับทุกระดับชั้น
                        </p>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <button type="button" id="selectAllGrades" class="btn btn-sm" style="background: #28a745; color: white; border: none; padding: 5px 12px; border-radius: 4px; font-size: 13px; cursor: pointer;">
                            <i class="fa fa-check-double"></i> เลือกทั้งหมด
                        </button>
                        <button type="button" id="deselectAllGrades" class="btn btn-sm" style="background: #dc3545; color: white; border: none; padding: 5px 12px; border-radius: 4px; font-size: 13px; cursor: pointer;">
                            <i class="fa fa-times-circle"></i> ยกเลิกทั้งหมด
                        </button>
                    </div>

                    <div id="gradeCheckboxContainer" style="max-height: 300px; overflow-y: auto; padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; background: #fafafa;">
                        ${gradeCheckboxes}
                    </div>
                </div>
            `,
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-save"></i> บันทึก',
        cancelButtonText: '<i class="fa fa-times"></i> ยกเลิก',
        confirmButtonColor: '#6351a2',
        cancelButtonColor: '#6c757d',
        width: '550px',
        customClass: {
          confirmButton: 'btn btn-primary btn-lg',
          cancelButton: 'btn btn-secondary btn-lg'
        },
        preConfirm: () => {
          const selectedGrades = [];
          document.querySelectorAll('.grade-checkbox:checked').forEach(checkbox => {
            selectedGrades.push(parseInt(checkbox.value));
          });
          return selectedGrades;
        }
      }).then(result => {
        if (result.isConfirmed) {
          saveLinkGrades(currentPackageId, result.value);
        }
      });

      // Add hover effect to checkboxes
      setTimeout(() => {
        document.querySelectorAll('.form-check').forEach(item => {
          item.addEventListener('mouseenter', function () {
            this.style.backgroundColor = '#e8f4f8';
          });
          item.addEventListener('mouseleave', function () {
            this.style.backgroundColor = 'transparent';
          });
        });

        // Add event listeners for select/deselect all buttons
        const selectAllBtn = document.getElementById('selectAllGrades');
        const deselectAllBtn = document.getElementById('deselectAllGrades');

        if (selectAllBtn) {
          selectAllBtn.addEventListener('click', function () {
            document.querySelectorAll('.grade-checkbox').forEach(checkbox => {
              checkbox.checked = true;
            });
            // Add visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
              this.style.transform = 'scale(1)';
            }, 100);
          });
        }

        if (deselectAllBtn) {
          deselectAllBtn.addEventListener('click', function () {
            document.querySelectorAll('.grade-checkbox').forEach(checkbox => {
              checkbox.checked = false;
            });
            // Add visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
              this.style.transform = 'scale(1)';
            }, 100);
          });
        }

        // Add hover effects for buttons
        [selectAllBtn, deselectAllBtn].forEach(btn => {
          if (btn) {
            btn.addEventListener('mouseenter', function () {
              this.style.opacity = '0.9';
              this.style.transform = 'translateY(-1px)';
            });
            btn.addEventListener('mouseleave', function () {
              this.style.opacity = '1';
              this.style.transform = 'translateY(0)';
            });
          }
        });
      }, 100);
    }

    function saveLinkGrades(packageId, gradeIds) {
      $.ajax({
        url: '{{
      route(
        'link-package-grades',
      )
    }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          package_id: packageId,
          grade_ids: gradeIds.length > 0 ? gradeIds : null
        },
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: '<span style="color: #28a745;">สำเร็จ!</span>',
              html: '<p style="font-size: 16px;">บันทึกการเชื่อมโยงระดับชั้นเรียบร้อยแล้ว</p>',
              timer: 2000,
              showConfirmButton: false
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: '<span style="color: #dc3545;">เกิดข้อผิดพลาด</span>',
            html: '<p style="font-size: 16px;">ไม่สามารถบันทึกการเชื่อมโยงระดับชั้นได้</p>',
            confirmButtonText: 'ตกลง',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    }

    // Exam Mode Functions
    function togglePackageExamMode(packageId) {
      const isChecked = document.getElementById('hasExamModePackage' + packageId)
        .checked
        ? 1
        : 0;
      const toggleIcon = document.getElementById('hasExamModePackage' + packageId);
      const formId = document.getElementById('form_id').value;

      // Disable temporarily
      toggleIcon.disabled = true;

      $.ajax({
        url: '{{
      route(
        'update-package-exam-mode',
      )
    }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          package_id: packageId,
          form_id: formId,
          has_exam_mode: isChecked
        },
        success: function (response) {
          if (response.success) {
            toastr.success('อัพเดต Exam Mode สำเร็จ');
          } else {
            toastr.error('ไม่สามารถอัพเดตค่าได้');
            // Revert checkbox if failed
            toggleIcon.checked = !isChecked;
          }
        },
        error: function (xhr) {
          toastr.error(
            ajaxErrorMessage(xhr, 'Unable to update the package exam mode.')
          );
          toggleIcon.checked = !isChecked;
        },
        complete: function () {
          toggleIcon.disabled = false;
        }
      });
    }

    document.addEventListener('DOMContentLoaded', function () {
      // Toggle Form Level Limits Container
      const enableExamModeCheckbox = document.getElementById('enable_exam_mode');
      const limitsContainer = document.getElementById('exam_mode_limits_container');

      if (enableExamModeCheckbox && limitsContainer) {
        enableExamModeCheckbox.addEventListener('change', function () {
          if (this.checked) {
            limitsContainer.style.display = 'block';
            // Animation effect
            limitsContainer.style.opacity = 0;
            let opacity = 0;
            const timer = setInterval(function () {
              if (opacity >= 1) {
                clearInterval(timer);
              }
              limitsContainer.style.opacity = opacity;
              opacity += 0.1;
            }, 20);
          } else {
            limitsContainer.style.display = 'none';
          }
        });
      }
    });
  </script>
@endsection
