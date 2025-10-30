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
                        <i class="pe-7s-network icon-gradient bg-tempting-azure"></i>
                    </div>
                    <div>
                        {{ $data[request()->get('id')-1]->title }}
                        Levels
                        <div class="page-title-subheading">META Knowledge Levels Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New
                            Level</a>

                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form method="post" action="{{ route('levels.destroy_all') }}" name="delete_all" id="delete_all">
                    <input type="hidden" name="id" id="id" value="{{ request()->get('id') }}">
                    @csrf
                    @method('DELETE')
                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th width="10px"><input type="checkbox" id="check-all" class="flat"></th>
                                <th>Subject</th>
                                <th>Sort</th>
                                <th>Book</th>
                                <th>Title</th>
                                <th>Title Thai</th>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Level</h5>
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
                                @foreach ($data as $key)
                                    <option value="{{ $key->id }}"  {{ request()->get('id') == $key->id ? 'selected' : '' }}> {{ $key->title }} </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Title">Title:</label>
                            <input type="text" class="form-control" name="title" id="AddTitle" value="">
                        </div>
                        <div class="form-group">
                            <label for="Title">Title Thai:</label>
                            <input type="text" class="form-control" name="title_th" id="AddTitleTh" value="">
                        </div>

                        <div class="form-group">
                            <label for="Name">Description</label>
                            <textarea class="form-control" name="description" id="AddDes"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="Sort">Sort:</label>
                            <input type="number" class="form-control" id="AddSort" name="sort" value=""
                                min="1" max="99">
                        </div>
                        <div class="form-group">
                            <label for="Book">Book:</label>
                            <input type="number" class="form-control" id="AddBook" name="book" value=""
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Level</h5>
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
                            <strong>Success!</strong> Level was edit successfully.
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
                        data: 'level_sort',
                        name: 'level_sort'
                    },
                    {
                        data: 'book_per_level',
                        name: 'book_per_level'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'title_th',
                        name: 'title_th'
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
                    url: "levels/edit/" + id,
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
                    url: "{{ route('levels.store') }}",
                    method: 'post',
                    data: {
                        subject: $('#AddSubject').val(),
                        book_per_level: $('#AddBook').val(),
                        title: $('#AddTitle').val(),
                        title_th: $('#AddTitleTh').val(),
                        description: $('#AddDes').val(),
                        sort: $('#AddSort').val(),
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
                    url: "levels/save/" + id,
                    method: 'PUT',
                    data: {
                        subject: $('#EditSubject').val(),
                        book_per_level: $('#EditBook').val(),
                        title: $('#EditTitle').val(),
                        title_th: $('#EditTitleTh').val(),
                        description: $('#EditDes').val(),
                        level_sort: $('#EditSort').val(),
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
                    url: "levels/destroy/" + rowid,
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

