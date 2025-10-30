@extends('layouts.main_template')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://rawgit.com/RobinHerbots/Inputmask/5.x/dist/jquery.inputmask.js"></script>
	<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @yield('style')
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

        .bg-light2 {
            background-color: #e4efff;
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
        </style>
@endsection

@section('content')
    <div class="row">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>Comment
                        <div class="page-title-subheading">META Knowledge Comment Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New
                            Comment</a>
                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form method="post" action="{{ route('comment.destroy_all') }}" name="delete_all" id="delete_all">
                    @csrf
                    @method('DELETE')
                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th>Code</th>
                                <th>Student</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Photo</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>

                    </table>
                </form>



            </div>
        </div>

    </div>

    <!-- Create Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="CreateModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="infinite" class="form" action="{{ route('comment.store1') }}" method="POST">
            @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">

                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <!-- <div class="form-group">
                            <label for="Name">Code:</label>
                            <input type="text" class="form-control" name="code" id="AddCode" value="">
                        </div> -->
                        <div class="form-group">
                            <label for="Student">Student:</label><br>
                            <select style="width: 100%;" class="select2 select2_single form-control" id="student"
                                name="student" multiple="multiple">
                                <!-- <option value="" selected>Select Student</option> -->
                                @foreach ($data2 as $key2)
                                    <option value="{{ $key2->id }}">{{ $key2->code }} {{ $key2->first_name }} {{ $key2->last_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="Name">User:</label>
                            <input type="text" class="form-control" name="user" id="user" value="{{ Str::upper(Auth::user()->name) }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="Name">Comment:</label>
                            <input type="text" class="form-control" name="comment" id="user" value="">
                        </div>


                        <div class="form-row form-focus" id="dropzone-photo">
                                    <div class="col-md-12 col-sm-12">
                                        <a id="dphoto"></a>
                                        <div class="position-relative form-group">
                                            <label class="form-label form-label-top form-label-auto"
                                                for="photo">Photo <span class="form-required">*</span>
                                                <div style="width: 280px"></div>
                                            </label>
                                            <input type="text" id="drop1" name="drop1"
                                                class="form-control form_none" value="" hidden>
                                            <div class="dropzone" id="my-awesome-dropzone" style="font-size: 1.5em;">
                                                <div class="fallback">

                                                </div>
                                            </div>
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

                                <div class="dropzonex dz-default dz-message" id="dropzone_preview"
                                    style="font-size: 1.5em;">
                                    <h3 class="dropzone-previews ui"></h3>


                                </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Save</button>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Comment</h5>
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
                            <strong>Success!</strong> Parent was edit successfully.
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div id="EditModalBody">

                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitEditForm">Update</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

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
            $(".select2_single").select2({
                maximumSelectionLength: 1,
                allowClear: true
            });
            $(".select2_multiple").select2({
                maximumSelectionLength: 1,
                //placeholder: "With Max Selection limit 4",
                allowClear: true
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
                lengthMenu: [10, 20, 50, 75, 100],
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
                        data: 'student_code',
                        name: 'student_code'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },
                    {
                        name: "photo",
                        data: "photo",
                        // render: function (data, type, full, meta) {

                        //     return "<img src=\"{{ asset('comments_images/') }}/" + data + "\" height=\"50\"/>";
                        // },
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });



            $(document).on('click', '#CreateButton', function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $('#CreateModal').modal('show');
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
                    url: "comment/edit/" + id,
                    method: 'GET',
                    success: function(res) {
                        $('#EditModalBody').html(res.html);
                        $('#EditModal').modal('show');

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
                    url: "{{ route('comment.store1') }}",
                    method: 'post',
                    data: {
                        // code: $('#AddCode').val(),
                        user: $('#AddUser').val(),
                        comment: $('#AddComment').val(),
                        photo: $('#AddPhoto').val(),

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
                            $('#Listview').DataTable().ajax.reload();
                            $('.form').trigger('reset');
                            //$('#SubmitCreateForm').hide();
                            //setTimeout(function() {
                            //$('.alert-success').hide();
                            $('#CreateModal').modal('hide');
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


                $.ajax({
                    url: "comment/save/" + id,
                    method: 'PUT',
                    data: {
                        user: $('#user').val(),
                        comment: $('#comment').val(),
                        student: $('#student').val(),

                        // photo: $('#EditPhoto').val(),

                        // grade: $('#EditGrade').val(),
                    },

                    success: function(result) {
                        // console.log($('#student').val());
                        //console.log(result);
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
                            $('#Listview').DataTable().ajax.reload();
                            //setTimeout(function() {
                            //$('.alert-success').hide();
                            $('#EditModal').modal('hide');
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
                    url: "comment/destroy/" + rowid,
                    data: {
                        _method: 'delete',
                        _token: token
                    },
                    success: function(data) {
                        if (data.success) {
                            table.row(el.parents('tr'))
                                .remove()
                                .draw();
                        }
                    }
                }); //end ajax
            })
        })
        var myDropzone = {};
        Dropzone.options.myAwesomeDropzone = {
            url: '{{ route('comment.upload') }}',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            paramName: "file", // ชื่อไฟล์ปลายทางเมื่อ upload แบบ mutiple จะเป็น array
            autoProcessQueue: true, // ใส่เพื่อไม่ให้อัพโหลดทันที หลังจากเลือกไฟล์
            uploadMultiple: true, // อัพโหลดไฟล์หลายไฟล์
            parallelUploads: 5, // ให้ทำงานพร้อมกัน 10 ไฟล์
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
                    $('#infinite').append("<input type='text' id='" + file.newName +
                       "' class='form_none' name='imgFiles[]' value='" + file.newName + "'/>");
                    file.previewElement.id = file.newName;


                }).on("removedfile", function(file) {
                    //alert(file.id);
                    //var name = file.name;
                    var name = file.previewElement.id;
                    console.log(name);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        url: '{{ route('comment.delete') }}',
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
                                    // .find('.form-error-message').css("display", "block");
                                $('#dropzone-photo').css('border', 'solid 1px red');
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
                        // console.log(obj.success);
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
