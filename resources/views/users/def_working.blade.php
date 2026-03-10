@extends ('layouts.main_template')

@section ('style')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />
  <script
    src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    type="text/javascript"
  ></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
    type="text/javascript"
  ></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://malsup.github.io/jquery.blockUI.js"></script>
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
  />
  <link
    rel="stylesheet"
    href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
  />
  <link
    href="/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
    rel="stylesheet"
  />
  <link
    href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css"
    rel="stylesheet"
  />
  <style>
    .nowrap {
      white-space: nowrap;
    }
  </style>
  {{-- <link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/> --}}
  {{--
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
  --}}
  <script src="/assets/plugins/parsleyjs/dist/parsley.min.js"></script>
@endsection

@section ('content')
  @if ($message = Session::get('error'))
    <script>
      toastr.error('{{ $message }}', {
        timeOut: 5000
      });
    </script>
  @endif
  @if ($message = Session::get('success'))
    <script>
      toastr.success('{{ $message }}', {
        timeOut: 5000
      });
    </script>
  @endif
  <div class="row">
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i
              class="fas fa-clock-rotate-left icon-gradient bg-tempting-azure"
            ></i>
          </div>
          <div>
            Record Time META Knowledge
            <div class="page-title-subheading">
              META Knowledge SetTime Forms Data
            </div>
          </div>
        </div>
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            <a
              href="javascript:;"
              class="btn btn-success"
              onclick="formModal_1('{{ route('recordtime.create') }}')"
              data-bs-toggle="tooltip"
              data-bs-trigger="hover"
              data-bs-container="body"
              data-bs-title="Create New Student"
            >
              <i class="fas fa-user-plus"></i>
              Add Record
            </a>

            {{--
              <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="ImportButton"><i
              class="fa fa-file-excel"></i> Import Excel
              </a>
              <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
              id="CreateButton"><i class="fa fa-plus"></i> Create New Student</a>
              
              <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
              All</a>
            --}}
          </div>
        </div>
      </div>
    </div>
    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <form
          action="{{ route('search_rect') }}"
          method="GET"
          data-parsley-validate="true"
        >
          @csrf
          <div class="row mb-3">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="col-lg-3">
              <div class="row">
                <label for="month" class="col-lg-3">พนักงาน :</label>
                <div class="col-lg-9">
                  {{--
                    <select id="select2test" class="form-select-lg" name="user_id">
                    @foreach ($users as $user_name)
                    <option value="{{ $user_name->id }}">{{ $user_name->name }}</option>
                    @endforeach
                    
                    </select>
                  --}}
                  <select name="user_id" class="form-select form-control">
                    <option value="">เลือกพนักงาน</option>

                    @foreach ($users as $user_name)
                      <option value="{{ $user_name->id }}">
                        {{ $user_name->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="row">
                <label for="month" class="col-sm-4">
                  เดือน
                  <span class="text-danger">*</span>
                  :
                </label>
                <div class="col-sm-8">
                  <select
                    name="month"
                    id="selectMonth"
                    class="form-select form-control"
                    data-parsley-required="true"
                    data-parsley-required-message="เลือกเดือน"
                  >
                    <option value="">เลือกเดือน</option>
                    @for ($i = 1; $i <= 12; $i++)
                      <option value="{{ $i }}">
                        {{
                          date(
                            'F',
                            mktime(0, 0, 0, $i, 1),
                          )
                        }}
                      </option>
                    @endfor
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="row">
                <label for="year" class="col-lg-2">ปี :</label>
                <div class="col-lg-9">
                  <select
                    name="year"
                    id="selectYear"
                    class="form-select form-control"
                    data-parsley-required="true"
                    data-parsley-required-message="เลือกปี"
                  >
                    {{-- <option value="">เลือกปี</option> --}}
                    @php
                      $currentYear = date('Y');
                      for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                        echo "<option value='$i'>$i</option>";
                      }
                    @endphp
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-2">
              <button class="btn btn-primary" type="submit">ค้นหา</button>
            </div>
          </div>
        </form>
        <table
          style="width: 100%"
          id="Listview"
          class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action table"
        >
          <thead>
            <tr>
              {{-- <th width="10px"><input type="checkbox" id="check-all" class="flat"></th> --}}
              <th width="1%" align="center">#</th>
              <th width="1%" align="center">Code</th>
              <th data-orderable="false">Name</th>
              <th data-orderable="false">Date</th>
              <th data-orderable="false">Time</th>
              <th width="1%" data-orderable="false">Staus</th>

              <th>หมายเหตุ</th>
              <th class="nowrap" data-orderable="false">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rec_times as $key => $rec_time)
              <tr>
                <td align="center">{{ $key + 1 }}</td>
                <td>
                  INF{{
                    $rec_time->user->code ??
                      'NUll'
                  }}
                </td>

                <td>
                  {{
                    $rec_time->user->name ??
                      'ไม่พบพนักงาน'
                  }}
                </td>
                <td>
                  {{
                    date(
                      'D d-M-Y',
                      strtotime($rec_time->date),
                    )
                  }}
                </td>
                <td>{{ $rec_time->full_time }}</td>

                @php
                  $class = '';
                  switch ($rec_time->status) {
                    case 1:
                      $class = 'success';
                      break;

                    case 2:
                    case 3:
                    case 4:
                    case 13:
                      $class = 'danger';
                      break;

                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                      $class = 'warning';
                      break;

                    case 11:
                    case 12:
                      $class = 'primary';
                      break;

                    case 10:
                      $class = 'dark';

                      break;

                    default:
                      break;
                  }
                @endphp

                <td>
                  {{-- <span class="badge bg-{{ $class }} text-white">{{ $rec_time->status_name }}</span> --}}
                  <span
                    class="badge border-{{ $class }} text-{{ $class }} pt-5px pb-5px fs-12px d-inline-flex align-items-center rounded border px-2"
                  >
                    <i class="fa fa-circle fs-9px fa-fw me-5px"></i>
                    {{ $rec_time->status_name }}
                  </span>
                </td>

                <td>
                  @php
                    $text_late = '';
                    if ($rec_time->late_time) {
                      $text_late = '| สาย : ' . $rec_time->late_time . ' นาที';
                    }
                  @endphp

                  {{ $rec_time->explain }} {{ $text_late }}
                </td>

                <td width="1%" class="text-nowrap">
                  <a
                    href="javascript:;"
                    class="btn btn-xs btn-warning"
                    onclick="
                      formModal_2(
                        '{{ route('recordtime.edit', [$rec_time->id]) }}'
                      )
                    "
                    data-bs-toggle="tooltip"
                    data-bs-trigger="hover"
                    data-bs-container="body"
                    data-bs-title="Edit Record time"
                  >
                    <i class="fa fa-edit"></i>
                  </a>
                  {{--
                    <button type="button" class="btn btn-xs btn-danger delete-button"
                    data-recordid="{{ $rec_time->id }}">
                    <i class="fa fa-trash"></i>
                    </button>
                  --}}
                  {{--
                    <form action="{{ route('recordtime.destroy', $rec_time->id) }}" method="POST">
                    <a href="javascript:;" class="btn btn-xs btn-warning"
                    onclick="formModal_2('{{ route('recordtime.edit', [$rec_time->id]) }}')"
                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
                    data-bs-title="Edit Record time">
                    <i class="fa fa-edit"></i>
                    </a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger"
                    onclick="return confirm('Are you sure you want to delete this record?')"><i
                    class="fa fa-trash"></i> </button>
                    </form>
                  --}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="body-block-example-2" style="display: none" id="loder_bar">
    <br />
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
    <br />
  </div>
@endsection

@section ('script')
  <script src="/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
  <script>
    var table = $('#Listview').DataTable({
      // serverSide: true,
      // processing: true,
      lengthMenu: [31, 75, 100]
    });
    var successMessage = '{{ session('success') }}';

    if (successMessage) {
      document.getElementById('successAlert').style.display = 'block';
    }
    $('.default-select2').select2();

    $('#select2test').select2();
    // $(document).on('click', '.f5', function(e) {
    //     e.preventDefault();
    //     window.open(event.target.href);
    //     window.location.reload();
    //     event.preventDefault();
    //     console.log(window.location);
    // });
  </script>
  {{--
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Attach a click event to the delete button
    document.querySelector('.delete-button').addEventListener('click', function() {
    // Display a confirmation dialog
    var confirmDelete = window.confirm('Are you sure you want to delete this record?');
    
    // If the user confirms, send an AJAX request
    if (confirmDelete) {
    var recordId = this.getAttribute('data-recordid');
    
    // Send an AJAX request to the delete route
    axios.delete('{{ route('recordtime.destroy', ['recordtime' => ':recordId']) }}'
    .replace(':recordId', recordId))
    .then(function(response) {
    // Handle success, e.g., remove the deleted record from the UI
    console.log(response.data);
    })
    .catch(function(error) {
    // Handle error
    console.error(error);
    });
    }
    });
    });
    </script>
  --}}
@endsection
