@extends ('layouts.main_template')

@section ('style')
  <script
    src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    type="text/javascript"
  ></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
    type="text/javascript"
  ></script>
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
  />
@endsection

@section ('content')
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
          <div>
            Parents
            <div class="page-title-subheading">META Knowledge parent Data</div>
          </div>
        </div>
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            <a
              class="btn btn-success"
              data-toggle="modal"
              data-target=".bd-example-modal-lg"
              id="CreateButton"
              ><i class="fa fa-plus"></i> Create New Parents</a
            >
            <a class="btn btn-danger delete_all_button" href="#"
              ><i class="fa fa-trash"></i> Delete All</a
            >
          </div>
        </div>
      </div>
    </div>
    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <form
          method="post"
          action="{{ route('parents.destroy_all') }}"
          name="delete_all"
          id="delete_all"
        >
          @csrf
          @method ('DELETE')
          <table
            style="width: 100%"
            id="Listview"
            class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action table"
          >
            <thead>
              <tr>
                <th width="10px">
                  <input type="checkbox" id="check-all" class="flat" />
                </th>
                <th>Code</th>
                <th>Email</th>
                <th>Parent's name</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th width="280px">Action</th>
              </tr>
            </thead>
          </table>
        </form>
      </div>
    </div>
  </div>
  <!-- Create Modal -->
  <div
    class="fade modal bd-example-modal-lg"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
    id="CreateModal"
  >
    <div class="modal-dialog modal-lg" role="document">
      <form class="form" action="" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Parent</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div
              class="alert alert-danger alert-dismissible fade show"
              role="alert"
              style="display: none"
            >
              <button
                type="button"
                class="btn-close"
                data-dismiss="alert"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div
              class="alert alert-success alert-dismissible fade show"
              role="alert"
              style="display: none"
            >
              <button
                type="button"
                class="btn-close"
                data-dismiss="alert"
                aria-label="Close"
              >
                <span aria-hidden="true"></span>
              </button>
            </div>
            <!-- <div class="form-group">
                            <label for="Name">Code:</label>
                            <input type="text" class="form-control" name="code" id="AddCode" value="">
                        </div> -->
            <div class="form-group">
              <label for="Name">Code:</label>
              <input
                type="text"
                class="form-control"
                name="code"
                id="AddCode"
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Name">Email:</label>
              <input
                type="text"
                class="form-control"
                name="email"
                id="AddEmail"
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Name">Password:</label>
              <input
                type="password"
                class="form-control"
                name="password"
                id="AddPassword"
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Name">Parent's name:</label>
              <input
                type="text"
                class="form-control"
                name="parent"
                id="AddParent"
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Name">Phone Number:</label>
              <input
                type="text"
                class="form-control"
                name="mobile"
                id="AddMobile"
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Name">Address:</label>
              <input
                type="text"
                class="form-control"
                name="address"
                id="AddAddress"
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Name">PostCode:</label>
              <input
                type="text"
                class="form-control"
                name="postcode"
                id="AddPostcode"
                value=""
              />
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="SubmitCreateForm">
              Save
            </button>
            <button
              type="button"
              class="btn btn-danger modelClose"
              data-bs-dismiss="modal"
            >
              Close
            </button>
          </div>
        </div>
    </div>
  </div>
  <!-- Edit  Modal -->
  <div
    class="fade modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
    id="EditModal"
  >
    <div class="modal-dialog modal-lg" role="document">
      <form class="form" action="" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Student</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div
              class="alert alert-danger alert-dismissible fade show"
              role="alert"
              style="display: none"
            >
              <button
                type="button"
                class="btn-close"
                data-dismiss="alert"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div
              class="alert alert-success alert-dismissible fade show"
              role="alert"
              style="display: none"
            >
              <strong>Success!</strong> Parent was edit successfully.
              <button
                type="button"
                class="btn-close"
                data-dismiss="alert"
                aria-label="Close"
              >
                <span aria-hidden="true"></span>
              </button>
            </div>
            <div id="EditModalBody"></div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="SubmitEditForm">
              Update
            </button>
            <button
              type="button"
              class="btn btn-danger modelClose"
              data-bs-dismiss="modal"
            >
              Close
            </button>
          </div>
        </div>
    </div>
  </div>
@endsection

