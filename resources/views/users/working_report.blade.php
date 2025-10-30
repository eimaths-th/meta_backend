@extends('layouts.main_template')


@section('style')
    <!-- Stylesheets -->


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="../assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="../assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"> --}}

    <link href="/assets/plugins/@fullcalendar/common/main.min.css" rel="stylesheet" />
    <link href="/assets/plugins/@fullcalendar/daygrid/main.min.css" rel="stylesheet" />
    <link href="/assets/plugins/@fullcalendar/timegrid/main.min.css" rel="stylesheet" />
    <link href="/assets/plugins/@fullcalendar/list/main.min.css" rel="stylesheet" />
    <link href="/assets/plugins/@fullcalendar/bootstrap/main.min.css" rel="stylesheet" />
    {{-- <link href="/assets/css/vendor.min.css" rel="stylesheet" /> --}}
    {{-- <link href="/assets/css/default/app.min.css" rel="stylesheet" /> --}}

    <style>
        @media screen and (max-width: 100px) {
            .screen-auto {
                max-width: 100%;
                height: auto;
            }
        }

        .screen-auto {
            max-width: 800;
            height: 200;
        }
    </style>
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    </script> --}}
@endsection




@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-home
                            icon-gradient bg-happy-itmeo">
                    </i>
                </div>
                <div>Wellcome
                    <div class="page-title-subheading">
                        META Knowledge Dashboard
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- <div class="main-card mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                Current Month Report <br>{{ date('F - Y') }}
            </div>
        </div>

        <div class="g-0 row">
            @foreach ($rec_times as $status => $count)
                @if ($status != 'วันหยุด')
                    @php
                        $total = 'Total';
                        $class = 'secondary';
                        switch ($status) {
                            case 'ปกติ':
                                $class = 'success';
                                break;
                            case 'สาย':
                            case 'ออกก่อน':
                            case 'ลาครึ่งวัน':
                            case 'ไม่แสกนออก':
                            case 'ไม่แสกนเข้า':
                                $class = 'warning';
                                break;
                            case 'OT':
                            case 'ชดเชย':
                                $class = 'primary';
                                break;
                            case 'ขาดงาน':
                                $class = 'danger';
                                break;
                            case 'ลาป่วย':
                                $class = 'danger';
                                $total = 'คงเหลือ ' . 30 - $count . 'ครั้ง';
                                break;
                            case 'ลาพักร้อน':
                                $class = 'danger';

                                $total = 'คงเหลือ ' . 6 - $count . 'ครั้ง';
                                break;
                            case 'ลากิจ':
                                $class = 'danger';
                                // Add more cases as needed
                                $total = 'คงเหลือ ' . 2 - $count . 'ครั้ง';
                                break;
                            default:
                                $class = 'secondary'; // Default color
                        }

                    @endphp
                    <div class="col-md-2">
                        <div class="pt-0 pb-0 card-body">
                            <ul class="list-group list-group-flush">

                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading text-{{ $class }}">
                                                        {{ $status }}
                                                    </div>
                                                    <div class="widget-subheading">{{ $total }}</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-heading">
                                                        {{ $count }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div> --}}

    {{-- <div class="main-card mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                Current Year Report <br>{{ date('Y') }}
            </div>
        </div>
        <div class="g-0 row">

            @foreach ($rec_times_year as $status => $count)
                @if ($status != 'วันหยุด')
                    @php
                        $total = 'Total';
                        $class = 'secondary';
                        switch ($status) {
                            case 'ปกติ':
                                $class = 'success';
                                break;
                            case 'สาย':
                            case 'ออกก่อน':
                            case 'ลาครึ่งวัน':
                            case 'ไม่แสกนออก':
                            case 'ไม่แสกนเข้า':
                                $class = 'warning';
                                break;
                            case 'OT':
                            case 'ชดเชย':
                                $class = 'primary';
                                break;
                            case 'ขาดงาน':
                                $class = 'danger';
                                break;
                            case 'ลาป่วย':
                                $class = 'danger';
                                $total = 'คงเหลือ ' . 30 - $count . 'ครั้ง';
                                break;
                            case 'ลาพักร้อน':
                                $class = 'danger';

                                $total = 'คงเหลือ ' . 6 - $count . 'ครั้ง';
                                break;
                            case 'ลากิจ':
                                $class = 'danger';
                                // Add more cases as needed
                                $total = 'คงเหลือ ' . 2 - $count . 'ครั้ง';
                                break;
                            default:
                                $class = 'secondary'; // Default color
                        }

                    @endphp
                    <div class="col-md-2">
                        <div class="pt-0 pb-0 card-body">
                            <ul class="list-group list-group-flush">

                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-outer">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading text-{{ $class }}">
                                                        {{ $status }}</div>
                                                    <div class="widget-subheading">{{ $total }}</div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <div class="widget-heading">
                                                        {{ $count }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div> --}}

    <div class="main-card mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                Current Month Report <br>{{ date('F - Y') }}
            </div>
        </div>
        <div class="g-0 row">
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-success">
                                                ปกติ
                                            </div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-heading text-success">
                                                {{ $rec_times['ปกติ'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-warning">
                                                สาย
                                            </div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-heading text-warning">
                                                {{ $rec_times['สาย'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-primary">OT</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-primary">
                                                {{ $rec_times['OT'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-primary">ชดเชย</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-primary">
                                                {{ $rec_times['ชดเชย'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-warning">ออกก่อน</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times['ออกก่อน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-warning">ลาครึ่งวัน</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times['ลาครึ่งวัน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-warning">ไม่แสกนออก</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times['ไม่แสกนออก'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-warning">ไม่แสกนเข้า</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times['ไม่แสกนเข้า'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ขาดงาน</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times['ขาดงาน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ลาป่วย</div>
                                            <div class="widget-subheading">
                                                @php
                                                    $sumA = 30;
                                                    if (isset($rec_times_year['ลาป่วย'])) {
                                                        $sumA = 30 - $rec_times_year['ลาป่วย'];
                                                    }
                                                @endphp
                                                คงเหลือ {{ $sumA }} ครั้ง
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times['ลาป่วย'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ลาพักร้อน</div>
                                            <div class="widget-subheading">
                                                @php
                                                    $sumb = 6;
                                                    if (isset($rec_times_year['ลาพักร้อน'])) {
                                                        $sumb = 6 - $rec_times_year['ลาพักร้อน'];
                                                    }
                                                @endphp
                                                คงเหลือ {{ $sumb }} ครั้ง
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times['ลาพักร้อน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ลากิจ</div>
                                            <div class="widget-subheading">
                                                @php
                                                    $sumc = 3;
                                                    if (isset($rec_times_year['ลากิจ'])) {
                                                        $sumc = 3 - $rec_times_year['ลากิจ'];
                                                    }
                                                @endphp
                                                {{--  --}}
                                                คงเหลือ {{ $sumc }} ครั้ง
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times['ลากิจ'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-premium-dark">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">วันหยุด</div>
                        <div class="widget-subheading">Total</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning">
                            <span> {{ $rec_times['วันหยุด'] ?? 0 }} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="main-card mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                Current Month Report <br>{{ date('F - Y') }}
            </div>
        </div>
        <div class="row">

        </div>
    </div> --}}

    <div class="main-card mb-3 card">
        <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
                <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                Current Year Report <br>{{ date('Y') }}
            </div>
        </div>
        <div class="g-0 row">
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-success">
                                                ปกติ
                                            </div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-heading text-success">
                                                {{ $rec_times_year['ปกติ'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-warning">
                                                สาย
                                            </div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-heading text-warning">
                                                {{ $rec_times_year['สาย'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-primary">OT</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-primary">
                                                {{ $rec_times_year['OT'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-primary">ชดเชย</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-primary">
                                                {{ $rec_times_year['ชดเชย'] ?? 0 }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-warning">ออกก่อน</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times_year['ออกก่อน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-warning">ลาครึ่งวัน</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times_year['ลาครึ่งวัน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-warning">ไม่แสกนออก</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times_year['ไม่แสกนออก'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-warning">ไม่แสกนเข้า</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning">
                                                {{ $rec_times_year['ไม่แสกนเข้า'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ขาดงาน</div>
                                            <div class="widget-subheading">Total</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times_year['ขาดงาน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ลาป่วย</div>
                                            <div class="widget-subheading">
                                                @php
                                                    $sumA = 30;
                                                    if (isset($rec_times_year['ลาป่วย'])) {
                                                        $sumA = 30 - $rec_times_year['ลาป่วย'];
                                                    }
                                                @endphp
                                                คงเหลือ {{ $sumA }} ครั้ง
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times_year['ลาป่วย'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <div class="pt-0 pb-0 card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ลาพักร้อน</div>
                                            <div class="widget-subheading">
                                                @php
                                                    $sumb = 6;
                                                    if (isset($rec_times_year['ลาพักร้อน'])) {
                                                        $sumb = 6 - $rec_times_year['ลาพักร้อน'];
                                                    }
                                                @endphp
                                                คงเหลือ {{ $sumb }} ครั้ง
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times_year['ลาพักร้อน'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading text-nowrap text-danger">ลากิจ</div>
                                            <div class="widget-subheading">
                                                @php
                                                    $sumc = 3;
                                                    if (isset($rec_times_year['ลากิจ'])) {
                                                        $sumc = 3 - $rec_times_year['ลากิจ'];
                                                    }
                                                @endphp
                                                คงเหลือ {{ $sumc }} ครั้ง
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger">
                                                {{ $rec_times_year['ลากิจ'] ?? 0 }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-premium-dark">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">วันหยุด</div>
                        <div class="widget-subheading">Total</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning">
                            <span> {{ $rec_times_year['วันหยุด'] ?? 0 }} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <button class="btn btn-warning mb-5" id="clearEventsButton">Clear</button> --}}

    <!-- breadcrumb -->

    {{-- <div id="calendar1">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-car icon-gradient bg-warm-flame">
                        </i>
                    </div>
                    <div>Calendar
                        <div class="page-title-subheading">Calendars are used in a lot of apps. We thought
                            to include one for React.
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                    <span>Basic Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                    <span>List View</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                    <span>Background Events</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div id="calendar-list"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div id="calendar-bg-events">test</div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- END breadcrumb -->


    <div class="main-card mb-3 card">
        <div id="calendar2">

            <div class="card-header-tab card-header-tab-animation card-header mb-3">
                <div class="card-header-title">
                    <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                    Work record of {{ auth()->user()->name }}
                </div>
            </div>

            <div class="col-lg">
                <div class="pt-0 pb-0 card-body mb-5">

                    <div id="calendar" class="calendar " style="max-height: 600px;"></div>

                </div>
            </div>
        </div>
    </div>

    {{-- <div id="calendar2" class="mb-5">
        <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
            <li class="breadcrumb-item active">Calendar</li>
        </ol>
        <!-- END breadcrumb -->
        <!-- BEGIN page-header -->
        <h1 class="page-header">Calendar <small>header small text goes here...</small></h1>
        <!-- END page-header -->
        <hr />
        <!-- BEGIN row -->
        <div class="row">
            <div class="col-lg">
                <!-- BEGIN calendar -->
                <div id="calendar" class="calendar"></div>
                <!-- END calendar -->
            </div>
        </div>
    </div> --}}
@endsection
{{-- @section('script')
    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/demo/calendar.demo.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('architectui/assets/scripts/fullcalendar.js') }}"></script>
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/@fullcalendar/core/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/daygrid/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/timegrid/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/interaction/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/list/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/bootstrap/main.global.js"></script>
    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('hello world !!');

            // FullCalendar initialization and other code
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                // Configuration options...
            });
            console.log(calendar);
            document.getElementById('clearEventsButton').addEventListener('click', function() {
                console.log('Event listener triggered');
                clearAllEvents();
            });

            // Function to clear all events
            function clearAllEvents() {
                calendar.getEvents().forEach(function(event) {
                    event.remove();
                });
            }
            console.log(calendar.getEvents());
            // Render the calendar
            calendar.render();
        });
    </script>
@endsection --}}
{{-- @section('script')
    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/demo/calendar.demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('architectui/assets/scripts/fullcalendar.js') }}"></script>
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/@fullcalendar/core/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/daygrid/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/timegrid/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/interaction/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/list/main.global.js"></script>
    <script src="/assets/plugins/@fullcalendar/bootstrap/main.global.js"></script>
    <!-- Include other plugins as needed -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('hello world !!');

            // FullCalendar initialization and other code
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                // Configuration options...
            });

            document.getElementById('clearEventsButton').addEventListener('click', function() {
                console.log('Event listener triggered');
                clearAllEvents();
            });

            // Function to clear all events
            function clearAllEvents() {
                calendar.getEvents().forEach(function(event) {
                    event.remove();
                });
            }

            // Render the calendar
            calendar.render();
        });
    </script>
@endsection --}}
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/multimonth@6.1.11/index.global.min.js'></script>
    {{-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap@6.1.11/index.global.min.js'></script> --}}


    <!-- Include other plugins as needed -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('hello world !!');

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                // initialDate: '2024-02-07',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                events: [

                    @php
                        foreach ($rec_times_years as $rec_years) {
                            $class = '';
                            switch ($rec_years->status) {
                                case 1:
                                    $color = 'rgba(58, 196, 125, 0.8)';
                                    break;

                                case 2:
                                case 3:
                                case 4:
                                case 13:
                                    $color = 'rgba(247, 185, 36, 0.8)';

                                    break;

                                case 5:
                                case 6:
                                case 7:
                                case 8:
                                case 9:
                                    $color = 'rgba(255, 91, 87,0.8)';

                                    break;

                                case 11:
                                case 12:
                                    $color = 'rgba(63, 106, 216, 0.8)';
                                    break;

                                case 10:
                                    $color = 'rgba(52, 58, 64, 0.8)';

                                    break;

                                default:
                                    break;
                            }
                            $text_late = '';
                            if ($rec_years->late_time) {
                                $text_late = ' : ' . $rec_years->late_time . ' นาที';
                            }

                            echo '{';
                            echo "title: '{$rec_years->status_name} {$text_late}',";
                            echo "start: '{$rec_years->date}',";
                            echo "color: '{$color}'";
                            echo '},';
                        }
                    @endphp

                    // {
                    //     title: 'สาย : 5 นาที',
                    //     start: '2024-03-10',
                    //     color: 'rgba(255, 91, 87,0.8)',
                    // },

                ]
            });
            calendar.render();

            document.getElementById('clearEventsButton').addEventListener('click', function() {
                console.log('Event listener triggered');
                clearAllEvents();
            });

            // Function to clear all events
            function clearAllEvents() {
                calendar.getEvents().forEach(function(event) {
                    event.remove();
                });

                // Clear the events array and re-render the calendar
                calendar.setOption('events', []);
                calendar.render();
            }

            // Render the calendar
            // calendar.render();
        });
    </script>
@endsection
