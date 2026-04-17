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
  <!-- Include Moment.js CDN -->
  <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"
  ></script>
  <!-- Include Bootstrap DateTimePicker CDN -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet"
  />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <style>
    .bg-chn {
      background-color: #ff9999 !important;
    }
    .bg-math {
      background-color: #80dfff !important;
    }
    .bg-eng {
      background-color: #66ffcc !important;
    }
    .bg-sci {
      background-color: #b3b3ff !important;
    }
  </style>
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
            <i class="pe-7s-diskette icon-gradient bg-tempting-azure"></i>
          </div>
          <div>
            Study Histories
            <div class="page-title-subheading">
              META Knowledge Study Histories Data
            </div>
          </div>
        </div>
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            <div class="dropdown show">
              <button
                class="btn btn-shadow btn-secondary dropdown-toggle"
                href="#"
                role="button"
                id="dropdownMenuLink"
                data-toggle="dropdown"
                autoClose="true"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <span class="btn-icon-wrapper pr-2 opacity-7">
                  <i class="fa fa-print fa-w-20"></i>
                </span>
                ดูรายงานประวัติการเรียน
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li>
                  <a class="dropdown-item" href="#" id="printr1">
                    รายงานประวัติการเรียนรายวัน
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#" id="printstd">
                    รายงานประวัติการเรียนรายบุคคล
                  </a>
                </li>
                {{-- <li><a class="dropdown-item" href="#" id="printr2">ใบปะหน้ารายเดือน</a></li> --}}
              </ul>
            </div>
          </div>
          <div class="d-inline-block dropdown">
            <a
              class="btn btn-success"
              data-toggle="modal"
              data-target=".bd-example-modal-lg"
              id="CreateButton"
            >
              <i class="fa fa-plus"></i>
              Create New History
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
          action="{{ route('histories.destroy_all') }}"
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
                <th>Student Code</th>
                <th>Student Name</th>
                <th>Subject</th>
                {{-- <th>Level</th> --}}
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th width="280px">Action</th>
              </tr>
            </thead>
          </table>
        </form>
      </div>
    </div>
  </div>
  <!-- PrintDay Modal -->
  <div
    class="fade modal bd-example-modal-lg"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
    id="PrintDayModal"
  >
    <div class="modal-dialog modal-lg" role="document">
      <form
        id="PrintDayForm"
        class="form"
        action="{{ route('histories.print_day') }}"
        method="POST"
      >
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              ดูประวัติการเรียน
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
            <div class="col-md-4">
              <div class="form-group">
                <label for="Submission Date">Date:</label>
                <input
                  type="text"
                  class="AddDate form-control"
                  name="print_date"
                  id="PrintDaySubmissiondate"
                  value=""
                  required
                />
                <input type="hidden" name="type" value="view" />
              </div>
            </div>
          </div>
          <!-- Modal footer id="SubmitPrintDayForm"-->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">View</button>
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
  <!-- Printstd Modal -->
  <div
    class="fade modal bd-example-modal-lg"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
    id="PrintStdModal"
  >
    <div class="modal-dialog modal-lg" role="document">
      <form
        id="PrintDayForm"
        class="form"
        action="{{ route('histories.print_std') }}"
        method="POST"
      >
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              ดูประวัติการเรียนรายบุคคล
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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="Student">Student:</label>
                  <br />
                  <select
                    style="width: 100%"
                    class="select2 select2_single form-control"
                    id="viewStudent"
                    name="student"
                    multiple="multiple"
                    required
                  ></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="Submission Date">Date:</label>
                  <input
                    type="text"
                    class="AddDate form-control"
                    name="std_date"
                    id="PrintStdSubmissiondate"
                    value=""
                    autocomplete="off"
                  />
                  <input type="hidden" name="type" value="view" />
                </div>
              </div>
            </div>
          </div>
          <!-- Modal footer id="SubmitPrintDayForm"-->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">View</button>
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
            <h5 class="modal-title" id="exampleModalLongTitle">
              Add Studies History
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
                    {{ $key2->code }} {{ $key2->first_name }} {{ $key2->last_name }}
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
                    {{
                      request()->get('id') == $key->id
                        ? 'selected'
                        : ''
                    }}
                  >
                    {{ $key->title }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="Preiod">Preiod :</label>
              <select
                class="AddPreiod form-control"
                id="AddPreiod"
                name="preiod"
              >
                <option value="" selected>Select Preiod</option>
                {{--
                  @foreach ($data as $key)
                  <option value="{{ $key->id }}"
                  {{ request()->get('id') == $key->id ? 'selected' : '' }}> {{ $key->title }}
                  </option>
                  @endforeach
                --}}
              </select>
            </div>
            {{--
              <div class="form-group">
              <label for="Level">Level:</label>
              <select class="form-control" id="AddLevel" name="level">
              <option value="" selected>Select Level</option>
              
              </select>
              </div>
            --}}
            <div class="form-group">
              <label for="Des">Description:</label>
              <input
                type="text"
                class="form-control"
                name="des"
                id="AddDes"
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Date">Date Studies (yyyy-mm-dd):</label>
              <input
                type="text"
                class="AddDate form-control"
                id="AddDate"
                name="date"
                required
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Time">Time Studies Start (HH-mm-ss):</label>
              <input
                type="text"
                class="AddTime form-control"
                id="AddTime"
                name="time"
                required
                value=""
              />
            </div>
            <div class="form-group">
              <label for="ETime">Time Studies End (HH-mm-ss):</label>
              <input
                type="text"
                class="AddTime form-control"
                id="AddETime"
                name="etime"
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
            <h5 class="modal-title" id="exampleModalLongTitle">
              Edit Histories
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
              {{--
                <div class="form-group">
                <label for="Level">Level:</label>
                <select class="form-control" id="EditLevel" name="level">
                <option value="" selected>Select Level</option>
                
                </select>
                </div>
              --}}
              <div class="form-group">
                <label for="Des">Description:</label>
                <input
                  type="text"
                  class="form-control"
                  name="des"
                  id="EditDes"
                  value=""
                />
              </div>
              <div class="form-group">
                <label for="Date">Date Studies (yyyy-mm-dd):</label>
                <input
                  type="text"
                  class="AddDate form-control"
                  id="EditDate"
                  name="date"
                  required
                />
              </div>
              <div class="form-group">
                <label for="Time">Time Studies Start (HH-mm-ss):</label>
                <input
                  type="text"
                  class="AddTime form-control"
                  id="EditTime"
                  name="time"
                  required
                  value=""
                />
              </div>
            </div>
            <div class="form-group">
              <label for="ETime">Time Studies End (HH-mm-ss):</label>
              <input
                type="text"
                class="AddTime form-control"
                id="EditETime"
                name="time"
                required
                value=""
              />
            </div>
            <div class="form-group">
              <label for="Signature">ลายเซ็นต์ผู้ปกครอง:</label>
              <div id="Signature"></div>
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

@section ('script')
  <script>
    $(document).ready(function () {
      $('.AddDate').datepicker({
        dateFormat: 'yy-mm-dd'
      });

      $('.dropdown-toggle').dropdown();

      /* $('.AddTime').datetimepicker({
                format: 'hh:mm:ss '
            }); */

      $('.AddDate').inputmask('9999-99-99');

      $('.AddTime').inputmask('99:99:99');

      $('.select2_single').select2({
        maximumSelectionLength: 1,
        allowClear: true
      });
      $('.select2_multiple').select2({
        maximumSelectionLength: 1,
        //placeholder: "With Max Selection limit 4",
        allowClear: true
      });

      $('.dropdown-menu li #printr1').on('click', function (e) {
        //console.log("TEST");
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();
        $('.dropdown-toggle').dropdown('hide');
        $('#PrintDayModal').modal('show');
      });

      $('.dropdown-menu li #printstd').on('click', function (e) {
        //console.log("TEST");
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();
        $('.dropdown-toggle').dropdown('hide');
        $('#PrintStdModal').modal('show');
        $.ajax({
          url: 'histories/show',
          method: 'POST',
          success: function (res) {
            $('#viewStudent').html(res.student);
          }
        });
      });

      /*  $("#SSubject").change(function() {

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
                         $("#SLevel").html(result.html);

                     }
                 });

             }); */

      /*  $("#AddSubject").change(function() {

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

                     }
                 });

             }); */

      /*  $("#EditSubject").change(function() {

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
                         $("#EditLevel").html(result.html);

                     }
                 });

             }); */

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

      // var table = $('#Listview').DataTable({
      //     ajax: '',
      //     serverSide: true,
      //     processing: true,
      //     language: {
      //         loadingRecords: '&nbsp;',
      //         processing: '<div class="spinner"></div>'
      //     },
      //     aaSorting: [
      //         [0, "desc"]
      //     ],
      //     iDisplayLength: 10,
      //     lengthMenu: [10, 20, 50, 75, 100],
      //     stateSave: true,
      //     sPaginationType: "full_numbers",
      //     dom: 'T<"clear">lfrtip',
      //     columns: [{
      //             data: 'checkbox',
      //             name: 'checkbox',
      //             orderable: false,
      //             searchable: false
      //         },
      //         {
      //             data: 'student_code',
      //             name: 'student_code'
      //         },
      //         {
      //             data: 'student_name',
      //             name: 'student_name'
      //         },
      //         {
      //             data: 'student_subject',
      //             name: 'student_subject'
      //         },
      //         /*   {
      //               data: 'student_level',
      //               name: 'student_level'
      //           }, */
      //         {
      //             data: 'datetime',
      //             name: 'datetime'
      //         },
      //         {
      //             data: 'stime',
      //             name: 'stime'
      //         },
      //         {
      //             data: 'etime',
      //             name: 'etime'
      //         },
      //         {
      //             data: 'action',
      //             name: 'action'
      //         },
      //     ],
      //     createdRow: function(row, data, dataIndex) {
      //         // Add a background color to the row based on your condition
      //         if ( /* Your condition here */ ) {
      //             $(row).addClass('bg-danger');
      //         }
      //     }
      // });

      var table = $('#Listview').DataTable({
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
            data: 'datetime',
            name: 'datetime'
          },
          {
            data: 'stime',
            name: 'stime'
          },
          {
            data: 'etime',
            name: 'etime'
          },
          {
            data: 'action',
            name: 'action'
          }
        ],
        createdRow: function (row, data, dataIndex) {
          // Add a background color to the row based on your condition
          if (data.student_subject === 'Chinese') {
            $(row).addClass('bg-chn');
          } else if (
            data.student_subject == 'Math' ||
            data.student_subject == 'Play Math' ||
            data.student_subject == 'Private Math'
          ) {
            $(row).addClass('bg-math');
          } else if (
            data.student_subject == 'English Pre-A - I' ||
            data.student_subject === 'English 5-8' ||
            data.student_subject === 'English Sparks'
          ) {
            $(row).addClass('bg-eng');
          } else if (data.student_subject === 'Science') {
            $(row).addClass('bg-sci');
          }
        }
      });

      $(document).on('click', '#CreateButton', function (e) {
        e.preventDefault();
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();

        $('#CreateModal').modal('show');

        $(document).on('change', '#AddStudent', function (e) {
          e.preventDefault();
          var id = $('#AddStudent').val()[0];
          $.ajax({
            url: 'histories/stdsub/' + id,
            method: 'get',
            data: {
              _token: token
            },
            success: function (result) {
              // console.log(result);
              $('#AddSubject').html(result.studentsub);
            }
          });
        });
        $(document).on('change', '#AddSubject', function (e) {
          e.preventDefault();
          var id = $('#AddStudent').val()[0];
          var sub_id = $('#AddSubject').val();
          $.ajax({
            url: 'histories/stdsperiod/' + id + '/' + sub_id,
            method: 'get',
            data: {
              _token: token
            },
            success: function (result) {
              // console.log(result);
              $('#AddPreiod').html(result.studentperiod);
            }
          });
        });
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
          url: 'histories/edit/' + id,
          method: 'GET',
          success: function (res) {
            $('#EditStudent').html(res.student);
            $('#EditSubject').html(res.subject);
            //$('#EditLevel').html(res.html);
            $('#EditDate').val(res.date);
            $('#EditTime').val(res.stime);
            $('#EditETime').val(res.etime);
            $('#EditDes').val(res.des);
            $('#Signature').html(res.signature);
            $('#EditModal').modal('show');
          }
        });
      });

      // view

      // $(document).on('click', '#getViewData', function(e) {
      //     e.preventDefault();

      //     $('.alert-danger').html('');
      //     $('.alert-danger').hide();
      //     $('.alert-success').html('');
      //     $('.alert-success').hide();

      //     id = $(this).data('id');
      //     $.ajax({
      //         url: "histories/view/" + id,
      //         method: 'GET',
      //         success: function(res) {

      //             $('#ViewStudent').html(res.student);
      //             $('#ViewSubject').html(res.subject);
      //             //$('#EditLevel').html(res.html);
      //             $('#ViewDate').val(res.date);
      //             $('#ViewTime').val(res.stime);
      //             $('#ViewETime').val(res.etime);
      //             $('#ViewDes').val(res.des);
      //             $('#toa').val(res.toa);
      //             // $('#Signature1').html(res.signature);
      //             $('#ViewModal').modal('show');
      //         }
      //     });

      // });

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
        'histories.store',
      )
    }}',
          method: 'post',
          data: {
            student: $('#AddStudent').val()[0],
            subject: $('#AddSubject').val(),
            preiod: $('#AddPreiod').val(),
            date: $('#AddDate').val(),
            des: $('#AddDes').val(),
            stime: $('#AddTime').val(),
            etime: $('#AddETime').val(),
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
            } else if (result.errortime) {
              $('.alert-danger').show();
              $('.alert-danger').append(
                '<strong><li>' + result.errortime + '</li></strong>'
              );
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
              //$('#AddLevel').val('');
              $('#AddBook').val('');
              $('#AddDate').val('');

              $('#CreateModal').modal('hide');
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
          url: 'histories/save/' + id,
          method: 'PUT',
          data: {
            student: $('#EditStudent').val()[0],
            subject: $('#EditSubject').val(),
            //level: $('#EditLevel').val(),
            date: $('#EditDate').val(),
            stime: $('#EditTime').val(),
            etime: $('#EditETime').val(),
            des: $('#EditDes').val(),
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
          url: 'histories/destroy/' + rowid,
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
