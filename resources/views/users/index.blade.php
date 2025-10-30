@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
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
                        <i class="pe-7s-user icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>Employees
                        <div class="page-title-subheading">META Knowledge Employee Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New
                            User</a>
                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form method="post" action="{{ route('users.destroy_all') }}" name="delete_all" id="delete_all">
                    @csrf
                    @method('DELETE')
                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Level</th>
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
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Employee</h5>
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
                            <label for="Name">Name:</label>
                            <input type="text" class="form-control" name="name" id="AddName" value="">
                        </div>
                        <div class="form-group">
                            <label for="Name">Email:</label>
                            <input type="text" class="form-control" name="email" id="AddEmail" value="">
                        </div>
                        <div class="form-group">
                            <label for="Name">Password:</label>
                            <input type="password" class="form-control" name="password" required autocomplete="new-password"
                                id="AddPassword">
                        </div>
                        <div class="form-group">
                            <label for="Name">Confirm Password:</label>
                            <input type="password" class="form-control" name="password_confirmation" id="AddPasswordC"
                                required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="Name">Level:</label>
                            <select class="form-control" id="AddType" name="type_user">
                                <option value="" selected>Select Time</option>
                                <option value="0">10.00-18.00</option>
                                <option value="1">09.00-17.00</option>

                            </select>
                        </div>
                        <input type="hidden" name="code" value="code" id="AddCode">
                        <div class="form-group">
                            <label for="Name">Level:</label>
                            <select class="form-control" id="AddLevel" name="level">
                                <option value="" selected>Select Level</option>
                                <option value="0">Owner</option>
                                <option value="1">Admin</option>
                                <option value="2">Teacher</option>
                                <option value="3">Account</option>
                                <option value="4">Officer</option>
                                <option value="5">Normal</option>
                            </select>
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

    <!-- Edit  Modal -->
    <div class="fade modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="EditModal">
        <div class="modal-dialog modal-lg" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Employee</h5>
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
                            <strong>Success!</strong> Users was edit successfully.
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
                lengthMenu: [10, 25, 50, 75, 100],
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
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'level',
                        name: 'level'
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
                    url: "users/edit/" + id,
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
                    url: "{{ route('users.store') }}",
                    method: 'post',
                    data: {
                        password: $('#AddPassword').val(),
                        password_confirmation: $('#AddPasswordC').val(),
                        name: $('#AddName').val(),
                        email: $('#AddEmail').val(),
                        level: $('#AddLevel').val(),
                        type_user: $('#AddType').val(),
                        code: $('#AddCode').val(),
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
                if (!confirm("Are you sure?")) return;
                e.preventDefault();

                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();


                $.ajax({
                    url: "users/save/" + id,
                    method: 'PUT',
                    data: {
                        name: $('#editName').val(),
                        password: $('#EditPassword').val(),
                        password_confirmation: $('#EditPasswordC').val(),
                        email: $('#editEmail').val(),
                        level: $('#editLevel').val(),
                    },

                    success: function(result) {
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
                            $('#Listview').DataTable().ajax.reload();
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
                    url: "users/destroy/" + rowid,
                    data: {
                        _method: 'delete',
                        _token: token
                    },
                    success: function(data) {

                        toastr.success(data.message, {
                            timeOut: 5000
                        });

                        $('#Listview').DataTable().ajax.reload();
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
