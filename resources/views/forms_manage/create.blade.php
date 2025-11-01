@extends('layouts.form')

@section('style')
    @include('forms_manage.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection


@section('content')
    <div id="loader-container" style="display: none;">
        <div id="loader" class="spinner"></div>
        <p id="loading-message">Please wait, your request is being processed...</p>
    </div>
    {{-- <div id="loader"></div> --}}
    <div class="error_div" id="error_div"><br>There are errors in this page. Please correct them before moving on.</div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card bg-light2 mb-3 ">
                    {{-- <div class="card-header">{{ __('Login') }}</div> --}}
                    <div align="center">
                        @if (isset($data->brand))
                            <div class="show-image-brand-default" id="show-image-brand-default">
                                <img class="card-img" src="{{ asset('form_manage/brand/' . $data->brand) }}" alt="..."
                                    width="100%" height="auto">
                            </div>
                        @else
                            <div class="show-image-brand-default" id="show-image-brand-default">

                            </div>
                        @endif
                    </div>
                    <script>
                        $(document).ready(function() {
                            //show image brand
                            $('#brand').on('change', function() {
                                var file = this.files[0];
                                if (file) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        $('.show-image-brand-default')
                                            .html('<img src="' + e.target.result +
                                                '" class=" my-3" alt="Preview" width="100%" height="auto">'
                                            )
                                            .show();
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        });
                    </script>
                    <form id="infinite" method="POST" action="{{ route('form-manage.store') }}"
                        enctype="multipart/form-data" {{-- onsubmit="return check_input();" --}}>
                        <input type="hidden" name="form_id" id="form_id" value="{{ $data->id ?? '' }}">
                        <input type="hidden" name="form_route" id="form_route" value="{{ $form_route }}">
                        <input type="hidden" name="form_name" id="form_name" value="{{ $data->form_name }}">
                        <input type="hidden" name="referent_code" id="referent_code"
                            value="{{ request()->referent_code }}">
                        <input type="hidden" name="sfield" id="sfield" value="{{ $data->sfield ?? '' }}">
                        @csrf
                        <div class="card-body">
                            <br>

                            <div class="text-center">

                                <h2 class="card-title form_header">{{ $data->form_name }} {{ $data->title ?? '' }} </h2>
                                <p class="card-text form_sub_header"><b>{{ $data->sub_title ?? '' }}</b></p>
                            </div>
                            <br>
                            <hr />

                            <div class="col-md-10 div_center" data-layout="full">
                                @if (session('warning'))
                                    <div class="alert alert-warning">
                                        {!! nl2br(e(session('warning'))) !!}
                                    </div>
                                @endif

                                @php
                                    $fieldSettings = $data->field_settings ?? [];
                                @endphp
                                @if (!empty($fieldConfig))
                                    <div class="card shadow-sm mb-4">
                                        <div class="card-header py-2">
                                            <strong>Field visibility & validation</strong>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-sm align-middle mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Field</th>
                                                            <th>Description</th>
                                                            <th class="text-center" style="width: 140px;">
                                                                Enabled
                                                                <div>
                                                                    <label class="mb-0 small">
                                                                        <input type="checkbox" id="toggle-all-enabled"
                                                                            class="form-check-input me-1">
                                                                        Check all
                                                                    </label>
                                                                </div>
                                                            </th>
                                                            <th class="text-center" style="width: 140px;">
                                                                Required
                                                                <div>
                                                                    <label class="mb-0 small">
                                                                        <input type="checkbox" id="toggle-all-required"
                                                                            class="form-check-input me-1">
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
                                                                    <strong>{{ $config['label'] }}</strong>
                                                                </td>
                                                                <td class="text-muted small">
                                                                    {{ $config['description'] ?? '' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="hidden"
                                                                        name="field_settings[{{ $fieldKey }}][enabled]"
                                                                        value="0">
                                                                    <input type="checkbox"
                                                                        class="form-check-input field-toggle-enabled"
                                                                        data-field="{{ $fieldKey }}"
                                                                        data-field-enabled="{{ $fieldKey }}"
                                                                        name="field_settings[{{ $fieldKey }}][enabled]"
                                                                        value="1"
                                                                        {{ $settings['enabled'] ?? true ? 'checked' : '' }}>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="hidden"
                                                                        name="field_settings[{{ $fieldKey }}][required]"
                                                                        value="0">
                                                                    <input type="checkbox"
                                                                        class="form-check-input field-toggle-required"
                                                                        data-field="{{ $fieldKey }}"
                                                                        data-field-required="{{ $fieldKey }}"
                                                                        name="field_settings[{{ $fieldKey }}][required]"
                                                                        value="1"
                                                                        {{ $settings['required'] ?? false ? 'checked' : '' }}>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="alert alert-danger" id="error_alert" style="display: none;">

                                </div>

                                <div class="form-html" data-component="text" tabindex="0">
                                    <p style="text-align: center;">
                                        <span style="color: #6351a2;">
                                            <strong>
                                                <span style="text-decoration: underline;">{{ $data->head_title ?? '' }}
                                                </span>
                                            </strong>
                                        </span>
                                    </p>


                                    <div class="row">

                                        <div class="col-md-6">
                                            <p style="text-align: left;">

                                                <span style="color: #6351a2;">
                                                    <label for="brand"><strong>Form Name : </strong></label>

                                                    <input type="text" name="form_name" id="form_name"
                                                        class="form-control" value="{{ $data->form_name }}"
                                                        placeholder="Form Name">
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p style="text-align: left;">

                                                <span style="color: #6351a2;">
                                                    <label for="brand"><strong>Title Form : </strong></label>

                                                    <input type="text" name="title" id="title"
                                                        class="form-control" value="{{ $data->title }}"
                                                        placeholder="Title Form">
                                                </span>
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <p style="text-align: left;">

                                                <span style="color: #6351a2;">
                                                    <label for="brand"><strong>Sub Title Form : </strong></label>

                                                    <input type="text" name="sub_title" id="sub_title"
                                                        class="form-control" value="{{ $data->sub_title }}"
                                                        placeholder="Sub Title Form">
                                                </span>
                                            </p>
                                        </div>


                                        <div class="col-md-6">
                                            <p style="text-align: left;">

                                                <span style="color: #6351a2;">
                                                    <label for="brand"><strong>Head Form : </strong></label>

                                                    <input type="text" name="head_title" id="head_title"
                                                        class="form-control" value="{{ $data->head_title }}"
                                                        placeholder="Head Title Form">
                                                </span>
                                            </p>
                                        </div>


                                        <div class="col-md-6">
                                            <p style="text-align: left;">
                                                <span style="color: #6351a2;">
                                                    <label for="brand"><strong>Brand Image : </strong></label>

                                                    <input type="file" name="brand" id="brand"
                                                        class="form-control">
                                                    @if (isset($data->brand))
                                                        <input type="text" name="oldBrand" id="oldBrand"
                                                            value="{{ $data->brand }}" hidden>
                                                    @endif
                                                </span>
                                            </p>
                                        </div>

                                        <div class="row">
                                            <p style="text-align: left;">
                                                <span style="color: #6351a2;">
                                                    <label for="registration_date_label">รับสมัคร:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="registration_date_label"
                                                            placeholder="รับสมัคร" class="form-control col-md-2"
                                                            value="{{ $data->registration_date_label }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        {{-- <input type="text" name="registration_date"
                                                            class="form-control" placeholder="dd/mm/yyyy"
                                                            value="{{ $data->registration_date }}"> --}}
                                                    </div>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p style="text-align: left;">
                                                <span style="color: #6351a2;">
                                                    <label for="ref_date_label">Label วันที่อ้างอิง:</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="ref_date_label" id="ref_date_label"
                                                            placeholder="วันที่อ้างอิง" class="form-control"
                                                            value="{{ $data->ref_date_label ?? '' }}">
                                                        <small class="text-muted">Label นี้จะแสดงในฟอร์มสาธารณะ (Check
                                                            "Enabled" ในตารางด้านบนเพื่อให้ user กรอกวันที่อ้างอิง)</small>
                                                    </div>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p>
                                        <span style="color: #6351a2;">
                                            <strong>สอบวันที่ :</strong>&nbsp;
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="text" name="contest_date_label"
                                                        placeholder="สอบวันที่" class="form-control col-md-2"
                                                        value="{{ $data->contest_date_label }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="contest_date" class="form-control"
                                                        placeholder="dd/mm/yyyy" value="{{ $data->contest_date }}">
                                                </div>
                                            </div>
                                        </span>
                                    </p>
                                    <p>
                                        <span style="color: #6351a2;">
                                            <strong>
                                                Registration Fee:&nbsp;
                                            </strong>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="text" name="registration_fee_label"
                                                        placeholder="ค่าสมัคร" class="form-control col-md-2"
                                                        value="{{ $data->registration_fee_label }}">
                                                </div>
                                                <div class="col-md-3">

                                                </div>
                                            </div>
                                            {{-- ค่าสมัครสอบพร้อมติว 1250 บาท --}}

                                        </span>
                                    </p>
                                    <p>
                                        <span style="color: #6351a2;">
                                            <b>{{ $data->admission_criteria_text_label }} {{ $data->form_name }}</b>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="text" name="admission_criteria_text_label"
                                                                    class="form-control col-lg-2"
                                                                    placeholder="{{ $data->admission_criteria_text_label }}"
                                                                    value="{{ $data->admission_criteria_text_label }}">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                {{-- <label for="admission_criteria_text_label col-lg-1">{{ $data->form_name }}</label> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            {{-- - หากเปิดเทอมไม่ครบ 3 เดือน (นับจากวันที่เปิดเทอม - วันสอบ)
                                            ให้ใช้ระดับชั้นปีการศึกษาที่ผ่านมา<br>
                                            - หากเปิดเทอมครบ 3 เดือน ให้ใช้ปีการศึกษาปัจจุบันเท่านั้น<br>

                                            <br><br>
                                            ถ้าได้รับการร้องเรียนเรื่องระดับชั้นปีการศึกษาแล้วตรวจสอบพบทาง<br>
                                            META Knowledge จะยึดตามเกณฑ์นี้<br>
                                            หากไม่ปฏิบัติตามจะถูกตัดสิทธิ์ในการสอบ<br>
                                            โดยสามารถตรวจสอบเทียบระดับชั้นปีการศึกษาจากเกณฑ์การเทียบระดับชั้น --}}
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <textarea name="admission_criteria_text" id="" cols="30" rows="10" class="form-control"
                                                            placeholder="{{ $data->admission_criteria_text_label }}">{{ $data->admission_criteria_text }}</textarea>
                                                        {{-- <textarea type="text" name="admission_criteria_text" class="form-control" placeholder="{{ $data->admission_criteria_text }}" value="{{ $data->admission_criteria_text }}"></textarea> --}}
                                                        {{-- <textarea type="text" name="admission_criteria_text" class="form-control col-lg-2" placeholder="{{ $data->admission_criteria_text }}" value="{{ $data->admission_criteria_text }}"> --}}
                                                        {{-- <label for="admission_criteria_text col-lg-1">{{ $data->admission_criteria_text_label }}</label> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </p>
                                    <p>
                                        <span style="color: #6351a2;"><b> {{ $data->admission_criteria_image_label }}
                                                {{ $data->form_name }}</b>
                                            {{--  --}}
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-8">
                                                                <input type="text"
                                                                    name="admission_criteria_image_label"
                                                                    class="form-control col-lg-2"
                                                                    placeholder="{{ $data->admission_criteria_image_label }}"
                                                                    value="{{ $data->admission_criteria_image_label }}">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="file" name="admission_criteria_image"
                                                                    id="admission_criteria_image"
                                                                    class="form-control col-lg-2">

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- show image --}}

                                            @if (isset($data->admission_criteria_image))
                                                <input type="text" name="oldAdmissionCriteriaImage"
                                                    id="oldAdmissionCriteriaImage"
                                                    value="{{ $data->admission_criteria_image }}" hidden>

                                                @php
                                                    $display = 'block';
                                                @endphp
                                            @else
                                                @php
                                                    $display = 'none';
                                                @endphp
                                            @endif

                                            <div id="preview_admission_criteria_image" class="text-center"
                                                style="display: {{ $display }};">

                                                @if (isset($data->admission_criteria_image))
                                                    <img name="admission_criteria_image" id="admission_criteria_image"
                                                        src="{{ asset('form_manage/admission_criteria_image/' . $data->admission_criteria_image) }}"
                                                        class="custom-image2 my-3" alt="Image 2" width="100%"
                                                        height="auto">
                                                @endif
                                                <button type="button" id="remove_admission_criteria_image"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#admission_criteria_image').on('change', function() {
                                                        var file = this.files[0];
                                                        if (file) {
                                                            var reader = new FileReader();
                                                            reader.onload = function(e) {
                                                                $('#preview_admission_criteria_image')
                                                                    .html('<img src="' + e.target.result +
                                                                        '" class="custom-image2 my-3" alt="Preview" width="100%" height="auto">'
                                                                    )
                                                                    .show();
                                                            };
                                                            reader.readAsDataURL(file);
                                                        }
                                                    });
                                                    $('#remove_admission_criteria_image').on('click', function() {
                                                        $('#preview_admission_criteria_image').hide();
                                                        $('#admission_criteria_image').val('');
                                                    });
                                                });
                                            </script>
                                            <br>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-11 div_center">

                                <div class="row mb-3 ">
                                    <label for="success" class="col-md-4 col-form-label text-md-end"></label>

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
                                        <label style="padding-left: 20px"
                                            class="form-label form-label-top form-label-auto">Name (English) /
                                            ชื่อ (ภาษาอังกฤษ) <span class="form-required">*</span></label>
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="student_first_name">
                                                <div style="width: 270px"></div>
                                            </label>
                                            <input type="text" class="form-control" name="student_first_name"
                                                id="student_first_name" value="{{ $data->student_first_name }}"
                                                maxlength="50" minlength="2"
                                                placeholder="{{ $data->student_first_name }}" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">First
                                                Name</label>
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
                                    <div class="col-md-6">
                                        <label style="padding-left: 20px"
                                            class="form-label form-label-top form-label-auto">Last Name (English) /
                                            นามสกุล (ภาษาอังกฤษ) <span class="form-required">*</span></label>
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto" for="lastname">
                                                <div style="width: 270px"></div>
                                            </label>
                                            <input type="text" class="form-control" name="student_last_name"
                                                id="student_last_name" value="{{ $data->student_last_name }}"
                                                maxlength="50" minlength="2"
                                                placeholder="{{ $data->student_last_name }}" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Last
                                                Name</label>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-row form-focus">

                                    <div class="col-md-6 col-sm-12">

                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="nickname">Nickname
                                                (English)/ ชื่อเล่น (ภาษาอังกฤษ) <span class="form-required">*</span>
                                                <div style="width: 270px"></div>
                                            </label>
                                            <input type="text" class="form-control" name="student_nick_name"
                                                id="student_nick_name" value="{{ $data->student_nick_name }}"
                                                maxlength="50" minlength="1"
                                                placeholder="{{ $data->student_nick_name }}" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Nick
                                                Name</label>
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
                                    <div class="col-md-6 col-sm-12">
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto" for="birthdate">Birth
                                                Date / วันเกิด <span class="form-required">*</span>
                                                <div style="width: 270px"></div>
                                            </label>
                                            <input type="text" class="form-control" name="date_of_birth"
                                                id="date_of_birth" value="{{ $data->date_of_birth }}"
                                                placeholder="{{ $data->date_of_birth }}" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Date</label>
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
                                </div>

                                <div class="form-row form-focus">

                                    <div class="col-md-6">

                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="student_school_name">School name (English) / ชื่อโรงเรียน
                                                (ภาษาอังกฤษ)<span class="form-required">*</span></label>
                                            <input type="text" class="form-control" name="student_school_name"
                                                id="student_school_name" value="{{ $data->student_school_name }}"
                                                maxlength="100" placeholder="{{ $data->student_school_name }}" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">School Name</label>
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
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="student_grade">Grade
                                                / ระดับชั้น <span class="form-required">*</span>
                                                <div style="width: 270px"></div>
                                            </label>
                                            <input type="text" class="form-control mb-3" name="student_grade"
                                                id="student_grade" value="{{ $data->student_grade }}"
                                                placeholder="{{ $data->student_grade }}" required>

                                            <button type="button" id="addOptionGrade" class="btn btn-primary btn-sm">Add
                                                Option</button>




                                            <div id="options_grade" style="display: none;">

                                            </div>



                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Grade</label>
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
                                </div>

                                <div class="form-row form-focus">

                                    <div class="col-md-12">

                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="package">Packages / แพคเกจในการสอบ <span
                                                    class="form-required">*</span></label>

                                            <input type="text" class="form-control mb-3" name="package"
                                                id="package" value="{{ $data->package }}"
                                                placeholder="{{ $data->package }}" required>

                                            {{-- add button add package --}}
                                            <button type="button" id="addOptionPackage"
                                                class="btn btn-primary btn-sm">Add
                                                Option</button>
                                            <div id="options_package" style="display: none;">

                                            </div>

                                            {{-- <select class="form-control" id="package" name="package"
                                                aria-label="แพคเกจในการสอบ / Packages" required>
                                                <option value="">Please Select</option>
                                                <option value="Test: 850 baht">Test: 850 baht</option>
                                                <option value="Test + tutoring class: 1250 bath">Test +
                                                    tutoring class: 1250 bath</option>
                                            </select> --}}
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Packages</label>
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
                                </div>

                                <div class="form-row form-focus">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="student_address">Address / ที่อยู่ภาษาไทยสำหรับจัดส่งของรางวัล <span
                                                    class="form-required">*</span></label>
                                            <input type="text" class="form-control" name="student_address"
                                                id="student_address" value="{{ $data->student_address }}"
                                                placeholder="{{ $data->student_address }}" maxlength="150"
                                                minlength="2" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Street Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label form-label-top form-label-auto" for="student_zip">
                                                <div style="width: 270px"></div>
                                            </label>
                                            <input type="text" class="form-control" name="student_zip"
                                                id="student_zip" value="{{ $data->student_zip }}"
                                                placeholder="Zip Code / รหัสไปรษณีย์" maxlength="150" minlength="2"
                                                required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Postal / Zip Code / รหัสไปรษณีย์ </label>
                                            <div class="form-error-message" role="alert"><img
                                                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                    height="10">
                                                <span class="error-navigation-message">This field is required.</span>
                                                <div class="form-error-arrow">
                                                    <div class="form-error-arrow-inner"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row form-focus">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group" style="padding-top:24px;">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="parent_name">Parent's name / ชื่อและนามสกุลผู้ปกครอง<span
                                                    class="form-required">*</span></label>
                                            <input type="text" class="form-control" name="parent_name"
                                                id="parent_name" value="{{ $data->parent_name }}" maxlength="100"
                                                placeholder="Parent's name / ชื่อและนามสกุลผู้ปกครอง" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Parent's name</label>
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
                                    <div class="col-md-6 col-sm-12">
                                        <div class="position-relative form-group" style="padding-top:24px;">
                                            <label class="form-label form-label-top form-label-auto" for="phone">Phone
                                                Number / เบอร์โทรศัพท์ <span class="form-required">*</span>
                                                <div style="width: 270px"></div>
                                            </label>
                                            <input type="text" class="form-control" name="parent_phone"
                                                id="parent_phone" value="{{ $data->parent_phone }}" maxlength="20"
                                                placeholder="Parent's phone number / เบอร์โทรศัพท์ผู้ปกครอง" required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Phone Number</label>
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

                                </div>
                                <div class="form-row form-focus">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="position-relative form-group" style="padding-top:0px;">
                                            <label class="form-label form-label-top form-label-auto" for="grade">E-mail
                                                (กรุณาตรวจสอบที่อยู่อีเมลให้ถูกต้อง หากกรอกผิด
                                                จะไม่สามารถส่งข้อมูลในการเข้าสอบได้) <span
                                                    class="form-required">*</span></label>
                                            <input type="text" class="form-control mb-2" name="contact_email"
                                                id="contact_email" value="{{ $data->contact_email }}" maxlength="70"
                                                placeholder="Contact email / อีเมลติดต่อ" required>
                                            {{-- <input type="text" class="form-control " name="contact_email_detail" id="contact_email_detail"
                                                value="{{ $data->contact_email_detail }}" maxlength="70" placeholder="Contact email / อีเมลติดต่อ" required> --}}
                                            <textarea name="contact_email_detail" id="contact_email_detail" class="form-control" cols="30" rows="5"
                                                required>{!! $data->contact_email_detail !!}</textarea>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">example@example.com</label>
                                            <div class="form-error-message" role="alert"><img
                                                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                    height="10"> <span class="error-navigation-message">Please input
                                                    correct email.</span>
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
                                            <label class="form-label form-label-top form-label-auto"
                                                for="photo">อัพโหลดรูปภาพผู้สมัคร <span class="form-required">*</span>
                                                <div style="width: 280px"></div>
                                            </label>
                                            <input type="text" class="form-control mb-2" name="student_photo"
                                                id="student_photo" value="{{ $data->student_photo }}" maxlength="70"
                                                placeholder="Student photo / รูปภาพผู้สมัคร" required>

                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Photo ขนาดไม่เกิน 5mb</label>
                                            <div id="dropzone-photo-error" class="form-error-message" role="alert"><img
                                                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                    height="10">
                                                <span class="error-navigation-message">This field is
                                                    required.</span>
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

                                <div class="form-row form-focus col-md-6" id="image-payment-wrapper"
                                    data-field-input="image_payment"
                                    @if ($hasExistingPaymentImage) style="display:none !important;" @endif>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label form-label-top form-label-auto" for="image_payment">
                                                Image Payment
                                            </label>
                                            <input type="file" class="form-control" name="image_payment"
                                                id="image_payment" accept="image/*">
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Upload payment QR code image (optional)</label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                @if ($hasExistingPaymentImage)
                                    <input type="text" name="oldImagePayment" id="oldImagePayment"
                                        value="{{ $data->image_payment }}" hidden>
                                @endif

                                <div id="preview_image_payment" class="text-center" data-field-related="image_payment"
                                    style="display: {{ $hasExistingPaymentImage ? 'block' : 'none' }};">

                                    @if ($hasExistingPaymentImage)
                                        <img src="{{ asset('form_manage/payment/' . $data->image_payment) }}"
                                            class="custom-image2 my-3" alt="Payment Image" width="100%"
                                            height="auto">
                                        <br>
                                        <button type="button" id="remove_image_payment" class="btn btn-danger">
                                            <i class="fa fa-times"></i> Remove Image
                                        </button>
                                    @endif
                                </div>
                                <br>
                                <script>
                                    $(document).ready(function() {

                                        // Check if there's an existing payment image
                                        let oldImagePaymentEl = document.getElementById('oldImagePayment');
                                        let hasExistingImage = oldImagePaymentEl && oldImagePaymentEl.value;
                                        const $imagePaymentToggle = $('[data-field-enabled="image_payment"]');
                                        const oldImagePaymentValue = oldImagePaymentEl.value;
                                        console.log('oldImagePaymentValue : ', oldImagePaymentValue);
                                        // console.log($oldImagePaymentEl);
                                        function isImagePaymentEnabled() {
                                            if ($imagePaymentToggle.length) {
                                                return $imagePaymentToggle.is(':checked');
                                            }
                                            const $wrapper = $('#image-payment-wrapper');
                                            return $wrapper.is(':visible') && $wrapper.css('display') !== 'none';
                                        }

                                        function syncPreviewWithFieldState() {
                                            if (!isImagePaymentEnabled()) {
                                                $('#preview_image_payment').hide();
                                                return;
                                            }


                                            if (hasExistingImage || $('#preview_image_payment').find('img').length) {
                                                $('#preview_image_payment').show();
                                            } else {
                                                $('#preview_image_payment').hide();
                                            }
                                        }

                                        function hideInputWrapper() {
                                            $('#image-payment-wrapper').attr('style', 'display: none !important;');
                                            $('#image-payment-wrapper').attr('data-field-visible', '0');
                                            $('#image_payment').prop('required', false).removeAttr('required');
                                            syncPreviewWithFieldState();
                                        }

                                        function showInputWrapper() {
                                            if (!isImagePaymentEnabled()) {
                                                syncPreviewWithFieldState();
                                                return;
                                            }
                                            $('#image-payment-wrapper').attr('style', 'display: block !important;');
                                            $('#image-payment-wrapper').attr('data-field-visible', '1');
                                            $('#image_payment').prop('required', false).removeAttr('required');
                                            $('#preview_image_payment').hide();
                                        }

                                        if (hasExistingImage) {
                                            hideInputWrapper();
                                        } else {
                                            showInputWrapper();
                                        }

                                        // Re-apply after a short delay to override field toggle system
                                        setTimeout(function() {
                                            if (hasExistingImage) {
                                                hideInputWrapper();
                                            }
                                            syncPreviewWithFieldState();
                                        }, 100);

                                        $imagePaymentToggle.on('change', function() {
                                            syncPreviewWithFieldState();
                                        });

                                        $('#image_payment').on('change', function() {
                                            var file = this.files[0];
                                            if (file) {
                                                var reader = new FileReader();
                                                reader.onload = function(e) {
                                                    $('#preview_image_payment')
                                                        .html('<img src="' + e.target.result +
                                                            '" class="custom-image2 my-3" alt="Preview" width="100%" height="auto"><br>' +
                                                            '<button type="button" id="remove_image_payment" class="btn btn-danger"><i class="fa fa-times"></i> Remove Image</button>'
                                                        );
                                                    hasExistingImage = true;
                                                    hideInputWrapper();

                                                    // Re-bind remove button
                                                    $('#remove_image_payment').on('click', handleRemovePaymentImage);
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

                                        $('#remove_image_payment').on('click', handleRemovePaymentImage);
                                        syncPreviewWithFieldState();
                                    });
                                </script>

                                <div class="form-row form-focus" id="dropzone-att">
                                    <div class="col-md-12 col-sm-12">
                                        <a id="datt"></a>
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="att">อัพโหลดหลักฐานการชำระเงิน<span
                                                    class="form-required">*</span>
                                                <div style="width: 280px"></div>
                                            </label>
                                            <input type="text" id="student_slip_photo" name="student_slip_photo"
                                                class="form-control" value="{{ $data->student_slip_photo }}"
                                                maxlength="70" placeholder="Student slip photo / หลักฐานการชำระเงิน"
                                                required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false">Receipt Photo ขนาดไม่เกิน 5mb</label>
                                            <div id="dropzone-att-error" class="form-error-message" role="alert"><img
                                                    src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                    height="10">
                                                <span class="error-navigation-message">This field is
                                                    required.</span>
                                                <div class="form-error-arrow">
                                                    <div class="form-error-arrow-inner"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row form-focus">
                                    <div class="col-md-6 ">
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="news">ท่านทราบข่าวสารการจัดสอบ {{ $data->form_name }}
                                                จากช่องทางใด <span class="form-required">*</span></label>
                                            <input type="text" id="news" name="news" class="form-control"
                                                value="{{ $data->news }}" maxlength="70" placeholder="News / ข่าวสาร"
                                                required>
                                            <label class="form-sub-label" style="min-height:13px"
                                                aria-hidden="false"></label>
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
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center form-actions-footer">
                            <br>
                            <div class="text-danger">
                                <h3>{!! $data->text_warning !!}
                                </h3>
                                <textarea name="text_warning" id="text_warning" class="form-control" cols="30" rows="3">{!! $data->text_warning !!}</textarea>
                            </div>
                            <br>
                            <div class="text-danger">{!! $data->text_footer !!}
                                <textarea name="text_footer" id="text_footer" class="form-control" cols="30" rows="3">{!! $data->text_footer !!}</textarea>
                            </div>
                            <br>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="" disabled
                                    style="float: none; margin-right: 3px;">
                                <label class="form-check-label" for="">
                                    {!! $data->text_policy !!}
                                </label>

                            </div>
                            <textarea name="text_policy" id="text_policy" class="form-control mb-5" cols="30" rows="3">{!! $data->text_policy !!}</textarea>
                            <div class="form-submit-actions">
                                <input type="submit" id="send_data" class="btn btn-lg btn-primary"
                                    value="Submit Application">
                                <button type="reset" class="btn btn-lg btn-primary">Clear Form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('forms_manage.script')
    <script>
        window.fieldConfig = @json($fieldConfig ?? []);
        window.initialFieldSettings = @json($fieldSettings ?? []);
    </script>
    <script>
        let indexoptionPackage = 0;

        document.getElementById('addOptionPackage').addEventListener('click', function() {
            indexoptionPackage++;
            document.getElementById('options_package').style.display = 'block';
            var option = document.createElement('div');
            option.classList.add(`option${indexoptionPackage}`);
            option.innerHTML = `
                <label>Option Package ${indexoptionPackage}</label>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="number" class="form-control" name="optionPackage[${indexoptionPackage}][value]" placeholder="Option Value">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="optionPackage[${indexoptionPackage}][name]" placeholder="Option Name">
                        </div>
                        <div class="col-md-2">
                            <div class="row">

                                <div class="col-md-2">
                                    <button type="button" onclick="removeOptionPackage(${indexoptionPackage})" class="btn btn-danger btn-sm mt-1">
                                        <i class="fa fa-trash"></i> test
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            `;

            document.getElementById('options_package').appendChild(option);
        });

        function removeOptionPackage(index) {
            let optionDiv = document.querySelector(`.option${index}`);
            if (optionDiv) {
                optionDiv.remove();
            }
            // ถ้าไม่มี option เหลือ ให้ซ่อน container
            if (document.getElementById('options_package').children.length === 0) {
                document.getElementById('options_package').style.display = 'none';
            }
        }


        function showPackage(id, package, price) {
            indexoptionPackage++;
            getOptionPackage(indexoptionPackage, package, price, id);
        }

        @if (isset($data->packages))
            @foreach ($data->packages as $index => $package)
                showPackage('{{ $package->id }}', '{{ $package->package }}', '{{ $package->price }}');
            @endforeach
        @endif

        function getOptionPackage(index, package, price, id) {
            document.getElementById('options_package').style.display = 'block';
            let option = document.createElement('div');
            option.classList.add(`option${index}`);
            option.innerHTML = `
                <label>Option Package ${index}</label>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="number" id="optionPackagePrice${id}" class="form-control" name="optionPackage[${index}][value]" placeholder="Option Value" value="${price}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="optionPackageName${id}" class="form-control" name="optionPackage[${index}][name]" placeholder="Option Name" value="${package}">
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="button" onclick="editOptionPackage(${id})" data-id="${id}" class="editOptionPackage btn btn-warning btn-sm mt-1">
                                        <i id="changeIcon${id}" class="fa fa-edit"></i>
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" onclick="removeOptionPackage(${index})" class="btn btn-danger btn-sm mt-1">
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
            let optionDiv = document.querySelector(`.option${index}`);
            if (optionDiv) {
                optionDiv.remove();
            }
            // ถ้าไม่มี option เหลือ ให้ซ่อน container
            if (document.getElementById('options_package').children.length === 0) {
                document.getElementById('options_package').style.display = 'none';
            }
        }

        let package_id;

        function editOptionPackage(id) {
            package_id = id;
            var value = document.getElementById('optionPackageName' + package_id).value;
            var price = document.getElementById('optionPackagePrice' + package_id).value;
            $.ajax({
                url: '{{ route('edit-option-package') }}', //update option package
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: package_id,
                    value: value,
                    price: price
                },
                success: function(response) {
                    //change icon
                    let icon = document.getElementById('changeIcon' + package_id);
                    icon.classList.remove('fa-edit');
                    icon.classList.add('fa-check');

                    setTimeout(() => {
                        icon.classList.remove('fa-check');
                        icon.classList.add('fa-edit');
                    }, 2000);
                }
            });
        }

        function deleteOptionPackage(id, index) {
            $.ajax({
                url: '{{ route('delete-option-package') }}', //delete option package
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: package_id,
                    index: index
                },
                success: function(response) {
                    removeOptionPackage(response.index);
                }
            });
        }
    </script>

    <script>
        let indexoption = 0;

        document.getElementById('addOptionGrade').addEventListener('click', function() {
            indexoption++;
            addOptionGrade(indexoption, '');
        });

        function addOptionGrade(index, value) {
            document.getElementById('options_grade').style.display = 'block';
            let option = document.createElement('div');
            option.classList.add(`option${index}`);
            option.innerHTML = `
            <label>Option Grade ${index}</label>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="optionGrade[]" value="${value}">
                    </div>
                    <div class="col-md-4">
                        <button type="button" onclick="removeOptionGrade(${index})" class="btn btn-danger btn-sm mt-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
            document.getElementById('options_grade').appendChild(option);
        }

        function removeOptionGrade(index) {
            let optionDiv = document.querySelector(`.option${index}`);
            if (optionDiv) optionDiv.remove();

            if (document.getElementById('options_grade').children.length === 0) {
                document.getElementById('options_grade').style.display = 'none';
            }
        }

        function showGrade(valueGrade, id) {
            indexoption++;
            getOptionGrade(indexoption, valueGrade, id);
        }
        @if (isset($data->grades))
            @foreach ($data->grades as $index => $grade)
                showGrade('{{ $grade->grade }}', '{{ $grade->id }}');
            @endforeach
        @endif

        function getOptionGrade(index, value, id) {
            document.getElementById('options_grade').style.display = 'block';
            let option = document.createElement('div');
            option.classList.add(`option${index}`);
            option.innerHTML = `
            <label>Option Grade ${index}</label>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="optionGrade${id}" name="optionGrade[]" value="${value}">
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

        function editOptionGrade(id) {
            id = id;
            var value = document.getElementById('optionGrade' + id).value;
            $.ajax({
                url: '{{ route('edit-option-grade') }}', //update option grade
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    value: value
                },
                success: function(response) {
                    //change icon
                    let icon = document.getElementById('changeIcon' + id);
                    icon.classList.remove('fa-edit');
                    icon.classList.add('fa-check');

                    setTimeout(() => {
                        icon.classList.remove('fa-check');
                        icon.classList.add('fa-edit');
                    }, 2000);
                }
            });
        }

        function deleteOptionGrade(id, index) {
            $.ajax({
                url: '{{ route('delete-option-grade') }}', //delete option grade
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    index: index
                },
                success: function(response) {
                    removeOptionGrade(response.index);
                }
            });
        }
    </script>
@endsection
