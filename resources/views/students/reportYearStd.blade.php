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
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            Report Year Students
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
              All YEAR Report
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
    </div>
    <div class="row mb-3">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
              <i
                class="header-icon lnr-apartment icon-gradient bg-love-kiss"
              ></i>
              All YEAR Report
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              {{--  --}}
              <canvas
                id="lineGroupChart"
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
    </div>
    {{-- </div> --}}

    {{-- </div> --}}

    <div class="main-card card mb-3" id="x_content">
      <div class="card-body">
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
                        if ($subjectGroup === 'M') {
                          # code...
                          $name = 'Math';
                        } elseif ($subjectGroup === 'E') {
                          # code...
                          $name = 'English';
                        } elseif ($subjectGroup === 'Sci') {
                          # code...
                          $name = 'Science';
                        } elseif ($subjectGroup === 'Sci') {
                          # code...
                          $name = 'Chinese';
                        } else {
                          # code...
                          $name = $subject->first()->title;
                        }
                      @endphp

                      <option value="{{ $subjectGroup }}">{{ $name }}</option>
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
                      <option value="{{ $i }}">
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
              href="#default-tab-2"
              data-bs-toggle="tab"
              class="nav-link active"
            >
              {{-- <span class="d-sm-none">Tab 1</span> --}}
              <span class="d-sm-block d-none">ตรวจสอบรายปี</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#default-tab-4" data-bs-toggle="tab" class="nav-link">
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

          <div class="tab-pane fade active show" id="default-tab-2">
            <div class="row">
              <div class="col-lg-6">
                <h3 class="mt-10px">
                  <i class="fa fa-cog"></i>
                  ตารางค่าสมัครเรียนปี {{ $year }}
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
              id="Listview3"
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
                  <th width="1%" class="text-center">Group</th>
                  <th class="text-center">Stutus</th>
                  <th width="1%" class="text-center">Tpye</th>
                  <th>total</th>
                  <th>Check</th>
                  <th>Note</th>
                  {{-- <th>Date Check</th> --}}
                </tr>
              </thead>
              @php
                use App\Models\Statuslog;
                $sum1 = 0;
              @endphp

              @foreach ($reportYear_schoolPrice as $keyG => $group)
                <tbody>
                  @php
                    $subg = 0;
                  @endphp

                  @foreach ($group as $key => $data1)
                    {{-- @foreach ($reportYear_schoolPrice as $studentId1 => $groupedData1) --}}
                    {{-- @foreach ($groupedData1 as $key => $data1) --}}
                    @php
                      $class = '';

                      $cMonth = date('m');
                      $cYear = date('Y');
                      $status = Statuslog::where('student_id', optional($data1->std)->id)
                        ->where('group', $data1->group)
                        ->whereMonth('status_date', $cMonth)
                        ->whereYear('status_date', $cYear)
                        ->get();

                      if ($status->last() && $status->last()->status === 'None Receipt') {
                        $class = 'text-info';
                      } elseif ($status->last() && $status->last()->status === 'drop') {
                        $class = 'text-black';
                      } elseif ($status->last() && $status->last()->status === 'waitting . . .') {
                        $class = 'text-primary';
                      } elseif ($status->last() && $status->last()->status === 'Termination of study') {
                        $class = 'text-warning';
                      } elseif ($status->last() && $status->last()->status === 'New Student') {
                        $class = 'text-red';
                      } else {
                        $class = 'text-blue';
                      }
                    @endphp

                    <tr>
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="text-center">
                        {{ $data1->std->code ?? 'Null' }}
                      </td>
                      <td class="{{ $class }}">
                        {{ $data1->std->nick_name ?? 'Null' }}
                      </td>
                      <td>
                        {{ $data1->rec_school->submission_date ?? 'Null' }}
                      </td>
                      <td>{{ $data1->period ?? 'Null' }}</td>

                      <td>
                        {{ $data1->rec_school->receipt_number ?? 'Null' }}
                      </td>
                      <td class="text-center">
                        {{ $data1->group ?? 'Null' }}
                      </td>

                      <td class="{{ $class }} text-center">
                        @if (

                          $data1->std &&
                          $data1->std->status_log &&
                          $data1->std->status_log->count() > 0 &&
                          $status->last() &&
                          $status->last()->group == $data1->group                        )
                          {{ $status->last()->status ?? 'Null' }}
                        @else
                            null
                        @endif
                      </td>
                      <td class="text-center">
                        {{ $data1->course_type ?? 'Null' }}
                      </td>
                      <td class="text-end">
                        {{ number_format($data1->total) ?? 'Null' }} บาท
                      </td>
                      @php
                        $routeParameters = [
                          'student_id' => $data1->std->id ?? 'Null',
                          'receipt_school_id' => $data1->rec_school->id ?? 'Null',
                          'school_price_id' => $data1->id ?? 'Null',
                        ];
                        $routeUrl = htmlspecialchars_decode(route('saveCheck', $routeParameters));
                      @endphp

                      <td class="text-center" width="1%">
                        <div class="form-check form-switch form-switch-sm">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            id="flexSwitchCheckChecked-{{ $data1->id }}"
                            data-id="{{ $data1->id }}"
                            data-route="{{ $routeUrl }}"
                            data-token="{{ csrf_token() }}"
                            data-input="@json($routeParameters)"
                          />
                          <label
                            class="label-text"
                            id="label-check-{{ $data1->id }}"
                            for=""
                          >
                            Date:
                          </label>
                        </div>
                      </td>
                      <td id="note-{{ $data1->id }}"></td>

                      {{--
                        <td>
                        
                        </td>
                      --}}
                    </tr>
                    @php
                      $sum1 += $data1->total;
                      $subg += $data1->total;
                    @endphp

                    {{-- @endforeach --}}
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
                    <td class="text-center" colspan="8">Sum {{ $keyG }}</td>
                    <!-- Merged cell -->
                    <td class="text-end">
                      {{ number_format($subg) ?? 'Null' }} บาท
                    </td>
                    <td></td>
                  </tr>
                </tbody>
              @endforeach

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
                  <td class="text-center" colspan="8">Sum Total</td>
                  <!-- Merged cell -->
                  <td class="text-end">{{ number_format($sum1) }} บาท</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- END tab-pane -->
          <div class="tab-pane fade" id="default-tab-4">
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
          <!-- BEGIN tab-pane -->
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
  @php
    // dd($totalForAllGroupYear);
  @endphp

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
      let id;
      let isChecked;
      let checkbox;
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
        // console.log(id);
        var note2 = $('#note2').val();
        if (isChecked) {
          $.ajax({
            url: 'getDataRec/' + id,
            method: 'GET',
            success: function (res) {
              // console.log(res);
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
              _token: token
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
        if (!confirm('Are you sure?')) return;
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
            // console.log(response);
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

    function export_report() {
      url =
        '{{ route('reportYearStd', ['type' => 'print', 'tap' => '1', 'year' => $year]) }}';

      window.open(url.replace(/&amp;/g, '&'));
    }
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
    var groupLabels = [
        @foreach ($totalForAllMonths as $month => $total)

            '{{ $month }} ',
        @endforeach
    ];

    var groupLabels2 = [
        @foreach ($totalForAllMonths as $month => $total)
            @if (isset($percentageChangeForAllMonths[$month]))
                @if ($percentageChangeForAllMonths[$month] > 0)
                    'ปี {{ $month }} : {{ number_format($total, 2) }} \n+{{ $percentageChangeForAllMonths[$month] }}% ',
                @else
                    'ปี {{ $month }} : {{ number_format($total, 2) }} \n{{ $percentageChangeForAllMonths[$month] }}% ',
                @endif
            @else
                'ปี {{ $month }} : {{ number_format($total, 2) }}',
            @endif
        @endforeach
    ];

    var ctx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: groupLabels2,
            // label: groupLabels,
            datasets: [{
                label: 'ยอดรวมแต่ละปี',
                data: [
                    @foreach ($totalForAllMonths as $month => $total)
                        {{ $total }},
                    @endforeach
                ],
                pointBackgroundColor: 'rgba(52, 143, 226,.65)',
                borderColor: 'rgba(52, 143, 226,.65)',
                backgroundColor: 'rgba(52, 143, 226,.65)',
                pointText: {{ $total }},
                pointRadius: 4,
                borderWidth: 2,
                dataLabels: {
                    display: true,
                    color: 'black',
                    formatter: function(value) {
                        return value.y.toFixed(2);
                    },
                },

            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                // tooltip: {
                //     mode: 'index', // Display multiple tooltips at once
                //     intersect: true, // Don't intersect with other elements
                // },
                // title: {
                //     display: true,
                //     text: 'Chart Title',
                // },
                // legend: {
                //     display: true,
                //     position: 'top',
                // },
                datalabels: {
                    display: true,
                    color: 'black',
                    formatter: function(value) {
                        return value.y.toFixed(2);
                    },
                },
            },
            // animation: {
            //     duration: 2000, // Animation duration in milliseconds
            //     easing: 'easeInOutQuad', // Easing function
            // },

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

  {{-- 'ปี {{ $Year }} {{ $group }} {{ number_format($total, 2) }}', --}}

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
            @endphp {
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
@endsection
