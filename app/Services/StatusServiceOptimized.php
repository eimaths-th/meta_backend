<?php
namespace App\Services;

use App\Models\SchoolPrice;
use App\Models\Statuslog;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatusServiceOptimized
{
    protected $currentMonthYear;
    protected $currentMonth;
    protected $cMonth;
    protected $cYear;
    protected $schoolPricesCache = [];
    protected $statusLogsToInsert = [];

    public function __construct()
    {
        $now = Carbon::now();

        $this->currentMonthYear = $now->format('Y-m');
        $this->currentMonth = $now->copy()->firstOfMonth();
        $this->cMonth = $now->format('m');
        $this->cYear = $now->format('Y');
    }

    public function updateStudentStatus()
    {
        // Eager load ALL relationships at once
        $students = Student::with([
            'rec_school',
            'status_log' => function ($query) {
                $query->latest();
            }
        ])->get();

        $this->updateStatus($students);
    }

    public function updateStatus($students)
    {
        // Pre-load all SchoolPrices for all students at once
        $studentIds = $students->pluck('id')->toArray();
        $schoolPrices = SchoolPrice::whereIn('student_id', $studentIds)
            ->where('course_type', 1)
            ->where('qty', '>', 0)
            ->orderBy('rid')
            ->get()
            ->groupBy('student_id');

        // Pre-load all existing status logs for current month
        $existingStatusLogs = Statuslog::whereIn('student_id', $studentIds)
            ->whereMonth('status_date', $this->cMonth)
            ->whereYear('status_date', $this->cYear)
            ->get()
            ->groupBy(function ($item) {
                return $item->student_id . '_' . $item->group;
            });

        // Pre-load latest status logs per student per group
        $latestStatusLogs = Statuslog::whereIn('student_id', $studentIds)
            ->get()
            ->groupBy(function ($item) {
                return $item->student_id . '_' . $item->group;
            })
            ->map(function ($group) {
                return $group->sortByDesc('id')->first();
            });

        // Cache SchoolPrice by ID
        $allSchoolPriceIds = $schoolPrices->flatten()->pluck('id')->unique()->toArray();
        $this->schoolPricesCache = SchoolPrice::whereIn('id', $allSchoolPriceIds)
            ->get()
            ->keyBy('id');

        $studentsToUpdate = [];
        $this->statusLogsToInsert = [];

        foreach ($students as $student) {
            $studentSchoolPrices = $schoolPrices->get($student->id, collect());
            $statuses = $this->determineStatus($student, $studentSchoolPrices);

            foreach ($statuses as $statuse) {
                foreach ($statuse as $subjectGroup => $statu) {
                    $schp_id = $statu['schoolprice_id'];
                    $status = $statu['status'];

                    $key = $student->id . '_' . $subjectGroup;
                    $existingStatus = $latestStatusLogs->get($key);
                    $checkDuplicateKey = $existingStatusLogs->get($key);

                    $check_schp = $this->schoolPricesCache->get($schp_id);
                    $checkDrop = $this->shouldDrop($check_schp, $subjectGroup);

                    $shouldCreate = false;

                    if (!$existingStatus) {
                        $shouldCreate = true;
                    } elseif ($existingStatus->status === $status && 
                              $existingStatus->group === $subjectGroup && 
                              Carbon::parse($existingStatus->status_date)->format('Y-m') == $this->currentMonthYear) {
                        // Skip - same status in same month
                    } elseif ($checkDuplicateKey && $checkDuplicateKey->first()->status === $status) {
                        // Skip - duplicate found
                    } else {
                        if (!$checkDrop) {
                            $shouldCreate = true;
                        }
                    }

                    if ($shouldCreate) {
                        $this->statusLogsToInsert[] = [
                            'student_id' => $student->id,
                            'schoolprice_id' => $schp_id,
                            'nick_name' => $student->nick_name,
                            'group' => $subjectGroup,
                            'status' => $status,
                            'status_date' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    // Prepare student status update
                    $lastStatusLog = $student->status_log->last();
                    if ($lastStatusLog && $student->status !== $lastStatusLog->status) {
                        $studentsToUpdate[$student->id] = $lastStatusLog->status;
                    }
                }
            }
        }

        // Bulk insert all status logs at once
        if (!empty($this->statusLogsToInsert)) {
            // Insert in chunks to avoid memory issues
            foreach (array_chunk($this->statusLogsToInsert, 500) as $chunk) {
                Statuslog::insert($chunk);
            }
        }

        // Bulk update student statuses
        if (!empty($studentsToUpdate)) {
            foreach ($studentsToUpdate as $studentId => $newStatus) {
                Student::where('id', $studentId)->update(['status' => $newStatus]);
            }
        }
    }

    protected function shouldDrop($check_schp, $subjectGroup)
    {
        if (!$check_schp) {
            return $subjectGroup === 'N';
        }

        $period = $check_schp->period;
        $periodd = explode(' - ', $period);
        
        if (count($periodd) == 1) {
            $periods = explode('-', $period);
            $startMonth = Carbon::parse("$periods[0]-$periods[1]")->format('Y-m');
            $endMonth = count($periods) > 2 ? Carbon::parse("$periods[2]-$periods[3]")->format('Y-m') : $startMonth;
        } else {
            $startMonth = Carbon::parse($periodd[0])->format('Y-m');
            $endMonth = Carbon::parse($periodd[1])->format('Y-m');
        }

        $endMonthYear = Carbon::parse($endMonth);
        return $endMonthYear->diffInMonths($this->currentMonth) > 2 && 
               $endMonthYear->lessThan($this->currentMonth) || 
               $subjectGroup === 'N';
    }

    public function determineStatus($student, $studentSchoolPrices = null)
    {
        $stdId = $student->id;

        // Use pre-loaded school prices if available
        if ($studentSchoolPrices === null) {
            $ssss = SchoolPrice::where('student_id', $stdId)
                ->where('course_type', 1)
                ->where('qty', '>', 0)
                ->orderBy('rid')
                ->get();
        } else {
            $ssss = $studentSchoolPrices;
        }

        $group_scp = $ssss->groupBy('group');
        $status = [];
        $statusss = [];

        if (!$group_scp->isEmpty()) {
            foreach ($group_scp as $group => $school_pice) {
                $currentMonth = $this->currentMonth;
                $count_qty = count($school_pice);
                $count_rec = 0;
                $monthsDifference = 0;
                $dateDrop = '';
                $dateResume = '';
                $firstEndMonth = '';

                foreach ($school_pice as $school_pice_II) {
                    $submission_date = $school_pice_II->rec_school->submission_date;
                    $period = $school_pice_II->period;

                    $periodd = explode(' - ', $period);
                    if (count($periodd) == 1) {
                        $periods = explode('-', $period);
                        $startMonth = Carbon::parse("$periods[0]-$periods[1]")->format('Y-m');
                        $endMonth = count($periods) > 2 ? Carbon::parse("$periods[2]-$periods[3]")->format('Y-m') : $startMonth;
                    } else {
                        $startMonth = Carbon::parse($periodd[0])->format('Y-m');
                        $endMonth = Carbon::parse($periodd[1])->format('Y-m');
                    }

                    if ($count_rec > 0) {
                        $monthsDifference = Carbon::parse($firstEndMonth)->diffInMonths(Carbon::parse($startMonth));
                    }

                    if ($monthsDifference > 1) {
                        $dateDrop = $firstEndMonth;
                        $dateResume = $startMonth;
                    }
                    $firstEndMonth = $endMonth;
                    $count_rec++;

                    $currentReceiptStatDate = Carbon::parse($startMonth);
                    $currentReceiptEndDate = Carbon::parse($firstEndMonth);
                    $currentReceiptsubmission_date = Carbon::parse($submission_date)->firstOfMonth();

                    if ($count_qty == 1 && $currentMonth->diffInMonths($currentReceiptStatDate) <= 0) {
                        $status[$group] = [
                            'status' => 'New Student',
                            'schoolprice_id' => $school_pice_II->id
                        ];
                    } elseif ($count_qty == 1 && $currentMonth->diffInMonths($currentReceiptsubmission_date) == 0 && $currentReceiptsubmission_date->lessThan($currentReceiptStatDate)) {
                        $status[$group] = [
                            'status' => 'waitting . . .',
                            'schoolprice_id' => $school_pice_II->id
                        ];
                    }

                    if ($count_qty == 1) {
                        if ($currentMonth->diffInMonths($currentReceiptEndDate) > 1 && $currentMonth->greaterThan($currentReceiptEndDate)) {
                            $status[$group] = [
                                'status' => 'drop',
                                'schoolprice_id' => $school_pice_II->id
                            ];
                        } else {
                            if ($currentMonth->greaterThan($currentReceiptEndDate)) {
                                $status[$group] = [
                                    'status' => 'Termination of study',
                                    'schoolprice_id' => $school_pice_II->id
                                ];
                            } else {
                                if ($currentMonth->diffInMonths($currentReceiptStatDate) <= 0) {
                                    $status[$group] = [
                                        'status' => 'New Student',
                                        'schoolprice_id' => $school_pice_II->id
                                    ];
                                } elseif ($currentMonth->diffInMonths($currentReceiptsubmission_date) == 0 && $currentReceiptsubmission_date->lessThan($currentReceiptStatDate)) {
                                    $status[$group] = [
                                        'status' => 'waitting . . .',
                                        'schoolprice_id' => $school_pice_II->id
                                    ];
                                } else {
                                    $status[$group] = [
                                        'status' => 'studying . . .',
                                        'schoolprice_id' => $school_pice_II->id
                                    ];
                                }
                            }
                        }
                    } elseif ($currentMonth->diffInMonths($currentReceiptEndDate) > 1 && $currentMonth->greaterThan($currentReceiptEndDate)) {
                        $status[$group] = [
                            'status' => 'drop',
                            'schoolprice_id' => $school_pice_II->id
                        ];
                    } else {
                        if ($currentMonth->greaterThan($currentReceiptEndDate)) {
                            $status[$group] = [
                                'status' => 'Termination of study',
                                'schoolprice_id' => $school_pice_II->id
                            ];
                        } else {
                            // Use pre-loaded status logs from student relationship
                            $check_resume = $student->status_log
                                ->where('group', $group)
                                ->sortByDesc('id')
                                ->values();

                            if (count($check_resume) > 0) {
                                $firstLog = $check_resume->first();
                                if ($currentMonth->diffInMonths($currentReceiptsubmission_date) == 0 && $currentReceiptsubmission_date->lessThan($currentReceiptStatDate)) {
                                    if ($monthsDifference == 1) {
                                        $status[$group] = [
                                            'status' => 'studying . . .',
                                            'schoolprice_id' => $school_pice_II->id
                                        ];
                                    } else {
                                        $status[$group] = [
                                            'status' => 'waitting . . .',
                                            'schoolprice_id' => $school_pice_II->id
                                        ];
                                    }
                                } else {
                                    if ($dateResume) {
                                        $submissionDateResume = Carbon::parse($dateResume);
                                        if ($currentMonth->diffInMonths($submissionDateResume) > 0) {
                                            $status[$group] = [
                                                'status' => 'studying . . .',
                                                'schoolprice_id' => $school_pice_II->id
                                            ];
                                        } else {
                                            $status[$group] = [
                                                'status' => 'resume',
                                                'schoolprice_id' => $school_pice_II->id
                                            ];
                                        }
                                    } else {
                                        $status[$group] = [
                                            'status' => 'studying . . .',
                                            'schoolprice_id' => $school_pice_II->id
                                        ];
                                    }
                                }
                            }
                        }
                    }
                    $statusss[] = $status;
                }
            }
        } else {
            $status['N'] = [
                'status' => 'None Receipt',
                'schoolprice_id' => null
            ];
            $statusss[] = $status;
        }

        return $statusss;
    }
}
