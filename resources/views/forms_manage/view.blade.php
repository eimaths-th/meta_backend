@extends('layouts.form')

@section('style')
    @include('forms_manage.css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Modern Educational Theme Styles - Orange Palette */
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #FF8C42;
            --accent-color: #FFA500;
            --success-color: #51CF66;
            --warning-color: #FFB84D;
            --dark-orange: #D84315;
            --light-orange: #FFE0B2;
            --dark-text: #2C3E50;
            --light-bg: #FFF8F0;
            --card-shadow: 0 10px 30px rgba(255, 107, 53, 0.15);
        }

        body {
            background: linear-gradient(135deg, #ffb555 0%, #ffa742 50%, #FFA500 100%);
            font-family: 'Sarabun', 'Kanit', sans-serif;
            min-height: 100vh;
        }

        /* Header Styling */
        .form-header-section {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C42 100%);
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 50px 50px;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }

        .form_header {
            color: #D84315;
            font-weight: 700;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 0.5rem;
        }

        .form_sub_header {
            color: #495057;
            font-weight: 500;
            font-size: 1.2rem;
        }

        /* Card Styling */
        .card.bg-light2 {
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 25px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .card-img {
            border-radius: 25px 25px 0 0;
            object-fit: cover;
        }

        .card-body {
            padding: 2.5rem;
        }

        /* Info Section with Icons */
        .info-badge {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C42 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            margin: 0.5rem;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            transition: transform 0.3s ease;
        }

        .info-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.5);
        }

        .info-badge i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        /* Form Fields */
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
            transform: translateY(-2px);
        }

        .form-label {
            color: var(--dark-text);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Submit Buttons */
        .submit-btn {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C42 100%);
            border: none;
            border-radius: 50px;
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.6);
            background: linear-gradient(135deg, #FF8C42 0%, #FFA500 100%);
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C42 100%);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, 0.5);
            background: linear-gradient(135deg, #FF8C42 0%, #FFA500 100%);
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.5rem 0;
            padding-bottom: 0.75rem;
            border-bottom: 3px solid var(--primary-color);
        }

        .section-header i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 0.75rem;
        }

        .section-header h3 {
            margin: 0;
            color: var(--dark-orange);
            font-weight: 700;
        }

        /* Dropzone Styling */
        .dropzone {
            border: 3px dashed var(--primary-color);
            border-radius: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            transition: all 0.3s ease;
        }

        .dropzone:hover {
            border-color: var(--secondary-color);
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            transform: scale(1.02);
        }

        /* Package List Styling */
        .package-list {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 1rem 0;
        }

        .package-list li {
            padding: 0.5rem 0;
            font-weight: 500;
            color: var(--dark-text);
        }

        .package-list li::before {
            content: "🎓";
            margin-right: 0.5rem;
        }

        /* Checkbox Styling */
        .form-check-input {
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid var(--primary-color);
            border-radius: 5px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            margin-left: 0.5rem;
            font-weight: 500;
            color: var(--dark-text);
        }

        /* Footer Styling */
        .meta-footer {
            background: linear-gradient(135deg, #D84315 0%, #BF360C 100%);
            color: white;
            padding: 3rem 0 1.5rem 0;
            margin-top: 4rem;
            border-radius: 50px 50px 0 0;
            box-shadow: 0 -10px 30px rgba(216, 67, 21, 0.3);
        }

        .meta-footer .footer-logo {
            max-width: 200px;
            margin-bottom: 1rem;
            filter: brightness(0) invert(1);
        }

        .meta-footer h4 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
        }

        .meta-footer p {
            color: #bdc3c7;
            margin-bottom: 0.5rem;
        }

        .meta-footer .social-links {
            margin-top: 1rem;
        }

        .meta-footer .social-links a {
            color: white;
            font-size: 1.5rem;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }

        .meta-footer .social-links a:hover {
            color: #FFB84D;
            transform: translateY(-3px);
        }

        .meta-footer .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            margin-top: 2rem;
            text-align: center;
            color: #95a5a6;
        }

        /* Select2 Styling */
        .select2-container--default .select2-selection--multiple {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            min-height: 45px;
            padding: 0.25rem;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C42 100%);
            border: none;
            color: white;
            border-radius: 20px;
            padding: 5px 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .col-md-9 {
                padding-left: 5px;
                padding-right: 5px;
            }

            /* Header adjustments */
            .form-header-section {
                padding: 1.5rem 0;
                margin-bottom: 1rem;
                border-radius: 0 0 30px 30px;
            }

            .form_header {
                font-size: 1.5rem;
                line-height: 1.3;
                padding: 0 10px;
            }

            .form_sub_header {
                font-size: 1rem;
                padding: 0 10px;
            }

            /* Card adjustments */
            .card.bg-light2 {
                border-radius: 15px;
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-footer {
                padding: 1rem !important;
            }

            /* Info badges - stack vertically on mobile */
            .info-badge {
                display: flex;
                width: 100%;
                margin: 0.5rem 0;
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
                justify-content: center;
                text-align: center;
            }

            .info-badge i {
                font-size: 1rem;
            }

            /* Section headers */
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                margin: 1.5rem 0 1rem 0;
            }

            .section-header i {
                font-size: 1.3rem;
                margin-bottom: 0.5rem;
            }

            .section-header h3 {
                font-size: 1.2rem;
            }

            /* Form controls */
            .form-control {
                font-size: 14px;
                padding: 0.6rem 0.8rem;
            }

            .form-label {
                font-size: 14px;
            }

            .form-sub-label {
                font-size: 12px;
            }

            /* Form rows - stack vertically */
            .form-row {
                margin-left: 0;
                margin-right: 0;
            }

            .form-row>[class*="col-"] {
                padding-left: 0;
                padding-right: 0;
                margin-bottom: 1rem;
            }

            .col-md-6,
            .col-md-12 {
                width: 100%;
                max-width: 100%;
            }

            /* Buttons */
            .submit-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.95rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 0.95rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }

            /* Package list */
            .package-list {
                padding: 1rem;
                font-size: 0.9rem;
            }

            .package-list li {
                font-size: 0.9rem;
            }

            /* Dropzone */
            .dropzone {
                font-size: 1.2em !important;
                padding: 1rem;
            }

            .dropzone .dz-message {
                font-size: 0.9rem;
            }

            /* Footer */
            .meta-footer {
                padding: 2rem 0 1rem 0;
                margin-top: 2rem;
                border-radius: 30px 30px 0 0;
            }

            .meta-footer .col-md-4 {
                margin-bottom: 1.5rem;
                text-align: center;
            }

            .meta-footer h4 {
                font-size: 1.1rem;
            }

            .meta-footer p {
                font-size: 0.9rem;
            }

            .meta-footer .footer-logo {
                max-width: 150px;
            }

            /* Checkbox and policy text */
            .form-check {
                padding: 1rem !important;
            }

            .form-check-label {
                font-size: 0.9rem !important;
                line-height: 1.5;
            }

            /* Warning and footer text boxes */
            div[style*="background: linear-gradient(135deg, #fff3cd"] {
                padding: 1rem !important;
                font-size: 0.9rem !important;
            }

            div[style*="background: linear-gradient(135deg, #f8d7da"] {
                padding: 1rem !important;
                font-size: 0.9rem !important;
            }

            /* Admission criteria */
            .custom-image2 {
                max-width: 100% !important;
                height: auto !important;
            }

            /* Center content divs */
            .col-md-10.div_center,
            .col-md-11.div_center {
                padding-left: 10px;
                padding-right: 10px;
            }

            /* Image payment */
            div[align="center"] img {
                max-width: 100%;
                height: auto !important;
            }

            /* Error messages */
            .error_div {
                font-size: 0.9rem;
                padding: 0.75rem;
            }

            /* Select2 adjustments */
            .select2-container {
                font-size: 14px;
            }

            .select2-container--default .select2-selection--multiple {
                min-height: 40px;
            }
        }

        /* Extra small devices (phones in portrait, less than 576px) */
        @media (max-width: 575px) {
            .form_header {
                font-size: 1.3rem;
            }

            .form_sub_header {
                font-size: 0.9rem;
            }

            .section-header h3 {
                font-size: 1.1rem;
            }

            .info-badge {
                font-size: 0.85rem;
                padding: 0.5rem 0.8rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .submit-btn,
            .btn-lg {
                font-size: 0.9rem;
                padding: 0.65rem 1.2rem;
            }
        }

        /* Landscape orientation adjustments */
        @media (max-width: 768px) and (orientation: landscape) {
            .form-header-section {
                padding: 1rem 0;
            }

            .form_header {
                font-size: 1.4rem;
            }

            .section-header {
                margin: 1rem 0 0.75rem 0;
            }
        }

        /* SweetAlert2 Mobile Responsive */
        @media (max-width: 768px) {
            .swal2-popup {
                width: 90% !important;
                max-width: 400px !important;
                font-size: 0.9rem !important;
                padding: 1rem !important;
            }

            .swal2-title {
                font-size: 1.2rem !important;
                padding: 0.5rem !important;
            }

            .swal2-html-container {
                font-size: 0.85rem !important;
                padding: 0.5rem !important;
            }

            .swal2-html-container div {
                padding: 0.75rem !important;
                margin-bottom: 0.75rem !important;
            }

            .swal2-html-container p {
                font-size: 0.85rem !important;
                margin: 0.5rem 0 !important;
            }

            .swal2-confirm {
                font-size: 0.9rem !important;
                padding: 0.6rem 1.5rem !important;
            }
        }

        @media (max-width: 575px) {
            .swal2-popup {
                width: 95% !important;
                padding: 0.75rem !important;
            }

            .swal2-title {
                font-size: 1.1rem !important;
            }

            .swal2-html-container {
                font-size: 0.8rem !important;
            }

            .swal2-html-container p {
                font-size: 0.8rem !important;
            }

            .swal2-confirm {
                font-size: 0.85rem !important;
                padding: 0.5rem 1.2rem !important;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Info Text Styling */
        .form-html p {
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .form-html p span {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        .form-html strong {
            color: var(--dark-orange);
        }

        /* Enhanced Error Styling */
        input.error,
        select.error,
        textarea.error {
            border: 2px solid #ff6b6b !important;
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%) !important;
            animation: shakeError 0.5s ease-in-out;
        }

        input.error:focus,
        select.error:focus,
        textarea.error:focus {
            border-color: #ff6b6b !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25) !important;
        }

        @keyframes shakeError {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        /* Success State */
        input.valid:not(:focus),
        select.valid:not(:focus),
        textarea.valid:not(:focus) {
            border: 2px solid #51CF66 !important;
            background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%) !important;
        }

        /* Error Label Enhancement */
        label.error {
            color: #ff6b6b !important;
            font-size: 0.875rem !important;
            margin-top: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
            font-weight: 500 !important;
            animation: slideDown 0.3s ease-out !important;
        }

        label.error::before {
            content: "⚠️";
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Tooltip Style Error */
        .error-tooltip {
            position: relative;
        }

        .error-tooltip .form-error-message {
            position: absolute;
            z-index: 1000;
            left: 0;
            right: 0;
        }
    </style>
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
                        @if (isset($form->brand))
                            <img class="card-img" src="{{ asset('form_manage/brand/' . $form->brand) }}" alt="..."
                                height="auto">
                        @else
                        @endif
                    </div>
                    <form id="infinite" method="POST" action="{{ route('form.storeFormManage') }}"
                        onsubmit="return check_input();">
                        @csrf
                        <div class="card-body">
                            <br>
                            <div class="text-center">
                                <h2 class="card-title form_header">
                                    @if (isset($form->form_name))
                                        {{ $form->form_name }}
                                    @endif
                                    @if (isset($form->title))
                                        {{ $form->title }}
                                    @endif
                                </h2>
                                <p class="card-text form_sub_header">
                                    <b>
                                        @if (isset($form->sub_title))
                                            {{ $form->sub_title }}
                                        @endif
                                    </b>
                                </p>
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
                                    $fieldSettingsData = is_array($form->field_settings ?? null)
                                        ? $form->field_settings
                                        : [];
                                    $fieldConfig = config('form_fields', []);
                                    $normalizeBoolean = function ($value, $default) {
                                        if ($value === true || $value === false) {
                                            return $value;
                                        }
                                        if ($value === 1 || $value === '1') {
                                            return true;
                                        }
                                        if ($value === 0 || $value === '0') {
                                            return false;
                                        }
                                        if ($value === null) {
                                            return (bool) $default;
                                        }
                                        if (is_string($value)) {
                                            $filtered = filter_var(
                                                $value,
                                                FILTER_VALIDATE_BOOLEAN,
                                                FILTER_NULL_ON_FAILURE,
                                            );
                                            if ($filtered !== null) {
                                                return $filtered;
                                            }
                                        }
                                        return (bool) ($value ?? $default);
                                    };
                                    $resolveSetting = function ($key, $attribute, $fallback) use (
                                        $fieldSettingsData,
                                        $fieldConfig,
                                        $normalizeBoolean,
                                    ) {
                                        $settings = $fieldSettingsData[$key] ?? null;
                                        if (is_array($settings) && array_key_exists($attribute, $settings)) {
                                            return $normalizeBoolean($settings[$attribute], $fallback);
                                        }
                                        if (is_object($settings) && isset($settings->{$attribute})) {
                                            return $normalizeBoolean($settings->{$attribute}, $fallback);
                                        }
                                        return $normalizeBoolean(
                                            data_get($fieldConfig, "$key.default_$attribute", $fallback),
                                            $fallback,
                                        );
                                    };
                                    $isFieldEnabled = function ($key) use ($resolveSetting) {
                                        return $resolveSetting($key, 'enabled', true);
                                    };
                                    $isFieldRequired = function ($key) use ($resolveSetting) {
                                        return $resolveSetting($key, 'required', false) &&
                                            $resolveSetting($key, 'enabled', true);
                                    };
                                @endphp
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {!! nl2br(e(session('error'))) !!}
                                    </div>
                                @endif
                                <div class="form-html" data-component="text" tabindex="0">
                                    <div style="text-align: center; margin-bottom: 2rem;">
                                        @if (isset($form->head_title))
                                            <h3
                                                style="color: #D84315; font-weight: 700; font-size: 1.8rem; margin-bottom: 1.5rem;">
                                                <i class="fas fa-clipboard-list" style="color: #FF6B35;"></i>
                                                {{ $form->head_title }}
                                            </h3>
                                        @endif
                                    </div>

                                    <div style="text-align: center; margin-bottom: 2rem;">
                                        @if (isset($form->registration_date_label))
                                            <div class="info-badge">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>
                                                    <strong>{{ $form->registration_date_label }}:</strong>
                                                    @if (isset($date))
                                                        {{ $date }}
                                                    @else
                                                        Today - 25 October 2024
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                        @if (isset($form->contest_date_label))
                                            <div class="info-badge">
                                                <i class="fas fa-calendar-alt"></i>
                                                <span>
                                                    <strong>{{ $form->contest_date_label }}:</strong>
                                                    @if (isset($form->contest_date))
                                                        {{ $form->contest_date }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{--  <p><span style="color: #6351a2;"><strong>Result Release:&nbsp;</strong>19 April
                                            2023</span>
                                    </p> --}}
                                    {{-- <p><span style="color: #6351a2;"><strong>Venue:</strong>&nbsp;Online Competition</span>
                                    </p> --}}
                                    @if (isset($form->registration_fee_label))
                                        <div style="margin: 2rem 0;">
                                            <h4 style="color: #D84315; font-weight: 700; margin-bottom: 1rem;">
                                                <i class="fas fa-money-bill-wave" style="color: #FF6B35;"></i>
                                                {{ $form->registration_fee_label }}
                                            </h4>
                                            <ul class="package-list" style="list-style: none; padding-left: 0;">
                                                @foreach ($form->packages as $item)
                                                    <li>{{ $item->package }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif


                                    @if (isset($form->admission_criteria_text_label))
                                        <div
                                            style="margin: 2rem 0; padding: 1.5rem; background: linear-gradient(135deg, #FFF8F0 0%, #FFE0B2 100%); border-radius: 15px; border-left: 5px solid #FF6B35;">
                                            <h4 style="color: #D84315; font-weight: 700; margin-bottom: 1rem;">
                                                <i class="fas fa-info-circle" style="color: #FF6B35;"></i>
                                                {{ $form->admission_criteria_text_label }}
                                                {{ $form->form_name }}
                                            </h4>
                                            <div style="color: #495057; line-height: 1.8;">
                                                @if (isset($form->admission_criteria_text))
                                                    {!! nl2br(e($form->admission_criteria_text ?? ' ')) !!}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($form->admission_criteria_image_label))
                                        <div style="margin: 2rem 0;">
                                            <h4 style="color: #D84315; font-weight: 700; margin-bottom: 1rem;">
                                                <i class="fas fa-image" style="color: #FF6B35;"></i>
                                                {{ $form->admission_criteria_image_label }}
                                                {{ $form->form_name }}
                                            </h4>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center"
                                                        style="padding: 1rem; background: #f8f9fa; border-radius: 15px;">
                                                        @if (isset($form->admission_criteria_image))
                                                            <img src="{{ asset('form_manage/admission_criteria_image/' . $form->admission_criteria_image) }}"
                                                                class="custom-image2 my-3" alt="Admission Criteria"
                                                                style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <p>{{ $errors->first() }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" class="form-control" name="subject" id="subject" value=""
                                    maxlength="50" minlength="2" required>
                                <input type="hidden" name="sfield" id="sfield" value="{{ $form->sfield }}">
                                <input type="hidden" name="routeName" id="routeName" value="{{ $form->form_route }}">
                                <input type="hidden" name="referent_code" id="referent_code"
                                    value="{{ request()->referent_code }}">

                                <!-- Student Information Section -->
                                <div class="section-header">
                                    <i class="fas fa-user-graduate"></i>
                                    <h3>ข้อมูลนักเรียน / Student Information</h3>
                                </div>

                                @if ($isFieldEnabled('student_first_name') || $isFieldEnabled('student_last_name'))
                                    <div class="form-row form-focus">
                                        @if ($isFieldEnabled('student_first_name'))
                                            <div class="col-md-6">
                                                <label style="padding-left: 20px"
                                                    class="form-label form-label-top form-label-auto">
                                                    {{ $form->student_first_name }}
                                                    @if ($isFieldRequired('student_first_name'))
                                                        <span class="form-required">*</span>
                                                    @endif
                                                </label>
                                                <div class="position-relative form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="firstname">
                                                        <div style="width: 270px"></div>
                                                    </label>
                                                    <input type="text" class="form-control" name="firstname"
                                                        id="firstname" value="" maxlength="50" minlength="2"
                                                        @if ($isFieldRequired('student_first_name')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">First
                                                        Name</label>
                                                    <div class="form-error-message" role="alert"><img
                                                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                            height="10"> <span class="error-navigation-message">This
                                                            field is
                                                            required.</span>
                                                        <div class="form-error-arrow">
                                                            <div class="form-error-arrow-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($isFieldEnabled('student_last_name'))
                                            <div class="col-md-6">
                                                <label style="padding-left: 20px"
                                                    class="form-label form-label-top form-label-auto">
                                                    {{ $form->student_last_name }}
                                                    @if ($isFieldRequired('student_last_name'))
                                                        <span class="form-required">*</span>
                                                    @endif
                                                </label>
                                                <div class="position-relative form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="lastname">
                                                        <div style="width: 270px"></div>
                                                    </label>
                                                    <input type="text" class="form-control" name="lastname"
                                                        id="lastname" value="" maxlength="50" minlength="2"
                                                        @if ($isFieldRequired('student_last_name')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">Last
                                                        Name</label>

                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($isFieldEnabled('student_nick_name') || $isFieldEnabled('date_of_birth'))
                                    <div class="form-row form-focus">

                                        @if ($isFieldEnabled('student_nick_name'))
                                            <div class="col-md-6 col-sm-12">

                                                <div class="position-relative form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="nickname">{{ $form->student_nick_name }}
                                                        @if ($isFieldRequired('student_nick_name'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                        <div style="width: 270px"></div>
                                                    </label>
                                                    <input type="text" class="form-control" name="nickname"
                                                        id="nickname" value="" maxlength="50" minlength="1"
                                                        @if ($isFieldRequired('student_nick_name')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">Nick
                                                        Name</label>
                                                    <div class="form-error-message" role="alert"><img
                                                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                            height="10"> <span class="error-navigation-message">This
                                                            field is
                                                            required.</span>
                                                        <div class="form-error-arrow">
                                                            <div class="form-error-arrow-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($isFieldEnabled('date_of_birth'))
                                            <div class="col-md-6 col-sm-12">
                                                <div class="position-relative form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="birthdate">
                                                        {{ $form->date_of_birth }}
                                                        @if ($isFieldRequired('date_of_birth'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                        <div style="width: 270px"></div>
                                                    </label>
                                                    <input type="date" class="AddDate form-control" name="birthdate"
                                                        id="birthdate" value=""
                                                        @if ($isFieldRequired('date_of_birth')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">Date</label>
                                                    <div class="form-error-message" role="alert"><img
                                                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                            height="10"> <span class="error-navigation-message">This
                                                            field is
                                                            required.</span>
                                                        <div class="form-error-arrow">
                                                            <div class="form-error-arrow-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($isFieldEnabled('ref_date_label') && isset($form->ref_date_label) && !empty($form->ref_date_label))
                                    <div class="form-row form-focus">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="position-relative form-group">
                                                <label class="form-label form-label-top form-label-auto" for="ref_date">
                                                    {{ $form->ref_date_label }}
                                                    <span class="form-required">*</span>
                                                    <div style="width: 270px"></div>
                                                </label>
                                                <input type="date" class="form-control" name="ref_date"
                                                    id="ref_date" value="" required>
                                                <label class="form-sub-label" style="min-height:13px"
                                                    aria-hidden="false">Reference Date</label>
                                                <div class="form-error-message" role="alert"><img
                                                        src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                        height="10"> <span class="error-navigation-message">This
                                                        field is
                                                        required.</span>
                                                    <div class="form-error-arrow">
                                                        <div class="form-error-arrow-inner"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($isFieldEnabled('student_school_name') || $isFieldEnabled('student_grade'))
                                    <div class="form-row form-focus">
                                        @if ($isFieldEnabled('student_school_name'))
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="schoolname">{{ $form->student_school_name }}
                                                        @if ($isFieldRequired('student_school_name'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                    </label>
                                                    <input type="text" class="form-control" name="schoolname"
                                                        id="schoolname" value="" maxlength="100"
                                                        @if ($isFieldRequired('student_school_name')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">School Name</label>
                                                    <div class="form-error-message" role="alert"><img
                                                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                            height="10"> <span class="error-navigation-message">This
                                                            field
                                                            is
                                                            required.</span>
                                                        <div class="form-error-arrow">
                                                            <div class="form-error-arrow-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($isFieldEnabled('student_grade'))
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="grade">
                                                        {{ $form->student_grade }}
                                                        @if ($isFieldRequired('student_grade'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                        <div style="width: 270px"></div>
                                                    </label>
                                                    <select style="width: 100%" class="form-control" id="grade"
                                                        name="grade" data-component="dropdown"
                                                        aria-label="Grade / ระดับชั้น"
                                                        @if ($isFieldRequired('student_grade')) required @endif>
                                                        <option value="">Please Select</option>
                                                        @foreach ($form->grades as $grade)
                                                            <option value="{{ $grade->id }}">{{ $grade->grade }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">{{-- Grade as per Academic Year 2022 --}}</label>
                                                    <div class="form-error-message" role="alert"><img
                                                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                            height="10"> <span class="error-navigation-message">This
                                                            field
                                                            is
                                                            required.</span>
                                                        <div class="form-error-arrow">
                                                            <div class="form-error-arrow-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif


                                @if ($isFieldEnabled('package'))
                                    <div class="form-row form-focus">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label class="form-label form-label-top form-label-auto" for="package">
                                                    {{ $form->package ?? ' ' }}
                                                    @if ($isFieldRequired('package'))
                                                        <span class="form-required">*</span>
                                                    @endif
                                                    @if ($form->package_multiselect && $form->package_max_selection)
                                                        <small class="text-muted">(Max: {{ $form->package_max_selection }}
                                                            selections)</small>
                                                    @endif
                                                </label>
                                                @if ($form->package_multiselect)
                                                    {{-- Multi-select dropdown with Select2 --}}
                                                    <select class="form-control select2-package" id="package"
                                                        name="package[]" aria-label="แพคเกจในการสอบ / Packages" multiple
                                                        data-max-selection="{{ $form->package_max_selection ?? '' }}"
                                                        @if ($isFieldRequired('package')) required @endif>
                                                        @foreach ($form->packages as $package)
                                                            <option value="{{ $package->id }}">{{ $package->package }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted">Select multiple packages from the
                                                        dropdown</small>
                                                @else
                                                    {{-- Single select dropdown --}}
                                                    <select class="form-control" id="package" name="package"
                                                        aria-label="แพคเกจในการสอบ / Packages"
                                                        @if ($isFieldRequired('package')) required @endif>
                                                        <option value="">Please Select</option>
                                                        @foreach ($form->packages as $package)
                                                            <option value="{{ $package->id }}">{{ $package->package }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                <label class="form-sub-label" style="min-height:13px"
                                                    aria-hidden="false">Packages</label>
                                                <div class="form-error-message" role="alert"><img
                                                        src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                        height="10"> <span class="error-navigation-message">This field
                                                        is
                                                        required.</span>
                                                    <div class="form-error-arrow">
                                                        <div class="form-error-arrow-inner"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Exam Mode Selection --}}
                                <div class="form-row form-focus" id="exam_mode_container" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto">
                                                Exam Mode / รูปแบบการสอบ
                                                <span class="form-required">*</span>
                                            </label>
                                            <div class="p-3 bg-light rounded border">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exam_mode_online" name="exam_mode"
                                                        value="online" class="custom-control-input" checked>
                                                    <label class="custom-control-label" for="exam_mode_online">
                                                        <i class="fas fa-laptop"></i> Online (สอบออนไลน์)
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exam_mode_onsite" name="exam_mode"
                                                        value="onsite" class="custom-control-input">
                                                    <label class="custom-control-label" for="exam_mode_onsite">
                                                        <i class="fas fa-chalkboard-teacher"></i> Onsite (สอบนอกสถานที่)
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted mt-2">
                                                    <i class="fas fa-info-circle"></i> โปรดระบุรูปแบบการสอบที่ท่านต้องการ
                                                    (Online หรือ Onsite)
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($isFieldEnabled('student_address') || $isFieldEnabled('student_zip'))
                                    <div class="form-row form-focus">
                                        @if ($isFieldEnabled('student_address'))
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="address">{{ $form->student_address ?? ' ' }}
                                                        @if ($isFieldRequired('student_address'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                    </label>
                                                    <input type="text" class="form-control" name="address"
                                                        id="address" maxlength="150" minlength="2"
                                                        @if ($isFieldRequired('student_address')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">Street Address</label>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($isFieldEnabled('student_zip'))
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="postcode">
                                                        {{ $form->student_zip ?? ' ' }}
                                                        @if ($isFieldRequired('student_zip'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                    </label>
                                                    <input type="text" class="form-control" name="postcode"
                                                        id="postcode" maxlength="50" minlength="2"
                                                        @if ($isFieldRequired('student_zip')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">
                                                        Postal / Zip Code / รหัสไปรษณีย์ </label>
                                                    <div class="form-error-message" role="alert"><img
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
                                        @endif
                                    </div>
                                @endif

                                {{-- Exam Mode Selection --}}
                                <div class="form-row form-focus" id="exam_mode_container" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto">
                                                Exam Mode / รูปแบบการสอบ
                                                <span class="form-required">*</span>
                                            </label>
                                            <div class="p-3 bg-light rounded border">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exam_mode_online" name="exam_mode"
                                                        value="online" class="custom-control-input" checked>
                                                    <label class="custom-control-label" for="exam_mode_online">
                                                        <i class="fas fa-laptop"></i> Online (สอบออนไลน์)
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exam_mode_onsite" name="exam_mode"
                                                        value="onsite" class="custom-control-input">
                                                    <label class="custom-control-label" for="exam_mode_onsite">
                                                        <i class="fas fa-chalkboard-teacher"></i> Onsite (สอบนอกสถานที่)
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted mt-2">
                                                    <i class="fas fa-info-circle"></i> โปรดระบุรูปแบบการสอบที่ท่านต้องการ
                                                    (Online หรือ Onsite)
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Parent/Guardian Information Section -->
                                <div class="section-header">
                                    <i class="fas fa-users"></i>
                                    <h3>ข้อมูลผู้ปกครอง / Parent/Guardian Information</h3>
                                </div>

                                @if ($isFieldEnabled('parent_name') || $isFieldEnabled('parent_phone'))
                                    <div class="form-row form-focus">
                                        @if ($isFieldEnabled('parent_name'))
                                            <div class="col-md-6">
                                                <div class="position-relative form-group" style="padding-top:24px;">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="parent">
                                                        {{ $form->parent_name ?? ' ' }}
                                                        @if ($isFieldRequired('parent_name'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                    </label>
                                                    <input type="text" class="form-control" name="parent"
                                                        id="parent" value="" maxlength="100"
                                                        @if ($isFieldRequired('parent_name')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">Parent's name</label>
                                                    <div class="form-error-message" role="alert"><img
                                                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                            height="10"> <span class="error-navigation-message">This
                                                            field
                                                            is
                                                            required.</span>
                                                        <div class="form-error-arrow">
                                                            <div class="form-error-arrow-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($isFieldEnabled('parent_phone'))
                                            <div class="col-md-6 col-sm-12">
                                                <div class="position-relative form-group" style="padding-top:24px;">
                                                    <label class="form-label form-label-top form-label-auto"
                                                        for="phone">
                                                        {{ $form->parent_phone ?? ' ' }}
                                                        @if ($isFieldRequired('parent_phone'))
                                                            <span class="form-required">*</span>
                                                        @endif
                                                        <div style="width: 270px"></div>
                                                    </label>
                                                    <input type="text" class="AddPhone form-control" name="phone"
                                                        id="phone" value="" maxlength="20"
                                                        @if ($isFieldRequired('parent_phone')) required @endif>
                                                    <label class="form-sub-label" style="min-height:13px"
                                                        aria-hidden="false">Phone Number</label>
                                                    <div class="form-error-message" role="alert"><img
                                                            src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                            height="10"> <span class="error-navigation-message">This
                                                            field
                                                            is
                                                            required.</span>
                                                        <div class="form-error-arrow">
                                                            <div class="form-error-arrow-inner"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if ($isFieldEnabled('contact_email'))
                                    <div class="form-row form-focus">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="position-relative form-group" style="padding-top:0px;">
                                                <label class="form-label form-label-top form-label-auto" for="grade">
                                                    {{ $form->contact_email ?? ' ' }}
                                                    {{ $form->contact_email_detail ?? ' ' }}
                                                    @if ($isFieldRequired('contact_email'))
                                                        <span class="form-required">*</span>
                                                    @endif
                                                </label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    value="" maxlength="70"
                                                    @if ($isFieldRequired('contact_email')) required @endif>
                                                <small id="email-msg" style="color: red;"></small>
                                                <label class="form-sub-label" style="min-height:13px"
                                                    aria-hidden="false">example@example.com</label>
                                                <div class="form-error-message" role="alert"><img
                                                        src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                        height="10"> <span class="error-navigation-message">Please
                                                        input
                                                        correct email.</span>
                                                    <div class="form-error-arrow">
                                                        <div class="form-error-arrow-inner"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Document Upload Section -->
                                <div class="section-header">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h3>อัพโหลดเอกสาร / Document Upload</h3>
                                </div>

                                @if ($isFieldEnabled('student_photo'))
                                    <div class="form-row form-focus" id="dropzone-photo">
                                        <div class="col-md-12 col-sm-12">
                                            <a id="dphoto"></a>
                                            <div class="position-relative form-group">
                                                <label class="form-label form-label-top form-label-auto" for="photo">
                                                    {{ $form->student_photo ?? ' ' }}
                                                    @if ($isFieldRequired('student_photo'))
                                                        <span class="form-required">*</span>
                                                    @endif
                                                    <div style="width: 280px"></div>
                                                </label>
                                                <input type="text" id="drop1" name="drop1"
                                                    class="form-control form_none" value=""
                                                    @if ($isFieldRequired('student_photo')) required @endif>
                                                <div class="dropzone" id="my-awesome-dropzone" style="font-size: 1.5em;">
                                                    <div class="fallback">

                                                    </div>
                                                </div>
                                                <label class="form-sub-label" style="min-height:13px"
                                                    aria-hidden="false">Photo ขนาดไม่เกิน 5mb</label>
                                                <div id="dropzone-photo-error" class="form-error-message" role="alert">
                                                    <img src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
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

                                    <div class="dropzonex dz-default dz-message" id="dropzone_preview"
                                        style="font-size: 1.5em;">
                                        <h3 class="dropzone-previews ui"></h3>


                                    </div>
                                @endif

                                @if ($isFieldEnabled('image_payment'))
                                    <br>
                                    <div align="center" data-field-related="image_payment">
                                        @if (isset($form->image_payment))
                                            <img src="{{ asset('form_manage/payment/' . $form->image_payment) }}"
                                                alt="..." height="500" width="auto">
                                        @endif
                                    </div>
                                    <br>
                                @endif

                                @if ($isFieldEnabled('student_slip_photo'))
                                    <div class="form-row form-focus" id="dropzone-att">
                                        <div class="col-md-12 col-sm-12">
                                            <a id="datt"></a>
                                            <div class="position-relative form-group">
                                                <label class="form-label form-label-top form-label-auto" for="att">
                                                    {{ $form->student_slip_photo ?? ' ' }}
                                                    @if ($isFieldRequired('student_slip_photo'))
                                                        <span class="form-required">*</span>
                                                    @endif
                                                    <div style="width: 280px"></div>
                                                </label>
                                                <input type="text" id="drop2" name="drop2"
                                                    class="form-control form_none" value=""
                                                    @if ($isFieldRequired('student_slip_photo')) required @endif>
                                                <div class="dropzone" id="my-awesome-dropzone2"
                                                    style="font-size: 1.5em;">
                                                    <div class="fallback">
                                                        {{--  <input name="file2" id="file2" type="file" multiple
                                                        class="form-control" /> --}}
                                                    </div>
                                                </div>
                                                <label class="form-sub-label" style="min-height:13px"
                                                    aria-hidden="false">Receipt Photo ขนาดไม่เกิน 5mb</label>
                                                <div id="dropzone-att-error" class="form-error-message" role="alert">
                                                    <img src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
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
                                    <div class="dropzonex dz-default dz-message" id="dropzone_preview2"
                                        style="font-size: 1.5em;">
                                        <h3 class="dropzone-previews ui"></h3>
                                    </div>
                                @endif
                                @if ($isFieldEnabled('news'))
                                    <div class="form-row form-focus">
                                        <div class="col-md-6 ">
                                            <div class="position-relative form-group">
                                                <label class="form-label form-label-top form-label-auto" for="newsf">
                                                    {{ $form->news ?? ' ' }}
                                                    @if ($isFieldRequired('news'))
                                                        <span class="form-required">*</span>
                                                    @endif
                                                </label>
                                                <input type="text" class="form-control" name="newsf" id="newsf"
                                                    value="" maxlength="50"
                                                    @if ($isFieldRequired('news')) required @endif>

                                                <label class="form-sub-label" style="min-height:13px"
                                                    aria-hidden="false"></label>
                                                <div class="form-error-message" role="alert"><img
                                                        src="https://cdn.jotfor.ms/images/exclamation-octagon.png"
                                                        height="10"> <span class="error-navigation-message">This field
                                                        is
                                                        required.</span>
                                                    <div class="form-error-arrow">
                                                        <div class="form-error-arrow-inner"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-center"
                            style="background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%); padding: 2rem;">
                            <br>
                            @if (!empty($form->text_warning))
                                <div
                                    style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); padding: 1.5rem; border-radius: 15px; border-left: 5px solid #ffc107; margin-bottom: 1.5rem;">
                                    <h3 style="color: #856404; font-weight: 700; margin-bottom: 1rem;">
                                        <i class="fas fa-exclamation-triangle"></i> คำเตือนสำคัญ / Important Notice
                                    </h3>
                                    <div style="color: #856404; font-size: 1.1rem; line-height: 1.8;">
                                        {!! nl2br($form->text_warning) ?? '' !!}
                                    </div>
                                </div>
                            @endif

                            @if (!empty($form->text_footer))
                                <div
                                    style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); padding: 1.5rem; border-radius: 15px; border-left: 5px solid #dc3545; margin-bottom: 1.5rem;">
                                    <div style="color: #721c24; font-size: 1rem; line-height: 1.8;">
                                        {!! nl2br($form->text_footer) ?? '' !!}
                                    </div>
                                </div>
                            @endif
                            <br>
                            <div class="form-group form-check"
                                style="background: linear-gradient(135deg, #FFF8F0 0%, #FFE0B2 100%); padding: 1.5rem; border-radius: 15px; border: 2px solid #FF6B35; margin-bottom: 2rem;">
                                <input type="checkbox" class="form-check-input" id="agreeCheckbox" required
                                    data-required-checkbox="true" style="float: none; margin-right: 10px;">
                                <label class="form-check-label" for="agreeCheckbox"
                                    style="font-size: 1.05rem; color: #2C3E50; font-weight: 500; text-align: left; display: inline-block;">
                                    <i class="fas fa-check-circle" style="color: #FF6B35;"></i>
                                    {!! nl2br($form->text_policy) ?? '' !!}
                                </label>
                            </div>

                            <button type="submit" class="submit-btn btn btn-lg btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Application
                            </button>
                            <button type="reset" class="btn btn-lg btn-primary"
                                style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                                <i class="fas fa-redo"></i> Clear Form
                            </button><br><br><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Meta Knowledge Footer -->
    @if ($form->show_footer ?? true)
        <footer class="meta-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        @php
                            $footerLogo = $form->footer_logo ?? 'logo_meta.png';
                        @endphp
                        <img src="{{ asset('images/' . $footerLogo) }}" alt="Footer Logo" class="footer-logo">
                        <h4>{{ $form->footer_company_name ?? 'Meta Knowledge' }}</h4>
                        <p>{{ $form->footer_description_1 ?? 'ศูนย์รวมความรู้และการพัฒนาทักษะสำหรับนักเรียนและผู้ปกครอง' }}
                        </p>
                        <p>{{ $form->footer_description_2 ?? 'พัฒนาศักยภาพ สร้างอนาคตที่ดีกว่า' }}</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h4><i class="fas fa-info-circle"></i> {{ $form->footer_about_title ?? 'เกี่ยวกับเรา' }}</h4>
                        <p><i class="fas fa-graduation-cap"></i>
                            {{ $form->footer_feature_1 ?? 'ระบบสอบและแข่งขันออนไลน์' }}</p>
                        <p><i class="fas fa-book-reader"></i>
                            {{ $form->footer_feature_2 ?? 'หลักสูตรคุณภาพสำหรับทุกระดับชั้น' }}</p>
                        <p><i class="fas fa-trophy"></i> {{ $form->footer_feature_3 ?? 'พัฒนาทักษะเพื่อความสำเร็จ' }}</p>
                        <p><i class="fas fa-certificate"></i> {{ $form->footer_feature_4 ?? 'ใบประกาศนียบัตรรับรอง' }}</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h4><i class="fas fa-envelope"></i> {{ $form->footer_contact_title ?? 'ติดต่อเรา' }}</h4>
                        <p><i class="fas fa-phone"></i> โทร: {{ $form->footer_phone ?? '02-XXX-XXXX' }}</p>
                        <p><i class="fas fa-envelope"></i> Email: {{ $form->footer_email ?? 'info@metaknowledge.com' }}
                        </p>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $form->footer_address ?? 'กรุงเทพมหานคร ประเทศไทย' }}
                        </p>
                        <div class="social-links">
                            <a href="{{ $form->footer_facebook ?? '#' }}" title="Facebook" target="_blank"><i
                                    class="fab fa-facebook"></i></a>
                            <a href="{{ $form->footer_line ?? '#' }}" title="Line" target="_blank"><i
                                    class="fab fa-line"></i></a>
                            <a href="{{ $form->footer_instagram ?? '#' }}" title="Instagram" target="_blank"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="{{ $form->footer_youtube ?? '#' }}" title="YouTube" target="_blank"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <p>&copy; {{ date('Y') }}
                        {{ $form->footer_copyright ?? 'Meta Knowledge. All Rights Reserved. | Empowering Education, Inspiring Excellence' }}
                    </p>
                </div>
            </div>
        </footer>
    @endif
    <script>
        const allowedSuffixes = ['.com', '.net', '.co.th', '.ac.th', '.or.th', '.go.th', '.edu', '.org'];
        const emailInput = document.getElementById('email');
        const msg = document.getElementById('email-msg');

        let timeout;

        emailInput.addEventListener('input', function() {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const email = emailInput.value.trim();

                if (email.length < 5) {
                    msg.textContent = '';
                    return;
                }

                // ยังพิมพ์อยู่ → รอ user ใส่ @ ก่อนค่อยเช็ค
                if (!email.includes('@')) {
                    msg.textContent = '';
                    return;
                }

                const parts = email.split('@');

                // ต้องมีแค่ 2 ส่วน
                if (parts.length !== 2 || !parts[1]) {
                    msg.textContent = '';
                    return;
                }

                const domain = parts[1].toLowerCase();

                // ยังพิมพ์ไม่ครบโดเมน → ไม่ต้องแสดง error
                if (domain.length < 3) {
                    msg.textContent = '';
                    return;
                }

                const isValid = allowedSuffixes.some(suffix => domain.endsWith(suffix));

                if (isValid) {
                    msg.textContent = '✅ อีเมลนี้รูปแบบถูกต้อง';
                    msg.style.color = 'green';
                } else {
                    msg.textContent = '❌ รูปแบบอีเมลนี้ไม่ถูกต้อง (อนุญาตเฉพาะ: ' + allowedSuffixes.join(
                        ', ') + ')';
                    msg.style.color = 'red';
                }

            }, 500);
        });
    </script>
    <script>
        $(document).ready(function() {
            var inputlist = ["firstname", "lastname", "address", "postcode"];
            $(".form-control").focusout(function() {
                //$(".form-control").focus();
                let inputxx;
                let nameinput = $(this).attr("name");

                if (inputlist.indexOf($(this).attr("name")) >= 0) {
                    inputxx = ".form-focus";
                } else {
                    inputxx = ".form-group";
                }

                if (nameinput == 'firstname') {
                    if ($(this).val() == '' || $("#lastname").val() == '') {
                        //alert();
                        $(this).closest(inputxx).addClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "block");
                        if ($(this).val() == '') {
                            $(this).css('border', 'solid 1px red');
                        } else {
                            $(this).css('border', 'solid 1px green');
                        }

                        if ($("#lastname").val() == '') {
                            $("#lastname").css('border', 'solid 1px red');
                        } else {
                            $("#lastname").css('border', 'solid 1px green');
                        }

                        //$(this).parents().css( "background-color", "red" );
                    } else {
                        // If it is not blank.
                        $(this).css('border', 'solid 1px green');
                        $("#lastname").css('border', 'solid 1px green');
                        $(this).closest(inputxx).removeClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "none");
                    }

                } else if (nameinput == 'lastname') {
                    if ($(this).val() == '' || $('#firstname').val() == '') {
                        //alert();
                        $(this).closest(inputxx).addClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "block");
                        if ($(this).val() == '') {
                            $(this).css('border', 'solid 1px red');
                        } else {
                            $(this).css('border', 'solid 1px green');
                        }

                        if ($("#firstname").val() == '') {
                            $("#firstname").css('border', 'solid 1px red');
                        } else {
                            $("#firstname").css('border', 'solid 1px green');
                        }
                        //$(this).parents().css( "background-color", "red" );
                    } else {
                        // If it is not blank.
                        $(this).css('border', 'solid 1px green');
                        $("#firstname").css('border', 'solid 1px green');
                        $(this).closest(inputxx).removeClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "none");
                    }

                } else if (nameinput == 'address') {
                    if ($(this).val() == '' || $('#postcode').val() == '') {
                        //alert();
                        $(this).closest(inputxx).addClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "block");
                        if ($(this).val() == '') {
                            $(this).css('border', 'solid 1px red');
                        } else {
                            $(this).css('border', 'solid 1px green');
                        }

                        if ($("#postcode").val() == '') {
                            $("#postcode").css('border', 'solid 1px red');
                        } else {
                            $("#postcode").css('border', 'solid 1px green');
                        }
                        //$(this).parents().css( "background-color", "red" );
                    } else {
                        // If it is not blank.
                        $(this).css('border', 'solid 1px green');
                        $("#postcode").css('border', 'solid 1px green');
                        $(this).closest(inputxx).removeClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "none");
                    }

                } else if (nameinput == 'postcode') {
                    if ($(this).val() == '' || $('#address').val() == '') {
                        //alert();
                        $(this).closest(inputxx).addClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "block");
                        if ($(this).val() == '') {
                            $(this).css('border', 'solid 1px red');
                        } else {
                            $(this).css('border', 'solid 1px green');
                        }

                        if ($("#address").val() == '') {
                            $("#address").css('border', 'solid 1px red');
                        } else {
                            $("#address").css('border', 'solid 1px green');
                        }
                        //$(this).parents().css( "background-color", "red" );
                    } else {
                        // If it is not blank.
                        $(this).css('border', 'solid 1px green');
                        $("#address").css('border', 'solid 1px green');
                        $(this).closest(inputxx).removeClass('form-focus-error');
                        $(this).closest(inputxx).find('.form-error-message').css("display", "none");
                    }

                } else {
                    if ($(this).attr('type') == 'email') {
                        var validRegex =
                            /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                        if ($(this).val() == '' || !$(this).val().match(validRegex)) {
                            $(this).closest(inputxx).addClass('form-focus-error');
                            $(this).closest(inputxx)
                                .find('.form-error-message').css("display", "block");
                            $(this).css('border', 'solid 1px red');
                            //$(this).parents().css( "background-color", "red" );
                        } else {
                            // If it is not blank.
                            $(this).css('border', 'solid 1px green');
                            $(this).closest(inputxx).removeClass('form-focus-error');
                            $(this).closest(inputxx).find('.form-error-message').css("display", "none");
                        }

                    } else {
                        if ($(this).val() == '') {
                            $(this).closest(inputxx).addClass('form-focus-error');
                            $(this).closest(inputxx)
                                .find('.form-error-message').css("display", "block");
                            $(this).css('border', 'solid 1px red');
                            //$(this).parents().css( "background-color", "red" );
                        } else {
                            // If it is not blank.
                            $(this).css('border', 'solid 1px green');
                            $(this).closest(inputxx).removeClass('form-focus-error');
                            $(this).closest(inputxx).find('.form-error-message').css("display", "none");
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

            $('#infinite').on('submit', function() {
                $('#loader-container').show();
            });

        });
    </script>
    <script type="text/javascript">
        var myDropzone = {};
        let imgFiles = document.getElementsByName('imgFiles[]');
        let imgFiles2 = document.getElementsByName('imgFiles2[]');

        Dropzone.options.myAwesomeDropzone = {
            url: '{{ route('form.upload') }}',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            paramName: "file", // ชื่อไฟล์ปลายทางเมื่อ upload แบบ mutiple จะเป็น array
            autoProcessQueue: true, // ใส่เพื่อไม่ให้อัพโหลดทันที หลังจากเลือกไฟล์
            uploadMultiple: true, // อัพโหลดไฟล์หลายไฟล์
            parallelUploads: 2, // ให้ทำงานพร้อมกัน 10 ไฟล์
            maxFiles: 2, // ไฟล์สูงสุด 5 ไฟล์
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
            maxFilesize: 5, // MB
            previewsContainer: "#dropzone_preview", // ระบุ element เป้าหลาย
            //previewTemplate: $('#template-preview').html(),
            dictRemoveFile: "Remove", // ชื่อ ปุ่ม remove
            renameFile: function(file) {
                let newName = new Date().getTime() + '_' + file.name;
                file.newName = newName;
                return newName;
            },
            dictCancelUpload: "Cancel", // ชื่อ ปุ่ม ยกเลิก
            dictDefaultMessage: "<img height='60' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNsug8XTE5KVJEMECVvm8p43BZTdvZExoQ9Q&usqp=CAU'><br><font size='3'>Browse File</font>", // ข้อความบนพื้นที่แสดงรูปจะแสดงหลังจากโหลดเพจเสร็จ
            dictFileTooBig: "ไม่อนุญาตให้อัพโหลดไฟล์เกิน 2 MB", //ข้อความแสดงเมื่อเลือกไฟล์ขนาดเกินที่กำหนด
            acceptedFiles: "image/*", // อนุญาตให้เลือกไฟล์ประเภทรูปภาพได้

            // The setting up of the dropzone
            init: function() {
                myDropzone = this;
                this.on("addedfile", function(file) {
                    //$('#infinite').append("<input type='text' class='form_none' name='imgFiles[]' value='" + file.newName + "'/>");
                    $('#infinite').append("<input type='text' id='" + file.newName +
                        "' class='form_none' name='imgFiles[]' value='" + file.newName + "'/>");
                    file.previewElement.id = file.newName;
                }).on("removedfile", function(file) {
                    //alert(file.id);
                    //var name = file.name;
                    var name = file.previewElement.id;

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        url: '{{ route('form.delete') }}',
                        data: {
                            name: name,
                        },
                        success: function(data) {
                            console.log('success: ' + data);
                            var element = document.getElementById("infinite");
                            var child = document.getElementById(name);
                            element.removeChild(child);
                            if (!document.getElementsByName('imgFiles[]').length) {
                                $('#dropzone_preview').css("display", "none");
                                $('#dropzone-photo').addClass('form-focus-error');
                                $('#dropzone-photo')
                                    .find('.form-error-message').css("display", "block");
                                $('#dropzone-photo').css('border', 'solid 1px red');
                            }
                        }
                    });

                    //var _ref;
                    //return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                }).on("maxfilesexceeded", function(file, response) {
                    alert('allow maximum 2 file');
                    this.removeFile(file);
                }).on('complete', function(file) {
                    let val = file.accepted;
                    if (file.accepted == true) {
                        obj = JSON.parse(file.xhr.response);
                        //file.previewElement.id = obj.success;
                        console.log(obj.success);
                        //$('#infinite').append("<input type='text' id='" + obj.success +
                        //    "' class='form_none' name='imgFiles[]' value='" + obj.success + "'/>");
                    }
                    let val1 = file.name;
                    $('#dropzone_preview').css("display", "block");
                    $('#dropzone-photo').removeClass('form-focus-error');
                    $('#dropzone-photo')
                        .find('.form-error-message').css("display", "none");
                    $('#dropzone-photo').css('border', 'solid 1px green');
                    if (document.getElementsByName('imgFiles[]').length) {
                        //$('#error_div').css('display', 'none');
                    }
                }).on("success", function(file) {
                    //var responseText = file.id // or however you would point to your assigned file ID here;
                    //console.log(response); // console should show the ID you pointed to
                    // do stuff with file.id ...
                }).on("error", function(file) {
                    alert("ไม่อนุญาตให้อัพโหลดไฟล์เกิน 5 MB");
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
        }

        Dropzone.options.myAwesomeDropzone2 = {
            url: '{{ route('form.upload') }}',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            paramName: "file", // ชื่อไฟล์ปลายทางเมื่อ upload แบบ mutiple จะเป็น array
            autoProcessQueue: true, // ใส่เพื่อไม่ให้อัพโหลดทันที หลังจากเลือกไฟล์
            uploadMultiple: true, // อัพโหลดไฟล์หลายไฟล์
            parallelUploads: 2, // ให้ทำงานพร้อมกัน 10 ไฟล์
            maxFiles: 1, // ไฟล์สูงสุด 5 ไฟล์
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
            maxFilesize: 5, // MB
            renameFile: function(file) {
                let newName = new Date().getTime() + '_' + file.name;
                file.newName = newName;
                return newName;
            },
            previewsContainer: "#dropzone_preview2", // ระบุ element เป้าหลาย
            //previewTemplate: $('#template-preview').html(),
            dictRemoveFile: "Remove", // ชื่อ ปุ่ม remove
            dictCancelUpload: "Cancel", // ชื่อ ปุ่ม ยกเลิก
            dictDefaultMessage: "<img height='60' src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNsug8XTE5KVJEMECVvm8p43BZTdvZExoQ9Q&usqp=CAU'><br><font size='3'>Browse File</font>", // ข้อความบนพื้นที่แสดงรูปจะแสดงหลังจากโหลดเพจเสร็จ
            dictFileTooBig: "ไม่อนุญาตให้อัพโหลดไฟล์เกิน 2 MB", //ข้อความแสดงเมื่อเลือกไฟล์ขนาดเกินที่กำหนด
            acceptedFiles: "image/*", // อนุญาตให้เลือกไฟล์ประเภทรูปภาพได้
            // The setting up of the dropzone
            init: function() {
                myDropzone = this;
                this.on("addedfile", function(file) {
                    //$('#infinite').append("<input type='text' class='form_none' name='imgFiles[]' value='" + file.name + "'/>");
                    $('#infinite').append("<input type='text' id='" + file.newName +
                        "' class='form_none' name='imgFiles2[]' value='" + file.newName + "'/>");
                    file.previewElement.id = file.newName;
                }).on("removedfile", function(file) {
                    //alert(file.id);
                    //var name = file.name;
                    var name = file.previewElement.id;

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        url: '{{ route('form.delete') }}',
                        data: {
                            name: name,
                        },
                        success: function(data) {
                            console.log('success: ' + data);
                            var element = document.getElementById("infinite");
                            var child = document.getElementById(name);
                            element.removeChild(child);
                            if (!document.getElementsByName('imgFiles2[]').length) {
                                //alert();
                                $('#dropzone_preview2').css("display", "none");
                                $('#dropzone-att').addClass('form-focus-error');
                                $('#dropzone-att')
                                    .find('.form-error-message').css("display", "block");
                                $('#dropzone-att').css('border', 'solid 1px red');
                            }
                        }
                    });

                    //var _ref;
                    //return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                }).on("maxfilesexceeded", function(file) {
                    alert('allow maximum 2 file');
                    this.removeFile(file);
                }).on('complete', function(file) {
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
                    $('#dropzone_preview2').css("display", "block");
                    $('#dropzone-att').removeClass('form-focus-error');
                    $('#dropzone-att')
                        .find('.form-error-message').css("display", "none");
                    $('#dropzone-att').css('border', 'solid 1px green');
                    if (document.getElementsByName('imgFiles2[]').length) {
                        //$('#error_div').css('display', 'none');
                    }
                }).on("success", function(file) {
                    //var responseText = file.id // or however you would point to your assigned file ID here;
                    //console.log(response); // console should show the ID you pointed to
                    // do stuff with file.id ...
                }).on("error", function(file) {
                    this.removeFile(file);
                    // this.removeFile(file);
                    console.log(file);
                    $('#imgFiles2').val('');
                    while (imgFiles2.length > 0) {
                        imgFiles2[0].parentNode.removeChild(imgFiles2[0]);
                    }
                    // document.getElementsByName('imgFiles2[]').length = 0;
                    alert("ไม่อนุญาตให้อัพโหลดไฟล์เกิน 5 MB");
                });
                /*this.on("addedfile", function(file) {

                }).on("removedfile", function(file) {

                }).on("thumbnail", function(file) {

                }).on("error", function(file) {

                }).on("processing", function(file) {

                }).on("uploadprogress", function(file) {

                });*/

            }
        }

        if ($.validator) {
            const originalCheck = $.validator.prototype.check;
            $.validator.prototype.check = function(element) {
                if (!element || !element.getAttribute || !element.name) {
                    return true;
                }
                return originalCheck.call(this, element);
            };
        }

        const valid_option = {
            ignore: ':hidden, [disabled], :not([name])',
            onkeyup: false,
            showErrors: function(errorMap, errorList) {
                var errors = this.numberOfInvalids();
                /* if (!document.getElementsByName('imgFiles[]').length) {
                    errors = errors + 1;
                }
                if (!document.getElementsByName('imgFiles2[]').length) {
                    errors = errors + 1;
                } */
                if (errors) {
                    var message = errors == 1 ?
                        '<br>You missed <span class="error-rounded-bg">1</span> field. It has been highlighted' :
                        '<br>You have missed <span class="error-rounded-bg">' + errors +
                        '</span> fields. Please fill before submitted.';
                    $("#error_div").html(message);
                    $(".error_div").show();
                    $('#loader-container').hide();
                } else {
                    $(".error_div").hide();
                    $('#loader-container').hide();
                }
                this.defaultShowErrors();

            },

            submitHandler: function(form) {
                $('#loader-container').show();
                $('#send_data').attr('disabled', true);

                // Check agreeCheckbox first
                const $agreeCheckbox = $('#agreeCheckbox');
                const $agreeWrapper = $agreeCheckbox.closest('.form-group');

                if (!$agreeCheckbox.is(':checked')) {
                    $agreeWrapper.addClass('form-focus-error');
                    if (!$agreeWrapper.find('.form-error-message').length) {
                        $agreeWrapper.append(`
                            <div class="form-error-message" role="alert">
                                <img src="https://cdn.jotfor.ms/images/exclamation-octagon.png" height="10">
                                <span class="error-navigation-message">
                                    กรุณาติ๊ก "ตกลงและยอมรับข้อกำหนดและเงื่อนไข รวมถึงตรวจสอบข้อมูลและเนื้อหาต่างๆเรียบร้อยแล้ว" ก่อนส่งฟอร์ม
                                </span>
                                <div class="form-error-arrow">
                                    <div class="form-error-arrow-inner"></div>
                                </div>
                            </div>
                        `);
                    } else {
                        $agreeWrapper.find('.form-error-message').show();
                    }

                    jumpTo('agreeCheckbox');
                    alert(
                        'กรุณาติ๊ก "ตกลงและยอมรับข้อกำหนดและเงื่อนไข รวมถึงตรวจสอบข้อมูลและเนื้อหาต่างๆเรียบร้อยแล้ว" ก่อนส่งฟอร์ม'
                    );
                    $('#loader-container').hide();
                    $('#send_data').attr('disabled', false);
                    return false;
                } else {
                    $agreeWrapper.removeClass('form-focus-error');
                    $agreeWrapper.find('.form-error-message').hide();
                }

                const $photoWrapper = $('#dropzone-photo');
                const $slipWrapper = $('#dropzone-att');
                const photoActive = $photoWrapper.length && $photoWrapper.is(':visible') && !$photoWrapper.find(
                    'input, textarea, select').filter(':enabled').length;
                const slipActive = $slipWrapper.length && $slipWrapper.is(':visible') && !$slipWrapper.find(
                    'input, textarea, select').filter(':enabled').length;

                let missing = false;

                if ($photoWrapper.length && $photoWrapper.is(':visible')) {
                    const hasPhoto = document.getElementsByName('imgFiles[]').length > 0;
                    if (!hasPhoto) {
                        missing = true;
                        $photoWrapper.addClass('form-focus-error');
                        $photoWrapper.find('.form-error-message').css('display', 'block');
                        $photoWrapper.css('border', 'solid 1px red');
                        jumpTo('dphoto');
                    } else {
                        $photoWrapper.removeClass('form-focus-error');
                        $photoWrapper.find('.form-error-message').css('display', 'none');
                        $photoWrapper.css('border', '');
                    }
                }

                if ($slipWrapper.length && $slipWrapper.is(':visible')) {
                    const hasSlip = document.getElementsByName('imgFiles2[]').length > 0;
                    if (!hasSlip) {
                        missing = true;
                        $slipWrapper.addClass('form-focus-error');
                        $slipWrapper.find('.form-error-message').css('display', 'block');
                        $slipWrapper.css('border', 'solid 1px red');
                        if (!missing) {
                            jumpTo('datt');
                        }
                    } else {
                        $slipWrapper.removeClass('form-focus-error');
                        $slipWrapper.find('.form-error-message').css('display', 'none');
                        $slipWrapper.css('border', '');
                    }
                }

                if (missing) {
                    $('#loader-container').hide();
                    $('#send_data').attr('disabled', false);
                    return false;
                }

                form.submit();
                return true;
            }
        }

        $(document).ready(function() {
            // $('#loader-container').show();

            $(".AddDate").inputmask("99-99-9999");
            $(".AddPhone").inputmask("(999) 999-9999");

            $("#infinite").validate(valid_option);

            $('#btnUpload').on('click', function() {
                myDropzone.processQueue();
            });
        });

        function check_input() {
            $('.form-control').focus();

            const $agreeCheckbox = $('#agreeCheckbox');
            const $agreeWrapper = $agreeCheckbox.closest('.form-group');

            if (!$agreeCheckbox.is(':checked')) {
                $agreeWrapper.addClass('form-focus-error');
                if (!$agreeWrapper.find('.form-error-message').length) {
                    $agreeWrapper.append(`
                        <div class="form-error-message" role="alert">
                            <img src="https://cdn.jotfor.ms/images/exclamation-octagon.png" height="10">
                            <span class="error-navigation-message">
                                กรุณาติ๊ก "ตกลงและยอมรับข้อกำหนดและเงื่อนไข รวมถึงตรวจสอบข้อมูลและเนื้อหาต่างๆเรียบร้อยแล้ว" ก่อนส่งฟอร์ม
                            </span>
                            <div class="form-error-arrow">
                                <div class="form-error-arrow-inner"></div>
                            </div>
                        </div>
                    `);
                } else {
                    $agreeWrapper.find('.error-navigation-message').text(
                        'กรุณาติ๊ก "ตกลงและยอมรับข้อกำหนดและเงื่อนไข รวมถึงตรวจสอบข้อมูลและเนื้อหาต่างๆเรียบร้อยแล้ว" ก่อนส่งฟอร์ม'
                    );
                    $agreeWrapper.find('.form-error-message').show();
                }

                jumpTo('agreeCheckbox');
                alert(
                    'กรุณาติ๊ก "ตกลงและยอมรับข้อกำหนดและเงื่อนไข รวมถึงตรวจสอบข้อมูลและเนื้อหาต่างๆเรียบร้อยแล้ว" ก่อนส่งฟอร์ม'
                );

                return false;
            } else {
                $agreeWrapper.removeClass('form-focus-error');
                $agreeWrapper.find('.form-error-message').hide();
            }

            if (document.getElementsByName('imgFiles[]').length && document.getElementsByName('imgFiles2[]')
                .length) {
                //$('#error_div').css('display', 'none');


                return true;
            } else {
                if (!document.getElementsByName('imgFiles[]').length) {
                    $('#dropzone-photo').addClass('form-focus-error');
                    $('#dropzone-photo')
                        .find('.form-error-message').css("display", "block");
                    $('#dropzone-photo').css('border', 'solid 1px red');
                    jumpTo('dphoto');
                }
                if (!document.getElementsByName('imgFiles2[]').length) {
                    $('#dropzone-att').addClass('form-focus-error');
                    $('#dropzone-att')
                        .find('.form-error-message').css("display", "block");
                    $('#dropzone-att').css('border', 'solid 1px red');
                    jumpTo('datt');
                }

                //$('#error_div').css('display', 'block');
                return false;
            }

        }

        function jumpTo(id) {
            var get = location.href;
            location.href = "#" + id;
        }

        var fixmeTop = $('.error_div').offset().top;
        $(window).scroll(function() {
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
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Package-Grade linking data
        const packageGradeLinks = @json(
            $form->packages->mapWithKeys(function ($package) {
                return [$package->id => $package->linked_grades];
            }));

        const gradeNameMap = @json(
            $form->grades->mapWithKeys(function ($grade) {
                return [$grade->id => $grade->grade];
            }));

        // Validate package selection against grade
        function validatePackageGradeCompatibility(selectedPackageIds, selectedGradeId) {
            if (!selectedGradeId) {
                return {
                    valid: true
                };
            }

            // Convert to integer for comparison
            selectedGradeId = parseInt(selectedGradeId);

            const incompatiblePackages = [];

            selectedPackageIds.forEach(packageId => {
                // Convert packageId to integer for consistent comparison
                packageId = parseInt(packageId);
                let linkedGrades = packageGradeLinks[packageId];

                // Convert linked grades to integers if they are strings
                if (linkedGrades && linkedGrades.length > 0) {
                    linkedGrades = linkedGrades.map(g => parseInt(g));
                }

                // Debug log
                console.log('Package ID:', packageId, 'Linked Grades:', linkedGrades, 'Selected Grade ID:',
                    selectedGradeId);

                // If linkedGrades is null or empty, package is available for all grades
                if (linkedGrades && linkedGrades.length > 0) {
                    // Check if selected grade is in the linked grades
                    if (!linkedGrades.includes(selectedGradeId)) {
                        // Find package name
                        const packageOption = $(`#package option[value="${packageId}"]`);
                        const packageName = packageOption.text();
                        const gradeName = gradeNameMap[selectedGradeId] || selectedGradeId;
                        incompatiblePackages.push({
                            id: packageId,
                            name: packageName,
                            gradeName: gradeName,
                            allowedGrades: linkedGrades
                        });
                    }
                }
            });

            if (incompatiblePackages.length > 0) {
                return {
                    valid: false,
                    incompatiblePackages: incompatiblePackages
                };
            }

            return {
                valid: true
            };
        }

        // Initialize Select2 for multi-select package
        $(document).ready(function() {
            const gradeSelect = $('#grade');
            const packageSelect = $('#package');
            const isMultiSelect = packageSelect.hasClass('select2-package');

            if (isMultiSelect) {
                const maxSelection = packageSelect.data('max-selection');

                const select2Options = {
                    placeholder: 'Select packages',
                    allowClear: true,
                    closeOnSelect: false,
                    width: '100%'
                };

                // Add maximumSelectionLength if max selection is set
                if (maxSelection && maxSelection !== '') {
                    select2Options.maximumSelectionLength = parseInt(maxSelection);
                    select2Options.language = {
                        maximumSelected: function(e) {
                            return 'You can only select ' + e.maximum +
                                ' package(s) / คุณสามารถเลือกได้สูงสุด ' + e.maximum + ' แพคเกจเท่านั้น';
                        }
                    };
                }

                packageSelect.select2(select2Options);

                // Handle validation for required field
                if (packageSelect.prop('required')) {
                    packageSelect.on('change', function() {
                        if ($(this).val() && $(this).val().length > 0) {
                            $(this).removeClass('is-invalid');
                        }
                    });
                }
            }

            // Validate when package changes
            packageSelect.on('change', function() {
                const selectedGrade = gradeSelect.val();
                let selectedPackages = [];

                if (isMultiSelect) {
                    selectedPackages = $(this).val() || [];
                } else {
                    const singleValue = $(this).val();
                    if (singleValue) {
                        selectedPackages = [parseInt(singleValue)];
                    }
                }

                if (selectedPackages.length > 0 && selectedGrade) {
                    const validation = validatePackageGradeCompatibility(selectedPackages, selectedGrade);

                    if (!validation.valid) {
                        const packageNames = validation.incompatiblePackages.map(p => p.name).join(', ');
                        const gradeName = validation.incompatiblePackages[0].gradeName;

                        Swal.fire({
                            icon: 'error',
                            title: '<span style="color: #dc3545;"><i class="fa fa-exclamation-triangle"></i> ไม่สามารถเลือกแพคเกจนี้ได้</span>',
                            html: `
                                <div style="text-align: left; padding: 15px;">
                                    <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 15px;">
                                        <p style="margin: 0; font-size: 15px; color: #856404;">
                                            <strong><i class="fa fa-info-circle"></i> แพคเกจที่ไม่สามารถเลือกได้:</strong>
                                        </p>
                                        <p style="margin: 10px 0 0 0; font-size: 16px; color: #333;">
                                            <strong style="color: #dc3545;">${packageNames}</strong>
                                        </p>
                                    </div>

                                    <div style="background: #f8d7da; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-bottom: 15px;">
                                        <p style="margin: 0; font-size: 15px; color: #721c24;">
                                            <strong><i class="fa fa-times-circle"></i> เหตุผล:</strong>
                                        </p>
                                        <p style="margin: 10px 0 0 0; font-size: 15px; color: #333;">
                                            แพคเกจนี้ไม่เหมาะสำหรับระดับชั้น <strong style="color: #6351a2;">${gradeName}</strong>
                                        </p>
                                    </div>

                                    <div style="background: #d1ecf1; padding: 12px; border-radius: 6px; border-left: 4px solid #17a2b8;">
                                        <p style="margin: 0; font-size: 14px; color: #0c5460;">
                                            <i class="fa fa-lightbulb"></i> <strong>คำแนะนำ:</strong> กรุณาเลือกแพคเกจอื่น หรือเปลี่ยนระดับชั้นที่เลือก
                                        </p>
                                    </div>
                                </div>
                            `,
                            confirmButtonText: '<i class="fa fa-check"></i> รับทราบ',
                            confirmButtonColor: '#6351a2',
                            width: window.innerWidth < 768 ? '90%' : '550px'
                        }).then(() => {
                            // Remove incompatible packages from selection
                            if (isMultiSelect) {
                                const validPackages = selectedPackages.filter(id =>
                                    !validation.incompatiblePackages.some(p => p.id == id)
                                );
                                packageSelect.val(validPackages).trigger('change.select2');
                            } else {
                                packageSelect.val('').trigger('change');
                            }
                        });
                    }
                }
            });

            // Validate when grade changes
            gradeSelect.on('change', function() {
                const selectedGrade = $(this).val();
                let selectedPackages = [];

                if (isMultiSelect) {
                    selectedPackages = packageSelect.val() || [];
                } else {
                    const singleValue = packageSelect.val();
                    if (singleValue) {
                        selectedPackages = [parseInt(singleValue)];
                    }
                }

                if (selectedPackages.length > 0 && selectedGrade) {
                    const validation = validatePackageGradeCompatibility(selectedPackages, selectedGrade);

                    if (!validation.valid) {
                        const packageNames = validation.incompatiblePackages.map(p => p.name).join(', ');
                        const gradeName = validation.incompatiblePackages[0].gradeName;

                        Swal.fire({
                            icon: 'warning',
                            title: '<span style="color: #ff9800;"><i class="fa fa-exclamation-circle"></i> แจ้งเตือนการเปลี่ยนระดับชั้น</span>',
                            html: `
                                <div style="text-align: left; padding: 15px;">
                                    <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 15px;">
                                        <p style="margin: 0; font-size: 15px; color: #856404;">
                                            <strong><i class="fa fa-graduation-cap"></i> ระดับชั้นที่เลือก:</strong>
                                        </p>
                                        <p style="margin: 10px 0 0 0; font-size: 16px; color: #333;">
                                            <strong style="color: #6351a2;">${gradeName}</strong>
                                        </p>
                                    </div>

                                    <div style="background: #ffe5e5; padding: 15px; border-radius: 8px; border-left: 4px solid #ff9800; margin-bottom: 15px;">
                                        <p style="margin: 0; font-size: 15px; color: #8b4513;">
                                            <strong><i class="fa fa-times-circle"></i> แพคเกจที่ไม่รองรับระดับชั้นนี้:</strong>
                                        </p>
                                        <p style="margin: 10px 0 0 0; font-size: 16px; color: #333;">
                                            <strong style="color: #dc3545;">${packageNames}</strong>
                                        </p>
                                    </div>

                                    <div style="background: #d1ecf1; padding: 12px; border-radius: 6px; border-left: 4px solid #17a2b8;">
                                        <p style="margin: 0; font-size: 14px; color: #0c5460;">
                                            <i class="fa fa-info-circle"></i> <strong>การดำเนินการ:</strong> แพคเกจที่ไม่รองรับจะถูกลบออกจากการเลือกโดยอัตโนมัติ
                                        </p>
                                    </div>
                                </div>
                            `,
                            confirmButtonText: '<i class="fa fa-check"></i> เข้าใจแล้ว',
                            confirmButtonColor: '#ff9800',
                            width: window.innerWidth < 768 ? '90%' : '550px'
                        }).then(() => {
                            // Remove incompatible packages from selection
                            if (isMultiSelect) {
                                const validPackages = selectedPackages.filter(id =>
                                    !validation.incompatiblePackages.some(p => p.id == id)
                                );
                                packageSelect.val(validPackages).trigger('change.select2');
                            } else {
                                packageSelect.val('').trigger('change');
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script>
        // Exam Mode Logic
        $(document).ready(function() {
            // Prepare data from server
            const packageExamModes = {
                @foreach ($form->packages as $pkg)
                    "{{ $pkg->id }}": {{ $pkg->has_exam_mode ? 1 : 0 }},
                @endforeach
            };

            // Form-level limits (not package-level)
            const formLimits = {
                online_limit: {{ $form->online_limit ?? 'null' }},
                onsite_limit: {{ $form->onsite_limit ?? 'null' }},
                online_registered: {{ $form->online_registered ?? 0 }},
                onsite_registered: {{ $form->onsite_registered ?? 0 }}
            };

            function getAvailableSlots(mode) {
                if (mode === 'online') {
                    if (formLimits.online_limit === null) return { available: true, remaining: null };
                    const remaining = formLimits.online_limit - formLimits.online_registered;
                    return { available: remaining > 0, remaining: remaining };
                } else {
                    if (formLimits.onsite_limit === null) return { available: true, remaining: null };
                    const remaining = formLimits.onsite_limit - formLimits.onsite_registered;
                    return { available: remaining > 0, remaining: remaining };
                }
            }

            function updateExamModeOptions() {
                const onlineSlots = getAvailableSlots('online');
                const onsiteSlots = getAvailableSlots('onsite');

                const $onlineRadio = $('#exam_mode_online');
                const $onsiteRadio = $('#exam_mode_onsite');
                const $onlineLabel = $('label[for="exam_mode_online"]');
                const $onsiteLabel = $('label[for="exam_mode_onsite"]');

                // Update Online option
                if (!onlineSlots.available) {
                    $onlineRadio.prop('disabled', true);
                    $onlineLabel.html('<i class="fas fa-laptop"></i> Online (สอบออนไลน์) <span class="badge badge-danger">เต็มแล้ว</span>');
                    if ($onlineRadio.is(':checked')) {
                        $onsiteRadio.prop('checked', true);
                    }
                } else {
                    $onlineRadio.prop('disabled', false);
                    let onlineText = '<i class="fas fa-laptop"></i> Online (สอบออนไลน์)';
                    if (onlineSlots.remaining !== null) {
                        onlineText += ' <span class="badge badge-info">เหลือ ' + onlineSlots.remaining + ' ที่นั่ง</span>';
                    }
                    $onlineLabel.html(onlineText);
                }

                // Update Onsite option
                if (!onsiteSlots.available) {
                    $onsiteRadio.prop('disabled', true);
                    $onsiteLabel.html('<i class="fas fa-chalkboard-teacher"></i> Onsite (สอบนอกสถานที่) <span class="badge badge-danger">เต็มแล้ว</span>');
                    if ($onsiteRadio.is(':checked')) {
                        $onlineRadio.prop('checked', true);
                    }
                } else {
                    $onsiteRadio.prop('disabled', false);
                    let onsiteText = '<i class="fas fa-chalkboard-teacher"></i> Onsite (สอบนอกสถานที่)';
                    if (onsiteSlots.remaining !== null) {
                        onsiteText += ' <span class="badge badge-info">เหลือ ' + onsiteSlots.remaining + ' ที่นั่ง</span>';
                    }
                    $onsiteLabel.html(onsiteText);
                }

                // If both are full, show warning
                if (!onlineSlots.available && !onsiteSlots.available) {
                    $('#exam_mode_container').find('.form-text').html(
                        '<i class="fas fa-exclamation-triangle text-danger"></i> <span class="text-danger">ขออภัย มีผู้สมัครเต็มทั้ง Online และ Onsite แล้ว</span>'
                    );
                } else {
                    $('#exam_mode_container').find('.form-text').html(
                        '<i class="fas fa-info-circle"></i> โปรดระบุรูปแบบการสอบที่ท่านต้องการ (Online หรือ Onsite)'
                    );
                }
            }

            function checkExamModeVisibility() {
                const packageSelect = $('#package');
                const examModeContainer = $('#exam_mode_container');
                let selectedValues = packageSelect.val();

                // Handle single select (string) or multi (array) or null
                if (!selectedValues) {
                    selectedValues = [];
                } else if (!Array.isArray(selectedValues)) {
                    selectedValues = [selectedValues];
                }

                let showExamMode = false;
                selectedValues.forEach(function(pkgId) {
                    if (pkgId && packageExamModes[pkgId] == 1) {
                        showExamMode = true;
                    }
                });

                if (showExamMode) {
                    examModeContainer.slideDown();
                    // Set required attribute
                    $('input[name="exam_mode"]').attr('required', true);

                    // Default to online if nothing checked
                    if (!$('input[name="exam_mode"]:checked').length) {
                        $('#exam_mode_online').prop('checked', true);
                    }

                    // Update available slots
                    updateExamModeOptions();
                } else {
                    examModeContainer.slideUp();
                    $('input[name="exam_mode"]').removeAttr('required');
                }
            }

            // Bind change event
            $('#package').on('change', checkExamModeVisibility);

            // Initial Check (in case of validation error reload)
            checkExamModeVisibility();
        });
    </script>
    <script type="text/javascript">
        const warningTitleCSS = 'color:red; font-size:60px; font-weight: bold; -webkit-text-stroke: 1px black;';
        const warningDescCSS = 'font-size: 18px;';

        console.log('%cหยุด!', warningTitleCSS);
        console.log(
            "%cนี่เป็นคุณสมบัติการทำงานของเบราว์เซอร์ที่มีจุดมุ่งหมายให้ใช้สำหรับผู้พัฒนา หากผู้ใดบอกให้คุณคัดลอกแล้ววางข้อความบางอย่างที่นี่เพื่อเปิดใช้งานคุณสมบัติการทำงานของ ระบบ หรือเพื่อเข้าถึงบัญชีของบุคคลใดบุคคลหนึ่ง โดยมิชอบ คำบอกกล่าวเช่นนี้เป็นกลลวงและจะทำให้ผู้นั้นมีสิทธิ์เข้าถึงบัญชี ของคุณ",
            warningDescCSS);
        //console.log('%cSee https://www.facebook.com/selfxss for more information.', warningDescCSS);
    </script>
@endsection
