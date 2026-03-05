@extends('layouts.main_template')

@section('style')
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"
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
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
  />

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  <style>
    .bg-success2 {
      background-color: #4ffca2 !important;
    }
  </style>
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
            <i class="pe-7s-users icon-gradient bg-tempting-azure"></i>
          </div>
          <div>
            Report Month Students
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
              <canvas
                id="barChart"
                {{-- width="800" height="200" --}}
              ></canvas>
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
        {{-- กราฟนี้ใช้ได้ --}}
        {{-- <div id="nv-line-chart" class="h-250px"></div> --}}

        {{-- <canvas id="bar-chart777"></canvas> --}}
        {{-- <canvas id="line-charttest" height="100px"></canvas> --}}
        {{-- <canvas id="line-charttest" width="600" height="150"></canvas> --}}
        {{--
          <table style="width: 100%;" id="Listview"
          class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
          <thead>
          <tr>
          <th>Group</th>
          <th class="text-success">New student</th>
          <th class="text-success">studying . . .</th>
          <th class="text-warning">Termination of study</th>
          <th class="text-danger">Drop</th>
          <th class="text-success">Resume</th>
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
          
          if (!isset($groupStatusCounts[$group])) {
          $groupStatusCounts[$group] = [];
          }
          if (!isset($groupStatusCounts[$group][$status])) {
          $groupStatusCounts[$group][$status] = 0;
          }
          $groupStatusCounts[$group][$status]++;
          }
          $totalNewStudents = 0;
          $totalStudying = 0;
          $totalTermination = 0;
          $totalDrop = 0;
          $totalResume = 0;
          $totalNoneReceipt = 0;
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
          @endif
          
          </td>
          <td>{{ isset($statusCounts['New Student']) ? $statusCounts['New Student'] : 0 }} คน</td>
          <td>{{ isset($statusCounts['studying . . .']) ? $statusCounts['studying . . .'] : 0 }} คน
          </td>
          <td>{{ isset($statusCounts['Termination of study']) ? $statusCounts['Termination of study'] : 0 }}
          คน</td>
          <td>{{ isset($statusCounts['drop']) ? $statusCounts['drop'] : 0 }} คน</td>
          <td>{{ isset($statusCounts['resume']) ? $statusCounts['resume'] : 0 }} คน</td>
          <td>{{ isset($statusCounts['None Receipt']) ? $statusCounts['None Receipt'] : 0 }} คน</td>
          <td>{{ now() }}</td>
          <!-- You can replace this with the actual date time if needed -->
          </tr>
          @php
          $totalNewStudents += isset($statusCounts['New Student']) ? $statusCounts['New Student'] : 0;
          $totalStudying += isset($statusCounts['studying . . .']) ? $statusCounts['studying . . .'] : 0;
          $totalTermination += isset($statusCounts['Termination of study']) ? $statusCounts['Termination of study'] : 0;
          $totalDrop += isset($statusCounts['drop']) ? $statusCounts['drop'] : 0;
          $totalResume += isset($statusCounts['resume']) ? $statusCounts['resume'] : 0;
          $totalNoneReceipt += isset($statusCounts['None Receipt']) ? $statusCounts['None Receipt'] : 0;
          @endphp
          @endforeach
          <tr>
          <td>Result</td>
          <td>{{ $totalNewStudents }} คน</td>
          <td>{{ $totalStudying }} คน</td>
          <td>{{ $totalTermination }} คน</td>
          <td>{{ $totalDrop }} คน</td>
          <td>{{ $totalResume }} คน</td>
          <td>{{ $totalNoneReceipt }} คน</td>
          <td>{{ now() }}</td>
          </tr>
          
          </tbody>
          
          
          </table>
        --}}

        <form action="{{ route('searchr_reportMonthStd') }}" method="GET">
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
                <label for="month" class="col-lg-4">subjects :</label>
                <div class="col-lg-8">
                  <select name="group" id="selectSubjects" class="form-select">
                    <option value="">select subjects</option>
                    @foreach ($subjects as $subjectGroup => $subject)
                      @php
                        $name = '';
                        switch ($subjectGroup) {
                          case 'M':
                            $name = 'Math';
                            break;
                          case 'E':
                            $name = 'English';
                            break;
                          case 'Sci':
                            $name = 'Science';
                            break;
                          case 'C':
                            $name = 'Chinese';
                            break;
                          default:
                            $name = $subject->first()->title ?? 'Unknown';
                        }
                      @endphp

                      <option
                        value="{{ $subjectGroup }}"
                        {{ $groupSubject === $subjectGroup ? 'selected' : '' }}
                      >
                        {{ $name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="col-lg-2">
              <div class="row">
                <label for="month" class="col-lg-3">เดือน :</label>
                <div class="col-lg-9">
                  <select name="month" id="selectMonth" class="form-select">
                    <option value="">เลือกเดือน</option>

                    @for ($i = 1; $i <= 12; $i++)
                      <option
                        value="{{ $i }}"
                        {{ $i == $monthf ? 'selected' : '' }}
                      >
                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
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
            </div>
            <div class="col-lg-2"></div>
            {{--
              <div class="col-lg-2">
              </div>
            --}}
            <div class="col-lg-2 text-end">
              <a
                href="#"
                onclick="formModalBonus('{{ route('stdlog_create') }}')"
                class="btn btn-success"
                data-bs-toggle="tooltip"
                data-bs-trigger="hover"
                data-bs-container="body"
                data-bs-title="ใบปะหน้า"
              >
                <i class="fa fa-plus"></i>
                ใบปะหน้า
              </a>
            </div>
          </div>
        </form>

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
          {{--
            <li class="nav-item">
            <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link">
            <span class="d-sm-none">Tab 1</span>
            <span class="d-sm-block d-none">ตรวจสอบรายปี</span>
            </a>
            </li>
          --}}
          <li class="nav-item">
            <a href="#default-tab-2" data-bs-toggle="tab" class="nav-link">
              {{-- <span class="d-sm-none">Tab 2</span> --}}
              <span class="d-sm-block d-none">ตรวจสอบแล้ว</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link">
              {{-- <span class="d-sm-none">Tab 2</span> --}}
              <span class="d-sm-block d-none">บันทึกใบปะหน้า</span>
            </a>
          </li>

          {{--
            <li class="nav-item">
            <a href="#default-tab-3" data-bs-toggle="tab" class="nav-link">
            <span class="d-sm-none">Tab 3</span>
            <span class="d-sm-block d-none">Default Tab 3</span>
            </a>
            </li>
          --}}
        </ul>
        <div class="tab-content panel rounded-0 m-0 p-3">
          <!-- BEGIN tab-pane -->
          <div class="tab-pane fade active show" id="default-tab-1">
            <div class="row">
              <div class="col-lg-6">
                <h3 class="mt-10px">
                  <i class="fa fa-cog"></i>
                  ตารางค่าสมัครเรียนเดือน
                  {{ thaidate('F', $month) }}
                  {{ $year }}
                </h3>
              </div>
              <div class="col-lg-6 text-end">
                <a href="#" onclick="export_report()" class="btn btn-success">
                  Print
                </a>
              </div>
            </div>
            <table
              style="width: 100%"
              id="Listview"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action my-5 table"
            >
              <thead>
                <tr>
                  <th width="1%" class="text-center">no.</th>
                  <th width="1%">Code</th>
                  <th>Student Nickname</th>
                  <th>Submission Date</th>
                  <th>Period</th>
                  <th>Reciept Number</th>
                  <th>Subject</th>
                  <th>Group</th>
                  <th>Stutus</th>
                  <th>Type</th>
                  <th>total</th>
                  <th>Check</th>
                  <th>Note</th>
                </tr>
              </thead>

              <tbody>
                @php
                  use App\Models\Statuslog;
                  $sum = 0;
                  $sum1 = 0;
                  $cMonth = date('m');
                  $cYear = date('Y');
                @endphp

                @foreach ($reportMonth_schoolPrice as $studentId => $groupedData)
                  @foreach ($groupedData as $key => $data)
                    @php
                      $class = '';

                      $status = Statuslog::where('student_id', $data->std->id)
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
                      // dd($checkStatus);
                    @endphp

                    {{--
                      @if ($checkStatus === 'all')
                      <tr>
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="text-center">{{ $data->std->code ?? 'Null' }}</td>
                      <td class="{{ $class }}">{{ $data->std->nick_name ?? 'Null' }}
                      </td>
                      <td>{{ $data->rec_school->submission_date }}</td>
                      <td>{{ $data->period }}</td>
                      
                      <td>{{ $data->rec_school->receipt_number }}</td>
                      <td>{{ $data->group }}</td>
                      
                      
                      <td class="{{ $class }}">
                      {{ $statusValue }}
                      </td>
                      <td>{{ $data->course_type }}</td>
                      <td class="text-end">{{ number_format($data->total) }} บาท</td>
                      <td class="text-center">
                      <div class="form-check form-switch form-switch-sm">
                      <input class="form-check-input" type="checkbox"
                      id="flexSwitchCheckChecked-{{ $data->rec_school->receipt_number }}">
                      </div>
                      </td>
                      
                      </tr>
                      @php
                      $sum += $data->total;
                      @endphp
                      @else
                      @if ($checkStatus && $checkStatus === $statusValue)
                      <tr>
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="text-center">{{ $data->std->code ?? 'Null' }}</td>
                      <td class="{{ $class }}">{{ $data->std->nick_name ?? 'Null' }}
                      </td>
                      <td>{{ $data->rec_school->submission_date }}</td>
                      <td>{{ $data->period }}</td>
                      
                      <td>{{ $data->rec_school->receipt_number }}</td>
                      <td>{{ $data->group }}</td>
                      
                      
                      <td class="{{ $class }}">
                      {{ $statusValue }}
                      </td>
                      <td>{{ $data->course_type }}</td>
                      <td class="text-end">{{ number_format($data->total) }} บาท</td>
                      <td class="text-center">
                      <div class="form-check form-switch form-switch-sm">
                      <input class="form-check-input" type="checkbox"
                      id="flexSwitchCheckChecked-{{ $data->rec_school->receipt_number }}">
                      </div>
                      </td>
                      
                      </tr>
                      @php
                      $sum += $data->total;
                      @endphp
                      @else
                      @endif
                      @endif
                    --}}
                    <tr>
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="text-center">
                        {{ $data->std->code ?? 'Null' }}
                      </td>
                      <td class="{{ $class }}">
                        {{ $data->std->nick_name ?? 'Null' }}
                      </td>
                      <td>
                        {{ $data->rec_school->submission_date ?? 'Null' }}
                      </td>
                      <td>{{ $data->period ?? 'Null' }}</td>

                      <td>
                        {{ $data->rec_school->receipt_number ?? 'Null' }}
                      </td>
                      <td>{{ $data->school_sub->title }}</td>
                      <td>{{ $data->group }}</td>

                      <td class="{{ $class }}">
                        {{-- @if ($data->std->status_log && $data->std->status_log->count() > 0 && $status->last()->group == $data->group) --}}
                        {{ $statusValue ?? 'Null' }}
                      </td>
                      <td>{{ $data->course_type ?? 'Null' }}</td>
                      {{-- <td class="text-end">{{ number_format($data->total) }} บาท</td> --}}
                      <td class="text-end">
                        {{ number_format($data->total) ?? 'Null' }} บาท
                      </td>
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
                      @php
                        $routeParameters = [
                          'student_id' => $data->std->id,
                          'receipt_school_id' => $data->rec_school->id,
                          'school_price_id' => $data->id,
                        ];
                        $routeUrl = htmlspecialchars_decode(
                          route('saveCheck', $routeParameters),
                        );
                      @endphp

                      <td class="text-center" width="1%">
                        <div class="form-check form-switch form-switch-sm">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            id="flexSwitchCheckChecked-{{ $data->id }}"
                            data-id="{{ $data->id }}"
                            data-route="{{ $routeUrl }}"
                            data-token="{{ csrf_token() }}"
                            data-input="@json($routeParameters)"
                          />
                          <label
                            class="label-text"
                            id="label-check-{{ $data->id }}"
                            for=""
                          >
                            Date:
                          </label>
                        </div>
                      </td>
                      <td id="note-{{ $data->id }}"></td>
                    </tr>
                    @php
                      $sum += $data->total;
                    @endphp
                  @endforeach
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td class="text-center">#</td>
                  <td class="text-center text-black" colspan="8">Sum Total</td>
                  <!-- Merged cell -->
                  <td class="text-end">{{ number_format($sum) }} บาท</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="tab-pane fade" id="default-tab-2">
            <blockquote class="blockquote">
              <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">รายการใบเสร็จที่ตรวจสอบแล้ว</p>
              </div>
            </blockquote>
            <table
              style="width: 100%"
              id="Listview2"
              class="table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action my-5 table"
            >
              <thead>
                <tr>
                  <th width="1%" class="text-center">no.</th>
                  <th width="1%">Code</th>
                  <th>Student Nickname</th>
                  <th>Submission Date</th>
                  <th>Reciept Number</th>
                  <th>Period</th>
                  <th>Group</th>
                  <th>Check Date</th>
                  <th>Note</th>
                  <th>User</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($check_recp as $key => $check)
                  <tr>
                    <td width="1%">{{ $key + 1 ?? 'null' }}</td>
                    <td width="1%">{{ $check->student->code ?? 'null' }}</td>
                    <td>
                      {{ $check->student->nick_name ?? 'null' }} /
                      {{ $check->student->full_name ?? 'null' }}
                    </td>
                    <td>
                      {{ $check->receiptSchool->submission_date ?? 'null' }}
                    </td>
                    <td>
                      {{ $check->receiptSchool->receipt_number ?? 'null' }}
                    </td>
                    <td>{{ $check->school_price->period ?? 'null' }}</td>
                    <td>{{ $check->school_price->group ?? 'null' }}</td>
                    <td>{{ $check->date_check ?? 'null' }}</td>
                    <td>{{ $check->note ?? 'null' }}</td>
                    <td>{{ $check->user->name ?? 'null' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="default-tab-3">
            <blockquote class="blockquote">
              <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">
                  ตารางแสดงผลบันทึกใบปะหน้าประจำเดือน
                  {{ thaidate('F', date('F')) }} {{ date('Y') }}
                </p>
              </div>
            </blockquote>
            <table
              style="width: 100%"
              id="Listview3"
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
                  {{-- <th>Stutus</th> --}}
                  {{-- <th>Tpye</th> --}}
                  <th>total</th>
                  {{-- <th>Check</th> --}}
                </tr>
              </thead>

              <tbody>
                @foreach ($paper as $key => $paper_rep)
                  <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $paper_rep->no }}</td>
                    <td>{{ $paper_rep->submission_date }}</td>
                    <td>{{ $paper_rep->student->nick_name }}</td>
                    <td>{{ $paper_rep->receipt_number }}</td>
                    <td>{{ $paper_rep->school_price->period ?? null }}</td>
                    <td>{{ $paper_rep->school_price->group ?? null }}</td>
                    <td class="text-end">
                      {{ number_format($paper_rep->school_price->total) ?? null }}
                      บาท
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
  @include('students.modal')
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
    $(document).ready(function () {
      $('.select2_single_paper').select2({
        // maximumSelectionLength: 1,
        allowClear: true
      });
      $('.select2_single').select2({
        maximumSelectionLength: 1,
        allowClear: true
      });

      $('.select3_single').select2({
        maximumSelectionLength: 1
        // allowClear: true
      });

      $('.select2_single2').select2({
        maximumSelectionLength: 2,
        //placeholder: "With Max Selection limit 4",
        allowClear: true
      });
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

      let id;
      let isChecked;
      let checkbox;
      // function showModal() {
      //     console.log('test');
      //     $('.alert-danger').html('');
      //     $('.alert-danger').hide();
      //     $('.alert-success').html('');
      //     $('.alert-success').hide();

      //     id = $(this).data('id');
      //     $.ajax({
      //         url: "users/edit/" + id,
      //         method: 'GET',
      //         success: function(res) {
      //             $('#EditModalBody').html(res.html);
      //             $('#EditModal').modal('show');
      //         }
      //     });

      // }

      $('input[type="checkbox"]').change(function () {
        checkbox = $(this);
        isChecked = checkbox.is(':checked');
        id = checkbox.data('id');
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();
        var route = checkbox.data('route');
        var input = checkbox.data('input');
        var token = checkbox.data('token');
        // var id = checkbox.attr('id');
        var labelElement = checkbox.siblings('.label-text');
        // showModal()
        var note2 = $('#note2').val();
        if (isChecked) {
          $.ajax({
            url: 'getDataRec/' + id,
            method: 'GET',
            success: function (res) {
              console.log(res);
              $('#EditModalBody').html(res.html);
              $('#EditModal').modal('show');
            }
          });
        } else {
          $.ajax({
            url: '{{ route('saveCheck') }}',
            method: 'POST',
            data: {
              isChecked: isChecked,
              input: input,
              note: note2,
              // note: $('#note').val(),
              _token: token // CSRF token
            },
            success: function (response) {
              labelElement.text(response.label);
              $('#note-' + id).text(response.note);

              if (isChecked) {
                checkbox.closest('tr').addClass('bg-success2');
              } else {
                checkbox.closest('tr').removeClass('bg-success2');
              }
            },
            error: function (xhr, status, error) {
              console.error('Request failed:', status, error);
            }
          });
        }
      });

      $(document).on('click', '#SubmitEditForm', function (e) {
        // if (!confirm("Are you sure?")) return;
        e.preventDefault();

        $('.alert-danger').html('');
        $('.alert-danger').hide();
        $('.alert-success').html('');
        $('.alert-success').hide();
        var route = checkbox.data('route');
        var input = checkbox.data('input');
        var token = checkbox.data('token');
        var labelElement = checkbox.siblings('.label-text');
        var note2 = $('#note2').val();
        $.ajax({
          url: '{{ route('saveCheck') }}',
          method: 'POST',
          data: {
            isChecked: isChecked,
            input: input,
            note: note2,
            // note: $('#note').val(),
            _token: token // CSRF token
          },
          success: function (response) {
            console.log(response);
            $('#EditModal').modal('hide');

            labelElement.text(response.label);
            $('#note-' + id).text(response.note);
            if (isChecked) {
              checkbox.closest('tr').addClass('bg-success2');
            } else {
              checkbox.closest('tr').removeClass('bg-success2');
            }
          },
          error: function (xhr, status, error) {
            console.error('Request failed:', status, error);
          }
        });

        // $.ajax({
        //     url: "users/save/" + id,
        //     method: 'PUT',
        //     data: {
        //         name: $('#editName').val(),
        //         password: $('#EditPassword').val(),
        //         password_confirmation: $('#EditPasswordC').val(),
        //         email: $('#editEmail').val(),
        //         level: $('#editLevel').val(),
        //     },

        //     success: function(result) {
        //         //console.log(result);
        //         if (result.errors) {
        //             $('.alert-danger').html('');
        //             $.each(result.errors, function(key, value) {
        //                 $('.alert-danger').show();
        //                 $('.alert-danger').append('<strong><li>' + value +
        //                     '</li></strong>');
        //             });
        //         } else {
        //             $('.alert-danger').hide();
        //             $('.alert-success').show();
        //             $('.alert-success').append('<strong><li>' + result.success +
        //                 '</li></strong>');
        //             $('#Listview').DataTable().ajax.reload();
        //             //setTimeout(function() {
        //             //$('.alert-success').hide();
        //             //   $('#EditModal').modal('hide');
        //             //}, 10000);

        //         }
        //     }
        // });
      });
      $.ajax({
        url: '{{ route('fetchCheckboxStates') }}',
        method: 'GET',
        success: function (response) {
          // console.log(response);

          $.each(response, function (index, item) {
            var id = item.school_price_id;
            var date = item.date_check;
            var note = item.note;

            $('#flexSwitchCheckChecked-' + id).prop('checked', true);
            $('#label-check-' + id).text(date);
            $('#note-' + id).text(note);
            $('#flexSwitchCheckChecked-' + id)
              .closest('tr')
              .addClass('bg-success2');
          });
        },
        error: function (xhr, status, error) {
          console.error('Failed to fetch checkbox states:', error);
        }
      });
    });
    // if (isChecked) {
    //         $(this).closest('tr').addClass('bg-success2');
    //         var id = $(this).attr('id');

    //         // Store the current date when the checkbox is checked
    //         var currentDate = new Date().toLocaleDateString();
    //         localStorage.setItem(id, currentDate);

    //         // Update label text with the stored date
    //         $(this).siblings('.label-text').text(currentDate);
    //     } else {
    //         $(this).closest('tr').removeClass('bg-success2');
    //         var id = $(this).attr('id');
    //         localStorage.setItem(id, '');

    //         // Reset label text
    //         $(this).siblings('.label-text').text("Date:");
    //     }

    // $('input[type="checkbox"]').each(function() {
    //     var id = $(this).attr('id');
    //     var storedDate = localStorage.getItem(id);

    //     if (storedDate) {
    //         $(this).prop('checked', true);
    //         $(this).closest('tr').addClass('bg-success2');
    //         // Update label text with stored date
    //         $(this).siblings('.label-text').text(storedDate);
    //     }
    // });
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

  <script>
    function export_report() {

        url = '{{ route('reportMonthStd', ['type' => 'print', 'tap' => '1', 'month' => $cMonth, 'year' => $year]) }}';

        window.open(
            url.replace(/&amp;/g, "&")
        );
    }
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
@endsection
