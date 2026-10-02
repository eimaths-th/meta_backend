<?php

namespace App\Http\Controllers;

use App\Models\Receipt_School;
use App\Models\Recordtime;
use App\Models\SchoolPrice;
use App\Models\Statuslog;
use App\Models\Statuswork;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\StatusService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $statusService;

    public function __construct(StatusService $statusService)
    {
        $this->middleware('auth');

        $this->statusService = $statusService;
    }
    public function check_permission()
    {
        if (Auth::check()) {
            if (Auth::user()->level == 1 || Auth::user()->level == 2 || Auth::user()->level == 0) {
            } else {
                abort(403, 'Unauthorized action.');
            }
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function landing()
    {
        return redirect(Auth::user()->backOfficeHomePath());
    }

    /**
     * Show the legacy student dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->check_permission();
        // $students = Student::where('id', 21)->get();
        $school_picei_update_group = SchoolPrice::all();
        // $subject_ids = $school_picei_update_group->pluck('subject')->toArray();
        foreach ($school_picei_update_group as $upg) {
            # code...
            $group = $upg->school_sub->group;
            $upg->update(['group' => $group]);
            // dd($upg->id,$group);
        }



        // $students = Student::with('rec_school')->get();
        // // $students = Student::where('id', 249)->get();

        // // $updateStatus = $this->updateStatus($students);
        // $updateStatus = $this->statusService->updateStatus($students); // call in service

        $month  = date('m');
        $year   = date('Y');
        $latestStatusCounts = Statuslog::select('id', 'group', 'student_id', 'status')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('status_log')
                    ->groupBy('group', 'student_id');
            })
            ->whereYear('status_date', $year)
            ->whereMonth('status_date', $month)
            ->orderBy('group')

            ->get();
        // dd($latestStatusCounts);

        // $students = Student::with('rec_school')->get();

        return view('admin.dashboard', [

            'latestStatusCounts' => $latestStatusCounts,
            // 'latestStatusByStudent' => $latestStatusByStudent,
            // 'select_status' => $select_status,

        ]);
        // $latestStatusByStudent = Statuslog::select('status_log.student_id', 'status_log.group', 'status_log.status', 'status_log.status_date', 'status_log.nick_name')
        //     ->whereIn('status_log.id', function ($query) {
        //         $query->select(DB::raw('MAX(id)'))
        //             ->from('status_log')
        //             ->groupBy('student_id', 'group'); // Group by student_id and group
        //     })
        //     ->whereYear('status_log.status_date', $year)
        //     ->whereMonth('status_log.status_date', $month)
        //     ->join('students', 'status_log.student_id', '=', 'students.id') // Assuming 'students' is the name of your students table
        //     ->orderBy('students.code')
        //     ->get();


    }
    public function updateStudentStatus()
    {
        $students = Student::with('rec_school')->get();
        // $students = Student::where('id', 42)->get();

        // $updateStatus = $this->updateStatus($students);
        $updateStatus = $this->statusService->updateStatus($students); // call in service

        return redirect()->route('home');
    }

    // private function updateStatus($students)
    // {
    //     foreach ($students as $student) {
    //         $statuses = $this->determineStatus($student);
    //         $cl = 0;
    //         foreach ($statuses as $statuse) {
    //             foreach ($statuse as $subjectGroup => $statu) {

    //                 $schp_id = $statu['schoolprice_id'];
    //                 $status = $statu['status'];

    //                 $existingStatus = Statuslog::where('student_id', $student->id)
    //                     ->where('group', $subjectGroup)
    //                     ->latest()
    //                     ->get();
    //                 $currentMonthYear = date('Y-m');

    //                 $status_date = $existingStatus->first()->status_date ?? '';
    //                 $status_date_year_month = date('Y-m', strtotime($status_date));

    //                 $select_status_date_year_month = date('Y-m', strtotime($currentMonthYear));

    //                 $cMonth = date('m');
    //                 $cYear = date('Y');
    //                 $checkDuplicate = Statuslog::where([
    //                     'student_id' => $student->id,
    //                     'schoolprice_id' => $schp_id,
    //                     'group' => $subjectGroup,
    //                     // 'status' => $status,
    //                 ])
    //                     ->whereMonth('status_date', $cMonth)
    //                     ->whereYear('status_date', $cYear)
    //                     ->orderBy('id', 'desc')->get();
    //                 $check_schp = SchoolPrice::find($schp_id);

    //                 if ($check_schp) {
    //                     # code...
    //                     $period = $check_schp->period;


    //                     $periodd = explode(' - ', $period);
    //                     if (count($periodd) == 1) {
    //                         $periods = explode('-', $period);
    //                         $startMonth = Carbon::parse("$periods[0]-$periods[1]")->format('Y-m');
    //                         $endMonth = count($periods) > 2 ? Carbon::parse("$periods[2]-$periods[3]")->format('Y-m') : $startMonth;
    //                     } else {

    //                         $startMonth = Carbon::parse($periodd[0])->format('Y-m');
    //                         $endMonth = Carbon::parse($periodd[1])->format('Y-m');
    //                     }
    //                     $cMonthYear = Carbon::parse($currentMonthYear)->firstOfMonth();
    //                     $endMonthYear = Carbon::parse($endMonth);
    //                     $checkDrop = $endMonthYear->diffInMonths($cMonthYear) > 2 && $endMonthYear->lessThan($cMonthYear) || $subjectGroup === 'N';
    //                 } else {
    //                     # code...
    //                     $checkDrop = $subjectGroup === 'N';
    //                     // dd($student->id, $schp_id, $check_schp, $subjectGroup, $status,$checkDrop);
    //                 }


    //                 // dd(
    //                 //     $student->id,
    //                 //     $schp_id,
    //                 //     $check_schp,
    //                 //     $checkDuplicate,
    //                 //     $status,
    //                 //     $endMonth,
    //                 //     $checkDrop,
    //                 // );

    //                 if (count($existingStatus) < 1) {
    //                     Statuslog::create([
    //                         'student_id' => $student->id,
    //                         'schoolprice_id' => $schp_id,
    //                         'nick_name' => $student->nick_name,
    //                         'group' => $subjectGroup,
    //                         'status' => $status,
    //                         'status_date' => now(),
    //                     ]);
    //                 } elseif ($existingStatus->first()->status === $status && $existingStatus->first()->group === $subjectGroup && $status_date_year_month == $select_status_date_year_month) {
    //                 } elseif ($checkDuplicate->count() > 0 && $checkDuplicate->first()->status === $status) {
    //                     # code...
    //                     // dd($checkDuplicate->first()->status, $status);
    //                 } else {
    //                     if ($checkDrop) {
    //                         # code...
    //                     } else {
    //                         # code...
    //                         Statuslog::create([
    //                             'student_id' => $student->id,
    //                             'schoolprice_id' => $schp_id,
    //                             'nick_name' => $student->nick_name,
    //                             'group' => $subjectGroup,
    //                             'status' => $status,
    //                             'status_date' => now(),
    //                         ]);
    //                     }
    //                 }
    //                 $lastStatusLog = $student->status_log->last();
    //                 if ($lastStatusLog) {
    //                     $student->update(['status' => $lastStatusLog->status]);
    //                 }
    //             }
    //             $cl++;
    //         }
    //     }
    // }
    // private function determineStatus($student)
    // {
    //     $stdId = $student->id;

    //     $ssss = SchoolPrice::where('student_id', $stdId)
    //         ->where('course_type', 1)
    //         ->where('qty', '>', 0)
    //         ->orderBy('rid')
    //         ->get();
    //     $group_scp = $ssss->groupBy('group');
    //     $status = [];
    //     $statusss = [];

    //     if (!$group_scp->isEmpty()) {

    //         foreach ($group_scp as $group => $school_pice) {
    //             // $current_Month = Carbon::createFromFormat('Y-m', '2024-05');
    //             $current_Month = date('Y-m');
    //             $currentMonth = Carbon::parse($current_Month)->firstOfMonth();
    //             $count_qty = count($school_pice);
    //             $count_rec = 0;
    //             $monthsDifference = 0;
    //             $datepr = [];
    //             $dateDrop = '';
    //             $dateResume = '';
    //             $firstEndMonth = '';
    //             $count_qty = count($school_pice);

    //             foreach ($school_pice as $school_pice_II) {
    //                 # code...
    //                 $submission_date = $school_pice_II->rec_school->submission_date;
    //                 $period = $school_pice_II->period;

    //                 $periodd = explode(' - ', $period);
    //                 if (count($periodd) == 1) {
    //                     $periods = explode('-', $period);
    //                     $startMonth = Carbon::parse("$periods[0]-$periods[1]")->format('Y-m');
    //                     $endMonth = count($periods) > 2 ? Carbon::parse("$periods[2]-$periods[3]")->format('Y-m') : $startMonth;
    //                 } else {

    //                     $startMonth = Carbon::parse($periodd[0])->format('Y-m');
    //                     $endMonth = Carbon::parse($periodd[1])->format('Y-m');
    //                 }

    //                 if ($count_rec > 0) {

    //                     $monthsDifference = Carbon::parse($firstEndMonth)->diffInMonths(Carbon::parse($startMonth));
    //                 }

    //                 if ($monthsDifference > 1) {

    //                     $dateDrop = $firstEndMonth;
    //                     $dateResume = $startMonth;
    //                 }
    //                 $firstEndMonth = $endMonth;
    //                 $count_rec++;

    //                 $currentReceiptStatDate = Carbon::parse($startMonth);
    //                 // $currentReceiptEndDate = Carbon::parse($endMonth);
    //                 $currentReceiptEndDate = Carbon::parse($firstEndMonth);
    //                 $currentReceiptsubmission_date = Carbon::parse($submission_date)->firstOfMonth();

    //                 if ($count_qty == 1 && $currentMonth->diffInMonths($currentReceiptStatDate) <= 0) {
    //                     $status[$group] = [
    //                         'status' => 'New Student',
    //                         'schoolprice_id' => $school_pice_II->id
    //                     ];
    //                     // dd('test',$group_scp, $school_pice, $school_pice_II, $status);
    //                 } elseif ($count_qty == 1 && $currentMonth->diffInMonths($currentReceiptsubmission_date) == 0 && $currentReceiptsubmission_date->lessThan($currentReceiptStatDate)) {
    //                     # code...
    //                     $status[$group] = [
    //                         'status' => 'waitting . . .',
    //                         'schoolprice_id' => $school_pice_II->id

    //                     ];
    //                 }
    //                 if ($count_qty == 1) {
    //                     # code...
    //                     if ($currentMonth->diffInMonths($currentReceiptEndDate) > 1 && $currentMonth->greaterThan($currentReceiptEndDate)) {
    //                         # code...
    //                         $status[$group] = [
    //                             'status' => 'drop',
    //                             'schoolprice_id' => $school_pice_II->id
    //                         ]; // ['drop', $school_pice_I->id];

    //                     } else {
    //                         if ($currentMonth->greaterThan($currentReceiptEndDate)) {
    //                             //กำลังยุติการการเรียน
    //                             $status[$group] = [
    //                                 'status' => 'Termination of study',
    //                                 'schoolprice_id' => $school_pice_II->id
    //                             ]; // ['Termination of study', $school_pice_I->id];

    //                         } else {
    //                             # code...
    //                             if ($currentMonth->diffInMonths($currentReceiptStatDate) <= 0) {
    //                                 # code...
    //                                 $status[$group] = [
    //                                     'status' => 'New Student',
    //                                     'schoolprice_id' => $school_pice_II->id
    //                                 ];
    //                             } elseif ($currentMonth->diffInMonths($currentReceiptsubmission_date) == 0 && $currentReceiptsubmission_date->lessThan($currentReceiptStatDate)) {
    //                                 # code...
    //                                 $status[$group] = [
    //                                     'status' => 'waitting . . .',
    //                                     'schoolprice_id' => $school_pice_II->id

    //                                 ];
    //                             } else {
    //                                 # code...
    //                                 $status[$group] = [
    //                                     'status' => 'studying . . .',
    //                                     'schoolprice_id' => $school_pice_II->id
    //                                 ];
    //                             }
    //                         }
    //                     }
    //                 } elseif ($currentMonth->diffInMonths($currentReceiptEndDate) > 1 && $currentMonth->greaterThan($currentReceiptEndDate)) {
    //                     //พ้นสภาพนักเรียน
    //                     $status[$group] = [
    //                         'status' => 'drop',
    //                         'schoolprice_id' => $school_pice_II->id
    //                     ]; // ['drop', $school_pice_I->id];

    //                 } else {
    //                     if ($currentMonth->greaterThan($currentReceiptEndDate)) {
    //                         //กำลังยุติการการเรียน
    //                         $status[$group] = [
    //                             'status' => 'Termination of study',
    //                             'schoolprice_id' => $school_pice_II->id
    //                         ]; // ['Termination of study', $school_pice_I->id];

    //                     } else {
    //                         //กำลังเรียนอยู่
    //                         $check_resume = Statuslog::where('student_id', $stdId)
    //                             ->where('group', $group)
    //                             // ->whereMonth('status_date', $resume_month)
    //                             // ->whereYear('status_date', $resume_year)
    //                             ->latest()
    //                             ->get();

    //                         if (count($check_resume) > 0) {

    //                             $firstLog = $check_resume->first();
    //                             if ($currentMonth->diffInMonths($currentReceiptsubmission_date) == 0 && $currentReceiptsubmission_date->lessThan($currentReceiptStatDate)) {
    //                                 //จ่ายในเดือนปัจจุบัน                                                      //วันที่จ่ายน้อยกว่าวันที่เริ่มเรียน
    //                                 if ($monthsDifference == 1) {
    //                                     $status[$group] = [
    //                                         'status' => 'studying . . .',
    //                                         'schoolprice_id' => $school_pice_II->id
    //                                     ]; // ['studying . . .', $school_pice_I->id];

    //                                 } else {
    //                                     $status[$group] = [
    //                                         'status' => 'waitting . . .',
    //                                         'schoolprice_id' => $school_pice_II->id

    //                                     ];
    //                                 }

    //                                 // dd($check_resume, $firstLog, $firstLog->status, $status, $currentReceiptEndDate);

    //                                 // $status[$group] = [
    //                                 //     'schoolprice_id' => $school_pice_II->id

    //                                 // ];
    //                             } else {
    //                                 if ($dateResume) {
    //                                     $submissionDateResume = Carbon::parse($dateResume);

    //                                     if ($currentMonth->diffInMonths($submissionDateResume) > 0) {
    //                                         $status[$group] = [
    //                                             'status' => 'studying . . .',
    //                                             'schoolprice_id' => $school_pice_II->id
    //                                         ]; // ['studying . . .', $school_pice_I->id];

    //                                     } else {
    //                                         $status[$group] = [
    //                                             'status' => 'resume',
    //                                             'schoolprice_id' => $school_pice_II->id
    //                                         ]; // ['resume', $school_pice_I->id];

    //                                     }
    //                                 } else {
    //                                     $status[$group] = [
    //                                         'status' => 'studying . . .',
    //                                         'schoolprice_id' => $school_pice_II->id
    //                                     ];
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //                 $statusss[] = $status;
    //             }
    //         }
    //     } else {
    //         $status['N'] = [
    //             'status' => 'None Receipt',
    //             'schoolprice_id' => null
    //         ];
    //         $statusss[] = $status;
    //     }

    //     $status = $statusss;

    //     return $status;
    // }


    public function home2()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $rec_times = Recordtime::where('user_id', Auth::user()->id)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            // ->get();
            ->get()
            ->groupBy('status_name')
            ->map->count();
        $rec_times_year = Recordtime::where('user_id', Auth::user()->id)
            ->whereYear('date', $currentYear)
            // ->get();
            ->get()
            ->groupBy('status_name')
            ->map->count();

        // $rec_timess = Recordtime::whereMonth('date', $currentMonth)
        //     ->whereYear('date', $currentYear)
        //     ->orderBy('user_id', 'desc')
        //     ->get()
        //     ->groupBy('user_id');

        // dd($rec_times_year);
        $rec_times_year2 = Recordtime::where('user_id', Auth::user()->id)
            // ->whereYear('date', $currentYear)
            ->get();
        // dd($rec_times_year2);


        return view('users.working_report', [
            // 'rec_timess' => $rec_timess,
            'rec_times' => $rec_times,
            'rec_times_year' => $rec_times_year,
            'rec_times_years' => $rec_times_year2,
            'currentYear' => $currentYear,
            'currentMonth' => $currentMonth,

        ]);
    }


    public function home3()
    {


        return view('addexcel');
    }
    //save code

}
