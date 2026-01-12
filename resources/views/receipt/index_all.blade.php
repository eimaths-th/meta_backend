@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/jquery.inputmask.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="plugins/moment/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js">
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection

@section('content')
    <div class="row">

        @if ($message = Session::get('success'))
            <!--<div class="alert alert-success">
                                                                                                            <p>{{ $message }}</p>
                                                                                            </div>-->
            <script>
                toastr.success('{{ $message }}', {
                    timeOut: 5000
                });
            </script>
        @endif

        @if ($message = Session::get('error'))
            <!--<div class="alert alert-success">
                                                                                                                    <p>{{ $message }}</p>
                                                                                                                        </div>-->
            <script>
                toastr.error('{{ $message }}', {
                    timeOut: 5000
                });
            </script>
        @endif

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note2 icon-gradient bg-tempting-azure"></i>
                    </div>
                    @php
                        // dd($sfielda,request()->get('sfield'));
                    @endphp
                    <div>
                        {{ $sfielda[(int) request()->get('sfield')] }} Receipts
                        <div class="page-title-subheading">META Knowledge Receipt Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a class="btn btn-info export_button" href="#"><i class="fa-solid fa-file-export"></i> Export
                            Excel </a>
                    </div>
                    <div class="d-inline-block dropdown">
                        <div class="dropdown show">
                            <button class="btn btn-shadow btn-primary dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" autoClose="true" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="fa fa-print fa-w-20"></i>
                                </span>
                                Print ใบเสร็จรายวัน
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#" id="printr4">ใบเสร็จรายวัน</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-inline-block dropdown">

                        <div class="dropdown show">
                            <button class="btn btn-shadow btn-secondary dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" autoClose="true" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="fa fa-print fa-w-20"></i>
                                </span>
                                Print ใบปะหน้า
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="#" id="printr1">ใบปะหน้ารายวัน</a></li>
                                <li><a class="dropdown-item" href="#" id="printr2">ใบปะหน้ารายเดือน</a></li>
                                <li><a class="dropdown-item" href="#" id="printr3">ใบปะหน้ารายสนาม</a></li>
                            </ul>
                        </div>

                    </div>


                    {{-- <div class="d-inline-block dropdown">
                        <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="ImportButton"><i
                                class="fa fa-file-excel"></i> Import Excel
                        </a>
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New
                            Receipt</a>
                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>

                    </div> --}}
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                {{-- <form action="{{ route('receipts') }}" method="GET">
                    @csrf
                    <input type="hidden" name="sfield" value="{{ request()->get('sfield') }}">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="start_date">วันที่เริ่มต้น</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date">วันที่สิ้นสุด</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary w-100">ค้นหา</button>
                        </div>
                    </div>
                </form> --}}
                <form action="{{ route('receipts') }}" method="GET">
                    <div class="row mb-4">

                        <div class="col-md-2">
                            <label for="sfield">School Field</label>

                            <select name="sfieldSelect" id="sfieldSelect" class="form-control">
                                <option value="">Select School Field</option>

                                @foreach ($formManage as $key => $form)
                                    @if ($form != null)
                                        <option value="{{ $key }}"
                                            {{ request()->get('sfield') == $key ? 'selected' : '' }}>
                                            {{ $form }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="date_range">วันที่</label>
                            <input type="hidden" name="sfield" id="sfield" value="{{ request()->get('sfield') }}">
                            <input type="text" name="date_range" class="form-control" id="daterange"
                                value="{{ request('date_range') ?? '' }}" autocomplete="off" placeholder="เลือกช่วงวันที่">
                        </div>
                        <div class="col-md-2">
                            <label for="date_range"> Referent Code</label>
                            <input type="hidden" name="sfield" id="sfield" value="{{ request()->get('sfield') }}">
                            <select name="referent_code" id="referent_code" class="form-control">
                                <option value="">Select Referent Code</option>
                                @foreach ($referent_codes as $referent_code)
                                    <option value="{{ $referent_code->referent_code }}"
                                        {{ request('referent_code') == $referent_code->referent_code ? 'selected' : '' }}>
                                        {{ $referent_code->referent_code }} — ({{ $referent_code->referent_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div> --}}
                    </div>
                </form>

                <form method="post" action="{{ route('receipts.destroy_all') }}" name="delete_all" id="delete_all">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="1" name="excel">
                    <input type="hidden" name="sfield" value="{{ request()->get('sfield') }}">

                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th>Type</th>
                                <th>Submission Date</th>
                                <th>Referent Code</th>
                                <th>Referent Name</th>
                                <th>Voucher Number</th>
                                <th>Customer Code</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Parent Name</th>
                                <th>Mobile</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>

                    </table>
                </form>



            </div>
        </div>

    </div>


    <div class="body-block-example-2" style="display:none" id="loder_bar">
        <br>
        <div class="loader" id="loder_bar_div">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-border text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <br>
    </div>


    <!-- PrintRDay Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="PrintRDayModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="PrintDayForm" class="form" action="{{ route('receipts.show_day') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Print ใบเสร็จรายวัน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="File">สนามสอบ:</label>
                                <select class="form-control" id="PrintDaysField" name="pdsfields" required disabled>
                                    @foreach ($sfielda as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ request()->get('sfield') == $key ? 'selected' : '' }}> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pdsfield" value="{{ request()->get('sfield') }}">
                            </div>
                            <div class="form-group">
                                <label for="Submission Date">Print Date:</label>
                                <input type="text" class="AddDate form-control" name="print_rdate"
                                    id="PrintRDaySubmissiondate" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="font">Template:</label>
                                <select class="form-control" id="template" name="template" required>
                                    <option value=""> Select </option>
                                    <option value="inf"> META Knowledge </option>
                                    <option value="meta" selected> Meta </option>
                                    <option value="meta2" selected> Meta2 </option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="font">ขนาดตัวอักษร:</label>
                                <select class="form-control" id="PrintDaysFont" name="fontsize" required>
                                    <option value="1"> เล็กมาก </option>
                                    <option value="2" selected> เล็ก </option>
                                    <option value="3"> ปานกลาง </option>
                                    <option value="4"> ใหญ่ </option>

                                </select>
                            </div>

                        </div>


                    </div>
                    <!-- Modal footer id="SubmitPrintDayForm"-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Print</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- PrintDay Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="PrintDayModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="PrintDayForm" class="form" action="{{ route('receipts.print_day') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Print ใบปะหน้ารายวัน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="File">สนามสอบ:</label>
                                <select class="form-control" id="PrintDaysField" name="pdsfields" required disabled>
                                    @foreach ($sfielda as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ request()->get('sfield') == $key ? 'selected' : '' }}> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pdsfield" value="{{ request()->get('sfield') }}">
                            </div>
                            <div class="form-group">
                                <label for="Submission Date">Print Date:</label>
                                <input type="text" class="AddDate form-control" name="print_date"
                                    id="PrintDaySubmissiondate" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="Submission Date">รหัสเอกสาร:</label>
                                <input type="number" class="form-control" name="print_number" id="PrintDayNumber"
                                    value="" required>
                            </div>
                            <div class="form-group">
                                <label for="font">ขนาดตัวอักษร:</label>
                                <select class="form-control" id="PrintDaysFont" name="fontsize" required>
                                    <option value="1"> เล็กมาก </option>
                                    <option value="2" selected> เล็ก </option>
                                    <option value="3"> ปานกลาง </option>
                                    <option value="4"> ใหญ่ </option>

                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pdsfield" value="{{ request()->get('sfield') }}">
                            </div>
                            <div class="form-group">
                                <label for="font">Template:</label>
                                <select class="form-control" id="printDaysTemplate" name="printDaysTemplate" required>
                                    <option value="">Select Template</option>
                                    <option value="inf">META Knowledge </option>
                                    <option value="meta"> Meta </option>
                                    <option value="meta2" selected> Meta2 </option>

                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pdsfield" value="{{ request()->get('sfield') }}">
                            </div>
                        </div>


                    </div>
                    <!-- Modal footer id="SubmitPrintDayForm"-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Print</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- PrintMonth Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="PrintMonthModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="PrintMonthForm" class="form" action="{{ route('receipts.print_month') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Print ใบปะหน้ารายเดือน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="File">สนามสอบ:</label>
                                <select class="form-control" id="PrintMonthsField" name="pmsfields" required disabled>
                                    @foreach ($sfielda as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ request()->get('sfield') == $key ? 'selected' : '' }}> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pmsfield" value="{{ request()->get('sfield') }}">
                            </div>
                            <div class="form-group">
                                <label for="Submission Month">Print Month:</label>
                                <input type="text" class="AddMonth form-control" name="print_month"
                                    autocomplete="off" id="PrintMonthSubmissiondate" value="" required>
                            </div>
                            <div class="form-group">
                                <div class="position-relative form-group">
                                    <label for="Des">รายการ:</label>
                                    <input type="text" class="form-control" name="Pmdescription" id="PmDes"
                                        value="ค่าสมัคร {{ $sfielda[request()->get('sfield')]  ?? 'All'}} รอบแรก {{-- @php {{ echo date("Y"); }} @endphp --}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="font">ขนาดตัวอักษร:</label>
                                <select class="form-control" id="PrintDaysFont" name="fontsize" required>
                                    <option value="1"> เล็กมาก </option>
                                    <option value="2" selected> เล็ก </option>
                                    <option value="3"> ปานกลาง </option>
                                    <option value="4"> ใหญ่ </option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="font">Template:</label>
                                <select class="form-control" id="printMonthTemplate" name="printMonthTemplate" required>
                                    <option value="">Select Template</option>
                                    <option value="inf">META Knowledge </option>
                                    <option value="meta"> Meta </option>
                                    <option value="meta2" selected> Meta2 </option>

                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pdsfield" value="{{ request()->get('sfield') }}">
                            </div>
                        </div>


                    </div>
                    <!-- Modal footer id="SubmitPrintDayForm"-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Print</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- PrintField Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="PrintFieldModal">
        <div class="modal-dialog modal-lg" role="document">
            {{-- <form id="PrintMonthForm" class="form" action="{{ route('testReq') }}" method="POST"> --}}
            <form id="PrintMonthForm" class="form" action="{{ route('receipts.print_field') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Print ใบปะหน้ารายสนาม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="File">สนามสอบ:</label>
                                <select class="form-control" id="PrintMonthsField" name="pmsfields" required disabled>
                                    @foreach ($sfielda as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ request()->get('sfield') == $key ? 'selected' : '' }}> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pmsfield" value="{{ request()->get('sfield') }}">
                            </div>

                            <div class="form-group">
                                <div class="position-relative form-group">
                                    <label for="Des">รายการ:</label>
                                    <input type="text" class="form-control" name="Pmdescription" id="PmDes"
                                        value="ค่าสมัคร {{ $sfielda[request()->get('sfield')] ?? 'All' }} รอบแรก {{-- @php {{ echo date("Y"); }} @endphp --}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Submission Month">Print Month:</label>
                                {{-- <input type="text" class="datePeriod form-control" name="print_monthYear" autocomplete="off" id="ssss" required> --}}
                                <input type="text" class="form-control datePeriod float-right" id="period"
                                    name="print_monthYear" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="font">ขนาดตัวอักษร:</label>
                                <select class="form-control" id="PrintDaysFont" name="fontsize" required>
                                    <option value="1"> เล็กมาก </option>
                                    <option value="2" selected> เล็ก </option>
                                    <option value="3"> ปานกลาง </option>
                                    <option value="4"> ใหญ่ </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="font">Template:</label>
                                <select class="form-control" id="printFieldTemplate" name="printFieldTemplate" required>
                                    <option value="">Select Template</option>
                                    <option value="inf">META Knowledge </option>
                                    <option value="meta"> Meta </option>
                                    <option value="meta2" selected> Meta2 </option>

                                </select>
                                <input type="hidden" name="type" value="view">
                                <input type="hidden" name="pdsfield" value="{{ request()->get('sfield') }}">
                            </div>
                        </div>


                    </div>
                    <!-- Modal footer id="SubmitPrintDayForm"-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Print</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="ImportModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="importForm" class="form" action="{{ route('receipts.import') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Import Receipt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="File">สนามสอบ:</label>
                                <select class="form-control" id="AddField" name="sfield" required>
                                    @foreach ($sfielda as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ request()->get('sfield') == $key ? 'selected' : '' }}> {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="File">Import File:</label>
                            <input type="file" name="import_file" id="import_file" required />
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitImportForm">import</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Create Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="CreateModal">
        <div class="modal-dialog modal-lg" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Receipt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="form-row">

                            <div class="col-md-12 ">
                                <select class="form-select" name="type" id="type" style="width:300px">

                                    <option value="1" hidden disabled>ใบกำกับภาษี/ใบเสร็จรับเงิน</option>
                                    <option value="2">ใบลดหนี้</option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="Submission Date">Submission Date:</label>
                                    <input type="text" class="AddDate form-control" name="submission_date"
                                        id="AddSubmissiondate" value="">
                                    <input type="hidden" name="Sfield" id="Sfield" value="{{ $sfield }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative  form-group">
                                    <label for="Package">Package:</label>
                                    <input type="text" class="form-control" name="package" id="AddPackage"
                                        value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="firstname">First Name:</label>
                                    <input type="text" class="form-control" name="firstname" id="AddFirstname"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="lastname">Last Name:</label>
                                    <input type="text" class="form-control" name="lastname" id="AddLastname"
                                        value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="Grade">Grade:</label>
                                    <input type="text" class="form-control" name="grade" id="AddGrade"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="Des">Description:</label>
                                    <input type="text" class="form-control" name="description" id="AddDes"
                                        value="">
                                </div>
                            </div>
                        </div>

                        <!--<div class="form-row">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="position-relative form-group">
                                                                                                                <label for="City">City:</label>
                                                                                                                <input type="text" class="form-control" name="city" id="AddCity"
                                                                                                                    value="">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="position-relative form-group">
                                                                                                                <label for="Province">Province:</label>
                                                                                                                <input type="text" class="form-control" name="province" id="AddProvince"
                                                                                                                    value="">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>-->
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="City">City:</label>
                                <input type="text" class="form-control" name="city" id="AddCity"
                                    value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="Province">Province:</label>
                                <input type="text" class="form-control" name="province" id="AddProvince"
                                    value="">
                            </div>
                        </div>
                    </div>-->
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Parent">Name Parent:</label>
                                <input type="text" class="form-control" name="name_parent" id="AddParent"
                                    value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Mobile">Mobile:</label>
                                <input type="text" class="AddPhone form-control" name="mobile" id="AddMobile"
                                    value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Postcode">Postcode:</label>
                        <input type="text" class="form-control" name="postcode" id="AddPostcode" value="">
                    </div>

                    <div class="form-group">
                        <label for="Name">Street Address:</label>
                        <textarea class="form-control" name="address" id="AddAddress"></textarea>
                    </div>
                    <!--<div class="form-group">
                                                                                                            <label for="Name">Street Address 2:</label>
                                                                                                            <textarea class="form-control" name="address2" id="AddAddress2"></textarea>
                                                                                                        </div>-->
                    <label for="Name">Street Address 2:</label>
                    <textarea class="form-control" name="address2" id="AddAddress2"></textarea>
                </div>-->

                <div class="form-group">
                    <label for="File">File:</label>
                    <input type="text" class="form-control" id="AddFile" name="file" value="" disabled>
                </div>


        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="SubmitCreateForm">Save</button>
            <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </form>
    </div>
    </div>

    <!-- Edit  Modal -->
    <div class="fade modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="EditModal">
        <div class="modal-dialog modal-lg" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>

                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <strong>Success!</strong> Receipt was edit successfully.
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>

                        <div id="EditModalBody">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-0"
                                        class="active nav-link">ข้อมูลลูกค้า</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-1"
                                        class="nav-link">รายการในใบเสร็จ</a></li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-eg10-0" role="tabpanel">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="ReceiptNumber">Voucher Number:</label>
                                                <input type="text" class="form-control" name="receipt_number"
                                                    id="receipt_number" value="" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative  form-group">
                                                <label for="ReceiptCNumber">Customer Code:</label>
                                                <input type="text" class="form-control" name="customer_code"
                                                    id="customer_code" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="Submission Date">Submission Date:</label>
                                                <input type="text" class="AddDate form-control" name="submission_date"
                                                    id="EditSubmissiondate" value="">
                                            </div>
                                        </div>
                                        {{--  <div class="col-md-6">
                                    <div class="position-relative  form-group">
                                        <label for="Package">Package:</label>
                                        <input type="text" class="form-control" name="package" id="EditPackage"
                                            value="">
                                    </div>
                                    </div> --}}
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="Grade">Grade:</label>
                                                <input type="text" class="form-control" name="grade" id="EditGrade"
                                                    value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="firstname">First Name:</label>
                                                <input type="text" class="form-control" name="firstname"
                                                    id="EditFirstname" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="lastname">Last Name:</label>
                                                <input type="text" class="form-control" name="lastname"
                                                    id="EditLastname" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Parent">Name Parent:</label>
                                                <input type="text" class="form-control" name="name_parent"
                                                    id="EditParent" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Mobile">Mobile:</label>
                                                <input type="text" class="AddPhone form-control" name="mobile"
                                                    id="EditMobile" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Postcode">Postcode:</label>
                                                <input type="text" class="form-control" name="postcode"
                                                    id="EditPostcode" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Contest">Contest:</label>
                                                <input type="text" class="form-control" name="contest"
                                                    id="EditContest" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <!--<div class="form-row">
                                                                                                                <div class="col-md-6">
                                                                                                                    <div class="position-relative form-group">
                                                                                                                        <label for="City">City:</label>
                                                                                                                        <input type="text" class="form-control" name="city" id="EditCity"
                                                                                                                            value="">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="col-md-6">
                                                                                                                    <div class="position-relative form-group">
                                                                                                                        <label for="Province">Province:</label>
                                                                                                                        <input type="text" class="form-control" name="province" id="EditProvince"
                                                                                                                            value="">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                </div>-->
                                    {{--  <div class="col-md-6">
                                  <div class="position-relative form-group">
                                    <label for="Des">Description:</label>
                                    <textarea class="form-control" name="drescription" id="EditDes"></textarea>
                                  </div>
                                 </div> --}}

                                    <div class="form-group">
                                        <label for="Name">Street Address:</label>
                                        <textarea class="form-control" name="address" id="EditAddress"></textarea>
                                    </div>
                                    <!--<div class="form-group">
                                                                                                                    <label for="Name">Street Address 2:</label>
                                                                                                                    <textarea class="form-control" name="address2" id="EditAddress2"></textarea>
                                                                                                                </div>-->


                                    {{-- <div class="form-group">
                                  <label for="File">File:</label>
                                  <input type="text" class="form-control" id="EditFile" name="file"
                                    value="">
                                 </div> --}}
                                </div>
                                <div class="tab-pane" id="tab-eg10-1" role="tabpanel">

                                    <table id="myTbl"
                                        class="table table-striped table-bordered responsive-utilities jambo_table "
                                        width="90%" align="center">
                                        <thead>

                                            <tr class="headings">

                                                <th class="column-title"> NO.</th>
                                                <th class="column-title"> Detail</th>
                                                <th class="column-title"> Qty</th>
                                                <th class="column-title"> Unit</th>
                                                <th class="column-title"> Unit Price</th>
                                                <th class="column-title"> Discount</th>
                                                {{-- <th class="column-title"> </th> --}}
                                            </tr>

                                        </thead>

                                        <tbody>
                                            <tr class="firstTr">
                                                <td width="10%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value="1"
                                                            required="required">

                                                    </div>
                                                </td>
                                                <td width="35%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>
                                                <td width="10%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>

                                                <td width="15%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>
                                                <td width="15%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>

                                                <td width="15%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>

                                                {{-- <td><button type="button" id="removeRowt"
                                                        class="btn btn-sm btn-danger btnRemoveg"><i
                                                            class="fa fa-minus"></i></button></td> --}}

                                            </tr>
                                        </tbody>


                                    </table>
                                    <div class="col-md-12" align="right">

                                        <button type="button" id="addRow" class="btn btn-sm btn-primary btnAddg"><i
                                                class="fa fa-plus"></i></button>
                                        <button type="button" id="removeRow" class="btn btn-sm btn-danger btnRemoveg"><i
                                                class="fa fa-minus"></i></button>
                                    </div>

                                </div>
                            </div>
                            <!--tab-->
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitEditForm">Update</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Convert credit note  Modal -->
    <div class="fade modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="ConvModal">
        <div class="modal-dialog modal-lg" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Credit Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <strong>Success!</strong> Credit Note was create successfully.
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>

                        <div id="ConvModalBody">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a data-toggle="tab" href="#tab-eg20-0"
                                        class="active nav-link">ข้อมูลลูกค้า</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#tab-eg20-1"
                                        class="nav-link">รายการในใบเสร็จ</a></li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-eg20-0" role="tabpanel">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="ReceiptNumber">Voucher Number:</label>
                                                <input type="text" class="form-control" name="conv_receipt_number"
                                                    id="conv_receipt_number" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative  form-group">
                                                <label for="ReceiptCNumber">Customer Code:</label>
                                                <input type="text" class="form-control" name="conv_customer_code"
                                                    id="conv_customer_code" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="Submission Date">Submission Date:</label>
                                                <input type="text" class="AddDate form-control"
                                                    name="conv_submission_date" id="ConvSubmissiondate"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="Grade">Grade:</label>
                                                <input type="text" class="form-control" name="conv_grade"
                                                    id="ConvGrade" value="">
                                            </div>
                                        </div>
                                        {{--  <div class="col-md-6">
                                            <div class="position-relative  form-group">
                                                <label for="Package">Package:</label>
                                                <input type="text" class="form-control" name="conv_package"
                                                    id="ConvPackage" value="">
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="firstname">First Name:</label>
                                                <input type="text" class="form-control" name="conv_firstname"
                                                    id="ConvFirstname" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="lastname">Last Name:</label>
                                                <input type="text" class="form-control" name="conv_lastname"
                                                    id="ConvLastname" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Parent">Name Parent:</label>
                                                <input type="text" class="form-control" name="conv_name_parent"
                                                    id="ConvParent" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Mobile">Mobile:</label>
                                                <input type="text" class="AddPhone form-control" name="conv_mobile"
                                                    id="ConvMobile" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Postcode">Postcode:</label>
                                                <input type="text" class="form-control" name="conv_postcode"
                                                    id="ConvPostcode" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Contest">Contest:</label>
                                                <input type="text" class="form-control" name="conv_contest"
                                                    id="ConvContest" value="">
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="Des">Description:</label>
                                            <textarea class="form-control" name="conv_drescription" id="ConvDes"></textarea>
                                        </div>
                                    </div> --}}

                                    <div class="form-group">
                                        <label for="Name">Street Address:</label>
                                        <textarea class="form-control" name="conv_address" id="ConvAddress"></textarea>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-eg20-1" role="tabpanel">

                                    <table id="myTbl2"
                                        class="table table-striped table-bordered responsive-utilities jambo_table "
                                        width="90%" align="center">
                                        <thead>

                                            <tr class="headings">

                                                <th class="column-title"> NO.</th>
                                                <th class="column-title"> Detail</th>
                                                <th class="column-title"> Qty</th>
                                                <th class="column-title"> Unit</th>
                                                <th class="column-title"> Unit Price</th>
                                                <th class="column-title"> Discount</th>
                                                {{-- <th class="column-title"> </th> --}}
                                            </tr>

                                        </thead>

                                        <tbody>
                                            <tr class="firstTr">
                                                <td width="10%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value="1"
                                                            required="required">

                                                    </div>
                                                </td>
                                                <td width="35%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>
                                                <td width="10%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>

                                                <td width="15%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>
                                                <td width="15%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>

                                                <td width="15%">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" id="flown[]" name="flown[]"
                                                            class="form-control has-feedback-left" value=""
                                                            required="required">
                                                    </div>
                                                </td>

                                                {{-- <td><button type="button" id="removeRowt"
                                                        class="btn btn-sm btn-danger btnRemoveg"><i
                                                            class="fa fa-minus"></i></button></td> --}}

                                            </tr>
                                        </tbody>


                                    </table>
                                    <div class="col-md-12" align="right">

                                        <button type="button" id="addRow2"
                                            class="btn btn-sm btn-primary btnAddg2"><i class="fa fa-plus"></i></button>
                                        <button type="button" id="removeRow2"
                                            class="btn btn-sm btn-danger btnRemoveg2"><i
                                                class="fa fa-minus"></i></button>
                                    </div>

                                </div>
                            </div>

                            {{--  <div class="form-group">
                                <label for="File">File:</label>
                                <input type="text" class="form-control" id="EditFile" name="file"
                                    value="">
                            </div> --}}
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitConvForm">Create</button>
                        <button type="button" class="btn btn-danger modelClose"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'ตกลง',
                    cancelLabel: 'ยกเลิก',
                    fromLabel: 'จาก',
                    toLabel: 'ถึง',
                    customRangeLabel: 'กำหนดเอง',
                    daysOfWeek: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                    monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                    ],
                    firstDay: 0
                },
                autoUpdateInput: true
            });
            $('#sfieldSelect').on('change', function() {
                sfield = $(this).val();
                $('#sfield').val(sfield);
                $('#Listview').DataTable().ajax.url("{{ route('receipts_all') }}?sfield=" + sfield)
                    .load();
            });
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var sfield = $('#sfield').val();
                $('#start_date').val(startDate);
                $('#end_date').val(endDate);
                $('#Listview').DataTable().ajax.url("{{ route('receipts_all') }}?start_date=" + startDate +
                    "&end_date=" + endDate + "&sfield=" + sfield).load();
            });

            $('#referent_code').on('change', function() {
                var referent_code = $(this).val();
                var sfield = $('#sfield').val();
                $('#Listview').DataTable().ajax.url("{{ route('receipts_all') }}?referent_code=" +
                    referent_code +
                    "&sfield=" + sfield).load();
            });

        });
        $(document).ready(function() {

            $(".nav-tabs a").click(function() {
                $(this).tab('show');
            });

            $('.datePeriod').daterangepicker({
                // startDate: startDate,
                // endDate: endDate,
                locale: {
                    format: 'YYYY-MM'
                }
            });

            $('.dropdown-toggle').dropdown();

            $(".AddDate").datepicker({
                dateFormat: "yy-mm-dd"
            });

            $(".AddMonth").datepicker({
                dateFormat: "yy-mm"
            });
            $("#AddMonthYear").datepicker({
                dateFormat: "yy-mm"
            });

            $(".AddDate").inputmask("9999-99-99");
            $(".AddMonth").inputmask("9999-99");
            $("#AddMonthYear").inputmask("9999-99");
            $(".AddPhone").inputmask("(999) 999-9999");

            $(".delete_all_button").click(function() {
                var len = $('input[name="table_records[]"]:checked').length;
                if (len > 0) {
                    if (confirm("Click OK to Delete?")) {
                        $('form#delete_all').submit();
                    }
                } else {
                    alert("Please Select Record For Delete");
                }

            });
            $(".export_button").click(function() {
                var len = $('input[name="table_records[]"]:checked').length;
                if (len > 0) {
                    if (confirm("Click OK to Export?")) {
                        $('form#delete_all').attr('action',
                            '{{ route('receipts_form.export') }}'); //this fails silently
                        $('form#delete_all').submit();
                    }
                } else {
                    alert("Please Select Record For Export");
                }

            });

            $('#check-all').click(function() {
                $(':checkbox.flat').prop('checked', this.checked);
            });

            //$.noConflict();
            var token = ''
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#Listview').DataTable({
                /*"aoColumnDefs": [
                {
                'bSortable': true,
                'aTargets': [0]
                } //disables sorting for column one
                ],
                "searching": false,
                "lengthChange": false,
                "paging": false,
                'iDisplayLength': 10,
                "sPaginationType": "full_numbers",
                "dom": 'T<"clear">lfrtip',
                    */
                ajax: '',
                serverSide: true,
                processing: true,
                language: {
                    loadingRecords: '&nbsp;',
                    processing: '<div class="spinner"></div>'
                },
                aaSorting: [
                    [0, "desc"]
                ],
                iDisplayLength: 10,
                lengthMenu: [10, 20, 50, 75, 100, -1],
                stateSave: true,
                sPaginationType: "full_numbers",
                dom: 'T<"clear">lfrtip',
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'receipt_type',
                        name: 'receipt_type'
                    },
                    {
                        data: 'receipt_submission_date',
                        name: 'receipt_submission_date'
                    },
                    {
                        data: 'referent_code',
                        name: 'referent_code'
                    },
                    {
                        data: 'referent_name',
                        name: 'referent_name'
                    },
                    {
                        data: 'receipt_number',
                        name: 'receipt_number'
                    },
                    {
                        data: 'receipt_customer_number',
                        name: 'receipt_customer_number'
                    },
                    {
                        data: 'receipt_firstname',
                        name: 'receipt_firstname'
                    },
                    {
                        data: 'receipt_lastname',
                        name: 'receipt_lastname'
                    },
                    {
                        data: 'receipt_parent_name',
                        name: 'receipt_parent_name'
                    },
                    {
                        data: 'receipt_mobile',
                        name: 'receipt_mobile'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });



            $('.dropdown-menu li #printr1').on('click', function(e) {
                //console.log("TEST");
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('.dropdown-toggle').dropdown('hide');
                $('#PrintDayModal').modal('show');
            });

            $('.dropdown-menu li #printr2').on('click', function(e) {
                //console.log("TEST");
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('.dropdown-toggle').dropdown('hide');
                $('#PrintMonthModal').modal('show');
            });

            $('.dropdown-menu li #printr3').on('click', function(e) {
                //console.log("TEST");
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('.dropdown-toggle').dropdown('hide');
                $('#PrintFieldModal').modal('show');
            });

            $('.dropdown-menu li #printr4').on('click', function(e) {
                //console.log("TEST");
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('.dropdown-toggle').dropdown('hide');
                $('#PrintRDayModal').modal('show');
            });




            $(document).on('click', '#CreateButton', function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('#CreateModal').modal('show');
            });

            $(document).on('click', '#SubmitPrintDayForm', function(e) {
                e.preventDefault();
                //$('#loder_bar').show();
                //$.blockUI({
                //    message: $("#loder_bar")
                //});
                //$("#PrintDayForm").submit();

            });

            $(document).on('click', '#SubmitImportForm', function(e) {
                e.preventDefault();
                //$('#loder_bar').show();
                $.blockUI({
                    message: $("#loder_bar")
                });
                $("#importForm").submit();

            });



            $(document).on('click', '#ImportButton', function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('#ImportModal').modal('show');
            });

            let id;
            $(document).on('click', '#getEditData', function(e) {
                e.preventDefault();


                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                id = $(this).data('id');
                $.ajax({
                    url: "receipts/edit/" + id + "/0",
                    method: 'GET',
                    success: function(res) {
                        //console.log(res);
                        //$('#EditModalBody').html(res.html);
                        //console.log(res.data_html);
                        $('#receipt_number').val(res.data.receipt_number);
                        $('#customer_code').val(res.data.receipt_customer_number);
                        $('#EditSubmissiondate').val(res.data.submission_date);
                        //$('#EditPackage').val(res.data.package);
                        $('#EditFirstname').val(res.data.first_name);
                        $('#EditLastname').val(res.data.last_name);
                        $('#EditDes').val(res.data.description);
                        $('#EditGrade').val(res.data.grade);
                        $('#EditAddress').val(res.data.street_address);
                        //$('#EditAddress2').val(res.data.street_address2);
                        //$('#EditCity').val(res.data.city);
                        //$('#EditProvince').val(res.data.province);
                        $('#EditPostcode').val(res.data.postcode);
                        $('#EditContest').val(res.data.contest);
                        $('#EditParent').val(res.data.name_parent);
                        $('#EditMobile').val(res.data.mobile);
                        $('#myTbl tbody').html(res.data_html);
                        //append
                        //$('#EditFile').val(res.data.file_att);
                        $('#EditModal').modal('show');

                    }
                });

            });


            $(document).on('click', '#getConvData', function(e) {
                e.preventDefault();


                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                id = $(this).data('id');
                $.ajax({
                    url: "receipts/edit/" + id + "/2",
                    method: 'GET',
                    success: function(res) {
                        console.log(res.data.receipt_number);
                        console.log(res.data.submission_date);
                        //console.log(res.data_html);
                        $('#conv_receipt_number').val(res.data.receipt_number);
                        $('#conv_customer_code').val(res.data.receipt_customer_number);
                        $('#ConvSubmissiondate').val(res.data.submission_date);
                        $('#ConvPackage').val(res.data.package);
                        $('#ConvFirstname').val(res.data.first_name);
                        $('#ConvLastname').val(res.data.last_name);
                        $('#ConvDes').val(res.data.description);
                        $('#ConvGrade').val(res.data.grade);
                        $('#ConvContest').val(res.data.contest);
                        $('#ConvAddress').val(res.data.street_address);
                        //$('#EditAddress2').val(res.data.street_address2);
                        //$('#EditCity').val(res.data.city);
                        //$('#EditProvince').val(res.data.province);
                        $('#ConvPostcode').val(res.data.postcode);
                        $('#ConvParent').val(res.data.name_parent);
                        $('#ConvMobile').val(res.data.mobile);
                        $('#ConvFile').val(res.data.file_att);
                        $('#myTbl2 tbody').html(res.data_html);
                        $('#ConvModal').modal('show');

                    }
                });

            })


            // Create product Ajax request.
            $('#SubmitCreateForm').click(function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                $.ajax({
                    url: "{{ route('receipts.store') }}",
                    method: 'post',
                    data: {
                        type: $('#type').val(),
                        submission_date: $('#AddSubmissiondate').val(),
                        first_name: $('#AddFirstname').val(),
                        last_name: $('#AddLastname').val(),
                        grade: $('#AddGrade').val(),
                        description: $('#AddDes').val(),
                        street_address: $('#AddAddress').val(),
                        //street_address2: $('#AddAddress2').val(),
                        //city: $('#AddCity').val(),
                        //province: $('#AddProvince').val(),
                        postcode: $('#AddPostcode').val(),
                        name_parent: $('#AddParent').val(),
                        mobile: $('#AddMobile').val(),
                        package: $('#AddPackage').val(),
                        file_att: $('#AddFile').val(),
                        sfield: $('#Sfield').val(),
                        _token: token,
                    },
                    success: function(result) {
                        if (result.errors) {
                            $('.alert-danger').html('');
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value +
                                    '</li></strong>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('.alert-success').append('<strong><li>' + result.success +
                                '</li></strong>');
                            toastr.success(result.success, {
                                timeOut: 5000
                            });
                            $('#CreateModal').modal('hide');
                            $('#Listview').DataTable().ajax.reload();
                            $('.form').trigger('reset');
                            //$('#SubmitCreateForm').hide();
                            //setTimeout(function() {
                            //$('.alert-success').hide();
                            //$('#CreateModal').modal('hide');
                            //}, 10000);

                        }
                    }
                });
            });

            $('#SubmitEditForm').click(function(e) {
                //if (!confirm("Are you sure?")) return;
                e.preventDefault();

                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                let rid = [];
                let rdes = [];
                let rqty = [];
                let runit = [];
                let runitp = [];
                let rdis = [];

                // Initializing array values
                $("input[name='rid[]']").each(function() {
                    rid.push(this.value);
                });


                $("input[name='rdes[]']").each(function() {
                    rdes.push(this.value);
                });

                $("input[name='rqty[]']").each(function() {
                    rqty.push(this.value);
                });

                $("input[name='runit[]']").each(function() {
                    runit.push(this.value);
                });

                $("input[name='runitp[]']").each(function() {
                    runitp.push(this.value);
                });

                $("input[name='rdis[]']").each(function() {
                    rdis.push(this.value);
                });


                $.ajax({
                    url: "receipts/save/" + id,
                    method: 'PUT',
                    data: {
                        submission_date: $('#EditSubmissiondate').val(),
                        first_name: $('#EditFirstname').val(),
                        last_name: $('#EditLastname').val(),
                        grade: $('#EditGrade').val(),
                        description: $('#EditDes').val(),
                        street_address: $('#EditAddress').val(),
                        //street_address2: $('#EditAddress2').val(),
                        //city: $('#EditCity').val(),
                        //province: $('#EditProvince').val(),
                        postcode: $('#EditPostcode').val(),
                        contest: $('#EditContest').val(),
                        name_parent: $('#EditParent').val(),
                        mobile: $('#EditMobile').val(),
                        package: $('#EditPackage').val(),
                        file_att: $('#EditFile').val(),
                        rdid: rid,
                        rdes: rdes,
                        rqty: rqty,
                        runit: runit,
                        runitp: runitp,
                        rdis: rdis,
                    },

                    success: function(result) {
                        console.log(result);
                        if (result.errors) {
                            $('.alert-danger').html('');
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value +
                                    '</li></strong>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('.alert-success').append('<strong><li>' + result.success +
                                '</li></strong>');
                            toastr.success(result.success, {
                                timeOut: 5000
                            });
                            $('#EditModal').modal('hide');
                            $('#Listview').DataTable().ajax.reload(null, false);
                            //setTimeout(function() {
                            //$('.alert-success').hide();
                            //   $('#EditModal').modal('hide');
                            //}, 10000);

                        }
                    }
                });
            });

            $('#SubmitConvForm').click(function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                let rrid = [];
                let rrdes = [];
                let rrqty = [];
                let rrunit = [];
                let rrunitp = [];
                let rrdis = [];

                // Initializing array values
                $("input[name='rrid[]']").each(function() {
                    rrid.push(this.value);
                });


                $("input[name='rrdes[]']").each(function() {
                    rrdes.push(this.value);
                });

                $("input[name='rrqty[]']").each(function() {
                    rrqty.push(this.value);
                });

                $("input[name='rrunit[]']").each(function() {
                    rrunit.push(this.value);
                });

                $("input[name='rrunitp[]']").each(function() {
                    rrunitp.push(this.value);
                });

                $("input[name='rrdis[]']").each(function() {
                    rrdis.push(this.value);
                });


                $.ajax({
                    url: "{{ route('receipts.conv') }}",
                    method: 'post',
                    data: {
                        type: 2,
                        receipt_number: $('#conv_receipt_number').val(),
                        receipt_customer_number: $('#conv_customer_code').val(),
                        submission_date: $('#ConvSubmissiondate').val(),
                        first_name: $('#ConvFirstname').val(),
                        last_name: $('#ConvLastname').val(),
                        grade: $('#ConvGrade').val(),
                        //description: $('#ConvDes').val(),
                        street_address: $('#ConvAddress').val(),
                        //street_address2: $('#AddAddress2').val(),
                        //city: $('#AddCity').val(),
                        //province: $('#AddProvince').val(),
                        postcode: $('#ConvPostcode').val(),
                        contest: $('#ConvContest').val(),
                        name_parent: $('#ConvParent').val(),
                        mobile: $('#ConvMobile').val(),
                        //package: $('#ConvPackage').val(),
                        //file_att: $('#AddFile').val(),
                        sfield: $('#Sfield').val(),
                        rrdid: rrid,
                        rrdes: rrdes,
                        rrqty: rrqty,
                        rrunit: rrunit,
                        rrunitp: rrunitp,
                        rrdis: rrdis,
                        _token: token,
                    },
                    success: function(result) {
                        if (result.errors) {
                            $('.alert-danger').html('');
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value +
                                    '</li></strong>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('.alert-success').append('<strong><li>' + result.success +
                                '</li></strong>');
                            toastr.success(result.success, {
                                timeOut: 5000
                            });
                            $('#CreateModal').modal('hide');
                            $('#Listview').DataTable().ajax.reload();
                            $('.form').trigger('reset');
                            //$('#SubmitCreateForm').hide();
                            //setTimeout(function() {
                            //$('.alert-success').hide();
                            //$('#CreateModal').modal('hide');
                            //}, 10000);

                        }
                    }
                });
            });


            $(document).on('click', '.btn-delete', function() {
                if (!confirm("Are you sure?")) return;

                var rowid = $(this).data('rowid')
                var el = $(this)
                if (!rowid) return;


                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: "receipts/destroy/" + rowid,
                    data: {
                        _method: 'delete',
                        _token: token
                    },
                    success: function(data) {
                        if (data.success) {
                            toastr.success(data.message, {
                                timeOut: 5000
                            });
                            table.row(el.parents('tr'))
                                .remove()
                                .draw();
                        }
                    }
                }); //end ajax
            })
        })

        $(function() {
            $.fn.size = () => {
                return this.length;
            }
        });

        $(function() {

            $("#addRow").click(function() {
                // ส่วนของการ clone ข้อมูลด้วย jquery clone() ค่า true คือ
                // การกำหนดให้ ไม่ต้องมีการ ดึงข้อมูลจากค่าเดิมมาใช้งาน
                // รีเซ้ตเป็นค่าว่าง ถ้ามีข้อมูลอยู่แล้ว ทั้ง select หรือ input
                $(".firstTr:eq(0)").clone(true)
                    .find("input").attr("value", "").end()
                    .find("select").attr("value", "").end()
                    .appendTo($("#myTbl"));
            });
            $("#removeRow").click(function() {
                // // ส่วนสำหรับการลบ
                if ($("#myTbl tr").length > 2) { // จะลบรายการได้ อย่างน้อย ต้องมี 1 รายการ
                    $("#myTbl tr:last").remove(); // ลบรายการสุดท้าย
                } else {
                    // เหลือ 1 รายการลบไม่ได้
                    if ($("#myTbl tr").length > 1) {
                        //alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
                        toastr.success('ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ', {
                            timeOut: 5000
                        });
                    }
                }
            });
            $(".btnRemoveg").click(function() {
                // // ส่วนสำหรับการลบ
                if ($("#myTbl tr").length > 2) { // จะลบรายการได้ อย่างน้อย ต้องมี 1 รายการ
                    //$("#myTbl tr:last").remove(); // ลบรายการสุดท้าย
                    $(this).closest("tr").remove();
                } else {
                    // เหลือ 1 รายการลบไม่ได้
                    if ($("#myTbl tr").length > 1) {
                        //alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
                        toastr.success('ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ', {
                            timeOut: 5000
                        });
                    }
                }
            });

            $("#addRow2").click(function() {
                // ส่วนของการ clone ข้อมูลด้วย jquery clone() ค่า true คือ
                // การกำหนดให้ ไม่ต้องมีการ ดึงข้อมูลจากค่าเดิมมาใช้งาน
                // รีเซ้ตเป็นค่าว่าง ถ้ามีข้อมูลอยู่แล้ว ทั้ง select หรือ input
                $(".firstTr:eq(0)").clone(true)
                    .find("input").attr("value", "").end()
                    .find("select").attr("value", "").end()
                    .appendTo($("#myTbl2"));
            });
            $("#removeRow2").click(function() {
                // // ส่วนสำหรับการลบ
                if ($("#myTbl2 tr").length > 2) { // จะลบรายการได้ อย่างน้อย ต้องมี 1 รายการ
                    $("#myTbl2 tr:last").remove(); // ลบรายการสุดท้าย
                } else {
                    // เหลือ 1 รายการลบไม่ได้
                    if ($("#myTbl2 tr").length > 1) {
                        //alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
                        toastr.success('ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ', {
                            timeOut: 5000
                        });
                    }
                }
            });
            $(".btnRemoveg2").click(function() {
                // // ส่วนสำหรับการลบ
                if ($("#myTbl2 tr").length > 2) { // จะลบรายการได้ อย่างน้อย ต้องมี 1 รายการ
                    //$("#myTbl tr:last").remove(); // ลบรายการสุดท้าย
                    $(this).closest("tr").remove();
                } else {
                    // เหลือ 1 รายการลบไม่ได้
                    if ($("#myTbl2 tr").length > 1) {
                        //alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
                        toastr.success('ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ', {
                            timeOut: 5000
                        });
                    }
                }
            });

            $(this).closest(".abcd").remove();
        });
    </script>
@endsection
