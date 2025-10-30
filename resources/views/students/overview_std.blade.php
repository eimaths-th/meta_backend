@extends('layouts.main_template')

@section('style')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                    <div>Students
                        <div class="page-title-subheading">META Knowledge Student Data</div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        {{-- <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg" id="ImportButton"><i
                                class="fa fa-file-excel"></i> Import Excel
                        </a>
                        <a class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"
                            id="CreateButton"><i class="fa fa-plus"></i> Create New
                            Student</a>
                        <a class="btn btn-danger delete_all_button" href="#"><i class="fa fa-trash"></i> Delete
                            All</a> --}}

                    </div>
                </div>
            </div>
        </div>
        @php
            use Carbon\Carbon;
            use App\Models\History;
            use App\Models\StudentBonus;

            // $all = 0;
            // $remain = 0;
            $qty1 = [];
            $bonus = 0;
            $processedIds = [];
            $reset_id = [];
            $his_time_out = [];
            $historyTimeOut_id = [];

            $current_Month = date('Y-m');
            // $currentMonth = Carbon::createFromFormat('Y-m','2023-10');
            $currentMonth = Carbon::createFromFormat('Y-m', $current_Month);
            // $currentReceiptEndDate = Carbon::createFromFormat('Y-m', '2023-9');
            // dd($currentMonth);
            $currentReceiptEndDate = Carbon::parse($end_date);
        @endphp
        <div class="main-card mb-3 card " id="x_content">
            <div class="card-body">
                <form action="" name="" id="">
                    @if ($startcourse == null)
                        <h5 class="text-danger"> ไม่พบใบเสร็จ</h5>
                        <h5>code : {{ $std->code }} | NickName : {{ $std->nick_name }}</h5>
                        <h5>Student Name : {{ $std->full_name }}</h5>
                    @else
                        @php
                            if ($std->status == 'กำลังยุติการการเรียน') {
                                $class = 'warning';
                            } elseif ($std->status == 'พ้นสภาพนักเรียน') {
                                $class = 'danger';
                            } else {
                                $class = 'success';
                            }
                        @endphp
                        <h5>
                            {{-- <span class="text-{{ $class }}">{{ $std->status }}</span> --}}
                            สิ้นสุดที่ {{ $end_date }}
                        </h5>
                        <h5>code : {{ $std->code }} | NickName : {{ $std->nick_name }}
                        </h5>
                        <h5>Student Name : {{ $std->full_name }}</h5>
                    @endif

                    <table style="width: 100%;" id="Listview"
                        class="table table-striped table-hover table-bordered responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th>Suject Name</th>
                                <th>date</th>
                                <th>Month</th>
                                <th>Prefer</th>
                                <th>Bonus</th>
                                <th>All</th>
                                <th>History</th>
                                <th>Per Time</th>
                                <th>Result</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if ($currentMonth->diffInMonths($currentReceiptEndDate) > 1 && $currentMonth->greaterThan($currentReceiptEndDate))
                                @foreach ($school_pice as $reset)
                                    @php
                                        $reset_id[] = $reset->id;
                                    @endphp
                                @endforeach
                            @else --}}
                            @foreach ($school_pice_group as $school_pice)
                                @php
                                    // dd($school_pice_group);
                                    $result_month = 0;
                                    $result_all = 0;
                                    $result_bonus = 0;
                                    $result_his = 0;
                                    $result_remain = 0;
                                    $result_prefer = 0;
                                    $all = 0;
                                    $remain = 0;
                                    $count_rec = 0;
                                    $monthsDifference = 0;
                                    $count_loop = $school_pice->count();
                                    // $count_id =
                                    $count_time_out = 0;

                                @endphp
                                @foreach ($school_pice as $school_pices)
                                    @php
                                        $count_loop--;
                                    @endphp
                                    @if (in_array($school_pices->id, $reset_id))
                                    @else
                                        @php
                                            $period = explode(' - ', $school_pices->period);

                                            $course = 0;
                                            $qty = null;
                                            $num_month = null;
                                            $prefer = 0;
                                            $school = $school_pices->qty;
                                            $sub_ids = $school_pices->subject;

                                            if (count($period) == 1) {
                                                $periods = explode('-', $school_pices->period);

                                                $startMonth = Carbon::parse("$periods[0]-$periods[1]")->format('Y-m');
                                                $endMonth = count($periods) > 2 ? Carbon::parse("$periods[2]-$periods[3]")->format('Y-m') : $startMonth;

                                                if ($count_rec > 0) {
                                                    $monthsDifference = Carbon::parse($firstEndMonth)->diffInMonths(Carbon::parse($startMonth));

                                                    $endMonth = count($periods) > 2 ? Carbon::parse("$periods[2]-$periods[3]")->format('Y-m') : $startMonth;
                                                }
                                                $firstEndMonth = $endMonth;
                                                $count_rec++;
                                            } else {
                                                $startMonth = Carbon::parse($period[0])->format('Y-m');
                                                $endMonth = Carbon::parse($period[1])->format('Y-m');

                                                if ($count_rec > 0) {
                                                    $monthsDifference = Carbon::parse($firstEndMonth)->diffInMonths(Carbon::parse($startMonth));
                                                    $endMonth = Carbon::parse($period[1])->format('Y-m');
                                                }
                                                $firstEndMonth = $endMonth;
                                                $count_rec++;
                                            }

                                            $history = $histories->where('student_id', $std->id)->where('subject_id', $sub_ids);
                                            $currecntMonth_Year = date('Y-m-d');
                                            $startMonthYMD = Carbon::parse($startMonth)->format('Y-m');

                                            if ($monthsDifference > 1) {
                                                $result_month = 0;
                                                $result_all = 0;
                                                $result_bonus = 0;
                                                $result_his = 0;
                                                $result_remain = 0;
                                                $result_prefer = 0;
                                                $all = 0;
                                                $remain = 0;
                                            }
                                            $stdate = explode('-', $startMonthYMD);
                                            [$stYear, $stMonth] = $stdate;

                                            $endate = explode('-', $endMonth);
                                            [$enYear, $enMonth] = $endate;

                                            // $history = History::where('student_id', $std->id)
                                            //     ->where('subject_id', $sub_ids)
                                            //     ->where(function ($query) use ($stYear, $enYear, $stMonth, $enMonth) {
                                            //         $query->whereRaw('DATE(datetime) >= ?', ["$stYear-$stMonth-01"])->whereRaw('DATE(datetime) <= ?', ["$enYear-$enMonth-31"]);
                                            //     })
                                            //     ->get();

                                            // $history = History::where('student_id', $std->id)
                                            //     ->where('subject_id', $sub_ids)
                                            //     ->whereBetween('datetime', ["$stYear-$stMonth-01", "$enYear-$enMonth-31"])
                                            //     ->get();

                                            $history = History::where('student_id', $std->id)
                                                ->where('subject_id', $sub_ids)
                                                ->whereBetween('datetime', ["$stYear-$stMonth-01", now()->year($enYear)->month($enMonth)->endOfMonth(),
                                                ])
                                                ->get();
                                            // dd([
                                            //     'startMonthYMD' => $startMonthYMD,
                                            //     'stYear' => $stYear,
                                            //     'stMonth' => $stMonth,
                                            //     'endMonth' => $endMonth,
                                            //     'enYear' => $enYear,
                                            //     'enMonth' => $enMonth,
                                            //     'history' => $history->toArray(),
                                            // ]);

                                            // $history = History::where('student_id', $std->id)
                                            //     ->where('subject_id', $sub_ids)
                                            //     ->whereYear('datetime', '>=', $stYear)
                                            //     ->whereYear('datetime', '<=', $enYear)
                                            //     ->whereMonth('datetime', '>=', $stMonth)
                                            //     ->whereMonth('datetime', '<=', $enMonth)
                                            //     ->get();

                                            if ($history->count() == 0) {
                                                $history = History::where('student_id', $std->id)
                                                    ->where('subject_id', $sub_ids)
                                                    ->where(function ($query) use ($stYear, $enYear, $stMonth, $enMonth) {
                                                        $query
                                                            ->whereYear('datetime', '>', $stYear)
                                                            ->Where(function ($query) use ($stYear, $stMonth) {
                                                                $query->whereYear('datetime', $stYear)->whereMonth('datetime', '>=', $stMonth);
                                                            })
                                                            ->Where(function ($query) use ($enYear, $enMonth) {
                                                                $query->whereYear('datetime', $enYear)->whereMonth('datetime', '<=', $enMonth);
                                                            });
                                                    })
                                                    ->get();
                                            }

                                            //รอแก้ บัค 00032 กับ 00148

                                            // if ($history->count() == 0) {
                                            //     $history = History::where('student_id', $std->id)
                                            //         ->where('subject_id', $sub_ids)
                                            //         ->where(function ($query) use ($stYear, $enYear, $stMonth, $enMonth) {
                                            //             $query
                                            //                 ->whereYear('datetime', '>', $stYear)
                                            //                 ->orWhere(function ($query) use ($stYear, $stMonth) {
                                            //                     $query->whereYear('datetime', $stYear)->whereMonth('datetime', '>=', $stMonth);
                                            //                 })
                                            //                 ->orWhere(function ($query) use ($enYear, $enMonth) {
                                            //                     $query->whereYear('datetime', $enYear)->whereMonth('datetime', '<=', $enMonth);
                                            //                 });
                                            //         })
                                            //         ->get();
                                            // }

                                            // dd(
                                            //     $history,
                                            //     $stYear,
                                            //     $stMonth,
                                            //     $enYear,
                                            //     $enMonth,
                                            // );

                                            // $history = History::where('student_id', $std->id)
                                            //     ->where('subject_id', $sub_ids)
                                            //     ->where(function ($query) use ($stYear, $enYear, $stMonth, $enMonth) {
                                            //         $query
                                            //             ->whereBetween('datetime', ["$stYear-$stMonth-01", "$enYear-$enMonth-31"])
                                            //             ->orWhere(function ($query) use ($stYear, $stMonth) {
                                            //                 $query->where('datetime', '>=', "$stYear-$stMonth-01");
                                            //             })
                                            //             ->orWhere(function ($query) use ($enYear, $enMonth) {
                                            //                 $query->where('datetime', '<=', "$enYear-$enMonth-31");
                                            //             });
                                            //     })
                                            //     ->get();

                                            if (!empty($history)) {
                                                // $his_succsss = count($history);
                                                $history_count = 0;
                                                foreach ($history as $his_check_time) {
                                                    $stime = Carbon::parse($his_check_time->stime); //format 11:15:00
                                                    $etime = Carbon::parse($his_check_time->etime); //format 12:15:00
                                                    $hoursDifference = $etime->diffInHours($stime);
                                                    // $minutesDifference = $etime->diffInMinutes($stime);
                                                    // $hoursDifference = $minutesDifference / 60; // Convert minutes to hours
                                                    // dd($stime, $etime, $hoursDifference,$minutesDifference,$hoursDifference);
                                                    $history_count += $hoursDifference; //1 ชม = 1 ครั้ง
                                                    $his_time_out[] = $his_check_time->id;
                                                    // $his_time_out[] = ['id' => $his_check_time->id, 'subject_id' => $his_check_time->subject_id];
                                                }

                                                $firstRecord = $history->first();

                                                if (!empty($firstRecord) && !in_array($firstRecord->id, $processedIds)) {
                                                    $processedIds[] = $firstRecord->id;
                                                } else {
                                                    $history_count = 0;
                                                }
                                            }

                                            $extra = StudentBonus::where(['student_id' => $std->id, 'schoolp_id' => $school_pices->id])->sum('bonus');
                                            $startcourse = $school_pices->period ?? null;
                                            if ($school_pices->period == $startcourse) {
                                                $num_month = $school;
                                                $course++;
                                            } else {
                                                $num_month += $school;
                                            }
                                            $startMonthYMD = Carbon::createFromFormat('Y-m', $startMonth);
                                            $stopBonus = '2024-01-01';
                                            $stopBonuss = Carbon::parse($stopBonus)->format('Y-m');

                                            $qty += $school;
                                            $checkbonus = $startMonthYMD->greaterThan($stopBonuss);

                                            // if ($num_month > 11) {
                                            //     if ($checkbonus) {
                                            //         $bonus = 0 + $extra;
                                            //     } else {
                                            //         $bonus = 12 * $course + $extra;
                                            //     }
                                            //     $prefer = $qty * 8;
                                            //     $all = $qty * 8 + $bonus ?? 'N/A';
                                            //     $remain = $all - $history_count;
                                            // } elseif ($num_month > 5) {
                                            //     if ($checkbonus) {
                                            //         $bonus = 0 + $extra;
                                            //     } else {
                                            //         $bonus = 5 * $course + $extra;
                                            //     }

                                            //     $prefer = $qty * 8;
                                            //     $all = $qty * 8 + $bonus ?? 'N/A';
                                            //     $remain = $all - $history_count;
                                            // } elseif ($num_month > 3) {
                                            //     if ($checkbonus) {
                                            //         $bonus = 0 + $extra;
                                            //     } else {
                                            //         $bonus = 3 * $course + $extra;
                                            //     }
                                            //     $prefer = $qty * 8;
                                            //     $all = $qty * 8 + $bonus ?? 'N/A';
                                            //     $remain = $all - $history_count;
                                            // } else {
                                            //     $bonus = 0 + $extra;
                                            //     $prefer = $qty * 8;
                                            //     $all = $qty * 8 + $bonus ?? 'N/A';
                                            //     $remain = $all - $history_count;
                                            // }

                                            if ($checkbonus) {
                                                $bonus = 0 + $extra;
                                            } else {
                                                if ($num_month > 11) {
                                                    $bonus = 12 * $course + $extra;
                                                } elseif ($num_month > 5) {
                                                    $bonus = 5 * $course + $extra;
                                                } elseif ($num_month > 3) {
                                                    $bonus = 3 * $course + $extra;
                                                } else {
                                                    $bonus = 0 + $extra;
                                                }
                                            }

                                            // if ($school_pices->group === 'CHN') {
                                            //     # code...
                                            //     $prefer = $qty * 10;
                                            // } else {
                                            //     $prefer = $qty * 8;
                                            // }

                                            $prefer = $qty * $school_pices->school_sub->hr_per_course;
                                            $all = $prefer + $bonus ?? 'N/A';
                                            $remain = $all - $history_count;

                                            // $bonus = $bonus + $extra;

                                        @endphp
                                    @endif
                                    @php
                                        $result_month += $num_month;
                                        $result_prefer += $prefer;
                                        $result_all += $all;
                                        $result_bonus += $bonus;
                                        $result_his += $history_count;
                                        $result_remain += $remain;

                                        $all_prefer = $result_month * 8;
                                        $class = ' ';
                                        if ($count_loop == 0) {
                                            # code...
                                            $class = 'info';
                                        }
                                    @endphp
                                    <tr class="bg-{{ $class }}">
                                        <td> {{ $school_pice->first()->school_sub->title }}</td>
                                        <td>{{ $school_pices->period }}</td>
                                        <td>{{ $num_month }}
                                            {{-- / {{ $result_month }} --}}
                                            {{-- dm : {{ $monthsDifference }} --}}
                                        </td>
                                        <td>
                                            {{ $prefer }}
                                            {{-- / {{ $all_prefer }}  --}}
                                        </td>
                                        <td>
                                            {{ $bonus }}
                                            {{-- / {{ $result_bonus }} --}}
                                        </td>
                                        <td>{{ $all }}</td>
                                        <td>{{ $history_count }}
                                            {{-- / {{ $result_his }} --}}
                                        </td>
                                        <td>
                                            {{ $remain }}
                                        </td>
                                        <td>
                                            {{ $result_remain - $count_time_out }}
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-primary btn-edit" id="getViewData"
                                                data-id="{{ $school_pice->first()->school_sub->id }},{{ $std->id }}"><i
                                                    class="fa fa-eye"></i> View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @php
                                    // dd($extra, $endMonth, $history, $stYear, $enYear, $stMonth, $enMonth);

                                    $historyTimeOut = $histories
                                        ->where('student_id', $std->id)
                                        ->whereIn('subject_id', $sub_ids)
                                        ->reject(function ($historyTime) use ($his_time_out) {
                                            return in_array($historyTime->id, $his_time_out);
                                        });
                                    foreach ($historyTimeOut as $a) {
                                        if (!in_array($a->id, array_column($historyTimeOut_id, 'id'))) {
                                            $historyTimeOut_id[] = ['id' => $a->id, 'subject_id' => $a->subject_id];
                                        }
                                    }

                                    if (!empty($historyTimeOut)) {
                                        // $his_succsss = count($history);
                                        $count_time_out = 0;
                                        foreach ($historyTimeOut as $his_check_time1) {
                                            $stime1 = Carbon::parse($his_check_time1->stime);
                                            $etime1 = Carbon::parse($his_check_time1->etime);
                                            $hoursDifference = $etime1->diffInHours($stime1);
                                            $count_time_out += $hoursDifference;
                                            $his_check_time1->update(['status' => 'non-reciept']);
                                        }
                                    }

                                    // $count_time_out = $historyTimeOut->count();
                                    // dd($historyTimeOut_id, $historyTimeOut);

                                    // dd($history, $startMonthYMD, $stMonth, $endMonth, $stYear, $endYear);

                                @endphp
                                <tr class="bg-danger">
                                    <td class="text-white">{{ $school_pice->first()->school_sub->title }} (นอกระยะเวลา)
                                    </td>
                                    <td class="text-white">date</td>

                                    <td class="text-white"> - </td>
                                    <td class="text-white"> - </td>
                                    <td class="text-white"> - </td>
                                    <td class="text-white"> - </td>
                                    <td class="text-white">{{ $count_time_out }}</td>
                                    <td class="text-white"> - </td>
                                    <td class="text-white">{{ $result_remain - $count_time_out }}</td>
                                    <td class="text-white">
                                        {{-- <a href="#" class="btn btn-xs btn-primary btn-edit" id="getViewData"
                                                data-id="{{ $school_pice->first()->school_sub->id }},{{ $std->id }}"><i
                                                    class="fa fa-eye"></i> View</a> --}}
                                        <a href="#" class="btn btn-xs btn-primary btn-edit" id="getViewData1"
                                            data-id="{{ $school_pice->first()->school_sub->id }},{{ $std->id }}"><i
                                                class="fa fa-eye"></i> View</a>
                                    </td>
                                </tr>
                                <tr class="bg-dark">
                                    <td class="text-white"> {{ $school_pice->first()->school_sub->title }} result</td>
                                    <td class="text-white">date</td>

                                    <td class="text-white">{{ $result_month }}</td>
                                    <td class="text-white">{{ $all_prefer }}</td>
                                    <td class="text-white">{{ $result_bonus }}</td>
                                    <td class="text-white">{{ $result_all }}</td>
                                    <td class="text-white">{{ $result_his + $count_time_out }}</td>
                                    <td class="text-white"> - </td>
                                    <td class="text-white">{{ $result_remain - $count_time_out }}</td>
                                    <td class="text-white">
                                        <a href="#" class="btn btn-xs btn-primary btn-edit" id="getViewData"
                                            data-id="{{ $school_pice->first()->school_sub->id }},{{ $std->id }}"><i
                                                class="fa fa-eye"></i> View</a>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- @endif --}}
                            @php
                                // dd($historyTimeOut_id, $historyTimeOut, $his_time_out);
                            @endphp


                        </tbody>

                    </table>
                </form>
            </div>
        </div>

    </div>

    <div class="body-block-example-2" style="display:none" id="loder_bar">
        <br>
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
        <br>
    </div>

    <!-- View  Modal -->
    <div class="fade modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="ViewModal">
        <div class="modal-dialog modal-lg" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">View History Student Class <span
                                id="className"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <strong>Success!</strong> Student was edit successfully.
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>

                        {{-- <div class="form-group">
                            <label for="Parent">ชื่อผู้ปกครอง:</label><br>
                            <select style="width: 100%;" class="parent select2 select2_single form-control" id="ViewParent"
                                name="name_parent" multiple="multiple">

                            </select>
                        </div> --}}
                        <div class="row">
                            {{-- date --}}
                            <div class="col-lg-4">
                                <label for="Parent">วันที่ : </label><br>
                                <div class="form-group" id="date_text">
                                    <label for="date"> test date text</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="Parent">เวลา : </label><br>
                                <div class="form-group">
                                    <label for="date" id="time_text"> test time text</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="Parent">จำนวนชั่วโมง : </label><br>
                                <div class="form-group">
                                    <label for="date" id="hr_history"> test time text</label>
                                </div>
                                <label for="Parent">รวม : </label>

                                <label for="date" id="sum_hr_history"> test time text</label>

                            </div>
                        </div>
                        <div id="ViewModalBody">


                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-success" id="SubmitEditForm">Update</button> --}}
                        <button type="button" class="btn btn-danger modelClose" data-bs-dismiss="modal">Close</button>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            //$.noConflict();
            var token = ''
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#Listview').DataTable({

                // serverSide: true,
                // processing: true,

                // iDisplayLength: 10,
                lengthMenu: [20, 50, 75, 100],

            });


            let sub_id, std_id;

            $(document).on('click', '#getViewData', function(e) {
                e.preventDefault();

                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                let id = $(this).data('id');
                [sub_id, std_id] = id.split(',');

                $.ajax({
                    url: "history/" + sub_id + "/" + std_id,
                    method: 'GET',
                    success: function(res) {
                        $('#time_text').html(res.timeText);
                        $('#date_text').html(res.dateText);
                        $('#hr_history').html(res.hr_history);
                        $('#sum_hr_history').html(res.sum_hr_history);
                        $('#className').html(res.classname);
                        $('#ViewModalBody').html(res.html);
                        $('#ViewParent').html(res.parent);
                        $('#ViewModal').modal('show');
                    }
                });
            });
            $(document).on('click', '#getViewData1', function(e) {
                e.preventDefault();

                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').html('');
                $('.alert-success').hide();

                let id = $(this).data('id');
                [sub_id, std_id] = id.split(',');

                $.ajax({
                    url: "history/" + sub_id + "/" + std_id,
                    method: 'GET',
                    data: {
                        historyTimeOut_id: {!! json_encode($historyTimeOut_id) !!}, // Pass the array to the controller
                        type: 'out',
                    },
                    success: function(res) {
                        $('#time_text').html(res.timeText);
                        $('#date_text').html(res.dateText);
                        $('#hr_history').html(res.hr_history);
                        $('#sum_hr_history').html(res.sum_hr_history);
                        $('#className').html(res.classname);
                        $('#ViewModalBody').html(res.html);
                        $('#ViewParent').html(res.parent);
                        $('#ViewModal').modal('show');
                    }
                });
            });

        })
    </script>
    <script>
        function openModal() {
            event.preventDefault();
            var modal = document.getElementById("ViewModal");
            modal.style.display = "block";
        }
    </script>
@endsection
