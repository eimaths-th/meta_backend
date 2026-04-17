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

    /* .switchery {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                width: 30px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                height: 16px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            .switchery-small {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                width: 12px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                height: 12px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } */
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
            Students
            <div class="page-title-subheading">META Knowledge Student Data</div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="main-card mb-3 card"> --}}
    {{-- <div class="card-body"> --}}
    <div class="row mb-3">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
              <i
                class="header-icon lnr-apartment icon-gradient bg-love-kiss"
              ></i>
              All Month Report
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              {{--  --}}
              <canvas id="barChart" {{-- width="800" height="200" --}}></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
              <i
                class="header-icon lnr-apartment icon-gradient bg-love-kiss"
              ></i>
              All Month Report
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <canvas
                id="lineChart"
                {{-- width="800" height="200" --}}
              ></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- </div> --}}

    {{-- </div> --}}

    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
        <form action="{{ route('reportRecieptStdSearch') }}" method="GET">
          @csrf
          <div class="row mb-5">
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
                      $currentYear = date('Y') + 1;
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

        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="#default-tab-1" data-bs-toggle="tab" class="nav-link">
              {{-- <span class="d-sm-none">Tab 1</span> --}}
              <span class="d-sm-block d-none">ตรวจสอบรายเดือน</span>
            </a>
          </li>
          <li class="nav-item">
            <a
              href="#default-tab-2"
              data-bs-toggle="tab"
              class="nav-link active"
            >
              {{-- <span class="d-sm-none">Tab 1</span> --}}
              <span class="d-sm-block d-none">ตรวจสอบรายปี</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link">
              {{-- <span class="d-sm-none">Tab 2</span> --}}
              <span class="d-sm-block d-none">บันทึกใบปะหน้า</span>
            </a>
          </li>
        </ul>
        <div class="tab-content panel rounded-0 m-0 p-3">
          <!-- BEGIN tab-pane -->
          <div class="tab-pane fade" id="default-tab-1">
            <h3 class="mt-10px">
              <i class="fa fa-cog"></i>
              ตารางค่าสมัครเรียนเดือน {{ thaidate('F', $month) }} {{ $year }} (ยังไม่เสร้จ)
            </h3>
            <table
              style="width: 100%"
              id="Listview"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action table"
            >
              <thead>
                <tr>
                  <th width="1%" class="text-center">no.</th>
                  <th width="1%">Code</th>
                  <th>Student Nickname</th>
                  <th>Submission Date</th>

                  <th>Period</th>
                  <th>Reciept Number</th>

                  <th>Group</th>
                  <th>Stutus</th>
                  <th>Tpye</th>
                  <th>total</th>
                  <th>Check</th>
                </tr>
              </thead>

              <tbody>
                @php
                  use App\Models\Statuslog;

                  $sum = 0;
                  $sum1 = 0;
                @endphp

                @foreach ($reportMonth_schoolPrice as $studentId => $groupedData)
                  @foreach ($groupedData as $key => $data)
                    @php
                      $class = '';

                      $cMonth = date('m');
                      $cYear = date('Y');
                      $status = Statuslog::where('student_id', $data->std->id)
                        ->where('group', $data->group)
                        ->whereMonth('status_date', $cMonth)
                        ->whereYear('status_date', $cYear)
                        ->get();

                      if ($status->last()->status === 'None Receipt') {
                        $class = 'text-info';
                      } elseif ($status->last()->status === 'drop') {
                        $class = 'text-black';
                      } elseif ($status->last()->status === 'waitting . . .') {
                        $class = 'text-primary';
                      } elseif ($status->last()->status === 'Termination of study') {
                        $class = 'text-warning';
                      } elseif ($status->last()->status === 'New Student') {
                        $class = 'text-red';
                      } else {
                        $class = 'text-blue';
                      }
                    @endphp
                    <tr>
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="text-center">
                        {{
                          $data->std->code ??
                            'Null'
                        }}
                      </td>
                      <td class="{{ $class }}">
                        {{
                          $data->std->nick_name ??
                            'Null'
                        }}
                      </td>
                      <td>
                        {{
                          $data->rec_school
                            ->submission_date
                        }}
                      </td>
                      <td>{{ $data->period }}</td>

                      <td>
                        {{
                          $data->rec_school
                            ->receipt_number
                        }}
                      </td>

                      <td>{{ $data->group }}</td>

                      <td class="{{ $class }}">
                        {{-- @if ($data->std->status_log && $data->std->status_log->count() > 0 && $status->last()->group == $data->group) --}}
                        @if (
                          $data->std &&
                          $data->std->status_log &&
                          $data->std->status_log->count() > 0 &&
                          $status->last() &&
                          $status->last()->group == $data->group
                        )
                          {{
                            $status->last()->status ??
                              'Null'
                          }}
                        @else
                          null
                        @endif
                      </td>
                      <td>{{ $data->course_type }}</td>
                      {{-- <td class="text-end">{{ number_format($data->total) }} บาท</td> --}}
                      <td class="text-end">
                        {{ number_format($data->total) }} บาท
                      </td>
                      {{-- <td class="text-end"><input type="checkbox" id="switchery-default" checked /></td> --}}
                      <td class="text-center">
                        {{-- <input type="checkbox" class="switchery-small" id="switchery-default-{{ $loop->index }}" checked /> --}}
                        <div class="form-check form-switch form-switch-sm">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            id="flexSwitchCheckChecked-{{ $data->rec_school->receipt_number }}"
                          />
                        </div>
                      </td>
                    </tr>
                    @php
                      $sum += $data->total;
                    @endphp
                  @endforeach
                @endforeach
              </tbody>
              <tbody>
                <tr>
                  <td class="text-center">#</td>
                  {{-- <td class="text-center" colspan="2"></td> <!-- Merged cell --> --}}
                  <td class="text-center" hidden></td>
                  <!-- Merged cell -->
                  <td class="text-center" hidden></td>
                  <!-- Merged cell -->
                  <td class="text-center" hidden></td>
                  <!-- Merged cell -->
                  <td class="text-center" hidden></td>
                  <!-- Merged cell -->
                  <td class="text-center" hidden></td>
                  <!-- Merged cell -->
                  <td class="text-center" hidden></td>
                  <!-- Merged cell -->
                  <td class="text-center" colspan="8">Sum Total</td>
                  <!-- Merged cell -->
                  <td class="text-end">{{ number_format($sum) }} บาท</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade active show" id="default-tab-2">
            <h3 class="mt-10px">
              <i class="fa fa-cog"></i>
              ตารางค่าสมัครเรียนปี {{ $year }} (ยังไม่เสร้จ)
            </h3>
            <table
              style="width: 100%"
              id="Listview3"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action my-5 table"
            >
              <thead>
                <tr>
                  <th width="1%" class="text-center" data-orderable="false">
                    Code
                  </th>
                  <th data-orderable="false">Name</th>
                  <th data-orderable="false">Firs Date</th>
                  <th data-orderable="false">Last Date</th>
                  <th data-orderable="false">Firs period</th>
                  <th data-orderable="false">Last period</th>
                  @php
                    $currentMonth = date('m');
                    // $currentYear = date('Y');
                  @endphp

                  @for ($i = 1; $i <= 12; $i++)
                    <th data-orderable="false">
                      {{
                        date(
                          'm',
                          mktime(0, 0, 0, $i, 1, $currentYear),
                        )
                      }}-{{ $year }}
                    </th>
                  @endfor

                  <th data-orderable="false" width="1%">view</th>
                </tr>
              </thead>

              <tbody>
                @php
                  use Carbon\Carbon;
                @endphp

                @foreach ($reportYear_schoolPrice as $studentId => $groupedData)
                  <tr>
                    <td class="text-center">
                      {{
                        $groupedData->first()->std->code ??
                          'Null'
                      }}
                    </td>
                    <td>
                      {{
                        $groupedData->first()->std->nick_name ??
                          'Null'
                      }}
                    </td>
                    <td>
                      {{
                        $groupedData->first()->rec_school
                          ->submission_date
                      }}
                    </td>
                    <td>
                      {{
                        $groupedData->last()->rec_school
                          ->submission_date
                      }}
                    </td>
                    <td>
                      {{
                        $groupedData->first()
                          ->period
                      }}
                    </td>
                    <td>
                      {{
                        $groupedData->last()
                          ->period
                      }}
                    </td>
                    @for ($month = 1; $month <= 12; $month++)
                      <td>
                        @php
                          $currentYear = $year;
                          //เซตวันที่
                          $currentMY = Carbon::parse("$currentYear-$month")->format('Y-m');

                          $mark = [];
                          $groupClass = 'text-red';

                          foreach ($groupedData as $data1) {
                            $period = explode(' - ', $data1->period);

                            if (count($period) == 1) {
                              $periods = explode('-', $data1->period);

                              $startMonth = Carbon::parse("$periods[0]-$periods[1]")->format('Y-m');
                              $endMonth =
                                count($periods) > 2
                                  ? Carbon::parse("$periods[2]-$periods[3]")->format('Y-m')
                                  : $startMonth;
                            } else {
                              $startMonth = Carbon::parse($period[0])->format('Y-m');
                              $endMonth = Carbon::parse($period[1])->format('Y-m');
                              // dd($currentMY, $period, $startMonth, $endMonth);
                            }
                            $isInMonthRange = $currentMY >= $startMonth && $currentMY <= $endMonth;

                            if ($isInMonthRange) {
                              $groupMark =
                                $data1->group === 'CHN'
                                  ? 'C'
                                  : ($data1->group === 'Sci'
                                    ? 'S'
                                    : $data1->group);
                              $groupClass = 'text-success';

                              if (!in_array($groupMark, $mark)) {
                                $mark[] = $groupMark;
                              }
                            }
                          }
                        @endphp

                        <span class="marked-cell {{ $groupClass }}">
                          @foreach ($mark as $markItem)
                            {{ $markItem }}
                          @endforeach
                        </span>
                      </td>
                    @endfor

                    <td>
                      <a
                        href="javascript:;"
                        class="btn btn-xs btn-primary"
                        onclick="
                          formModal(
                            '{{ route('reportRecieptStdShow', ['id' => $studentId]) }}'
                          )
                        "
                        data-bs-toggle="tooltip"
                        data-bs-trigger="hover"
                        data-bs-container="body"
                        data-bs-title="View Detail"
                      >
                        <i class="fa fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="default-tab-3">
            <blockquote class="blockquote">
              <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">
                  ตารางแสดงผลบันทึกใบปะหน้าประจำเดือน {{ thaidate('F', date('F')) }} {{ date('Y') }}
                </p>
              </div>
            </blockquote>
            <table
              style="width: 100%"
              id="Listview2"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action my-5 table"
            >
              <thead>
                <tr>
                  <th width="1%" class="text-center">#</th>
                  <th width="1%" class="text-center">NO.</th>
                  <th>Submission Date</th>
                  <th>Student Nickname</th>
                  <th>Reciept Number</th>

                  <th>Period</th>
                  <th>Group</th>
                  <th>total</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($paper as $key => $paper_rep)
                  <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $paper_rep->no }}</td>
                    <td>{{ $paper_rep->submission_date }}</td>
                    <td>
                      {{
                        $paper_rep->student
                          ->nick_name
                      }}
                    </td>
                    <td>{{ $paper_rep->receipt_number }}</td>
                    <td>
                      {{
                        $paper_rep->school_price->period ??
                          null
                      }}
                    </td>
                    <td>
                      {{
                        $paper_rep->school_price->group ??
                          null
                      }}
                    </td>
                    <td class="text-end">
                      {{
                        number_format(
                          $paper_rep->school_price->total,
                        ) ?? null
                      }} บาท
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
    {{-- <script>
    var checkboxes = document.querySelectorAll('input[id^="switchery-default-"]');
    checkboxes.forEach(function(checkbox) {
    var switchery = new Switchery(checkbox, {
    color: '#00acac'
    });
    });
    </script>
  --}}
  <script>
    $(document).ready(function () {
      var selectMonth1 = document.getElementById('selectMonth1');

      if (selectMonth1) {
        selectMonth1.disabled = true;
      }
      var table1 = $('#Listview').DataTable({
        lengthMenu: [-1]
      });

      var table2 = $('#Listview2').DataTable({
        lengthMenu: [-1]
      });
      var table3 = $('#Listview3').DataTable({
        lengthMenu: [-1]
      });

      $('input[type="checkbox"]').change(function () {
        var isChecked = $(this).is(':checked');
        if (isChecked) {
          $(this).closest('tr').addClass('bg-success');
          var id = $(this).attr('id');
          localStorage.setItem(id, 'checked');
        } else {
          $(this).closest('tr').removeClass('bg-success');
          var id = $(this).attr('id');
          localStorage.setItem(id, 'unchecked');
        }
      });
      $(document).ready(function () {
        $('input[type="checkbox"]').each(function () {
          var id = $(this).attr('id');
          var state = localStorage.getItem(id);
          if (state === 'checked') {
            $(this).prop('checked', true);
            $(this).closest('tr').addClass('bg-success');
          }
        });
      });
    });

    // document.addEventListener('DOMContentLoaded', function() {
    //     var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    //     checkboxes.forEach(function(checkbox) {
    //         checkbox.addEventListener('change', function() {
    //             var isChecked = this.checked;
    //             if (isChecked) {
    //                 this.closest('tr').style.backgroundColor = 'green';
    //             } else {
    //                 this.closest('tr').style.backgroundColor = '';
    //             }
    //         });
    //     });
    // });

    $(document).ready(function () {});
  </script>
  <script>
    var groupLabels = [
      @foreach ($totalForAllMonths as $month => $total)

      '{{ $month }} '
      @endforeach
    ];

    var groupLabels2 = [
      @foreach ($totalForAllMonths as $month => $total)
      @if (isset($percentageChangeForAllMonths[$month]))
      @if ($percentageChangeForAllMonths[$month] > 0)
      '{{ $month }}\n+{{
      $percentageChangeForAllMonths[
        $month
      ]
    }}%',
      @else
      '{{ $month }}\n{{
      $percentageChangeForAllMonths[
        $month
      ]
    }}%',
      @endif
      @else
      '{{ $month }}  '
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
        datasets: [
          {
            label: 'ยอดรวมแต่ละเดือน ',
            data: [
              @foreach ($totalForAllMonths as $month => $total)
              {{ $total }}
              @endforeach
            ],
            pointBackgroundColor: 'rgba(52, 143, 226,.65)',
            borderColor: 'rgba(52, 143, 226,.65)',
            backgroundColor: 'rgba(52, 143, 226,.65)',
            pointRadius: 4,
            borderWidth: 2
          }
        ]
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
            intersect: false // Don't intersect with other elements
          },
          // title: {
          //     display: true,
          //     text: 'Chart Title',
          // },
          legend: {
            display: true,
            position: 'top'
          }
        },
        animation: {
          duration: 2000, // Animation duration in milliseconds
          easing: 'easeInOutQuad' // Easing function
        }
      }
    });
  </script>
  <script>
    var groupLabels = [
      @foreach ($totalForAllMonths as $month => $total)
      '{{ $month }}'
      @endforeach
    ];
    var groupLabels2 = [
      @foreach ($totalForAllMonths as $month => $total)
      @if (isset($percentageChangeForAllMonths[$month]))
      @if ($percentageChangeForAllMonths[$month] > 0)
      '{{ $month }}\n+{{
      $percentageChangeForAllMonths[
        $month
      ]
    }}%',
      @else
      '{{ $month }}\n{{
      $percentageChangeForAllMonths[
        $month
      ]
    }}%',
      @endif
      @else
      '{{ $month }}  '
      @endif
      @endforeach
    ];

    var data = {
      labels: groupLabels2,
      datasets: [
        {
          label: 'ยอดรวมแต่ละเดือน ',
          data: [
            @foreach ($totalForAllMonths as $month => $total)
            {{ $total }}
            @endforeach
          ],
          pointBackgroundColor: 'rgba(52, 143, 226,.65)',
          borderColor: 'rgba(52, 143, 226,.65)',
          backgroundColor: 'rgba(52, 143, 226,.65)',
          pointRadius: 4,
          borderWidth: 2
        }
      ]
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
            intersect: false // Don't intersect with other elements
          },
          // title: {
          //     display: true,
          //     text: 'Chart Title',
          // },
          legend: {
            display: true,
            position: 'top'
          }
        },
        animation: {
          duration: 2000, // Animation duration in milliseconds
          easing: 'easeInOutQuad' // Easing function
        }
      }
    });
  </script>
