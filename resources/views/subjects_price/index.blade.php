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
                        <i class="pe-7s-cash icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>
                        {{ $subject[request()->get('id') - 1]->title }}
                        Cost
                        <div class="page-title-subheading">META Knowledge Cost Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New
                            Cost</a>

                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form method="post" action="{{ route('subjects_price.destroy_all') }}" name="delete_all" id="delete_all">
                    <input type="hidden" name="id" id="id" value="{{ request()->get('id') }}">
                    @csrf
                    @method('DELETE')
                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th>Subject</th>
                                <th>Level</th>
                                <?php
                        if(request()->get('id')==3){?>
                                <th>Type</th>

                        <?php }
                        ?>
                                <th>Week</th>
                                <th>Price</th>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Cost</h5>
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
                            <label for="Subject">Subject:</label>
                            <select class="form-control" id="AddSubject" name="subject" disabled>
                                <option value="" selected>Select Subject</option>
                                @foreach ($subject as $key)
                                    <option value="{{ $key->id }}"
                                        {{ request()->get('id') == $key->id ? 'selected' : '' }}> {{ $key->title }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Level">Level:</label>
                            <select class="form-control" id="AddLevel" name="level">
                                <option value="" selected>Select Level</option>

                            </select>
                        </div>
                        <?php
                        if(request()->get('id')==3){?>
                        <div class="form-group">
                            <label for="Type">Type:</label>
                            <select class="form-control" id="AddType" name="type">
                                <option value="" selected>Select Type</option>
                                <option value="1">One Type แบบเดี่ยว</option>
                                <option value="2">Couple แบบคู่</option>

                            </select>
                        </div>

                        <?php }
                        ?>
                        <div class="form-group">
                            <label for="Title">Week:</label>
                            <select class="form-control" id="AddWeek" name="week">
                                <option value="" selected>Select Week</option>
                                <option value="1">1 week</option>
                                <option value="2">2 week</option>
                                <option value="3">3 week</option>
                                <option value="4">4 week</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Oldprice">Course Old Price:</label>
                            <input type="number" class="form-control" id="AddOprice" name="old_price" value=""
                                min="1" max="99">
                        </div>
                        <div class="form-group">
                            <label for="Price">Course Price:</label>
                            <input type="number" class="form-control" id="AddPrice" name="price" value=""
                                min="1" max="99">
                        </div>
                        <div class="form-group">
                            <label for="Book">Booklets:</label>
                            <input type="number" class="form-control" id="AddBook" name="book" value=""
                                min="1" max="99">
                        </div>
                        <div class="form-group">
                            <label for="Price">Book Old Price:</label>
                            <input type="number" class="form-control" id="AddBoprice" name="boprice" value=""
                                min="1" max="99">
                        </div>
                        <div class="form-group">
                            <label for="Price">Book Price:</label>
                            <input type="number" class="form-control" id="AddBprice" name="bprice" value=""
                                min="1" max="99">
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Cost</h5>
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
                            <strong>Success!</strong> Cost was edit successfully.
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

            var token = ''
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var subject_id = {{ request()->get('id') }};
                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: "levels/select_list/" + subject_id,
                    data: {
                        _token: token
                    },
                    success: function(result) {
                        //console.log(result);
                        $("#AddLevel").html(result.html);
                        //$("#AddBook").html(result.html2);
                    }
                });


            $("#AddSubject").change(function() {

                var subject_id = $(this).val();
                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: "levels/select_list/" + subject_id,
                    data: {
                        _token: token
                    },
                    success: function(result) {
                        //console.log(result);
                        $("#AddLevel").html(result.html);
                        //$("#AddBook").html(result.html2);
                    }
                });

            });

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

if(subject_id==3){
    var table = $('#Listview').DataTable({
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
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'week',
                        name: 'week'
                    },

                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
}else{
    var table = $('#Listview').DataTable({
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
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },

                    {
                        data: 'week',
                        name: 'week'
                    },

                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
}




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
                    url: "subjects_price/edit/" + id,
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
                    url: "{{ route('subjects_price.store') }}",
                    method: 'post',
                    data: {
                        subject: $('#AddSubject').val(),
                        level: $('#AddLevel').val(),
                        week: $('#AddWeek').val(),
                        old_price: $('#AddOprice').val(),
                        price: $('#AddPrice').val(),
                        book: $('#AddBook').val(),
                        book_old_price: $('#AddBoprice').val(),
                        book_price: $('#AddBprice').val(),
                        type: $('#AddType').val(),

                        _token: token,
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
                    url: "subjects_price/save/" + id,
                    method: 'PUT',
                    data: {
                        subject: $('#EditSubject').val(),
                        level: $('#EditLevel').val(),
                        week: $('#EditWeek').val(),
                        old_price: $('#EditOprice').val(),
                        price: $('#EditPrice').val(),
                        book: $('#EditBook').val(),
                        book_old_price: $('#EditBoprice').val(),
                        book_price: $('#EditBprice').val(),
                        type: $('#EditType').val(),

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
                    url: "subjects_price/destroy/" + rowid,
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
