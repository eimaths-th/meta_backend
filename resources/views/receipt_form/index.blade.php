@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="http://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://rawgit.com/RobinHerbots/Inputmask/5.x/dist/jquery.inputmask.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        input:required:focus:invalid~.form-error-message {
            display: block;
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

        .form_none {
            display: none !important;
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

        .modal-xxl {
            max-width: 1500px !important;
        }
    </style>
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection

@section('content')
    <div id="loadingOverlay" style="display: none;">
        {{-- Loading... </br> --}}
        <div class="spinner"></div>
    </div>

    <style>
        /* Styling for overlay and spinner */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            z-index: 1000;
        }
    </style>
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

                    <div>
                        @if (isset($sfielda[request()->get('sfield')]) && $sfielda[request()->get('sfield')] === 'neos' )
                            Neo science Online Form
                            <div class="page-title-subheading">META Knowledge Online Form Data</div>
                        @else
                            {{ isset($sfielda[request()->get('sfield')]) ? $sfielda[request()->get('sfield')] : $form->form_name }} Online Form
                            <div class="page-title-subheading">META Knowledge Online Form Data</div>
                        @endif

                    </div>
                </div>
                <div class="page-title-actions">



                    <div class="d-inline-block dropdown">
                        <a class="btn btn-info export_button" href="#"><i class="fa-solid fa-file-export"></i> Export
                            Excel </a>

                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form action="{{ route('receipts_form') }}" method="GET">
                    <div class="row mb-4">

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
                                        {{ $referent_code->referent_code }} — ({{ $referent_code->referent_name }})</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div> --}}
                    </div>
                </form>
                <form method="post" action="" name="delete_all" id="delete_all">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="sfield" value="{{ request()->get('sfield') }}">
                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th>Receipt</th>
                                <th>Submission Date</th>
                                <th>Referent Code</th>
                                <th>Referent Name</th>
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






    <!-- Edit  Modal -->
    <div class="fade modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="EditModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="infiniteEdit" class="form" action="" method="POST">
                <div class="modal-content">
                    <div id="modalLoadingOverlay" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                    <style>
                        /* Styling for modal loading overlay */
                        #modalLoadingOverlay {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(255, 255, 255, 0.8);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: #000;
                            font-size: 18px;
                            z-index: 10;
                        }
                    </style>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Generate Receipt (<span id="rnumber"
                                style="color: red;"></span>)</h5>
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
                            <strong>Success!</strong> Receipt was generate successfully.
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>

                        <div id="EditModalBody">

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="Submission Date">Submission Date:</label>
                                        <input type="text" class="form-control" name="submission_date"
                                            id="AddSubmissiondate" value="">
                                        <input type="hidden" name="Sfield" id="Sfield"
                                            value="{{ $sfield }}">
                                        <input type="hidden" name="fid" id="fid" value="">
                                        <input type="hidden" name="rec_id" id="AddRecId" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative  form-group">
                                        <label for="Package">Package:</label>
                                        <input type="text" class="form-control" name="package" id="AddPackage" value="">
                                        <input type="hidden" name="package_id" id="AddPackageId" value="">
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
                                        <label for="Nickname">Nick Name:</label>
                                        <input type="text" class="form-control" name="nickname" id="AddNickname"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="AddGender">Gender:</label>
                                        <input type="text" class="form-control" name="gender" id="AddGender"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="BirthDate">Birth Date:</label>
                                        <input type="text" class="form-control" name="birthdate" id="AddBirthdate"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="referent_code">Referent Code:</label>
                                        <input type="text" class="form-control" name="referent_code" id="AddReferentCode" readonly
                                            value="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="School">School Name:</label>
                                        <input type="text" class="form-control" name="school" id="AddSchoolname"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="Grade">Grade:</label>
                                        <input type="text" class="form-control" name="grade" id="AddGrade"
                                            value="">
                                    </div>
                                </div>

                            </div>


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
                                        <input type="text" class="AddPhone form-control" name="mobile"
                                            id="AddMobile" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Parent">Email:</label>
                                        <input type="text" class="form-control" name="email" id="AddEmail"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Newsf">ข่าวสารการจัดสอบ:</label>
                                        <input type="text" class="form-control" name="newsf" id="AddNewsf"
                                            value="" readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="Name">Street Address:</label>
                                <input type="text" class="form-control" name="address" id="AddAddress">
                            </div>

                            <div class="form-group">
                                <label for="Postcode">Postcode:</label>
                                <input type="text" class="form-control" name="postcode" id="AddPostcode"
                                    value="">
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Parent">Contest:</label>
                                        <input type="text" class="form-control" name="contest" id="AddContest"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Dcode">Discount Code:</label>
                                        <input type="text" class="form-control" name="dcode" id="AddDcode"
                                            value="" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-6" style="display: none;" id="showaward">
                                    <div class="form-group">
                                        <label for="Parent">รางวัล:</label>
                                        <input type="text" class="form-control" name="award" id="Addaward" readonly
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none;" id="showfollow">
                                    <div class="form-group">
                                        <label for="Dcode">จำนวนผู้ติดตาม:</label>
                                        <input type="text" class="form-control" name="follow" id="Addfollow" readonly
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="display: none;" id="showrefdate">
                                        <label for="Parent" id="AddRefDateLabel">Reference Date:</label>
                                        <input type="text" class="form-control" name="ref_date" id="AddRefDate"
                                            value="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row text-center">
                                <div class="col-md-6">
                                    <label for="รูปภาพผู้สมัคร">รูปภาพผู้สมัคร</label>
                                    <div class="form-group" id="sphoto">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="หลักฐานการชำระเงิน">หลักฐานการชำระเงิน:</label>
                                    <div class="form-group" id="satt">

                                    </div>
                                    <input type="hidden" id="AddFile" name="file">
                                </div>
                            </div>

                            <div class="form-row form-focus" id="dropzone-photo">
                                <div class="col-md-12 col-sm-12">
                                    <a id="dphoto"></a>
                                    <div class="position-relative form-group">
                                        <label class="form-label form-label-top form-label-auto"
                                            for="att">อัพโหลดหลักฐานการชำระเงิน<span class="form-required">*</span>
                                            <div style="width: 280px"></div>
                                        </label>
                                        <input type="text" id="drop1" name="drop1"
                                            class="form-control form_none" value="">
                                        <div class="dropzone" id="my-awesome-dropzone" style="font-size: 1.5em;">
                                            <div class="fallback">

                                            </div>
                                        </div>
                                        <label class="form-sub-label" style="min-height:13px" aria-hidden="false">Receipt
                                            Photo</label>
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
                            <div class="dropzonex dz-default dz-message" id="dropzone_preview" style="font-size: 1.5em;">
                                <h3 class="dropzone-previews ui"></h3>
                            </div>

                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitEditForm">Generate Receipt</button>
                        <button type="button" class="btn btn-warning" id="SubmitEditOForm">Edit</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
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
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                var sfield = $('#Sfield').val();
                $('#start_date').val(startDate);
                $('#end_date').val(endDate);
                $('#Listview').DataTable().ajax.url("{{ route('receipts_form') }}?start_date=" + startDate + "&end_date=" + endDate + "&sfield=" + sfield).load();
            });
            $('#referent_code').on('change', function() {
                var referent_code = $(this).val();
                var sfield = $('#sfield').val();
                $('#Listview').DataTable().ajax.url("{{ route('receipts_form') }}?referent_code=" + referent_code +
                    "&sfield=" + sfield).load();
            });
        });
        //Dropzone.autoDiscover = false;
        $(document).ready(function() {

            $('.dropdown-toggle').dropdown();


            $(".AddDate").datepicker({
                dateFormat: "yy-mm-dd"
            });

            $(".AddMonth").datepicker({
                dateFormat: "yy-mm"
            });

            $(".AddDate").inputmask("9999-99-99");
            $(".AddMonth").inputmask("9999-99");
            $(".AddPhone").inputmask("(999) 999-9999");

            $(".delete_all_button").click(function() {
                var len = $('input[name="table_records[]"]:checked').length;
                if (len > 0) {
                    if (confirm("Click OK to Delete?")) {
                        $('form#delete_all').attr('action',
                            '{{ route('receipts_form.destroy_all') }}'); //this fails silently
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
                lengthMenu: [10, 20, 50, 75, 100, 500, 1000],
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
                        data: 'receipt_status',
                        name: 'receipt_status'
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


            let id;
            $(document).on('click', '#getEditData', function(e) {
                e.preventDefault();
                $('#SubmitEditForm').css('display', 'block');

                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                document.getElementById("loadingOverlay").style.display = "flex";

                id = $(this).data('id');
                $.ajax({
                    url: "receipts_form/edit/" + id,
                    method: 'GET',
                    success: function(res) {
                        console.log(res);
                        document.getElementById("loadingOverlay").style.display = "none";
                        //$('#EditModalBody').html(res.html);
                        $('#AddRecId').val(res.data.id);
                        $('#AddSubmissiondate').val(res.data.submission_date);
                        $('#AddPackage').val(res.data.package);
                        $('#AddPackageId').val(res.data.packageId);
                        $('#AddContest').val(res.data.contest);
                        $('#AddDcode').val(res.data.discount_code);
                        $('#AddFirstname').val(res.data.first_name);
                        $('#AddLastname').val(res.data.last_name);
                        $('#AddNickname').val(res.data.nick_name);
                        $('#AddGender').val(res.data.gender);
                        $('#AddBirthdate').val(res.data.birth_date);
                        $('#AddSchoolname').val(res.data.school_name);
                        $('#AddtDes').val(res.data.description);
                        $('#AddGrade').val(res.data.grade);
                        $('#AddAddress').val(res.data.street_address);
                        $('#AddReferentCode').val(res.data.referent_code);
                        //$('#EditAddress2').val(res.data.street_address2);
                        //$('#EditCity').val(res.data.city);
                        //$('#EditProvince').val(res.data.province);
                        $('#AddPostcode').val(res.data.postcode);
                        $('#AddParent').val(res.data.name_parent);
                        $('#AddMobile').val(res.data.mobile);
                        $('#AddEmail').val(res.data.email);
                        $('#AddNewsf').val(res.data.news_form);
                        //alert(res.data.file_re);
                        $('#AddFile').val(res.data.file_re);
                        $('#fid').val(res.data.id);
                        $('#sphoto').html(res.data.photo);
                        $('#satt').html(res.data.file);
                        $('#rnumber').html(res.data.rnumber);
                        if (res.data.generate == 1) {
                            $('#SubmitEditForm').css('display', 'none');
                        }
                        $('#Addaward').val(res.data.award);
                        $('#Addfollow').val(res.data.street_address2);
                        $('#AddRefDate').val(res.data.ref_date);

                        if (res.data.award) {
                            $('#showaward').css('display', 'block');
                        }
                        if (res.data.street_address2) {
                            $('#showfollow').css('display', 'block');
                        }
                        if (res.data.ref_date) {
                            $('#AddRefDateLabel').text(res.data.ref_date_label);
                            $('#showrefdate').css('display', 'block');
                        }
                        //console.log(res.data.photo);
                        $('#EditModal').modal('show');

                    }
                });

            })

            $('#SubmitEditForm').click(function(e) {
                //if (!confirm("Are you sure?")) return;
                e.preventDefault();
                // document.getElementById("loadingOverlay").style.display = "flex";
                // $("#modalLoadingOverlay").show();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                //alert($('#AddFile').val());
                var values = $("input[name='imgFiles[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();
                var sfield = $('#Sfield').val();

                // console.log(sfield);
                if (sfield == 17) {
                    // pls .wait
                    alert("Please wait 2-3 second to send the email. !`");
                }

                //alert(values);
                //exit();

                $.ajax({
                    url: "{{ route('receipts_form.store') }}",
                    method: 'post',
                    data: {

                        img: values,
                        rec_id: $('#AddRecId').val(),
                        submission_date: $('#AddSubmissiondate').val(),
                        first_name: $('#AddFirstname').val(),
                        last_name: $('#AddLastname').val(),
                        grade: $('#AddGrade').val(),
                        dcode: $('#AddDcode').val(),
                        description: $('#AddPackage').val(),
                        package_id: $('#AddPackageId').val(),
                        referent_code: $('#AddReferentCode').val(),
                        street_address: $('#AddAddress').val(),
                        //street_address2: $('#AddAddress2').val(),
                        //city: $('#AddCity').val(),
                        //province: $('#AddProvince').val(),
                        ref_date: $('#AddRefDate').val(),
                        postcode: $('#AddPostcode').val(),
                        name_parent: $('#AddParent').val(),
                        mobile: $('#AddMobile').val(),
                        email: $('#AddEmail').val(),
                        package: $('#AddPackage').val(),
                        contest: $('#AddContest').val(),
                        file_att: $('#AddFile').val(),
                        sfield: $('#Sfield').val(),
                        fid: $('#fid').val(),
                        _token: token,
                    },

                    success: function(result) {
                        console.log(result);
                        if (result.errors) {
                            $("#modalLoadingOverlay").hide();
                            $('.alert-danger').html('');
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value +
                                    '</li></strong>');
                            });

                        } else {
                            $("#modalLoadingOverlay").hide();
                            // document.getElementById("loadingOverlay").style.display = "none";
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('.alert-success').append('<strong><li>' + result.success +
                                '</li></strong>');
                            toastr.success(result.success, {
                                timeOut: 5000
                            });
                            $('.dz-preview').remove();
                            $(".file_arr").remove();
                            $('#dropzone_preview').css("display", "none");
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

            let rid;
            let rid2;
            $(document).on('click', '#getDeleteData', function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                rid = $(this).data('id');
                rid2 = $(this).data('id2');
                if (confirm("Click OK to Delete?")) {
                    $.ajax({
                        url: "receipt_form/delete_img/" + rid + "/" + rid2,
                        method: 'PUT',
                        // async : false,
                        success: function(res) {
                            $('#satt').html(res.imgs);

                        }
                    })
                }
            })




            // $('#SubmitEditForm').click(function(e) {
            //     //if (!confirm("Are you sure?")) return;
            //     e.preventDefault();

            //     $('.alert-danger').html('');
            //     $('.alert-danger').hide();
            //     $('.alert-success').html('');
            //     $('.alert-success').hide();
            //     //alert($('#AddFile').val());
            //     var values = $("input[name='imgFiles[]']")
            //         .map(function() {
            //             return $(this).val();
            //         }).get();

            //     //alert(values);
            //     //exit();
            //     swal({
            //         title: 'Are you sure?',
            //         text: 'You will not be able to recover this imaginary file!',
            //         icon: 'info',
            //         buttons: {
            //             cancel: {
            //                 text: 'Cancel',
            //                 value: null,
            //                 visible: true,
            //                 className: 'btn btn-default',
            //                 closeModal: true,
            //             },
            //             confirm: {
            //                 text: 'Primary',
            //                 value: true,
            //                 visible: true,
            //                 className: 'btn btn-primary',
            //                 closeModal: true
            //             }
            //         }
            //     }).then((value) => {
            //         if (value) {
            //             $.ajax({
            //                 url: "{{ route('receipts_form.store') }}",
            //                 method: 'post',
            //                 data: {

            //                     img: values,
            //                     rec_id: $('#AddRecId').val(),
            //                     submission_date: $('#AddSubmissiondate').val(),
            //                     first_name: $('#AddFirstname').val(),
            //                     last_name: $('#AddLastname').val(),
            //                     grade: $('#AddGrade').val(),
            //                     dcode: $('#AddDcode').val(),
            //                     description: $('#AddPackage').val(),
            //                     street_address: $('#AddAddress').val(),
            //                     //street_address2: $('#AddAddress2').val(),
            //                     //city: $('#AddCity').val(),
            //                     //province: $('#AddProvince').val(),
            //                     postcode: $('#AddPostcode').val(),
            //                     name_parent: $('#AddParent').val(),
            //                     mobile: $('#AddMobile').val(),
            //                     email: $('#AddEmail').val(),
            //                     package: $('#AddPackage').val(),
            //                     contest: $('#AddContest').val(),
            //                     file_att: $('#AddFile').val(),
            //                     sfield: $('#Sfield').val(),
            //                     fid: $('#fid').val(),
            //                     _token: token,
            //                 },
            //                 dataType: 'json',
            //                 cache: false,
            //                 success: function(result) {
            //                     console.log(result);
            //                     if (result.success) {
            //                         swal({
            //                             icon: 'success',
            //                             title: result
            //                                 .success,
            //                             html: result
            //                                 .success +
            //                                 ' กำลังโหลดหน้าใหม่... <b></b>',
            //                             timer: 1000,
            //                             timerProgressBar: true,
            //                             onBeforeOpen: () => {
            //                                 Swal.showLoading()
            //                                 timerInterval
            //                                     =
            //                                     setInterval(
            //                                         () => {
            //                                             Swal.getContent()
            //                                                 .querySelector(
            //                                                     'b'
            //                                                 )
            //                                                 .textContent =
            //                                                 Swal
            //                                                 .getTimerLeft()
            //                                         },
            //                                         100
            //                                     )
            //                             },
            //                             onClose: () => {
            //                                 location
            //                                     .reload();
            //                             }
            //                         });
            //                         $('.alert-danger').hide();
            //                         $('.alert-success').show();
            //                         $('.alert-success').append('<strong><li>' + result
            //                             .success +
            //                             '</li></strong>');
            //                         toastr.success(result.success, {
            //                             timeOut: 5000
            //                         });
            //                         $('.dz-preview').remove();
            //                         $(".file_arr").remove();
            //                         $('#dropzone_preview').css("display", "none");


            //                         // $('#EditModal').modal('hide');
            //                         $('#Listview').DataTable().ajax.reload(null, false);

            //                     } else {
            //                         console.log(result);

            //                         $('.alert-danger').html('');
            //                         $.each(result.errors, function(key, value) {
            //                             $('.alert-danger').show();
            //                             $('.alert-danger').append(
            //                                 '<strong><li>' + value +
            //                                 '</li></strong>');
            //                         });
            //                         swal({
            //                             icon: "error",
            //                             text: result.msg
            //                         });
            //                     }
            //                 },
            //                 error: function(xhr, resp, text) {
            //                     console.log(xhr, resp, text);
            //                 }
            //             });
            //         } else {
            //             swal.close()
            //         }
            //     })

            //     // $.ajax({
            //     //     url: "{{ route('receipts_form.store') }}",
            //     //     method: 'post',
            //     //     data: {

            //     //         img: values,
            //     //         rec_id: $('#AddRecId').val(),
            //     //         submission_date: $('#AddSubmissiondate').val(),
            //     //         first_name: $('#AddFirstname').val(),
            //     //         last_name: $('#AddLastname').val(),
            //     //         grade: $('#AddGrade').val(),
            //     //         dcode: $('#AddDcode').val(),
            //     //         description: $('#AddPackage').val(),
            //     //         street_address: $('#AddAddress').val(),
            //     //         //street_address2: $('#AddAddress2').val(),
            //     //         //city: $('#AddCity').val(),
            //     //         //province: $('#AddProvince').val(),
            //     //         postcode: $('#AddPostcode').val(),
            //     //         name_parent: $('#AddParent').val(),
            //     //         mobile: $('#AddMobile').val(),
            //     //         email: $('#AddEmail').val(),
            //     //         package: $('#AddPackage').val(),
            //     //         contest: $('#AddContest').val(),
            //     //         file_att: $('#AddFile').val(),
            //     //         sfield: $('#Sfield').val(),
            //     //         fid: $('#fid').val(),
            //     //         _token: token,
            //     //     },

            //     //     success: function(result) {
            //     //         console.log(result);
            //     //         if (result.errors) {
            //     //             $('.alert-danger').html('');
            //     //             $.each(result.errors, function(key, value) {
            //     //                 $('.alert-danger').show();
            //     //                 $('.alert-danger').append('<strong><li>' + value +
            //     //                     '</li></strong>');
            //     //             });
            //     //         } else {
            //     //             $('.alert-danger').hide();
            //     //             $('.alert-success').show();
            //     //             $('.alert-success').append('<strong><li>' + result.success +
            //     //                 '</li></strong>');
            //     //             toastr.success(result.success, {
            //     //                 timeOut: 5000
            //     //             });
            //     //             $('.dz-preview').remove();
            //     //             $(".file_arr").remove();
            //     //             $('#dropzone_preview').css("display", "none");


            //     //             $('#EditModal').modal('hide');
            //     //             $('#Listview').DataTable().ajax.reload(null, false);

            //     //             //setTimeout(function() {
            //     //             //$('.alert-success').hide();
            //     //             //   $('#EditModal').modal('hide');
            //     //             //}, 10000);

            //     //         }
            //     //     }
            //     // });
            // });




            $('#SubmitEditOForm').click(function(e) {
                //if (!confirm("Are you sure?")) return;
                e.preventDefault();


                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                //alert($('#AddFile').val());
                var values = $("input[name='imgFiles[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();
                //alert(values);
                //exit();


                $.ajax({
                    url: "{{ route('receipts_form.update') }}",
                    method: 'post',
                    data: {
                        img: values,
                        submission_date: $('#AddSubmissiondate').val(),
                        first_name: $('#AddFirstname').val(),
                        last_name: $('#AddLastname').val(),
                        nick_name: $('#AddNickname').val(),
                        birth_date: $('#AddBirthdate').val(),
                        grade: $('#AddGrade').val(),
                        //description: $('#AddPackage').val(),
                        street_address: $('#AddAddress').val(),
                        //street_address2: $('#AddAddress2').val(),
                        //city: $('#AddCity').val(),
                        //province: $('#AddProvince').val(),
                        postcode: $('#AddPostcode').val(),
                        school_name: $('#AddSchoolname').val(),
                        name_parent: $('#AddParent').val(),
                        mobile: $('#AddMobile').val(),
                        email: $('#AddEmail').val(),
                        package: $('#AddPackage').val(),
                        contest: $('#AddContest').val(),
                        news_form: $('#AddNewsf').val(),
                        //file_att: $('#AddFile').val(),
                        sfield: $('#Sfield').val(),
                        fid: $('#fid').val(),
                        _token: token,
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
                            $('.dz-preview').remove();
                            $(".file_arr").remove();
                            $('#dropzone_preview').css("display", "none");
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


            $(document).on('click', '.btn-delete', function() {
                if (!confirm("Are you sure?")) return;

                var rowid = $(this).data('rowid')
                var el = $(this)
                if (!rowid) return;


                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: "receipts_form/destroy/" + rowid,
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

            $(document).on('click', '.btn-resend-mail', function(e) {
                e.preventDefault();

                if (!confirm("คุณต้องการส่งอีเมลอีกครั้งหรือไม่?")) return;

                var id = $(this).data('id');
                var btn = $(this);

                if (!id) return;

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');

                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: "receipts_form/resend-mail/" + id,
                    data: {
                        _token: token
                    },
                    success: function(data) {
                        btn.prop('disabled', false).html('<i class="fa fa-envelope"></i> Resend Mail');
                        if (data.status === 'success') {
                            toastr.success(data.message, {
                                timeOut: 5000
                            });
                        } else {
                            toastr.error(data.message || 'Failed to send email', {
                                timeOut: 5000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        btn.prop('disabled', false).html('<i class="fa fa-envelope"></i> Resend Mail');
                        toastr.error('เกิดข้อผิดพลาดในการส่งอีเมล', {
                            timeOut: 5000
                        });
                    }
                });
            })

        })


        var myDropzone = {};
        Dropzone.options.myAwesomeDropzone = {
            url: '{{ route('form.upload') }}',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            paramName: "file", // ชื่อไฟล์ปลายทางเมื่อ upload แบบ mutiple จะเป็น array
            autoProcessQueue: true, // ใส่เพื่อไม่ให้อัพโหลดทันที หลังจากเลือกไฟล์
            uploadMultiple: true, // อัพโหลดไฟล์หลายไฟล์
            parallelUploads: 2, // ให้ทำงานพร้อมกัน 10 ไฟล์
            maxFiles: 5, // ไฟล์สูงสุด 5 ไฟล์
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            addRemoveLinks: true, // อนุญาตให้ลบไฟล์ก่อนการอัพโหลด
            maxFilesize: 10, // MB
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
                    $('#infiniteEdit').append("<input type='text' id='" + file.newName +
                        "' class='form_none file_arr' name='imgFiles[]' value='" + file.newName +
                        "'/>");
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
                            var element = document.getElementById("infiniteEdit");
                            var child = document.getElementById(name);
                            element.removeChild(child);
                            if (!document.getElementsByName('imgFiles[]').length) {
                                $('#dropzone_preview').css("display", "none");
                                /*  $('#dropzone-photo').addClass('form-focus-error');
                                 $('#dropzone-photo')
                                     .find('.form-error-message').css("display",
                                         "block");
                                 $('#dropzone-photo').css('border', 'solid 1px red'); */
                            }
                        }
                    });

                    //var _ref;
                    //return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                }).on("maxfilesexceeded", function(file, response) {
                    alert('allow maximum 5 file');
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
    </script>
@endsection
