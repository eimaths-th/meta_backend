@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                    <div>Students
                        <div class="page-title-subheading">META Knowledge Student Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">


                        {{-- <a href="#" class="btn btn-success" onclick="formModal('{{ route('test_modal') }}')"
                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                            data-bs-title="Create New Student">
                            <i class="fa fa-plus"></i> Create New Student test
                        </a> --}}
                        <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="ImportButton"><i
                                class="fa fa-file-excel"></i> Import Excel
                        </a>
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New Student</a>

                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form method="post" action="{{ route('students.destroy_all') }}" name="delete_all" id="delete_all">
                    @csrf
                    @method('DELETE')
                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th width="20px" align="center"></th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Lastname</th>
                                <th>Nickname</th>
                                <th>Mobile</th>
                                <th>status</th>
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

    <!-- Import Modal -->
    <div class="fade modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="ImportModal">
        <div class="modal-dialog modal-lg" role="document">
            <form id="importForm" class="form" action="{{ route('students.import') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Import Students</h5>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>
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

                        <div class="form-group">
                            <label for="Parent">Name Parent:</label><br>
                            <select style="width: 100%;" class="parent select2 select2_single form-control"
                                id="AddParent" name="name_parent" multiple="multiple">

                                @foreach ($data4 as $key2)
                                    <option value="{{ $key2->id }}">{{ $key2->code }} {{ $key2->name_parent }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group my-3">
                            <label for="Name">Select Code:

                            </label>
                            @foreach ($newStudentCode as $code)
                                <div class="form-check">
                                    <input class="form-check-input AddCode" type="radio" name="code"
                                        id="AddCode{{ $code['code'] }}" value="{{ $code['code'] }}">
                                    <label class="form-check-label" for="AddCode{{ $code['code'] }}"> {{ $code['code'] }}
                                        {{ $code['type'] }}</label>
                                </div>
                            @endforeach
                            {{-- <input type="hidden" class="form-control" name="code" id="AddCode" value=""> --}}
                        </div>
                        <div class="form-group">
                            <label for="Name">Name:</label>
                            <input type="text" class="form-control" name="name" id="AddName" value="">
                        </div>
                        <div class="form-group">
                            <label for="Name">Lastname:</label>
                            <input type="text" class="form-control" name="lastname" id="AddLastname" value="">
                        </div>
                        <div class="form-group">
                            <label for="Name">Nickname:</label>
                            <input type="text" class="form-control" name="nick_name" id="AddNickname"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="Name">Mobile:</label>
                            <input type="text" class="form-control" name="mobile" id="AddMobile" value="">
                        </div>
                        <div class="form-group">
                            <label for="Name">Grade:</label>
                            <input type="text" class="form-control" name="grade" id="AddGrade" value="">
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="SubmitCreateForm">Save</button>
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="fade modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="EditModal">
        <div class="modal-dialog modal-lg" role="document">
            <form class="form" action="" method="POST">


                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Student</h5>
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
                            <strong>Success!</strong> Student was edit successfully.
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>

                        <div class="form-group">
                            <label for="Parent">Name Parent:</label><br>
                            <select style="width: 100%;" class="parent select2 select2_single form-control"
                                id="EditParent" name="name_parent" multiple="multiple">

                            </select>
                        </div>
                        <div id="EditModalBody">

                        </div>
                        <div class="form-group mb-2">
                            <label for="Name">หมายเหตุไม่เรียนต่อ:</label>
                            <select style="width: 100%;"
                                class="form-control form-select select2 select3_single mt-2"id="Editreason" name="reason"
                                multiple="multiple">

                            </select>


                            <input type="text" class="form-control mt-2" id="textReason" name="reason"
                                autocomplete="off" placeholder="กรอกเหตุผลอื่นๆ">
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

    <!-- View  Modal -->
    <div class="fade modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="ViewModal">
        <div class="modal-dialog modal-lg" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">View Student</h5>
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
                            <strong>Success!</strong> Student was edit successfully.
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>

                        <div class="form-group">
                            <label for="Parent">ชื่อผู้ปกครอง:</label><br>
                            <select style="width: 100%;" class="parent select2 select2_single form-control"
                                id="ViewParent" name="name_parent" multiple="multiple">

                            </select>
                        </div>
                        <div id="ViewModalBody">

                        </div>


                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-success" id="SubmitEditForm">Update</button> --}}
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

            $(".select3_single").select2({
                maximumSelectionLength: 1,
                // allowClear: true
            });

            $(".select2_multiple").select2({
                maximumSelectionLength: 2,
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
                        data: 'photo',
                        name: 'photo'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'nick_name',
                        name: 'nick_name'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
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
                    url: "students/edit/" + id,
                    method: 'GET',
                    success: function(res) {
                        $('#EditModalBody').html(res.html);
                        $('#EditParent').html(res.parent);
                        $('#Editreason').html(res.select_reaon);
                        $('#EditModal').modal('show');
                        $('#textReason').hide();

                        $(document).ready(function() {
                            e.preventDefault();
                            var reasonValue = $('#Editreason').val()[0];
                            console.log('Editreason : ' + reasonValue);

                            if ($('#Editreason').val()[0] === '') {
                                $('#textReason').show();
                            } else {
                                $('#textReason').hide();
                            }
                        });

                    }
                });
            });
            $(document).on('change', '#Editreason', function(e) {
                e.preventDefault();
                var reasonValue = $('#Editreason').val()[0];
                console.log('Editreason : ' + reasonValue);

                if ($('#Editreason').val()[0] === '') {
                    $('#textReason').show();
                } else {
                    $('#textReason').hide();
                }
            });


            //view
            $(document).on('click', '#getViewData', function(e) {
                e.preventDefault();

                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                id = $(this).data('id');
                $.ajax({
                    url: "students/view/" + id,
                    method: 'GET',
                    success: function(res) {
                        $('#ViewModalBody').html(res.html);
                        $('#ViewParent').html(res.parent);
                        $('#ViewModal').modal('show');
                    }
                });

            });

            // Create product Ajax request.
            $('#SubmitCreateForm').click(function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                var selectedCode = $('.AddCode:checked').val();
                $.ajax({
                    url: "{{ route('students.store') }}",
                    method: 'post',
                    data: {
                        code: selectedCode,
                        name: $('#AddName').val(),
                        lastname: $('#AddLastname').val(),
                        nick_name: $('#AddNickname').val(),
                        mobile: $('#AddMobile').val(),
                        grade: $('#AddGrade').val(),
                        parent: $('#AddParent').val()[0],
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
                            location.reload();

                        }
                    }
                });
            });

            $('#SubmitEditForm').click(function(e) {
                e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();
                $.ajax({
                    url: "students/save/" + id,
                    method: 'PUT',
                    data: {
                        code: $('#EditCode').val(),
                        first_name: $('#EditName').val(),
                        last_name: $('#EditLastname').val(),
                        nick_name: $('#EditNickname').val(),
                        mobile: $('#EditMobile').val(),
                        grade: $('#Editgrade').val(),
                        // reason: $('#Editreason').val()[0],
                        reason: $('#Editreason').val()[0] !== null && $('#Editreason').val()[0] !==
                            '' ? $('#Editreason').val()[0] : $('#textReason').val(),
                        // reason: JSON.parse($('#Editreason').val()),
                        pid: $('#EditParent').val()[0],
                    },
                    success: function(result) {
                        console.log(result);
                        console.log($('#Editreason').val());

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
                    url: "students/destroy/" + rowid,
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
    </script>
@endsection
