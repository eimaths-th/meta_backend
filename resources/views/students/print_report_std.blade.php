@extends('layouts.print_temp')

@section('style')
  <style>
    @media print {
      @page {
        size: landscape;
      }
    }
  </style>
@endsection

@section('content')
  <div class="row">
    <div class="main-card card mb-3" id="x_content">
      <div class="card-header-tab card-header-tab-animation card-header">
        <div class="card-header-title">
          <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"></i>
          RESULT STUDENT {{ $monthf }} - {{ $year }}
        </div>
      </div>
      <div class="card-body">
        {{--
          <div class="col-lg-12 mb-3 text-end">
          <a href="#" onclick="export_report();" class="btn btn-success ">Print</a>
          
          </div>
        --}}
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

                if (! isset($groupStatusCounts[$group])) {
                  $groupStatusCounts[$group] = [];
                }
                if (! isset($groupStatusCounts[$group][$status])) {
                  $groupStatusCounts[$group][$status] = 0;
                }
                $groupStatusCounts[$group][$status]++;
              }
              $totalNewStudents = 0;
              $totalStudying = 0;
              $totalTermination = 0;
              $totalDrop = 0;
              $totalResume = 0;
              $totalWait = 0;
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
                  @else
                    {{ $group }}
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
                  {{ isset($statusCounts['drop']) ? $statusCounts['drop'] : 0 }}
                  คน
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
                  {{
                    (isset($statusCounts['New Student']) ? $statusCounts['New Student'] : 0) +
                      (isset($statusCounts['studying . . .']) ? $statusCounts['studying . . .'] : 0) +
                      (isset($statusCounts['resume']) ? $statusCounts['resume'] : 0)
                  }}
                  คน
                </td>
                <td>
                  {{ isset($statusCounts['None Receipt']) ? $statusCounts['None Receipt'] : 0 }}
                  คน
                </td>

                <td>{{ now() }}</td>
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
              <td>
                <b>
                  {{ $totalNewStudents + $totalStudying + $totalResume }} คน
                </b>
              </td>
              <td>{{ $totalNoneReceipt }} คน</td>
              <td>{{ now() }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('script')
  
@endsection
