@extends('layouts.main_template')

@section('style')
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
    @media screen and (max-width: 100px) {
      .screen-auto {
        max-width: 100%;
        height: auto;
      }
    }

    .screen-auto {
      max-width: 800;
      height: 200;
    }

    .line-contact-btn {
      position: fixed;
      bottom: 100px;
      right: 20px;
      background-color: #00b900;
      /* Line's green color */
      color: white;
      padding: 15px 20px;
      border-radius: 50px;
      text-align: center;
      font-size: 16px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
  </style>
@endsection

@section('content')
  <table
    style="width: 100%"
    id="Listview"
    hidden
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

          if (! isset($groupStatusCounts[$group])) {
            $groupStatusCounts[$group] = [];
          }
          if (! isset($groupStatusCounts[$group][$status])) {
            $groupStatusCounts[$group][$status] = 0;
          }
          if (! isset($groupStatusCounts[$group][$status_log_ids][$status])) {
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

        //ทำต่ออาทิตหน้า
        // dd($latestStatusCounts, $groupStatusCounts);
        // dd($latestStatusCounts, $groupStatusCounts);
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
          <td>
            {{ isset($statusCounts['New Student']) ? $statusCounts['New Student'] : 0 }}
            คน
          </td>
          <td>
            {{ isset($statusCounts['studying . . .']) ? $statusCounts['studying . . .'] : 0 }}
            คน
          </td>
          <td>
            {{ isset($statusCounts['Termination of study']) ? $statusCounts['Termination of study'] : 0 }}
            คน
          </td>
          <td>
            {{ isset($statusCounts['drop']) ? $statusCounts['drop'] : 0 }} คน
          </td>
          <td>
            {{ isset($statusCounts['resume']) ? $statusCounts['resume'] : 0 }}
            คน
          </td>
          <td>
            {{ isset($statusCounts['waitting . . .']) ? $statusCounts['waitting . . .'] : 0 }}
            คน
          </td>
          <td>
            {{ isset($statusCounts['None Receipt']) ? $statusCounts['None Receipt'] : 0 }}
            คน
          </td>
          <td>{{ now() }}</td>
          <!-- You can replace this with the actual date time if needed -->
        </tr>
        @php
          $totalNewStudents += isset($statusCounts['New Student']) ? $statusCounts['New Student'] : 0;
          $totalStudying += isset($statusCounts['studying . . .']) ? $statusCounts['studying . . .'] : 0;
          $totalTermination += isset($statusCounts['Termination of study']) ? $statusCounts['Termination of study'] : 0;
          $totalDrop += isset($statusCounts['drop']) ? $statusCounts['drop'] : 0;
          $totalResume += isset($statusCounts['resume']) ? $statusCounts['resume'] : 0;
          $totalWait += isset($statusCounts['waitting . . .']) ? $statusCounts['waitting . . .'] : 0;
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
        <td>{{ $totalWait }} คน</td>
        <td>{{ $totalNoneReceipt }} คน</td>
        <td>{{ now() }}</td>
      </tr>

      {{-- </tbody> --}}
    </tbody>
  </table>

  <div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
        <div class="page-title-icon">
          <i class="fa fa-home icon-gradient bg-happy-itmeo"></i>
        </div>
        <div>
          Back Office Dashboard
          <div class="page-title-subheading">META Knowledge Dashboard</div>
        </div>
      </div>

      {{--
        <div class="page-title-actions">
        <button type="button" data-bs-toggle="tooltip" title="Example Tooltip" data-bs-placement="bottom"
        class="btn-shadow me-3 btn btn-dark">
        <i class="fa fa-star"></i>
        </button>
        <div class="d-inline-block dropdown">
        <button type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        class="btn-shadow dropdown-toggle btn btn-info">
        <span class="btn-icon-wrapper pe-2 opacity-7">
        <i class="fa fa-business-time fa-w-20"></i>
        </span>
        Buttons
        </button>
        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
        <ul class="nav flex-column">
        <li class="nav-item">
        <a href="javascript:void(0);" class="nav-link">
        <i class="nav-link-icon lnr-inbox"></i>
        <span>
        Inbox
        </span>
        <div class="ms-auto badge rounded-pill bg-secondary">86</div>
        </a>
        </li>
        <li class="nav-item">
        <a href="javascript:void(0);" class="nav-link">
        <i class="nav-link-icon lnr-book"></i>
        <span>
        Book
        </span>
        <div class="ms-auto badge rounded-pill bg-danger">5</div>
        </a>
        </li>
        <li class="nav-item">
        <a href="javascript:void(0);" class="nav-link">
        <i class="nav-link-icon lnr-picture"></i>
        <span>
        Picture
        </span>
        </a>
        </li>
        <li class="nav-item">
        <a disabled href="javascript:void(0);" class="nav-link disabled">
        <i class="nav-link-icon lnr-file-empty"></i>
        <span>
        File Disabled
        </span>
        </a>
        </li>
        </ul>
        </div>
        </div>
        </div>
      --}}
    </div>
  </div>
  @if (auth()->user()->id == 16)
    <div class="d-flex justify-content-end mb-3">
      <a href="{{ route('updateStudentStatus') }}" class="btn btn-success">
        update status student
      </a>
    </div>
  @endif

  <div class="row">
    <div class="col-md-12 col-lg-6">
      <div class="card mb-3">
        <div class="card-header-tab card-header-tab-animation card-header">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            Current Month Report
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
    <div class="col-md-12 col-lg-6">
      <div class="card mb-3">
        <div class="card-header-tab card-header-tab-animation card-header">
          <div class="card-header-title">
            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
            Current Month Report
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

  <div class="row">
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-premium-dark mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Total Student</div>
            <div class="widget-subheading">{{ date('Y-m-d') }}</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-warning">
              <span>
                {{ $totalResume + $totalStudying + $totalNewStudents }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-happy-green mb-3">
        {{-- <div class="card mb-3 widget-content bg-midnight-bloom"> --}}
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Total New Students</div>
            <div class="widget-subheading">{{ date('Y-m-d') }}</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-white">
              <span>{{ $totalNewStudents }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-grow-early mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Total Studing</div>
            <div class="widget-subheading">{{ date('Y-m-d') }}</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-white">
              <span>{{ $totalStudying }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-arielle-smile mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Total Resume</div>
            <div class="widget-subheading">{{ date('Y-m-d') }}</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-white">
              <span>{{ $totalResume }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-warning mb-3">
        <div class="widget-content-wrapper text-dark">
          <div class="widget-content-left">
            <div class="widget-heading">Total Termination</div>
            <div class="widget-subheading">{{ date('Y-m-d') }}</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-dark">
              <span>{{ $totalTermination }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="card widget-content bg-danger mb-3">
        <div class="widget-content-wrapper text-white">
          <div class="widget-content-left">
            <div class="widget-heading">Total Drop</div>
            <div class="widget-subheading">{{ date('Y-m-d') }}</div>
          </div>
          <div class="widget-content-right">
            <div class="widget-numbers text-white">
              <span>{{ $totalDrop }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{--
      <div class="col-lg-6 col-xl-4">
      <div class="card mb-3 widget-content bg-happy-green">
      <div class="widget-content-wrapper text-white">
      <div class="widget-content-left">
      <div class="widget-heading">Followers</div>
      <div class="widget-subheading">People Interested</div>
      </div>
      <div class="widget-content-right">
      <div class="widget-numbers text-dark"><span>46%</span></div>
      </div>
      </div>
      </div>
      </div>
    --}}
    {{--
      <div class="col-lg-6 col-xl-4">
      <div class="card mb-3 widget-content bg-night-fade">
      <div class="widget-content-wrapper text-white">
      <div class="widget-content-left">
      <div class="widget-heading">Followers</div>
      <div class="widget-subheading">People Interested</div>
      </div>
      <div class="widget-content-right">
      <div class="widget-numbers text-dark"><span>46%</span></div>
      </div>
      </div>
      </div>
      </div>
    --}}

    {{--
      <div class="col-md-6 col-xl-3">
      <div class="card mb-3 widget-content bg-arielle-smile">
      <div class="widget-content-wrapper text-white">
      <div class="widget-content-left">
      <div class="widget-heading">Total Resume</div>
      <div class="widget-subheading">{{ date('Y-m-d') }}</div>
      </div>
      <div class="widget-content-right">
      <div class="widget-numbers text-white"><span>{{ $totalResume }}</span></div>
      </div>
      </div>
      </div>
      </div>
      <div class="col-md-6 col-xl-3">
      <div class="card mb-3 widget-content bg-premium-dark">
      <div class="widget-content-wrapper text-white">
      <div class="widget-content-left">
      <div class="widget-heading">Total Student</div>
      <div class="widget-subheading">{{ date('Y-m-d') }}</div>
      </div>
      <div class="widget-content-right">
      <div class="widget-numbers text-warning">
      <span>{{ $totalResume + $totalStudying + $totalNewStudents }}</span></div>
      </div>
      </div>
      </div>
      </div>
    --}}
  </div>

  {{--
    <div class="main-card mb-3 card">
    <div class="g-0 row">
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-success">English</div>
    
    <div class="widget-subheading">Total</div>
    </div>
    <div class="widget-content-right">
    @php
    // dd($groupStatusCounts);
    $routeParameters = [
    'paraCheck' => 'all',
    'group' => 'E',
    'resume' => isset($groupStatusCounts['E']['ids']['resume']) ? $groupStatusCounts['E']['ids']['resume'] : '',
    'New Student' => isset($groupStatusCounts['E']['ids']['New Student']) ? $groupStatusCounts['E']['ids']['New Student'] : '',
    'studying . . .' => isset($groupStatusCounts['E']['ids']['studying . . .']) ? $groupStatusCounts['E']['ids']['studying . . .'] : '',
    'ids' => [],
    ];
    
    if (isset($groupStatusCounts['E']['ids']['resume'])) {
    $routeParameters['ids'][] = $groupStatusCounts['E']['ids']['resume'];
    }
    
    if (isset($groupStatusCounts['E']['ids']['New Student'])) {
    $routeParameters['ids'][] = $groupStatusCounts['E']['ids']['New Student'];
    }
    
    if (isset($groupStatusCounts['E']['ids']['studying . . .'])) {
    $routeParameters['ids'][] = $groupStatusCounts['E']['ids']['studying . . .'];
    }
    $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
    
    // dd($groupStatusCounts,$routeParameters);
    @endphp
    
    <div class="widget-heading">
    <a class="text-dark"
    href="{{ route('searchTestLog', ['id' => $routeParameters]) }}">
    {{ (isset($groupStatusCounts['E']['New Student']) ? $groupStatusCounts['E']['New Student'] : 0) +
    (isset($groupStatusCounts['E']['studying . . .']) ? $groupStatusCounts['E']['studying . . .'] : 0) +
    (isset($groupStatusCounts['E']['resume']) ? $groupStatusCounts['E']['resume'] : 0) }}
    
    </a>
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-primary"> Math</div>
    
    <div class="widget-subheading">Total</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-heading">
    {{ (isset($groupStatusCounts['M']['New Student']) ? $groupStatusCounts['M']['New Student'] : 0) +
    (isset($groupStatusCounts['M']['studying . . .']) ? $groupStatusCounts['M']['studying . . .'] : 0) +
    (isset($groupStatusCounts['M']['resume']) ? $groupStatusCounts['M']['resume'] : 0) }}
    </div>
    
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">New Student</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-success">
    {{ isset($groupStatusCounts['E']['New Student']) ? $groupStatusCounts['E']['New Student'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">New Student</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-primary">
    {{ isset($groupStatusCounts['M']['New Student']) ? $groupStatusCounts['M']['New Student'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">Studying</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-success">
    {{ isset($groupStatusCounts['E']['studying . . .']) ? $groupStatusCounts['E']['studying . . .'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">Studying</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-primary">
    {{ isset($groupStatusCounts['M']['studying . . .']) ? $groupStatusCounts['M']['studying . . .'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Termination of study</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-warning">
    {{ isset($groupStatusCounts['E']['Termination of study']) ? $groupStatusCounts['E']['Termination of study'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Termination of study</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-warning">
    {{ isset($groupStatusCounts['M']['Termination of study']) ? $groupStatusCounts['M']['Termination of study'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Drop</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-danger">
    {{ isset($groupStatusCounts['E']['drop']) ? $groupStatusCounts['E']['drop'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Drop</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-danger">
    {{ isset($groupStatusCounts['M']['drop']) ? $groupStatusCounts['M']['drop'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Resume</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-success">
    {{ isset($groupStatusCounts['E']['resume']) ? $groupStatusCounts['E']['resume'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Resume</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-primary">
    {{ isset($groupStatusCounts['M']['resume']) ? $groupStatusCounts['M']['resume'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    
    </div>
    </div>
  --}}

  {{--
    <div class="main-card mb-3 card">
    <div class="g-0 row">
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-indigo">Science</div>
    
    <div class="widget-subheading">Total</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-heading">
    {{ (isset($groupStatusCounts['Sci']['New Student']) ? $groupStatusCounts['Sci']['New Student'] : 0) +
    (isset($groupStatusCounts['Sci']['studying . . .']) ? $groupStatusCounts['Sci']['studying . . .'] : 0) +
    (isset($groupStatusCounts['Sci']['resume']) ? $groupStatusCounts['Sci']['resume'] : 0) }}
    </div>
    
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-warning"> Chinese</div>
    
    <div class="widget-subheading">Total</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-heading">
    {{ (isset($groupStatusCounts['CHN']['New Student']) ? $groupStatusCounts['CHN']['New Student'] : 0) +
    (isset($groupStatusCounts['CHN']['studying . . .']) ? $groupStatusCounts['CHN']['studying . . .'] : 0) +
    (isset($groupStatusCounts['CHN']['resume']) ? $groupStatusCounts['CHN']['resume'] : 0) }}
    </div>
    
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">New Student</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-success">
    {{ isset($groupStatusCounts['Sci']['New Student']) ? $groupStatusCounts['Sci']['New Student'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">New Student</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-primary">
    {{ isset($groupStatusCounts['CHN']['New Student']) ? $groupStatusCounts['CHN']['New Student'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">Studying</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-success">
    {{ isset($groupStatusCounts['Sci']['studying . . .']) ? $groupStatusCounts['Sci']['studying . . .'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading">Studying</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-primary">
    {{ isset($groupStatusCounts['CHN']['studying . . .']) ? $groupStatusCounts['CHN']['studying . . .'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Termination of study</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-warning">
    {{ isset($groupStatusCounts['Sci']['Termination of study']) ? $groupStatusCounts['Sci']['Termination of study'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Termination of study</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-warning">
    {{ isset($groupStatusCounts['CHN']['Termination of study']) ? $groupStatusCounts['CHN']['Termination of study'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Drop</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-danger">
    {{ isset($groupStatusCounts['Sci']['drop']) ? $groupStatusCounts['Sci']['drop'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Drop</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-danger">
    {{ isset($groupStatusCounts['CHN']['drop']) ? $groupStatusCounts['CHN']['drop'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-md-2">
    <div class="pt-0 pb-0 card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Resume</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-success">
    {{ isset($groupStatusCounts['Sci']['resume']) ? $groupStatusCounts['Sci']['resume'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="widget-content p-0">
    <div class="widget-content-outer">
    <div class="widget-content-wrapper">
    <div class="widget-content-left">
    <div class="widget-heading text-nowrap">Resume</div>
    <div class="widget-subheading">{{ date('Y-m-d') }}</div>
    </div>
    <div class="widget-content-right">
    <div class="widget-numbers text-primary">
    {{ isset($groupStatusCounts['CHN']['resume']) ? $groupStatusCounts['CHN']['resume'] : 0 }}
    </div>
    </div>
    </div>
    </div>
    </div>
    </li>
    </ul>
    </div>
    </div>
    
    </div>
    </div>
  --}}
  <!-- chn & sci -->
  <div class="main-card card mb-3">
    <div class="g-0 row">
      @php
        $count_group = count($groupStatusCounts);
        $line = '<li class="list-group-item"> </li>';
        // dd($groupStatusCounts);
      @endphp

      @foreach ($groupStatusCounts as $group => $groupData)
        @if ($group != 'N')
          @php
            if ($group === 'E') {
              $text_group = 'English';
              $class = 'success';
            } elseif ($group === 'M') {
              $text_group = 'Math';
              $class = 'primary';
            } else {
              if ($group === 'CHN') {
                $class = 'warning';
                $text_group = 'Chinese';
              } else {
                $class = 'indigo';
                $text_group = 'Science';
              }
            }
          @endphp

          <div class="col-md-2">
            <div class="card-body pt-0 pb-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="widget-content p-0">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-heading text-{{ $class }}">
                            {{ $text_group }}
                          </div>

                          <div class="widget-subheading">Total</div>
                        </div>

                        @php
                          // dd($groupData);
                          $routeParameters = [
                            'type' => 'view',
                            'paraCheck' => 'all',
                            'group' => $group,
                            'resume' => isset($groupData['ids']['resume']) ? $groupData['ids']['resume'] : '',
                            'New Student' => isset($groupData['ids']['New Student']) ? $groupData['ids']['New Student'] : '',
                            'studying . . .' => isset($groupData['ids']['studying . . .']) ? $groupData['ids']['studying . . .'] : '',
                            'ids' => [],
                          ];
                          if (isset($groupData['ids']['resume'])) {
                            $routeParameters['ids'][] = $groupData['ids']['resume'];
                          }

                          if (isset($groupData['ids']['New Student'])) {
                            $routeParameters['ids'][] = $groupData['ids']['New Student'];
                          }

                          if (isset($groupData['ids']['studying . . .'])) {
                            $routeParameters['ids'][] = $groupData['ids']['studying . . .'];
                          }
                          $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                          // dd($groupData, $routeParameters);
                        @endphp

                        <div class="widget-content-right">
                          <div class="widget-heading">
                            {{--
                              {{ (isset($groupData['resume']) ? $groupData['resume'] : 0) +
                              (isset($groupData['studying . . .']) ? $groupData['studying . . .'] : 0) +
                              (isset($groupData['New Student']) ? $groupData['New Student'] : 0) }}
                            --}}
                            <a
                              class="text-dark"
                              href="{{ route('searchTestLog', $routeParameters) }}"
                            >
                              {{
                                (isset($groupData['New Student']) ? $groupData['New Student'] : 0) +
                                  (isset($groupData['studying . . .']) ? $groupData['studying . . .'] : 0) +
                                  (isset($groupData['resume']) ? $groupData['resume'] : 0)
                              }}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                @if ($count_group > 1)
                  {!! $line !!}
                @endif
              </ul>
            </div>
          </div>
          <div class="col-md-2">
            <div class="card-body pt-0 pb-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="widget-content p-0">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-heading">New Student</div>
                          <div class="widget-subheading">
                            {{ date('Y-m-d') }}
                          </div>
                        </div>

                        @php
                          // dd($groupData);
                          $routeParameters = [
                            'type' => 'view',
                            'paraCheck' => 'New Student',
                            'group' => $group,
                            // 'resume' => isset($groupData['ids']['resume']) ? $groupData['ids']['resume'] : '',
                            'New Student' => isset($groupData['ids']['New Student']) ? $groupData['ids']['New Student'] : '',
                            // 'studying . . .' => isset($groupData['ids']['studying . . .']) ? $groupData['ids']['studying . . .'] : '',
                            'ids' => [],
                          ];
                          // if (isset($groupData['ids']['resume'])) {
                          //     $routeParameters['ids'][]= $groupData['ids']['resume'];
                          // }

                          if (isset($groupData['ids']['New Student'])) {
                            $routeParameters['ids'][] = $groupData['ids']['New Student'];
                          }

                          // if (isset($groupData['ids']['studying . . .'])) {
                          //     $routeParameters['ids'][] = $groupData['ids']['studying . . .'];
                          // }
                          $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                          // dd($groupData, $routeParameters);
                        @endphp

                        <div class="widget-content-right">
                          <div class="widget-heading">
                            {{--
                              {{ (isset($groupData['resume']) ? $groupData['resume'] : 0) +
                              (isset($groupData['studying . . .']) ? $groupData['studying . . .'] : 0) +
                              (isset($groupData['New Student']) ? $groupData['New Student'] : 0) }}
                            --}}
                            <a
                              class="text-success"
                              href="{{ route('searchTestLog', $routeParameters) }}"
                            >
                              {{ isset($groupData['New Student']) ? $groupData['New Student'] : 0 }}
                            </a>
                          </div>
                        </div>

                        {{--
                          <div class="widget-content-right">
                          <div class="widget-numbers text-success">
                          {{ isset($groupData['New Student']) ? $groupData['New Student'] : 0 }}
                          </div>
                          </div>
                        --}}
                      </div>
                    </div>
                  </div>
                </li>
                @if ($count_group > 1)
                  {!! $line !!}
                @endif
              </ul>
            </div>
          </div>
          <div class="col-md-2">
            <div class="card-body pt-0 pb-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="widget-content p-0">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-heading">Studying</div>
                          <div class="widget-subheading">
                            {{ date('Y-m-d') }}
                          </div>
                        </div>

                        @php
                          $routeParameters = [
                            'type' => 'view',
                            'paraCheck' => 'studying',
                            'group' => $group,
                            'studying . . .' => isset($groupData['ids']['studying . . .']) ? $groupData['ids']['studying . . .'] : '',
                            'ids' => [],
                          ];
                          if (isset($groupData['ids']['studying . . .'])) {
                            $routeParameters['ids'][] = $groupData['ids']['studying . . .'];
                          }
                          $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                        @endphp

                        <div class="widget-content-right">
                          <div class="widget-heading">
                            <a
                              class="text-success"
                              href="{{ route('searchTestLog', $routeParameters) }}"
                            >
                              {{ isset($groupData['studying . . .']) ? $groupData['studying . . .'] : 0 }}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                @if ($count_group > 1)
                  {!! $line !!}
                @endif
              </ul>
            </div>
          </div>
          <div class="col-md-2">
            <div class="card-body pt-0 pb-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="widget-content p-0">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-heading text-nowrap">
                            Termination of study
                          </div>
                          <div class="widget-subheading">
                            {{ date('Y-m-d') }}
                          </div>
                        </div>

                        @php
                          $routeParameters = [
                            'type' => 'view',
                            'paraCheck' => 'Termination of study',
                            'group' => $group,
                            'Termination of study' => isset($groupData['ids']['Termination of study'])
                              ? $groupData['ids']['Termination of study']
                              : '',
                            'ids' => [],
                          ];
                          if (isset($groupData['ids']['Termination of study'])) {
                            $routeParameters['ids'][] = $groupData['ids']['Termination of study'];
                          }
                          $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                        @endphp

                        <div class="widget-content-right">
                          <div class="widget-heading">
                            <a
                              class="text-warning"
                              href="{{ route('searchTestLog', $routeParameters) }}"
                            >
                              {{ isset($groupData['Termination of study']) ? $groupData['Termination of study'] : 0 }}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                @if ($count_group > 1)
                  {!! $line !!}
                @endif
              </ul>
            </div>
          </div>
          <div class="col-md-2">
            <div class="card-body pt-0 pb-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="widget-content p-0">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-heading text-nowrap">Drop</div>
                          <div class="widget-subheading">
                            {{ date('Y-m-d') }}
                          </div>
                        </div>
                        @php
                          $routeParameters = [
                            'type' => 'view',
                            'paraCheck' => 'drop',
                            'group' => $group,
                            'drop' => isset($groupData['ids']['drop']) ? $groupData['ids']['drop'] : '',
                            'ids' => [],
                          ];
                          if (isset($groupData['ids']['drop'])) {
                            $routeParameters['ids'][] = $groupData['ids']['drop'];
                          }
                          $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                        @endphp

                        <div class="widget-content-right">
                          <div class="widget-heading">
                            <a
                              class="text-danger"
                              href="{{ route('searchTestLog', $routeParameters) }}"
                            >
                              {{ isset($groupData['drop']) ? $groupData['drop'] : 0 }}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                @if ($count_group > 1)
                  {!! $line !!}
                @endif
              </ul>
            </div>
          </div>
          <div class="col-md-2">
            <div class="card-body pt-0 pb-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="widget-content p-0">
                    <div class="widget-content-outer">
                      <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                          <div class="widget-heading text-nowrap">Resume</div>
                          <div class="widget-subheading">
                            {{ date('Y-m-d') }}
                          </div>
                        </div>

                        @php
                          $routeParameters = [
                            'type' => 'view',
                            'paraCheck' => 'resume',
                            'group' => $group,
                            'resume' => isset($groupData['ids']['resume']) ? $groupData['ids']['resume'] : '',
                            'ids' => [],
                          ];
                          if (isset($groupData['ids']['resume'])) {
                            $routeParameters['ids'][] = $groupData['ids']['resume'];
                          }
                          $routeParameters['ids'] = array_unique(array_merge(...$routeParameters['ids']));
                        @endphp

                        <div class="widget-content-right">
                          <div class="widget-heading">
                            <a
                              class="text-success"
                              href="{{ route('searchTestLog', $routeParameters) }}"
                            >
                              {{ isset($groupData['resume']) ? $groupData['resume'] : 0 }}
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                @if ($count_group > 1)
                  {!! $line !!}
                @endif
              </ul>
            </div>
          </div>
        @endif

        @php
          $count_group--;
        @endphp
      @endforeach
    </div>
  </div>
  {{--
    @php
    dd($count_group);
    @endphp
  --}}
  {{--
    @foreach ($groupStatusCounts as $group => $groupData)
    @if ($group != 'N')
    <h2>{{ $group }}</h2>
    <ul>
    <li>Resume: {{ $groupData['resume'] ?? 'N/A' }}</li>
    <li>New Student: {{ $groupData['New Student'] ?? 'N/A' }}</li>
    <li>Studying: {{ $groupData['studying . . .'] ?? 'N/A' }}</li>
    <!-- Add more items as needed -->
    </ul>
    @endif
    @endforeach
  --}}
  @php
    // dd(request('ref'));
    $ref = 'uaLPxKcg9Y';
    $url = url()->full();
  @endphp
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  {{-- <script src="https://d3js.org/d3.v7.min.js"></script> --}}
  <script src="../assets/plugins/d3/d3.min.js"></script>
  <script src="../assets/plugins/nvd3/build/nv.d3.min.js"></script>
  <script src="../assets/plugins/chart.js/dist/chart.min.js"></script>
  {{-- <script src="{{ asset('assets/plugins/chart.js/dist/chart.min.js') }}"></script> --}}
  <script src="../assets/plugins/flot/source/jquery.canvaswrapper.js"></script>
  <script src="../assets/plugins/flot/source/jquery.colorhelpers.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.saturated.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.browser.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.drawSeries.js"></script>
  <script src="../assets/plugins/flot/source/jquery.flot.uiConstants.js"></script>

  <script>
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
    var groupLabels = ['New Student', 'Studying', 'Termination of study', 'Drop', 'Resume', 'Waitting'];
    var data = [
        @foreach ($groupStatusCounts as $group => $statusCounts)
            @if ($group !== 'N')

                {
                    label: '{{ $group }}',
                    data: [
                        {{ isset($statusCounts['New Student']) ? $statusCounts['New Student'] : 0 }},
                        {{ isset($statusCounts['studying . . .']) ? $statusCounts['studying . . .'] : 0 }},
                        {{ isset($statusCounts['Termination of study']) ? $statusCounts['Termination of study'] : 0 }},
                        {{ isset($statusCounts['drop']) ? $statusCounts['drop'] : 0 }},
                        {{ isset($statusCounts['resume']) ? $statusCounts['resume'] : 0 }},
                        {{ isset($statusCounts['waitting . . .']) ? $statusCounts['waitting . . .'] : 0 }},

                        // {{ isset($statusCounts['None Receipt']) ? $statusCounts['None Receipt'] : 0 }},
                    ]
                },
            @endif
        @endforeach
    ];
    // var ran2 = Math.floor(Math.random() * 255);
    // var ran3 = Math.floor(Math.random() * 255);
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
        'rgba(251, 85, 151,.65)',

    ];
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: groupLabels,
            datasets: data.map(function(item, index) {
                // var ran1 = Math.floor(Math.random() * 255);
                // var randomColor = 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 1)';
                // var groupColors = {
                //     'M': 'rgba(52, 143, 226,.65)',
                //     'E': 'rgba(0, 172, 172,.65)',
                //     // 'N': 'rgba(255, 99, 132,.65)' // Add more colors if needed
                // };
                // var grouplabels = {
                //     'M': 'Math',
                //     'E': 'English',
                //     // 'N': 'None' // Add more colors if needed
                // };
                return {
                    label: item.label,
                    // label: grouplabels[item.label],
                    data: item.data,

                    // pointBackgroundColor: groupColors[item.label],
                    // borderColor: groupColors[item.label],
                    // backgroundColor: groupColors[item.label],
                    pointBackgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length],
                    pointRadius: 4,
                    borderWidth: 2,
                    // fill: false
                }
            })
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

  <script>
    var groupLabels = ['New Student', 'Studying', 'Termination of study', 'Drop', 'Resume', 'Waitting'];
    var data = [
        @foreach ($groupStatusCounts as $group => $statusCounts)
            @if ($group !== 'N')

                {
                    label: '{{ $group }}',
                    data: [
                        {{ isset($statusCounts['New Student']) ? $statusCounts['New Student'] : 0 }},
                        {{ isset($statusCounts['studying . . .']) ? $statusCounts['studying . . .'] : 0 }},
                        {{ isset($statusCounts['Termination of study']) ? $statusCounts['Termination of study'] : 0 }},
                        {{ isset($statusCounts['drop']) ? $statusCounts['drop'] : 0 }},
                        {{ isset($statusCounts['resume']) ? $statusCounts['resume'] : 0 }},
                        {{ isset($statusCounts['waitting . . .']) ? $statusCounts['waitting . . .'] : 0 }},

                        // {{ isset($statusCounts['None Receipt']) ? $statusCounts['None Receipt'] : 0 }},
                    ]
                },
            @endif
        @endforeach
    ];

    var ctx = document.getElementById('barChart').getContext('2d');
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
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: groupLabels,
            datasets: data.map(function(item, index) {
                // var groupColors = {
                //     'M': 'rgba(52, 143, 226,.65)',
                //     'E': 'rgba(0, 172, 172,.65)',
                //     'N': 'rgba(255, 99, 132,.65)' // Add more colors if needed
                // };
                // var grouplabels = {
                //     'M': 'Math',
                //     'E': 'English',
                //     'N': 'None' // Add more colors if needed
                // };
                return {
                    label: item.label,
                    // label: grouplabels[item.label],
                    data: item.data,

                    // pointBackgroundColor: groupColors[item.label],
                    // borderColor: groupColors[item.label],
                    // backgroundColor: groupColors[item.label],
                    pointBackgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length],
                    backgroundColor: colors[index % colors.length],
                    pointRadius: 4,
                    borderWidth: 2,
                }
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