@endsection

{{--
  @php
  $mark = [];
  $countdata = 0;
  $ignorId = [];
  $groupClass = 'text-red';
  
  foreach ($groupedData as $data1) {
  $period = explode(' - ', $data1->period);
  if (count($period) == 1) {
  $periods = explode('-', $data1->period);
  $startMonth = date('m', strtotime("{$periods[0]}-{$periods[1]}"));
  $endMonth = count($periods) > 2 ? date('m', strtotime("{$periods[2]}-{$periods[3]}")) : $startMonth;
  } else {
  $startMonth = date('n', strtotime($period[0]));
  $endMonth = date('n', strtotime($period[1]));
  }
  $isInMonthRange = $month >= $startMonth && $month <= $endMonth;
  
  if ($isInMonthRange === true) {
  if ($data1->group === 'CHN') {
  $groupMark = 'C';
  } elseif ($data1->group === 'Sci') {
  $groupMark = 'S';
  } else {
  $groupMark = $data1->group;
  }
  $groupClass = 'text-success';
  } else {
  $groupMark = '';
  }
  if (!in_array($groupMark, $mark)) {
  $mark[] = $groupMark;
  }
  } //endforeach
  @endphp
--}}
{{--
  @php
  $mark = [];
  $countdata = 0;
  $ignorId = [];
  $groupClass = 'text-red';
  
  foreach ($groupedData as $data1) {
  $period = explode(' - ', $data1->period);
  $currentYear = date('Y');
  if (count($period) == 1) {
  $periods = explode('-', $data1->period);
  
  $startMonth = date('m', strtotime("{$periods[0]}-{$periods[1]}"));
  $endMonth = count($periods) > 2 ? date('m', strtotime("{$periods[2]}-{$periods[3]}")) : $startMonth;
  $startYear = $periods[0];
  $endYear = $periods[2];
  // dd($periods, $endMonth, $startMonth, $startYear, $endYear);
  } else {
  $periodss = explode('-', $data1->period);
  $startYear = $periods[0];
  $endYear = $periods[2];
  $startMonth = date('m', strtotime("{$periodss[0]}-{$periodss[1]}"));
  $endMonth = date('m', strtotime("{$periodss[2]}-{$periodss[3]}"));
  // dd(
  //     $periodss,
  //     $startMonth,
  //     $endMonth,
  //     // $currentYear
  //     // $startYear,
  //     // $endYear
  // );
  }
  $isInMonthRange = $month >= $startMonth && $startMonth == $currentYear && $month <= $endMonth && $endYear >= $currentYear;
  if ($isInMonthRange === true) {
  if ($data1->group === 'CHN') {
  $groupMark = 'C';
  } elseif ($data1->group === 'Sci') {
  $groupMark = 'S';
  } else {
  $groupMark = $data1->group;
  }
  $groupClass = 'text-success';
  } else {
  $groupMark = '';
  }
  if (!in_array($groupMark, $mark)) {
  $mark[] = $groupMark;
  }
  } //endforeach
  @endphp
  
  @php
  $mark = [];
  $countdata = 0;
  $ignorId = [];
  $groupClass = 'text-red';
  
  foreach ($groupedData as $data1) {
  $period = explode(' - ', $data1->period);
  $currentYear = date('Y');
  if (count($period) == 1) {
  $periods = explode('-', $data1->period);
  
  $startMonth = date('m', strtotime("{$periods[0]}-{$periods[1]}"));
  $startYear = $periods[0];
  $endMonth = count($periods) > 2 ? date('m', strtotime("{$periods[2]}-{$periods[3]}")) : $startMonth;
  $endYear = count($periods) > 2 ? date('Y', strtotime("{$periods[2]}-{$periods[3]}")) : $startYear;
  } else {
  $periodss = explode('-', $data1->period);
  $startYear = $periodss[0];
  $endYear = $periodss[2];
  $startMonth = date('m', strtotime("{$periodss[0]}-{$periodss[1]}"));
  $endMonth = date('m', strtotime("{$periodss[2]}-{$periodss[3]}"));
  }
  
  $isInMonthRange = $currentYear == $startYear && $currentYear == $endYear && $month >= $startMonth && $month <= $endMonth;
  
  if ($isInMonthRange) {
  if ($data1->group === 'CHN') {
  $groupMark = 'C';
  } elseif ($data1->group === 'Sci') {
  $groupMark = 'S';
  } else {
  $groupMark = $data1->group;
  }
  
  $groupClass = 'text-success';
  
  if (!in_array($groupMark, $mark)) {
  $mark[] = $groupMark;
  }
  }
  }
  @endphp
  @php
  // use Carbon\Carbon;
  
  $mark = [];
  $countdata = 0;
  $ignorId = [];
  $groupClass = 'text-red';
  
  foreach ($groupedData as $data1) {
  $period = explode(' - ', $data1->period);
  $currentYear = date('Y');
  
  if (count($period) == 1) {
  $periods = explode('-', $data1->period);
  
  $startMonth = Carbon::parse("{$periods[0]}-{$periods[1]}")->month;
  $startYear = $periods[0];
  $endMonth = count($periods) > 2 ? Carbon::parse("{$periods[2]}-{$periods[3]}")->month : $startMonth;
  $endYear = count($periods) > 2 ? $periods[2] : $startYear;
  } else {
  $periodss = explode('-', $data1->period);
  $startYear = $periodss[0];
  $endYear = $periodss[2];
  $startMonth = Carbon::parse("{$periodss[0]}-{$periodss[1]}")->month;
  $endMonth = Carbon::parse("{$periodss[2]}-{$periodss[3]}")->month;
  }
  dd($startMonth);
  
  $isInMonthRange = Carbon::now()->year >= $startYear && Carbon::now()->year <= $endYear && Carbon::now()->month >= $startMonth && Carbon::now()->month <= $endMonth;
  
  if ($isInMonthRange) {
  if ($data1->group === 'CHN') {
  $groupMark = 'C';
  } elseif ($data1->group === 'Sci') {
  $groupMark = 'S';
  } else {
  $groupMark = $data1->group;
  }
  
  $groupClass = 'text-success';
  
  if (!in_array($groupMark, $mark)) {
  $mark[] = $groupMark;
  }
  }
  }
  @endphp
--}}
