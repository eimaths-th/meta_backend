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
            <a
              href="#"
              onclick="export_report()"
              class="btn btn-success"
              data-bs-toggle="tooltip"
              data-bs-trigger="hover"
              data-bs-container="body"
              data-bs-title="print"
            >
              <i class="fa fa-print"></i>
              print
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
      </div>
      {{-- @if (auth()->user()->id == 16) --}}
      <div id="calendar2">
        <div class="card-header-tab card-header-tab-animation card-header mb-3">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            Work record of {{ $name }}
          </div>
        </div>

        <div class="col-lg">
          <div class="card-body mb-5 pt-0 pb-0">
            <div id="calendar" class="calendar" style="max-height: 600px"></div>
          </div>
        </div>
      </div>
      {{-- @endif --}}

      <div class="card-body">
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
                <td>INF{{ $rec_time->user->code }}</td>

                <td>
                  {{
                    $rec_time->user
                      ->name
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/multimonth@6.1.11/index.global.min.js"></script>
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
  function export_report() {
    url = '{{ route('search_rect', ['type' => 'print', 'user_id' => $user_id, 'month' => $month, 'year' => $year]) }}';

    window.open(url.replace(/&amp;/g, '&'));
  }
</script>

<script>
      document.addEventListener('DOMContentLoaded', function() {
          console.log('hello world !!');

          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              initialDate: '{{ $date }}',
              headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth'
              },
              events: [

                  @php
                      foreach ($rec_times_year2 as $rec_years) {
                          $class = '';
                          switch ($rec_years->status) {
                              case 1:
                                  $color = 'rgba(58, 196, 125, 0.8)';
                                  break;

                              case 2:
                              case 3:
                              case 4:
                              case 13:
                                  $color = 'rgba(247, 185, 36, 0.8)';

                                  break;

                              case 5:
                              case 6:
                              case 7:
                              case 8:
                              case 9:
                                  $color = 'rgba(255, 91, 87,0.8)';

                                  break;

                              case 11:
                              case 12:
                                  $color = 'rgba(63, 106, 216, 0.8)';
                                  break;

                              case 10:
                                  $color = 'rgba(52, 58, 64, 0.8)';

                                  break;

                              default:
                                  break;
                          }
                          $text_late = '';
                          if ($rec_years->late_time) {
                              $text_late = ' : ' . $rec_years->late_time . ' นาที';
                          }

                          echo '{';
                          echo "title: '{$rec_years->status_name} {$text_late}',";
                          echo "start: '{$rec_years->date}',";
                          echo "color: '{$color}'";
                          echo '},';
                      }
                  @endphp

                  // {
                  //     title: 'สาย : 5 นาที',
                  //     start: '2024-03-10',
                  //     color: 'rgba(255, 91, 87,0.8)',
                  // },

              ]
          });
          calendar.render();

          document.getElementById('clearEventsButton').addEventListener('click', function() {
              console.log('Event listener triggered');
              clearAllEvents();
          });

          // Function to clear all events
          function clearAllEvents() {
              calendar.getEvents().forEach(function(event) {
                  event.remove();
              });

              // Clear the events array and re-render the calendar
              calendar.setOption('events', []);
              calendar.render();
          }

          // Render the calendar
          // calendar.render();
      });
    </script>
  @endsection

