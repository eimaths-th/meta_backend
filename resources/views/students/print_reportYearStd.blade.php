@extends('layouts.print_temp')

@section('style')
  <style>
    /* @media print {
                                                                                                                                                                            @page {
                                                                                                                                                                                size: landscape;
                                                                                                                                                                            }
                                                                                                                                                                        } */
  </style>
@endsection

@section('content')
  <div class="row">
    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif

    {{--
      <div class="app-page-title">
      <div class="page-title-wrapper">
      <div class="page-title-heading">
      <div class="page-title-icon">
      <i class="pe-7s-users icon-gradient bg-tempting-azure"></i>
      </div>
      <div>Students print
      <div class="page-title-subheading">META Knowledge Student Data</div>
      </div>
      </div>
      
      </div>
      </div>
    --}}
    {{-- <div class="main-card mb-3 card"> --}}
    {{-- <div class="card-body"> --}}
    <div class="row mb-3">
      <div class="col-lg-6">
        <div class="card-header-tab card-header-tab-animation card-header">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            All YEAR Report
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <canvas id="barChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card-header-tab card-header-tab-animation card-header">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            All YEAR Report
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
    <div class="row my-5">
      <div class="col-lg-6 mt-3">
        <div class="card-header-tab card-header-tab-animation card-header">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            All YEAR Report
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <canvas
              id="lineGroupChart"
              {{-- width="800" height="200" --}}
            ></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mt-3">
        <div class="card-header-tab card-header-tab-animation card-header">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            All YEAR Report
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content">
            {{-- <canvas id="lineGroup2Chart" width="800" height="200"></canvas> --}}
            <h4 class="mt-4">ค่าสมัครเรียนรายปีต่อกลุ่มรายวิชา</h4>
            <table
              style="width: 100%"
              id="Listvie"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action mt-4 table"
            >
              @php
                $uniqueYears = [];
                foreach ($totalForAllGroupYear as $groupTotals) {
                  foreach ($groupTotals as $year => $value) {
                    if (! in_array($year, $uniqueYears)) {
                      $uniqueYears[] = $year;
                    }
                  }
                }
                sort($uniqueYears);

                $sum = array_fill_keys($uniqueYears, 0);
                $col_count = 0;
              @endphp

              <thead>
                <tr>
                  <th>Group/Year</th>
                  @foreach ($uniqueYears as $year)
                    <th>{{ $year }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach ($totalForAllGroupYear as $group => $value)
                  <tr>
                    <td>
                      @php
                        $text_g = '';
                        if ($group === 'M') {
                          $text_g = 'Math';
                        } elseif ($group === 'E') {
                          $text_g = 'English';
                        } elseif ($group === 'CHN') {
                          $text_g = 'Chinese';
                        } elseif ($group === 'Sci') {
                          $text_g = 'Science';
                        } else {
                          $text_g = 'null_group';
                        }
                      @endphp

                      {{ $text_g }}
                    </td>

                    @foreach ($uniqueYears as $year)
                      @php
                        $sum[$year] += $value[$year] ?? 0;
                      @endphp

                      <td>{{ number_format($value[$year] ?? 0, 0) }}</td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>Total</th>
                  @foreach ($uniqueYears as $year)
                    <th>{{ number_format($sum[$year], 0) }}</th>
                  @endforeach
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
    {{-- </div> --}}

    {{-- </div> --}}

    <table
      style="width: 100%"
      id="Listview"
      class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action my-5 table"
    >
      <thead>
        <tr>
          <th class="text-center text-black" colspan="8">
            ตารางค่าสมัครเรียนปี {{ $year }}
          </th>
          <!-- Merged cell -->
        </tr>
        <tr>
          <th width="1%" class="text-center">no.</th>
          <th width="1%">Code</th>
          <th>Student Nickname</th>
          <th>Submission Date</th>
          <th>Period</th>
          <th>Reciept Number</th>
          <th>Group</th>
          {{-- <th>Stutus</th> --}}
          {{-- <th>Tpye</th> --}}
          <th>total</th>
        </tr>
      </thead>

      @php
        use App\Models\Statuslog;

        $sum = 0;
        $sum1 = 0;
      @endphp

      @foreach ($reportYear_schoolPrice as $keyG => $group)
        <tbody>
          @php
            $subg = 0;
          @endphp

          @foreach ($group as $key => $data)
            @php
              $class = '';

              $cMonth = date('m');
              $cYear = date('Y');
              $status = Statuslog::where('student_id', optional($data->std)->id)
                ->where('group', $data->group)
                ->whereMonth('status_date', $cMonth)
                ->whereYear('status_date', $cYear)
                ->get();

              // $status = '';

              if ($status->isNotEmpty() && $status->last()->status) {
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
                $statusValue = $status->last()->status;
              } else {
                $class = 'text-muted'; // You can set a default class for null or empty status
                $statusValue = 'Null';
              }
              $class = 'text-dark';
              // dd($checkStatus);
            @endphp

            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td class="text-center">{{ $data->std->code ?? 'Null' }}</td>
              <td class="{{ $class }}">
                {{ $data->std->nick_name ?? 'Null' }}
              </td>
              <td>{{ $data->rec_school->submission_date }}</td>
              <td>{{ $data->period }}</td>
              <td>{{ $data->rec_school->receipt_number }}</td>
              <td>{{ $data->group }}</td>
              <td class="text-end">{{ number_format($data->total) }} บาท</td>

              {{--
                <td class="{{ $class }}">
                {{ $statusValue }}
                </td>
              --}}
              {{-- <td>{{ $data->course_type }}</td> --}}
              {{-- <td class="text-end">{{ number_format($data->total) }} บาท</td> --}}
              {{-- <td class="text-end"><input type="checkbox" id="switchery-default" checked /></td> --}}
              {{--
                <td class="text-center">
                <input type="checkbox" class="switchery-small" id="switchery-default-{{ $loop->index }}" checked />
                <div class="form-check form-switch form-switch-sm">
                <input class="form-check-input" type="checkbox"
                id="flexSwitchCheckChecked-{{ $data->rec_school->receipt_number }}">
                </div>
                </td>
              --}}
            </tr>
            @php
              $sum += $data->total;
              $subg += $data->total;
            @endphp
          @endforeach
        </tbody>
        <tbody>
          <tr>
            <td class="text-center">#</td>
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
            <td class="text-center" colspan="6">Sum {{ $keyG }}</td>
            <!-- Merged cell -->
            <td class="text-end">{{ number_format($subg) }} บาท</td>
          </tr>
        </tbody>
      @endforeach

      <tbody>
        <tr>
          <td class="text-center">#</td>
          <td class="text-center text-black" colspan="6">Sum Total</td>
          <!-- Merged cell -->
          <td class="text-end">{{ number_format($sum) }} บาท</td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection

@section('script')
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
    var groupLabels = [
        @foreach ($totalForAllMonths as $month => $total)

            '{{ $month }} ',
        @endforeach
    ];

    var groupLabels2 = [
        @foreach ($totalForAllMonths as $month => $total)
            @if (isset($percentageChangeForAllMonths[$month]))
                @if ($percentageChangeForAllMonths[$month] > 0)
                    'ปี {{ $month }} :{{ number_format($total, 2) }}  \n+{{ $percentageChangeForAllMonths[$month] }}%',
                @else
                    'ปี {{ $month }} : {{ number_format($total, 2) }} \n {{ $percentageChangeForAllMonths[$month] }}%',
                @endif
            @else
                'ปี {{ $month }} : {{ number_format($total, 2) }}',
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
    //
  </script>
  {{-- // line-grafh --}}

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
                    'ปี {{ $month }} :{{ number_format($total, 2) }}  \n+{{ $percentageChangeForAllMonths[$month] }}%',
                @else
                    'ปี {{ $month }} : {{ number_format($total, 2) }} \n {{ $percentageChangeForAllMonths[$month] }}%',
                @endif
            @else
                'ปี {{ $month }} : {{ number_format($total, 2) }}',
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
  {{-- //bar-grafh --}}

  <script>
    var groupLabels = [
        @php
            $uniqueYears = [];
            foreach ($totalForAllGroupYear as $groupTotals) {
                foreach ($groupTotals as $year => $value) {
                    if (!in_array($year, $uniqueYears)) {
                        $uniqueYears[] = $year;
                    }
                }
            }
            sort($uniqueYears);
            echo "'" . implode("', '", $uniqueYears) . "'";
        @endphp
    ];
    // console.log(groupLabels);
    var data = [
        @foreach ($totalForAllGroupYear as $group => $groupTotals)
            @php
                $text_g = '';
                if ($group === 'M') {
                    $text_g = 'Math';
                } elseif ($group === 'E') {
                    $text_g = 'English';
                } elseif ($group === 'CHN') {
                    $text_g = 'Chinese';
                } elseif ($group === 'Sci') {
                    $text_g = 'Science';
                } else {
                    $text_g = 'null_group';
                }
            @endphp
             {
                label: '{{ $text_g }}',
                data: [
                    @foreach ($uniqueYears as $year)
                        {{ isset($groupTotals[$year]) ? $groupTotals[$year] : 0 }},
                    @endforeach

                ]
            },
        @endforeach
    ];

    var ctx = document.getElementById('lineGroupChart').getContext('2d');
    var colors = [
        'rgba(245, 156, 26,.65)',
        'rgba(0, 172, 172,.65)',
        'rgba(52, 143, 226,.65)',
        'rgba(135, 83, 217,.65)',
        // more colors
        'rgba(255, 91, 87,.65)',
        'rgba(114, 124, 182,.65)',
        'rgba(50, 169, 50,.65)',
        'rgba(144, 202, 75,.65)',
        'rgba(73, 182, 214,.65)',
        'rgba(108, 117, 125,.65)',
        'rgba(251, 85, 151,.65)',

    ];
    var lineChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: groupLabels,

            datasets: data.map(function(item, index) {

                return {
                    label: item.label,
                    data: item.data,
                    pointBackgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length],
                    pointRadius: 4,
                    borderWidth: 2,
                    // fill: false
                };
            })
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

  <script>
    var groupLabels = [
        @php
            $uniqueYears = [];
            foreach ($totalForAllGroupYear as $groupTotals) {
                foreach ($groupTotals as $year => $value) {
                    if (!in_array($year, $uniqueYears)) {
                        $uniqueYears[] = $year;
                    }
                }
            }
            sort($uniqueYears);
            echo "'" . implode("', '", $uniqueYears) . "'";
        @endphp
    ];
    // console.log(groupLabels);
    var data = [
        @foreach ($totalForAllGroupYear as $group => $groupTotals)
            {
                label: '{{ $group }}',
                data: [
                    @foreach ($uniqueYears as $year)
                        {{ isset($groupTotals[$year]) ? $groupTotals[$year] : 0 }},
                    @endforeach

                ]
            },
        @endforeach
    ];

    var ctx = document.getElementById('lineGroup2Chart').getContext('2d');
    var colors = [
        'rgba(245, 156, 26,.65)',
        'rgba(0, 172, 172,.65)',
        'rgba(52, 143, 226,.65)',
        'rgba(135, 83, 217,.65)',
        // more colors
        'rgba(255, 91, 87,.65)',
        'rgba(114, 124, 182,.65)',
        'rgba(50, 169, 50,.65)',
        'rgba(144, 202, 75,.65)',
        'rgba(73, 182, 214,.65)',
        'rgba(108, 117, 125,.65)',
        'rgba(251, 85, 151,.65)',

    ];
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: groupLabels,

            datasets: data.map(function(item, index) {

                return {
                    label: item.label,
                    data: item.data,
                    pointBackgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length],
                    pointRadius: 4,
                    borderWidth: 2,
                    // fill: false
                };
            })
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
  {{--
    <script>
    function printrep() {
    window.print();
    }
    printrep();
    setTimeout(function() {
    window.close();
    }, 4000);
    </script>
  --}}
@endsection
