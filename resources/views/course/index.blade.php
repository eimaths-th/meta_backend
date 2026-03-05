@extends('layouts.main_template')

@section('style')
  <script
    src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    type="text/javascript"
  ></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
    type="text/javascript"
  ></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/jquery.inputmask.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
  />
  <link
    rel="stylesheet"
    href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
  />
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />
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
            Study Course
            <div class="page-title-subheading">
              META Knowledge Study Course Data
            </div>
          </div>
        </div>
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            <a
              class="btn btn-info"
              data-toggle="modal"
              data-target=".bd-example-modal-lg"
              id="SimulateButton"
            >
              <i class="fa fa-bar-chart"></i>
              Simulate Chart
            </a>
            <a
              class="btn btn-success"
              data-toggle="modal"
              data-target=".bd-example-modal-lg"
              id="CreateButton"
            >
              <i class="fa fa-plus"></i>
              Create New Course
            </a>
            <a class="btn btn-danger delete_all_button" href="#">
              <i class="fa fa-trash"></i>
              Delete All
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <form
          method="post"
          action="{{ route('course.destroy_all') }}"
          name="delete_all"
          id="delete_all"
        >
          @csrf
          @method('DELETE')
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
                <th>Student Code</th>
                <th>Student Name</th>
                <th>Subject</th>
                <th>Start Level</th>
                <th>Start Book</th>
                <th>Start Date</th>
                <th width="280px">Action</th>
              </tr>
            </thead>
          </table>
        </form>
      </div>
    </div>
  </div>

  <!-- Simulate Modal -->

  <div
    class="fade modal bd-example-modal-lg"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
    id="SimulateModal"
  >
    <div class="modal-dialog modal-lg" role="document">
      <form
        class="form"
        id="simulate"
        action="{{ route('course.simulate', ['type' => 'view', 'lang' => 'en']) }}"
        method="POST"
      >
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              Simulate Chart
            </h5>
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
            <div class="form-group">
              <label for="Student">Student Name:</label>
              <br />
              <input
                type="text"
                class="form-control"
                name="student"
                id="SStudent"
                value=""
                required
              />
            </div>
            <div class="form-group">
              <label for="Subject">Subject:</label>
              <select
                class="SSubject form-control"
                id="SSubject"
                name="subject"
                required
              >
                <option value="" selected>Select Subject</option>
                @foreach ($data as $key)
                  <option
                    value="{{ $key->id }}"
                    {{ request()->get('id') == $key->id ? 'selected' : '' }}
                  >
                    {{ $key->title }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="Level">Start Level:</label>
              <select class="form-control" id="SLevel" name="level" required>
                <option value="" selected>Select Level</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Book">Book Start:</label>
              <select class="form-control" id="SBook" name="book" required>
                <option value="" selected>Select Book</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Grade">Grade:</label>
              <br />
              <input
                type="number"
                class="form-control"
                name="grade"
                id="SGrade"
                value=""
                required
              />
            </div>
            <div class="form-group">
              <label for="Date">Date Start (yyyy-mm-dd):</label>
              <input
                type="text"
                class="AddDate form-control"
                id="SDate"
                name="date"
                required
                value=""
              />
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button
              type="submit"
              class="btn btn-success"
              id="sSubmitSimulateForm"
            >
              Generate
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
      </form>
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
            <h5 class="modal-title" id="exampleModalLongTitle">Add Course</h5>
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
            <div class="form-group">
              <label for="Student">Student:</label>
              <br />
              <select
                style="width: 100%"
                class="select2 select2_single form-control"
                id="AddStudent"
                name="student"
                multiple="multiple"
              >
                <!--<option value="" selected>Select Student</option>-->
                @foreach ($data2 as $key2)
                  <option value="{{ $key2->id }}">
                    {{ $key2->code }} {{ $key2->first_name }}
                    {{ $key2->last_name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="Subject">Subject:</label>
              <select
                class="AddSubject form-control"
                id="AddSubject"
                name="subject"
              >
                <option value="" selected>Select Subject</option>
                @foreach ($data as $key)
                  <option
                    value="{{ $key->id }}"
                    {{ request()->get('id') == $key->id ? 'selected' : '' }}
                  >
                    {{ $key->title }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="Level">Start Level:</label>
              <select class="form-control" id="AddLevel" name="level">
                <option value="" selected>Select Level</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Book">Book Start:</label>
              <select class="form-control" id="AddBook" name="book">
                <option value="" selected>Select Book</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Date">Date Start (yyyy-mm-dd):</label>
              <input
                type="text"
                class="AddDate form-control"
                id="AddDate"
                name="date"
                required
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
      </form>
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
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Course</h5>
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
              <strong>Success!</strong>
              Course was edit successfully.
              <button
                type="button"
                class="btn-close"
                data-dismiss="alert"
                aria-label="Close"
              >
                <span aria-hidden="true"></span>
              </button>
            </div>
            <div id="EditModalBody">
              <div class="form-group">
                <label for="Student">Student:</label>
                <br />
                <select
                  style="width: 100%"
                  class="select2 select2_single form-control"
                  id="EditStudent"
                  name="student"
                  multiple="multiple"
                ></select>
              </div>
              <div class="form-group">
                <label for="Subject">Subject:</label>
                <select
                  class="AddSubject form-control"
                  id="EditSubject"
                  name="subject"
                >
                  <option value="" selected>Select Subject</option>
                  '.
                </select>
              </div>
              <div class="form-group">
                <label for="Level">Start Level:</label>
                <select class="form-control" id="EditLevel" name="level">
                  <option value="" selected>Select Level</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Book">Book Start:</label>
                <select class="form-control" id="EditBook" name="book">
                  <option value="" selected>Select Book</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Date">Date Start (yyyy-mm-dd):</label>
                <input
                  type="text"
                  class="AddDate form-control"
                  id="EditDate"
                  name="date"
                  required
                />
              </div>
            </div>
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
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      $('.AddDate').datepicker({
        dateFormat: 'yy-mm'
      });

      $('.AddDate').inputmask('9999-99');

      $('.select2_single').select2({
        maximumSelectionLength: 1,
        allowClear: true
      });
      $('.select2_multiple').select2({
        maximumSelectionLength: 1,
        //placeholder: "With Max Selection limit 4",
        allowClear: true
      });

      $('#SSubject').change(function () {
        var subject_id = $(this).val();
        $.ajax({
          type: 'POST',
          dataType: 'JSON',
          url: 'levels/select_list/' + subject_id,
          data: {
            _token: token
          },
          success: function (result) {
            //console.log(result);
            $('#SLevel').html(result.html);
            $('#SBook').html(result.html2);
          }
        });
      });

      $('#AddSubject').change(function () {
        var subject_id = $(this).val();
        $.ajax({
          type: 'POST',
          dataType: 'JSON',
          url: 'levels/select_list/' + subject_id,
          data: {
            _token: token
          },
          success: function (result) {
            //console.log(result);
            $('#AddLevel').html(result.html);
            $('#AddBook').html(result.html2);
          }
        });
      });

      $('#EditSubject').change(function () {
        var subject_id = $(this).val();
        $.ajax({
          type: 'POST',
          dataType: 'JSON',
          url: 'levels/select_list/' + subject_id,
          data: {
            _token: token
          },
          success: function (result) {
            //console.log(result);
            $('#EditLevel').html(result.html);
            $('#EditBook').html(result.html2);
          }
        });
      });

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
            data: 'student_code',
            name: 'student_code'
          },
          {
            data: 'student_name',
            name: 'student_name'
          },
          {
            data: 'student_subject',
            name: 'student_subject'
          },
          {
            data: 'student_level',
            name: 'student_level'
          },
          {
            data: 'book_start',
            name: 'book_start'
          },
          {
            data: 'date_start',
            name: 'date_start'
          },
          {
            data: 'action',
            name: 'action'
          }
        ]
      });

      $(document).on('click', '#SimulateButton', function (e) {
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        $('#SimulateModal').modal('show');
        //$('#SubmitCreateForm').show();
      });

      $(document).on('click', '#CreateButton', function (e) {
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        $('#CreateModal').modal('show');
        //$('#SubmitCreateForm').show();
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
          url: 'course/edit/' + id,
          method: 'GET',
          success: function (res) {
            $('#EditStudent').html(res.student);
            $('#EditSubject').html(res.subject);
            $('#EditLevel').html(res.html);
            $('#EditBook').html(res.html2);
            $('#EditDate').val(res.date);
            $('#EditModal').modal('show');
          }
        });
      });

      // Create product Ajax request.
      $('#SubmitSimulateForm').click(function (e) {
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        $.ajax({
          url: '{{ route('course.simulate', ['type' => 'view', 'lang' => 'en']) }}',
          method: 'get',
          data: {
            student: $('#SStudent').val(),
            subject: $('#SSubject').val(),
            level: $('#SLevel').val(),
            book: $('#SBook').val(),
            date: $('#SDate').val(),
            _token: token
          },
          success: function (result) {
            console.log(result);
            $('.alert-danger').html('');
            $.each(result.errors, function (key, value) {
              $('.alert-danger').show();
              $('.alert-danger').append(
                '<strong><li>' + value + '</li></strong>'
              );
            });
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
          url: '{{ route('course.store') }}',
          method: 'post',
          data: {
            student: $('#AddStudent').val()[0],
            subject: $('#AddSubject').val(),
            level: $('#AddLevel').val(),
            book: $('#AddBook').val(),
            date: $('#AddDate').val(),
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
              $('#AddStudent').val('').select2();
              $('#AddSubject').val('');
              $('#AddLevel').val('');
              $('#AddBook').val('');
              $('#AddDate').val('');

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
        //alert(id);
        e.preventDefault();

        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        $.ajax({
          url: 'course/save/' + id,
          method: 'PUT',
          data: {
            student: $('#EditStudent').val()[0],
            subject: $('#EditSubject').val(),
            level: $('#EditLevel').val(),
            book: $('#EditBook').val(),
            date: $('#EditDate').val(),
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
              $('#EditModal').modal('hide');
              //setTimeout(function() {
              //$('.alert-success').hide();
              //
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
          url: 'course/destroy/' + rowid,
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
