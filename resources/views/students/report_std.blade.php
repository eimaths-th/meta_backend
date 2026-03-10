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
            Students
            <div class="page-title-subheading">META Knowledge Student Data</div>
          </div>
        </div>

        {{--
          <a href="#" class="btn btn-primary btn-sm"
          onclick="formModal('{{ route('test_modal') }}')"
          data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body"
          data-bs-title="View OT Record">
          
          <i class="fa fa-eye fa-1x"></i></a>
        --}}
      </div>
    </div>

    <div class="main-card card mb-3" id="x_content">
      <div class="card-header-tab card-header-tab-animation card-header">
        <div class="card-header-title">
          <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
          Current Month Report
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('search_status') }}" method="GET">
          @csrf
          <div class="row mb-5">
            {{--
              <div class="col-lg-2">
              <div class="row">
              <label for="month" class="col-lg-3">status : </label>
              <div class="col-lg-9">
              <select name="month" id="selectMonth" class="form-select">
              <option value="">เลือกเดือน</option>
              @for ($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}"> {{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
              @endfor
              </select>
              </div>
              </div>
              </div>
            --}}
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
                    <option value="">เลือกปี</option>
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
              <button
                class="btn btn-primary"
                type="submit"
                id="seach_status"
                name="seach_status"
              >
                ค้นหา
              </button>
              {{-- <a href="{{ route('search_status') }}" class="btn btn-primary" id="seach_status" name="seach_status">ค้นหา</a> --}}
            </div>
          </div>
        </form>

        {{-- กราฟนี้ใช้ได้ --}}
        {{-- <div id="nv-line-chart" class="h-250px"></div> --}}
        <div class="row">
          <div class="col-lg-6">
            <canvas
              id="lineChart"
              class="screen-auto"
              {{-- width="800" height="200" --}}
            ></canvas>
          </div>
          <div class="col-lg-6">
            <canvas
              id="barChart"
              class="screen-auto"
              {{-- width="800" height="200" --}}
            ></canvas>
          </div>
        </div>
      </div>
    </div>

    {{-- <canvas id="bar-chart777"></canvas> --}}
    {{-- <canvas id="line-charttest" height="100px"></canvas> --}}
    {{-- <canvas id="line-charttest" width="600" height="150"></canvas> --}}
    <div class="main-card card mb-3" id="x_content">
      <div class="card-header-tab card-header-tab-animation card-header">
        <div class="card-header-title">
          <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
          RESULT STUDENT {{ $monthf }} - {{ $year }}
        </div>
      </div>
      <div class="card-body">
        <div class="col-lg-12 mb-3 text-end">
          <a href="#" onclick="export_report()" class="btn btn-success">
            Print
          </a>
        </div>
        <table
          style="width: 100%"
          id="Listview"
          class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action table"
        >
          <thead>
            <tr>
              <th>Group</th>
              <th class="text-success">New student</th>
              <th class="text-success">studying . . .</th>
              <th class="text-warning">Termination of study</th>
              <th class="text-danger">Drop</th>
              <th class="text-success">Resume</th>
              <th class="text-primary">Waitting . . .</th>
              <th class="text-info">Total</th>

              <th class="text-info">None Receipt</th>
              <th>date time</th>
            </tr>
          </thead>
          <tbody>
            @php
              $groupStatusCounts = [];
              foreach ($latestStatusCounts as $record) {
                $group = $record->group;
                $status = $record->status;
                $status_log_ids = 'ids';
                // $ids = [];

                if (!isset($groupStatusCounts[$group])) {
                  $groupStatusCounts[$group] = [];
                }
                if (!isset($groupStatusCounts[$group][$status])) {
                  $groupStatusCounts[$group][$status] = 0;
                }
                if (!isset($groupStatusCounts[$group][$status_log_ids][$status])) {
                  $groupStatusCounts[$group][$status_log_ids][$status] = [];
                }
                $groupStatusCounts[$group][$status]++;
                $groupStatusCounts[$group][$status_log_ids][$status][] = $record->id;
              }
              $totalNewStudents = 0;
              $totalStudying = 0;
              $totalTermination = 0;
              $totalDrop = 0;
              $totalResume = 0;
              $totalWait = 0;
              $totalNoneReceipt = 0;
              // dd($groupStatusCounts);
            @endphp

            @foreach ($groupStatusCounts as $group => $statusCounts)
              <tr>
                <td>
                  @if ($group === 'M')
                    Math
                  @elseif ($group === 'E')
                    English
                  @elseif ($group === 'N')
                    None Receipt
                  @else
                    {{ $group }}
                  @endif
                </td>

                <td>
                  @php
                    $routeParameters = [
                      'type' => 'view',
                      'paraCheck' => 'all',
                      'month' => $month,
                      'year' => $year,
                      'group' => $group,
                      'New Student' => isset($statusCounts['ids']['New Student'])
                        ? $statusCounts['ids']['New Student']
                        : '',
                      'ids' => [],
                    ];
                    if (isset($statusCounts['ids']['New Student'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['New Student'];
                    }
                    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                  @endphp

                  <a
                    class="text-dark"
                    href="{{ route('searchTestLog', $routeParameters) }}"
                  >
                    {{
                      isset($statusCounts['New Student'])
                        ? $statusCounts['New Student']
                        : 0
                    }} คน
                  </a>
                </td>
                <td>
                  @php
                    $routeParameters = [
                      'type' => 'view',
                      'paraCheck' => 'all',
                      'month' => $month,
                      'year' => $year,
                      'group' => $group,
                      'studying . . .' => isset($statusCounts['ids']['studying . . .'])
                        ? $statusCounts['ids']['studying . . .']
                        : '',
                      'ids' => [],
                    ];
                    if (isset($statusCounts['ids']['studying . . .'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['studying . . .'];
                    }
                    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                  @endphp

                  <a
                    class="text-dark"
                    href="{{ route('searchTestLog', $routeParameters) }}"
                  >
                    {{
                      isset($statusCounts['studying . . .'])
                        ? $statusCounts['studying . . .']
                        : 0
                    }} คน
                  </a>
                </td>
                <td>
                  @php
                    $routeParameters = [
                      'type' => 'view',
                      'paraCheck' => 'all',
                      'month' => $month,
                      'year' => $year,
                      'group' => $group,
                      'Termination of study' => isset($statusCounts['ids']['Termination of study'])
                        ? $statusCounts['ids']['Termination of study']
                        : '',
                      'ids' => [],
                    ];
                    if (isset($statusCounts['ids']['Termination of study'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['Termination of study'];
                    }
                    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                  @endphp

                  <a
                    class="text-dark"
                    href="{{ route('searchTestLog', $routeParameters) }}"
                  >
                    {{
                      isset(
                        $statusCounts['Termination of study'],
                      )
                        ? $statusCounts['Termination of study']
                        : 0
                    }} คน
                  </a>
                </td>
                <td>
                  @php
                    $routeParameters = [
                      'type' => 'view',
                      'paraCheck' => 'all',
                      'month' => $month,
                      'year' => $year,
                      'group' => $group,
                      'drop' => isset($statusCounts['ids']['drop'])
                        ? $statusCounts['ids']['drop']
                        : '',
                      'ids' => [],
                    ];
                    if (isset($statusCounts['ids']['drop'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['drop'];
                    }
                    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                  @endphp

                  <a
                    class="text-dark"
                    href="{{ route('searchTestLog', $routeParameters) }}"
                  >
                    {{
                      isset($statusCounts['drop'])
                        ? $statusCounts['drop']
                        : 0
                    }} คน
                  </a>
                </td>
                <td>
                  @php
                    $routeParameters = [
                      'type' => 'view',
                      'paraCheck' => 'all',
                      'month' => $month,
                      'year' => $year,
                      'group' => $group,
                      'resume' => isset($statusCounts['ids']['resume'])
                        ? $statusCounts['ids']['resume']
                        : '',
                      'ids' => [],
                    ];
                    if (isset($statusCounts['ids']['resume'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['resume'];
                    }
                    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                  @endphp

                  <a
                    class="text-dark"
                    href="{{ route('searchTestLog', $routeParameters) }}"
                  >
                    {{
                      isset($statusCounts['resume'])
                        ? $statusCounts['resume']
                        : 0
                    }} คน
                  </a>
                </td>
                <td>
                  @php
                    $routeParameters = [
                      'type' => 'view',
                      'paraCheck' => 'all',
                      'month' => $month,
                      'year' => $year,
                      'group' => $group,
                      'waitting . . .' => isset($statusCounts['ids']['waitting . . .'])
                        ? $statusCounts['ids']['waitting . . .']
                        : '',
                      'ids' => [],
                    ];
                    if (isset($statusCounts['ids']['waitting . . .'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['waitting . . .'];
                    }
                    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                  @endphp

                  <a
                    class="text-dark"
                    href="{{ route('searchTestLog', $routeParameters) }}"
                  >
                    {{
                      isset($statusCounts['waitting . . .'])
                        ? $statusCounts['waitting . . .']
                        : 0
                    }} คน
                  </a>
                </td>
                <td>
                  @php
                    // dd($groupData);
                    $routeParameters = [
                      'type' => 'view',
                      'paraCheck' => 'all',
                      'month' => $month,
                      'year' => $year,
                      'group' => $group,
                      'resume' => isset($statusCounts['ids']['resume'])
                        ? $statusCounts['ids']['resume']
                        : '',
                      'New Student' => isset($statusCounts['ids']['New Student'])
                        ? $statusCounts['ids']['New Student']
                        : '',
                      'studying . . .' => isset($statusCounts['ids']['studying . . .'])
                        ? $statusCounts['ids']['studying . . .']
                        : '',
                      'ids' => [],
                    ];
                    if (isset($statusCounts['ids']['resume'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['resume'];
                    }

                    if (isset($statusCounts['ids']['New Student'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['New Student'];
                    }

                    if (isset($statusCounts['ids']['studying . . .'])) {
                      $routeParameters['ids'][] = $statusCounts['ids']['studying . . .'];
                    }
                    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                    // dd($groupData, $routeParameters);
                  @endphp

                  <a
                    class="text-dark"
                    href="{{ route('searchTestLog', $routeParameters) }}"
                  >
                    {{
                      (isset($statusCounts['New Student'])
                        ? $statusCounts['New Student']
                        : 0) +
                        (isset($statusCounts['studying . . .'])
                          ? $statusCounts['studying . . .']
                          : 0) +
                        (isset($statusCounts['resume'])
                          ? $statusCounts['resume']
                          : 0)
                    }} คน
                  </a>
                </td>
                <td>
                  {{
                    isset($statusCounts['None Receipt'])
                      ? $statusCounts['None Receipt']
                      : 0
                  }} คน
                </td>

                <td>{{ now() }}</td>
              </tr>
              @php
                $totalNewStudents += isset($statusCounts['New Student'])
                  ? $statusCounts['New Student']
                  : 0;
                $totalStudying += isset($statusCounts['studying . . .'])
                  ? $statusCounts['studying . . .']
                  : 0;
                $totalTermination += isset($statusCounts['Termination of study'])
                  ? $statusCounts['Termination of study']
                  : 0;
                $totalDrop += isset($statusCounts['drop']) ? $statusCounts['drop'] : 0;
                $totalResume += isset($statusCounts['resume']) ? $statusCounts['resume'] : 0;
                $totalWait += isset($statusCounts['waitting . . .'])
                  ? $statusCounts['waitting . . .']
                  : 0;
                $totalNoneReceipt += isset($statusCounts['None Receipt'])
                  ? $statusCounts['None Receipt']
                  : 0;
              @endphp
            @endforeach

            <tr>
              <td>Result</td>
              <td>{{ $totalNewStudents }} คน</td>
              <td>{{ $totalStudying }} คน</td>
              <td>{{ $totalTermination }} คน</td>
              <td>{{ $totalDrop }} คน</td>
              <td>{{ $totalResume }} คน</td>
              <td>{{ $totalWait }} คน</td>
              <td>
                <b>
                  {{
                    $totalNewStudents +
                      $totalStudying +
                      $totalResume
                  }} คน
                </b>
              </td>
              <td>{{ $totalNoneReceipt }} คน</td>
              <td>{{ now() }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="main-card card mb-3" id="x_content">
      <div class="card-header-tab card-header-tab-animation card-header">
        <div class="card-header-title">
          <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
          STUDENT LIST {{ date('F-Y') }}
        </div>
      </div>
      <div class="card-body">
        <table
          style="width: 100%"
          id="Listview1"
          class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action my-5 table"
        >
          <thead>
            <tr>
              <th width="1%" class="text-center">no.</th>
              <th width="1%">Code</th>
              <th>Student Nickname</th>
              <th>Group</th>
              <th>Status</th>
              <th>Status Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($latestStatusByStudent as $key => $status)
              <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">
                  {{
                    $status->student
                      ->code
                  }}
                </td>
                <td>
                  <a
                    target="_blank"
                    class="text-dark"
                    href="{{ route('students.show', $status->student_id) }}"
                  >
                    {{ $status->student->full_name }} ( {{ $status->nick_name }} )
                  </a>
                  {{-- {{ $status->nick_name }} --}}
                </td>
                <td>
                  @if ($status->group === 'M')
                    Math
                  @elseif ($status->group === 'E')
                    English
                  @elseif ($status->group === 'N')
                    None Receipt
                  @else
                    {{ $status->group }}
                  @endif
                </td>

                @php
                  $class = '';
                  if ($status->status === 'None Receipt') {
                    $class = 'text-info';
                  } elseif ($status->status === 'drop') {
                    $class = 'text-danger';
                  } elseif ($status->status === 'waitting . . .') {
                    $class = 'text-primary';
                  } elseif ($status->status === 'Termination of study') {
                    $class = 'text-warning';
                  } else {
                    $class = 'text-success';
                  }
                @endphp

                <td class="{{ $class }}">{{ $status->status }}</td>
                <td>{{ $status->status_date }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section ('script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  {{-- <script src="https://d3js.org/d3.v7.min.js"></script> --}}
  <script src="../assets/plugins/d3/d3.min.js"></script>
  <script src="../assets/plugins/nvd3/build/nv.d3.min.js"></script>
  <script src="../assets/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="../assets/plugins/flot/source/jquery.canvaswrapper.js"></script>
  <script src="../assets/plugins/flot/source/jquery.colorhelpers.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.saturated.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.browser.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.drawSeries.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.uiConstants.js"></script>
  <script>
    function export_report() {
      url = '{{ route('search_status', ['type' => 'print', 'month' => $month, 'year' => $year]) }}';

      window.open(url.replace(/&amp;/g, '&'));
    }
    $(document).ready(function () {
      //$.noConflict();
      // var token = ''
      // $.ajaxSetup({
      //     headers: {
      //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //     }
      // });
      // var table = $('#Listview').DataTable({

      //     // serverSide: true,
      //     // processing: true,

      //     // iDisplayLength: 10,
      //     lengthMenu: [10, 20, 50, 75, 100],

      // });
      var table1 = $('#Listview1').DataTable({
        // serverSide: true,
        // processing: true,

        // iDisplayLength: 10,
        lengthMenu: [20, 50, 75, 100, 200]
      });

      // let sub_id, std_id;

      // $(document).on('click', '#getViewData', function(e) {
      //     e.preventDefault();

      //     $('.alert-danger').html('');
      //     $('.alert-danger').hide();
      //     $('.alert-success').html('');
      //     $('.alert-success').hide();

      //     let id = $(this).data('id');
      //     [sub_id, std_id] = id.split(',');

      //     $.ajax({
      //         url: "history/" + sub_id + "/" + std_id,
      //         method: 'GET',
      //         success: function(res) {
      //             $('#time_text').html(res.timeText);
      //             $('#date_text').html(res.dateText);
      //             $('#className').html(res.classname);
      //             $('#ViewModalBody').html(res.html);
      //             $('#ViewParent').html(res.parent);
      //             $('#ViewModal').modal('show');
      //         }
      //     });
      // });
    });
  </script>
  {{-- กราฟนี้ใช้ได้ --}}
  {{--
    <script>
    nv.addGraph(function() {
    var sin = [],
    cos = [];
    for (var i = 0; i < 100; i++) {
    sin.push({
    x: i,
    y: Math.sin(i / 10)
    });
    cos.push({
    x: i,
    y: .5 * Math.cos(i / 10)
    });
    }
    var lineChartData = [{
    values: sin,
    key: 'Sine Wave',
    color: 'rgb(0, 172, 172)'
    },
    {
    values: cos,
    key: 'Cosine Wave',
    color: 'rgb(52, 143, 226)'
    }
    ];
    
    var lineChart = nv.models.lineChart().options({
    transitionDuration: 300,
    useInteractiveGuideline: true
    });
    
    lineChart.xAxis.axisLabel('Time (s)').tickFormat(d3.format(',.1f'));
    lineChart.yAxis.axisLabel('Voltage (v)').tickFormat(function(d) {
    if (d == null) {
    return 'N/A';
    }
    return d3.format(',.2f')(d);
    });
    
    d3.select('#nv-line-chart').append('svg').datum(lineChartData).call(lineChart);
    nv.utils.windowResize(lineChart.update);
    
    return lineChart;
    });
    </script>
  --}}
  {{--
    <script>
    // Extracted data from your table
    var labels = ['New student', 'studying . . .', 'Termination of study', 'Drop', 'Resume', 'None Receipt'];
    var data = [
    {{ $totalNewStudents }},
    {{ $totalStudying }},
    {{ $totalTermination }},
    {{ $totalDrop }},
    {{ $totalResume }},
    {{ $totalNoneReceipt }}
    ];
    
    // Initialize Chart.js
    var ctx = document.getElementById('line-charttest').getContext('2d');
    var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: labels,
    datasets: [{
    label: 'Dataset 1',
    borderColor: 'rgb(52, 143, 226)',
    pointBackgroundColor: 'rgb(52, 143, 226)',
    pointRadius: 4,
    borderWidth: 2,
    backgroundColor: 'rgb(52, 143, 226)',
    data: data
    }]
    },
    options: {
    scales: {
    y: {
    beginAtZero: true
    }
    }
    }
    });
    </script>
  --}}
  {{--
    <script>
    Chart.defaults.color = 'gray';
    // Chart.defaults.font.family = app.font.family;
    Chart.defaults.font.weight = 300;
    Chart.defaults.scale.grid.color = 'gray';
    Chart.defaults.scale.ticks.backdropColor = 'gray';
    
    var randomScalingFactor = function() {
    return Math.round(Math.random() * 100)
    };
    
    var ctx = document.getElementById('line-charttest').getContext('2d');
    var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
    label: 'Dataset 1',
    borderColor: 'rgb(52, 143, 226)',
    pointBackgroundColor: 'rgb(52, 143, 226)',
    pointRadius: 4,
    borderWidth: 2,
    backgroundColor: 'rgb(52, 143, 226)',
    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor()
    ]
    }, {
    label: 'Dataset 2',
    borderColor: 'rgb(0, 172, 172)',
    pointBackgroundColor: 'rgb(0, 172, 172)',
    pointRadius: 4,
    borderWidth: 2,
    backgroundColor: 'rgb(0, 172, 172)',
    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor()
    ]
    }]
    }
    });
    </script>
  --}}
  <script>
    var groupLabels = [
      'New Student',
      'Studying',
      'Termination of study',
      'Drop',
      'Resume',
      'Waiting'
    ];
    var data = [
      @foreach ($groupStatusCounts as $group => $statusCounts)
      @if ($group !== 'N')

      {
        label: '{{ $group }}',
        data: [
          {{
      isset($statusCounts['New Student'])
        ? $statusCounts['New Student']
        : 0
    }},
          {{
      isset($statusCounts['studying . . .'])
        ? $statusCounts['studying . . .']
        : 0
    }},
          {{
      isset(
        $statusCounts['Termination of study'],
      )
        ? $statusCounts['Termination of study']
        : 0
    }},
          {{
      isset($statusCounts['drop'])
        ? $statusCounts['drop']
        : 0
    }},
          {{
      isset($statusCounts['resume'])
        ? $statusCounts['resume']
        : 0
    }},
          {{
      isset($statusCounts['waitting . . .'])
        ? $statusCounts['waitting . . .']
        : 0
    }}
          // {{
      isset($statusCounts['None Receipt'])
        ? $statusCounts['None Receipt']
        : 0
    }},
        ]
      }
      @endif
      @endforeach
    ];
    var ctx = document.getElementById('lineChart').getContext('2d');
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
      'rgba(251, 85, 151,.65)'
    ];
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: groupLabels,

        datasets: data.map(function (item, index) {
          // var ran1 = Math.floor(Math.random() * 255);
          // var randomColor = 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 1)';
          // var grouplabels = item.label;

          // var groupColors = {
          //     'M': 'rgba(52, 143, 226,.65)',
          //     'E': 'rgba(0, 172, 172,.65)',
          //     'Sci': 'rgba(135, 83, 217,.65)',
          //     'CHN': 'rgba(245, 156, 26,.65)',
          // };
          // var grouplabels = {
          //     'M': 'Math',
          //     'E': 'English',
          //     'Sci': 'Science',
          //     'CHN': 'Chinese' ,
          // };
          return {
            // label: grouplabels[item.label],
            label: item.label,
            data: item.data,
            // pointBackgroundColor: groupColors[item.label],
            // borderColor: groupColors[item.label],
            // backgroundColor: groupColors[item.label],
            pointBackgroundColor: colors[index % colors.length],
            borderColor: colors[index % colors.length],
            backgroundColor: colors[index % colors.length],
            pointRadius: 4,
            borderWidth: 2
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
      'New Student',
      'Studying',
      'Termination of study',
      'Drop',
      'Resume',
      'waitting'
    ];
    var data = [
      @foreach ($groupStatusCounts as $group => $statusCounts)
      @if ($group !== 'N')

      {
        label: '{{ $group }}',
        data: [
          {{
      isset($statusCounts['New Student'])
        ? $statusCounts['New Student']
        : 0
    }},
          {{
      isset($statusCounts['studying . . .'])
        ? $statusCounts['studying . . .']
        : 0
    }},
          {{
      isset(
        $statusCounts['Termination of study'],
      )
        ? $statusCounts['Termination of study']
        : 0
    }},
          {{
      isset($statusCounts['drop'])
        ? $statusCounts['drop']
        : 0
    }},
          {{
      isset($statusCounts['resume'])
        ? $statusCounts['resume']
        : 0
    }},
          {{
      isset($statusCounts['waitting . . .'])
        ? $statusCounts['waitting . . .']
        : 0
    }}
          // {{
      isset($statusCounts['None Receipt'])
        ? $statusCounts['None Receipt']
        : 0
    }},
        ]
      }
      @endif
      @endforeach
    ];
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
      'rgba(251, 85, 151,.65)'
    ];

    var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: groupLabels,
        datasets: data.map(function (item, index) {
          // var groupColors = {
          //     'M': 'rgba(52, 143, 226,.65)',
          //     'E': 'rgba(0, 172, 172,.65)',
          //     'Sci': 'rgba(135, 83, 217,.65)', // Add more colors if needed
          //     'CHN': 'rgba(245, 156, 26,.65)', // Add more colors if needed
          // };
          // var grouplabels = {
          //     'M': 'Math',
          //     'E': 'English',
          //     'Sci': 'Science', // Add more colors if needed
          //     'CHN': 'Chinese', // Add more colors if needed
          // };
          return {
            label: item.label,
            // label: grouplabels[item.label],
            data: item.data,
            // backgroundColor: groupColors[item.label],
            // borderColor: groupColors[item.label],

            // pointBackgroundColor: colors[index % colors.length],
            borderColor: colors[index % colors.length],
            backgroundColor: colors[index % colors.length],
            borderWidth: 1
          };
        })
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            maxTicksLimit: 5 // Set the maximum number of ticks on the Y-axis
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
  {{--
    <script>
    // Chart.defaults.color = 'rgba(' + app.color.componentColorRgb + ', .65)';
    Chart.defaults.color = 'rgba(52, 143, 226, .65)';
    Chart.defaults.font.weight = 500;
    Chart.defaults.scale.grid.color = 'rgba(52, 143, 226, .65)';
    Chart.defaults.scale.ticks.backdropColor = 'rgba(52, 143, 226, .65)';
    
    var randomScalingFactor = function() {
    return Math.round(Math.random() * 100)
    };
    
    var ctx2 = document.getElementById('bar-chart777').getContext('2d');
    var barChart = new Chart(ctx2, {
    type: 'bar',
    data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
    label: 'Dataset 1',
    borderWidth: 1,
    borderColor: 'rgba(52, 143, 226, .65)',
    backgroundColor: 'rgba(52, 143, 226, .65)',
    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor()
    ]
    }, {
    label: 'Dataset 2',
    borderWidth: 1,
    borderColor: 'rgba(0, 172, 172, .65)',
    backgroundColor: 'rgba(0, 172, 172,  .65)',
    data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor(), randomScalingFactor(), randomScalingFactor(),
    randomScalingFactor()
    ]
    }]
    }
    });
    </script>
  --}}
  {{--
    <script>
    // Assuming you have already extracted the data as $totalNewStudents, $totalStudying, etc.
    
    var ctx = document.getElementById('line-charttest').getContext('2d');
    var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: ['New student', 'Studying', 'Termination of study', 'Drop', 'Resume', 'None Receipt'],
    datasets: [{
    label: 'Dataset 1',
    borderColor: 'rgb(52, 143, 226)',
    pointBackgroundColor: 'rgb(52, 143, 226)',
    pointRadius: 4,
    borderWidth: 2,
    backgroundColor: 'rgb(52, 143, 226)',
    data: [
    {{ $totalNewStudents }},
    {{ $totalStudying }},
    {{ $totalTermination }},
    {{ $totalDrop }},
    {{ $totalResume }},
    {{ $totalNoneReceipt }}
    ]
    }]
    }
    });
    </script>
  --}}
  {{--
    <script>
    var groupLabels = [];
    var newData = [];
    
    // Iterate over each row in the table body
    document.querySelectorAll('#Listview tbody tr').forEach(function(row) {
    var cells = row.querySelectorAll('td');
    groupLabels.push(cells[0].textContent.trim()); // Extract group label
    newData.push(Array.from(cells).slice(1).map(function(cell) {
    return parseInt(cell.textContent, 10); // Extract numerical data
    }));
    });
    
    var ctx = document.getElementById('line-charttest').getContext('2d');
    var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: ['New student', 'Studying', 'Termination of study', 'Drop', 'Resume', 'None Receipt'],
    datasets: groupLabels.map(function(label, index) {
    return {
    label: label,
    borderColor: 'rgb(' + Math.random() * 255 + ',' + Math.random() * 255 + ',' + Math.random() * 255 + ')',
    pointBackgroundColor: 'rgb(' + Math.random() * 255 + ',' + Math.random() * 255 + ',' + Math.random() * 255 + ')',
    pointRadius: 4,
    borderWidth: 2,
    backgroundColor: 'rgb(' + Math.random() * 255 + ',' + Math.random() * 255 + ',' + Math.random() * 255 + ')',
    data: newData[index]
    };
    })
    },
    options: {
    scales: {
    y: {
    beginAtZero: true,
    maxTicksLimit: 5, // Set the maximum number of ticks on the Y-axis
    }
    }
    }
    });
    </script>
  --}}
@endsection
