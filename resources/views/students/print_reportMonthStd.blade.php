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

        {{-- <div class="app-page-title">
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
        </div> --}}
        {{-- <div class="main-card mb-3 card"> --}}
        {{-- <div class="card-body"> --}}
        <div class="row mb-3">
            <div class="col-lg-6">
                <div class="card-header-tab card-header-tab-animation card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                        All Month Report
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
                        <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                        All Month Report
                    </div>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <canvas id="lineChart" {{-- width="800" height="200" --}}></canvas>

                    </div>
                </div>
            </div>
        </div>
        {{-- </div> --}}

        {{-- </div> --}}



        <table style="width: 100%;" id="Listview"
            class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action my-5">

            <thead>
                <tr>
                    <th class="text-center text-black" colspan="8">ตารางค่าสมัครเรียนเดือน  {{ thaidate('F', $month) }}  {{ $year }}</th> <!-- Merged cell -->
                </tr>
                <tr>
                    <th width='1%' class="text-center">no.</th>
                    <th width='1%'>Code</th>
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

                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">{{ $data->std->code ?? 'Null' }}</td>
                            <td class="{{ $class }}">{{ $data->std->nick_name ?? 'Null' }}</td>
                            <td>{{ $data->rec_school->submission_date }}</td>
                            <td>{{ $data->period }}</td>
                            <td>{{ $data->rec_school->receipt_number }}</td>
                            <td>{{ $data->group }}</td>
                            <td class="text-end">{{ number_format($data->total) }} บาท</td>

                            {{-- <td class="{{ $class }}">
                                        {{ $statusValue }}
                                    </td> --}}
                            {{-- <td>{{ $data->course_type }}</td> --}}
                            {{-- <td class="text-end">{{ number_format($data->total) }} บาท</td> --}}
                            {{-- <td class="text-end"><input type="checkbox" id="switchery-default" checked /></td> --}}
                            {{-- <td class="text-center">
                                        <input type="checkbox" class="switchery-small" id="switchery-default-{{ $loop->index }}" checked />
                                        <div class="form-check form-switch form-switch-sm">
                                            <input class="form-check-input" type="checkbox"
                                                id="flexSwitchCheckChecked-{{ $data->rec_school->receipt_number }}">
                                        </div>
                                    </td> --}}

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
                    <td class="text-center text-black" colspan="6">Sum Total</td> <!-- Merged cell -->
                    <td class="text-end">{{ number_format($sum) }} บาท</td>
                </tr>
            </tfoot>

        </table>


    </div>
@endsection

@section('script')
    {{-- <script>
        var checkboxes = document.querySelectorAll('input[id^="switchery-default-"]');
        checkboxes.forEach(function(checkbox) {
            var switchery = new Switchery(checkbox, {
                color: '#00acac'
            });
        });
    </script> --}}

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
        //
    </script> {{-- // line-grafh --}}


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
    </script> {{-- //bar-grafh --}}
    {{-- <script>
        function printrep() {
            window.print();
        }
        printrep();
        setTimeout(function() {
            window.close();
        }, 4000);
    </script> --}}
@endsection
