@extends ('layouts.main_template')

@section ('style')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
  />
  <link href="../assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
  <link
    href="/assets/plugins/switchery/dist/switchery.min.css"
    rel="stylesheet"
  />
  <style>
    .screen-auto {
      max-width: 100%;
      height: auto;
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
            <i class="pe-7s-users icon-gradient bg-tempting-azure"></i>
          </div>
          <div>
            Report working time
            <div class="page-title-subheading">META Knowledge Student Data</div>
          </div>
        </div>
      </div>
    </div>

    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a
              href="#default-tab-1"
              data-bs-toggle="tab"
              class="nav-link active"
            >
              {{-- <span class="d-sm-none">Tab 1</span> --}}
              <span class="d-sm-block d-none">ตรวจสอบรายเดือน</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link">
              {{-- <span class="d-sm-none">Tab 1</span> --}}
              <span class="d-sm-block d-none">ตรวจสอบรายปี</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link">
              {{-- <span class="d-sm-none">Tab 1</span> --}}
              <span class="d-sm-block d-none">Late time</span>
            </a>
          </li>
        </ul>
        <div class="tab-content panel rounded-0 m-0 p-3">
          <!-- BEGIN tab-pane -->
          <div class="tab-pane fade active show" id="default-tab-1">
            <form action="{{ route('search_reportMonthTime') }}" method="GET">
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

                <div class="col-lg-2">
                  <div class="row">
                    <label for="month" class="col-lg-3">เดือน :</label>
                    <div class="col-lg-9">
                      <select name="month" id="selectMonth" class="form-select">
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
                      <select name="year" id="selectMonth" class="form-select">
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
                  <a
                    href="#"
                    onclick="export_report1()"
                    class="btn btn-success"
                  >
                    Print
                  </a>
                </div>
              </div>
            </form>

            <h3 class="">
              <i class="fa fa-cog"></i>
              ตารางการมาทำงาน {{
                date(
                  'F-Y',
                  strtotime("$year-$month"),
                )
              }}
            </h3>
            <table
              style="width: 100%"
              id="Listview"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action Listview my-4 table"
            >
              <thead>
                <tr>
                  <th width="1%" class="text-center">No.</th>
                  <th width="1%">Code</th>
                  <th>User</th>
                  @foreach ($stwork as $status)
                    <th>{{ $status->name }}</th>
                  @endforeach

                  <th>Late Time</th>
                </tr>
              </thead>

              <tbody>
                @php
                  $loops = 1;
                  $result = 0;
                @endphp

                @foreach ($rec_timess as $records)
                  <tr>
                    <td class="text-center">{{ (int) $loops }}</td>
                    <td class="text-center">
                      {{
                        $records->first()->user->code ??
                          'code'
                      }}
                    </td>
                    <td>
                      {{
                        $records->first()->user
                          ->name
                      }}
                    </td>

                    @foreach ($stwork as $status)
                      <td>
                        <a
                          href="{{ route('find_UserRecTime', ['user_id' => $records->first()->user->id, 'status' => $status->id, 'month' => $month, 'year' => $year]) }}"
                          class="text-dark"
                        >
                          @php
                            $statusName = $status->name;
                            $statusCount = $records->where('status_name', $status->name)->count();
                            $text = '';

                            // if ($status->name === 'ลากิจ') {
                            //     # code...
                            //     $remain = 3;
                            // } elseif ($status->name === 'ลาป่วย') {
                            //     # code...
                            //     $remain = 30;
                            // } elseif ($status->name === 'ลาพักร้อน') {
                            //     # code...
                            //     $remain = 6;
                            // }
                            // if ($status->name === 'ลากิจ' || $status->name === 'ลาป่วย' || $status->name === 'ลาพักร้อน') {
                            //     # code...
                            //     $text = 'remain : ' . $remain - $statusCount ?? '';
                            // }
                          @endphp

                          {{ $statusCount }}

                          {{-- {{ $text }} --}}
                        </a>
                      </td>
                    @endforeach

                    <td>
                      @php
                        $statuslate = $records->where('status', 5)->sum('late_time');
                        $result += $statuslate;
                        $loops++;
                      @endphp

                      {{ $statuslate ?? '0' }} นาที
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>#</td>
                  @php
                    $count_line = 0;
                  @endphp

                  @foreach ($stwork as $test)
                    @php
                      $count_line++;
                    @endphp
                  @endforeach

                  @php
                    $colspan = 2 + $count_line;
                  @endphp

                  <td colspan="{{ $colspan }}">รวม</td>

                  <td>{{ $result }} นาที</td>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="tab-pane fade" id="default-tab-2">
            <form action="{{ route('search_reportMonthTime') }}" method="GET">
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

                <div class="col-lg-2">
                  <div class="row">
                    <label for="year" class="col-lg-2">ปี :</label>
                    <div class="col-lg-9">
                      <select name="year" id="selectMonth" class="form-select">
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
                  <a
                    href="#"
                    onclick="export_report2()"
                    class="btn btn-success"
                  >
                    Print
                  </a>
                </div>
              </div>
            </form>

            <h3 class="">
              <i class="fa fa-cog"></i>
              ตารางการมาทำงานปี {{ $year }}
            </h3>
            <table
              id="Listview3"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action Listview3 my-4 table"
            >
              <thead>
                <tr id="tr2">
                  <th class="text-center" width="1%">No.</th>
                  <th class="text-center">Code</th>
                  <th>User</th>
                  @foreach ($stwork as $status)
                    <th>{{ $status->name }}</th>
                  @endforeach
                </tr>
              </thead>

              <tbody>
                @foreach ($rec_times_year as $user_id => $records)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                      {{
                        $records->first()->user->code ??
                          'code'
                      }}
                    </td>
                    <td>
                      <a
                        href="#"
                        onclick="
                          export_report_user(
                            '{{ $records->first()->user->id }}'
                          )
                        "
                        class="text-dark"
                      >
                        {{
                          $records->first()->user->name ??
                            'ไม่พบพนักงาน'
                        }}
                      </a>
                      {{-- {{ $records->first()->user->name ?? 'ไม่พบพนักงาน' }} --}}
                    </td>

                    @foreach ($stwork as $status)
                      <td>
                        <a
                          href="{{ route('find_UserRecTime', ['user_id' => $records->first()->user->id ?? '9999', 'status' => $status->id, 'month' => 'null', 'year' => $year]) }}"
                          class="text-dark"
                        >
                          @php
                            $statusName = $status->name;
                            $statusCount = $records->where('status_name', $status->name)->count();
                            $text = '';

                            if ($status->name === 'ลากิจ') {
                              # code...
                              $remain = 3;
                            } elseif ($status->name === 'ลาป่วย') {
                              # code...
                              $remain = 30;
                            } elseif ($status->name === 'ลาพักร้อน') {
                              # code...
                              $remain = 6;
                            }
                            if (
                              $status->name === 'ลากิจ' ||
                              $status->name === 'ลาป่วย' ||
                              $status->name === 'ลาพักร้อน'
                            ) {
                              # code...
                              $text = 'remain : ' . $remain - $statusCount ?? '';
                            }
                          @endphp

                          {{ $statusCount }}

                          {{ $text }}
                        </a>
                      </td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="tab-pane fade" id="default-tab-3">
            {{--
              <form action="{{ route('search_reportMonthTime') }}" method="GET">
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
              <div class="col-lg-2">
              <div class="row">
              <label for="year" class="col-lg-2">ปี : </label>
              <div class="col-lg-9">
              <select name="year" id="selectMonth" class="form-select">
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
            --}}

            <h3 class="">
              <i class="fa fa-cog"></i>
              รวม เวลามาสาย & ขาดงาน
              <a href="#" onclick="export_report3()" class="btn btn-success">
                Print
              </a>
            </h3>

            <table
              id="Listview4"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action Listview3 my-4 table"
            >
              <thead>
                <tr id="tr2">
                  <th class="text-center" width="1%">No.</th>
                  <th class="text-center">Date</th>
                  <th>Late All</th>
                  <th>Missing Work All</th>
                  <th>Updated At</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($overlates as $key => $overlate)
                  <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">
                      {{ $overlate->month ?? 'null' }}-{{ $overlate->year ?? 'null' }}
                    </td>
                    <td>
                      <a
                        href="{{ route('find_statusRecTime', ['status' => 5, 'month' => $overlate->month, 'year' => $overlate->year]) }}"
                        class="text-dark"
                      >
                        {{
                          $overlate->late_time_all ??
                            '0'
                        }} นาที
                      </a>
                    </td>
                    <td>
                      <a
                        href="{{ route('find_statusRecTime', ['status' => 13, 'month' => $overlate->month, 'year' => $overlate->year]) }}"
                        class="text-dark"
                      >
                        {{
                          $overlate->missing_work_all ??
                            '0'
                        }} วัน
                      </a>
                    </td>
                    <td>
                      {{
                        $overlate->updated_at ??
                          'null'
                      }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section ('script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  {{-- <script src="https://d3js.org/d3.v7.min.js"></script> --}}
  <script src="../assets/plugins/d3/d3.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  {{-- <script src="../assets/plugins/nvd3/build/nv.d3.min.js"></script> --}}
  {{-- <script src="../assets/plugins/chart.js/dist/Chart.min.js"></script> --}}
  <script src="../assets/plugins/flot/source/jquery.canvaswrapper.js"></script>
  <script src="../assets/plugins/flot/source/jquery.colorhelpers.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.saturated.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.browser.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.drawSeries.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.uiConstants.js"></script>
  <script src="/assets/plugins/switchery/dist/switchery.min.js"></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    type="text/javascript"
  ></script>
  <script
    src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"
    type="text/javascript"
  ></script>
  {{--
    <script>
    var checkboxes = document.querySelectorAll('input[id^="switchery-default-"]');
    checkboxes.forEach(function(checkbox) {
    var switchery = new Switchery(checkbox, {
    color: '#00acac'
    });
    });
    </script>
  --}}
  <script>
    function export_report1() {
      url = '{{ route('search_reportMonthTime', ['type' => 'print', 'tap' => '1', 'month' => $month, 'year' => $year]) }}';

      window.open(url.replace(/&amp;/g, '&'));
    }

    function export_report2() {
      url = '{{ route('search_reportMonthTime', ['type' => 'print', 'tap' => '2', 'year' => $year]) }}';

      window.open(url.replace(/&amp;/g, '&'));
    }

    function export_report3() {
      url = '{{ route('search_reportMonthTime', ['type' => 'print', 'tap' => '3']) }}';

      window.open(url.replace(/&amp;/g, '&'));
    }
    let baseUrl = '{{ route('search_reportMonthTime', ['type' => 'print', 'tap' => '4', 'year' => $year]) }}';

    function export_report_user(user_id) {
      let url = `${baseUrl}&user_id=${user_id}`;

      window.open(url.replace(/&amp;/g, '&'));
    }
    $(document).ready(function () {
      // var selectMonth1 = document.getElementById('selectMonth1');

      // if (selectMonth1) {
      //     selectMonth1.disabled = true;
      // }

      var table1 = $('.Listview').DataTable({
        lengthMenu: [-1]
      });
      $('#Listview3').DataTable({
        column: [
          {
            width: '1%'
          } // Set the width for the first column
          // ... other column configurations
        ],
        lengthMenu: [-1]
      });
      $('#Listview3 th').removeAttr('style');
      $('#Listview4').DataTable({
        column: [
          {
            width: '1%'
          } // Set the width for the first column
          // ... other column configurations
        ],
        lengthMenu: [-1]
      });
      $('#Listview4 th').removeAttr('style');
      // var table2 = $('#Listview2').DataTable({
      //     lengthMenu: [-1],
      // });

      // var table3 = $('#Listview3').DataTable({
      //     lengthMenu: [-1],
      // });

      // $('input[type="checkbox"]').change(function() {
      //     var isChecked = $(this).is(":checked");
      //     console.log(isChecked);
      //     if (isChecked) {
      //         $(this).closest('tr').addClass('bg-success');
      //         var id = $(this).attr('id');
      //         localStorage.setItem(id, 'checked');
      //     } else {
      //         $(this).closest('tr').removeClass('bg-success');
      //         var id = $(this).attr('id');
      //         localStorage.setItem(id, 'unchecked');
      //     }
      // });

      // $('input[type="checkbox"]').each(function() {

      //     var id = $(this).attr('id');
      //     var state = localStorage.getItem(id);
      //     // console.log(id);

      //     if (state === 'checked') {
      //         $(this).prop('checked', true);
      //         $(this).closest('tr').addClass('bg-success');
      //     }
      // });
    });
  </script>
  {{--
    <script>
    var checkboxes = document.querySelectorAll('input[id^="switchery-default-"]');
    checkboxes.forEach(function(checkbox) {
    var switchery = new Switchery(checkbox, {
    color: '#00acac'
    });
    });
    </script>
  --}}
  {{--
    <script>
    var groupLabels = [
    @foreach ($totalForAllMonths as $month => $total)
    
    '{{ $month }} ',
    @endforeach
    ];
    
    var groupLabels2 = [
    @foreach ($totalForAllMonths as $month => $total)
    @if (isset($percentageChangeForAllMonths[$month]))
    @if ($percentageChangeForAllMonths[$month] > 0)
    '{{ $month }}\n+{{ $percentageChangeForAllMonths[$month] }}%',
    @else
    '{{ $month }}\n{{ $percentageChangeForAllMonths[$month] }}%',
    @endif
    @else
    '{{ $month }}  ',
    @endif
    @endforeach
    ];
    
    // var data = {
    //     labels: groupLabels2,
    //     // label: groupLabels,
    //     datasets: [{
    //         label: 'ยอดรวมแต่ละเดือน ',
    //         data: [
    //             @foreach ($totalForAllMonths as $month => $total)
    //                 {{ $total }},
    //             @endforeach
    //         ],
    //         pointBackgroundColor: 'rgba(52, 143, 226,.65)',
    //         borderColor: 'rgba(52, 143, 226,.65)',
    //         backgroundColor: 'rgba(52, 143, 226,.65)',
    //         pointRadius: 4,
    //         borderWidth: 2,
    //     }, ]
    // };
    var ctx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: groupLabels2,
    // label: groupLabels,
    datasets: [{
    label: 'ยอดรวมแต่ละเดือน ',
    data: [
    @foreach ($totalForAllMonths as $month => $total)
    {{ $total }},
    @endforeach
    ],
    pointBackgroundColor: 'rgba(52, 143, 226,.65)',
    borderColor: 'rgba(52, 143, 226,.65)',
    backgroundColor: 'rgba(52, 143, 226,.65)',
    pointRadius: 4,
    borderWidth: 2,
    }, ]
    },
    options: {
    scales: {
    y: {
    beginAtZero: true
    }
    },
    plugins: {
    tooltip: {
    mode: 'index', // Display multiple tooltips at once
    intersect: false, // Don't intersect with other elements
    },
    // title: {
    //     display: true,
    //     text: 'Chart Title',
    // },
    legend: {
    display: true,
    position: 'top',
    },
    },
    animation: {
    duration: 2000, // Animation duration in milliseconds
    easing: 'easeInOutQuad', // Easing function
    },
    
    }
    });
    </script>
  --}}
  {{--
    <script>
    var groupLabels = [
    @foreach ($totalForAllMonths as $month => $total)
    '{{ $month }}',
    @endforeach
    ];
    var groupLabels2 = [
    @foreach ($totalForAllMonths as $month => $total)
    @if (isset($percentageChangeForAllMonths[$month]))
    @if ($percentageChangeForAllMonths[$month] > 0)
    '{{ $month }}\n+{{ $percentageChangeForAllMonths[$month] }}%',
    @else
    '{{ $month }}\n{{ $percentageChangeForAllMonths[$month] }}%',
    @endif
    @else
    '{{ $month }}  ',
    @endif
    @endforeach
    ];
    
    var data = {
    labels: groupLabels2,
    datasets: [{
    label: 'ยอดรวมแต่ละเดือน ',
    data: [
    @foreach ($totalForAllMonths as $month => $total)
    {{ $total }},
    @endforeach
    ],
    pointBackgroundColor: 'rgba(52, 143, 226,.65)',
    borderColor: 'rgba(52, 143, 226,.65)',
    backgroundColor: 'rgba(52, 143, 226,.65)',
    pointRadius: 4,
    borderWidth: 2,
    }]
    };
    var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
    scales: {
    y: {
    beginAtZero: true
    }
    },
    plugins: {
    tooltip: {
    mode: 'index', // Display multiple tooltips at once
    intersect: false, // Don't intersect with other elements
    },
    // title: {
    //     display: true,
    //     text: 'Chart Title',
    // },
    legend: {
    display: true,
    position: 'top',
    },
    },
    animation: {
    duration: 2000, // Animation duration in milliseconds
    easing: 'easeInOutQuad', // Easing function
    },
    }
    });
    </script>
  --}}
@endsection