@section ('script')
  <script>
    $(document).ready(function () {
      $('.delete_all_button').click(function () {
        var len = $('input[name="table_records[]"]:checked').length;
        if (len > 0) {
          if (confirm('Click OK to Delete?')) {
            $('form#delete_all').submit();
          }
        } else {
          alert('Please Select Record For Delete');
        }
      });

      $('#check-all').click(function () {
        $(':checkbox.flat').prop('checked', this.checked);
      });

      //$.noConflict();
      var token = '';
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
        aaSorting: [[0, 'desc']],
        iDisplayLength: 10,
        lengthMenu: [10, 20, 50, 75, 100],
        stateSave: true,
        sPaginationType: 'full_numbers',
        dom: 'T<"clear">lfrtip',
        columns: [
          {
            data: 'checkbox',
            name: 'checkbox',
            orderable: false,
            searchable: false
          },
          {
            data: 'code',
            name: 'code'
          },
          {
            data: 'email',
            name: 'email'
          },
          {
            data: 'name_parent',
            name: 'name_parent'
          },
          {
            data: 'mobile',
            name: 'mobile'
          },
          {
            data: 'street_address',
            name: 'street_address'
          },
          {
            data: 'action',
            name: 'action'
          }
        ]
      });

      $(document).on('click', '#CreateButton', function (e) {
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();
        $('#CreateModal').modal('show');
      });

      let id;
      $(document).on('click', '#getEditData', function (e) {
        e.preventDefault();

        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        id = $(this).data('id');
        $.ajax({
          url: 'parents/edit/' + id,
          method: 'GET',
          success: function (res) {
            $('#EditModalBody').html(res.html);
            $('#EditModal').modal('show');
          }
        });
      });

      // Create product Ajax request.
      $('#SubmitCreateForm').click(function (e) {
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        $.ajax({
          url: '{{
      route(
        'parents.store1',
      )
    }}',
          method: 'post',
          data: {
            // code: $('#AddCode').val(),
            code: $('#AddCode').val(),
            email: $('#AddEmail').val(),
            password: $('#AddPassword').val(),
            parent: $('#AddParent').val(),
            mobile: $('#AddMobile').val(),
            address: $('#AddAddress').val(),
            postcode: $('#AddPostcode').val(),
            _token: token
          },
          success: function (result) {
            if (result.errors) {
              $('.alert-danger').html('');
              $.each(result.errors, function (key, value) {
                $('.alert-danger').show();
                $('.alert-danger').append(
                  '<strong><li>' + value + '</li></strong>'
                );
              });
            } else {
              $('.alert-danger').hide();
              $('.alert-success').show();
              $('.alert-success').append(
                '<strong><li>' + result.success + '</li></strong>'
              );
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

      $('#SubmitEditForm').click(function (e) {
        //if (!confirm("Are you sure?")) return;
        e.preventDefault();

        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        $.ajax({
          url: 'parents/save/' + id,
          method: 'PUT',
          data: {
            code: $('#EditCode').val(),
            email: $('#EditEmail').val(),
            name_parent: $('#EditParentName').val(),
            mobile: $('#EditMobile').val(),
            street_address: $('#EditAddress').val(),
            postcode: $('#EditPostcode').val()
            // grade: $('#EditGrade').val(),
          },

          success: function (result) {
            //console.log(result);
            if (result.errors) {
              $('.alert-danger').html('');
              $.each(result.errors, function (key, value) {
                $('.alert-danger').show();
                $('.alert-danger').append(
                  '<strong><li>' + value + '</li></strong>'
                );
              });
            } else {
              $('.alert-danger').hide();
              $('.alert-success').show();
              $('.alert-success').append(
                '<strong><li>' + result.success + '</li></strong>'
              );
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

      $(document).on('click', '.btn-delete', function () {
        if (!confirm('Are you sure?')) return;

        var rowid = $(this).data('rowid');
        var el = $(this);
        if (!rowid) return;

        $.ajax({
          type: 'POST',
          dataType: 'JSON',
          url: 'parents/destroy/' + rowid,
          data: {
            _method: 'delete',
            _token: token
          },
          success: function (data) {
            if (data.success) {
              table.row(el.parents('tr')).remove().draw();
            }
          }
        }); //end ajax
      });
    });
  </script>
@endsection
