<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Receipt_RunningNumber extends Model
{
    use HasFactory;

    protected $table = 'receipt_running_numbers';

    protected $fillable = [
        'type',
        'number',
        'year',
        'month',
    ];

    const TYPES = [
        '0',
        '2',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '24',
        '25',
        '26',
        '27',
        '28',
        '29',
        '30',
        '31',
        '32',
    ];

    const TYPE_PREFIX = [
        '0' => '0',
        '2' => '2',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30',
        '31' => '31',
        '32' => '32',
    ];


    public static function mergeArrayTypes()
    {
        $mergeArray = self::TYPE_PREFIX;
        $mergeArray2 = self::TYPES;
        $formManage = FormManage::orderBy("id", "asc")->get();
        foreach ($formManage as $form) {
            if (!array_key_exists($form->sfield, $mergeArray)) {
                $mergeArray[$form->sfield] = $form->sfield;
            }
            if (!in_array($form->sfield, $mergeArray2)) {
                $mergeArray2[] = $form->sfield;
            }
        }

        return [
            'TYPE_PREFIX' => $mergeArray,
            'TYPES' => $mergeArray2
        ];
    }

    public static function getMergedTypePrefix()
    {
        $merged = self::mergeArrayTypes();
        return $merged['TYPE_PREFIX'];
    }

    public static function getMergedTypes()
    {
        $merged = self::mergeArrayTypes();
        return $merged['TYPES'];
    }


    public static function pre_generate(string $type, string $sdate)
    {
        // Get merged arrays from FormManage
        $merged = self::mergeArrayTypes();
        $mergeArrayTYPE_PREFIX = $merged['TYPE_PREFIX'];
        $mergeArrayTYPES = $merged['TYPES'];

        // Debug: ดูค่าหลัง merge
        // dd([
        //     'Original TYPE_PREFIX' => self::TYPE_PREFIX,
        //     'Original TYPES' => self::TYPES,
        //     'Merged TYPE_PREFIX' => $mergeArrayTYPE_PREFIX,
        //     'Merged TYPES' => $mergeArrayTYPES,
        //     'FormManage sfields' => \App\Models\FormManage::pluck('sfield')->toArray()
        // ]);

        $type = strtoupper($type);

        $sfield = FormManage::where('sfield', $type)->first();

        if (!in_array($type, $mergeArrayTYPES)) {
            throw new \Exception('Undefined running number type: ' . $type);
        }

        if ($sfield) {
            $type = $sfield->sfield;
        }
        $number = 0;
        $year = date('Y');
        $month = date('m');
        $sda = explode("-", $sdate);
        $ldate = Carbon::create($sda[0], $sda[1], $sda[2]); // Create a Carbon instance for the date 2023-09-30

        $lastDayOfMonth = $ldate->endOfMonth()->format('d');

        $day = $sda[2];
        $month = $sda[1];
        $year = $sda[0];
        if ($day == $lastDayOfMonth && $month != '01') {
            // $month = str_pad(intval($month) -1, 2, '0', STR_PAD_LEFT); // Decrease month by 1
            $month = str_pad(intval($month), 2, '0', STR_PAD_LEFT); // Decrease month by 1


            if ($month == '00') {
                $month = '12'; // If month becomes 00 (December of previous year)
                $year--;
            }
        }
        $month = $sda[1];

        // dd($sda[1],$sdate,$day,$lastDayOfMonth,$ldate,$month);
        if (!Receipt_RunningNumber::where('type', $type)->where('year', $year)->where('month', $month)->exists()) {
            Receipt_RunningNumber::create([
                'type' => $type,
                'number' => $number,
                'year' => $year,
                'month' => $month,
            ]);
        }

        $running_number = Receipt_RunningNumber::where('type', $type)->where('year', $year)->where('month', $month)->first();
        //print_r($running_number);
        //exit();
        $running_number->number++;
        //$running_number->save();
        $number = $running_number->number;
        $number = str_pad($number, 3, '0', STR_PAD_LEFT);

        // A-21-00001
        if (strlen($mergeArrayTYPE_PREFIX[$type]) > 1) {
            return $mergeArrayTYPE_PREFIX[$type] . '' . date('y') . '' . $month . '' . $number;
        } else {
            return "0" . $mergeArrayTYPE_PREFIX[$type] . '' . date('y') . '' . $month . '' . $number;
        }

        //return Receipt_RunningNumber::TYPE_PREFIX[$type] . '' . date('y') . '01' . $number;
    }

    public static function generate(string $type, string $sdate)
    {
        $mergeArrayTYPE_PREFIX = self::TYPE_PREFIX;
        $mergeArrayTYPES = self::TYPES;

        $formManage = FormManage::orderBy('id', 'asc')->get();
        foreach ($formManage as $form) {
            $sfield = (string) $form->sfield;

            if ($sfield === '') {
                continue;
            }

            if (!array_key_exists($sfield, $mergeArrayTYPE_PREFIX)) {
                $mergeArrayTYPE_PREFIX[$sfield] = $sfield;
            }

            $mergeArrayTYPES[] = $sfield;
        }

        $mergeArrayTYPES = array_values(array_unique(array_map('strval', $mergeArrayTYPES)));
        usort($mergeArrayTYPES, function ($a, $b) {
            return (int) $a <=> (int) $b;
        });

        $normalizedPrefixes = [];
        foreach ($mergeArrayTYPE_PREFIX as $key => $value) {
            $normalizedKey = (string) $key;
            $normalizedPrefixes[$normalizedKey] = (string) $value;
        }

        uksort($normalizedPrefixes, function ($a, $b) {
            return (int) $a <=> (int) $b;
        });

        $mergeArrayTYPE_PREFIX = $normalizedPrefixes;

        $type = trim((string) $type);

        if (!array_key_exists($type, $mergeArrayTYPE_PREFIX)) {
            $normalizedType = ltrim($type, '0');

            if ($normalizedType === '') {
                $normalizedType = '0';
            }

            if (array_key_exists($normalizedType, $mergeArrayTYPE_PREFIX)) {
                $type = $normalizedType;
            } else {
                throw new \Exception('Undefined running number type.');
            }
        }
        // dd($type,$mergeArrayTYPE_PREFIX ,array_key_exists($type, $mergeArrayTYPE_PREFIX));

        $number = 0;
        $year = date('Y');
        $month = date('m');
        $sda = explode('-', $sdate);
        $ldate = Carbon::create($sda[0], $sda[1], $sda[2]); // Create a Carbon instance for the date 2023-09-30
        $lastDayOfMonth = $ldate->endOfMonth()->format('d');

        $day = $sda[2];
        $month = $sda[1];
        $year = $sda[0];

        if ($day == $lastDayOfMonth && $month != '01') {
            $month = str_pad(intval($month), 2, '0', STR_PAD_LEFT);
            if ($month == '00') {
                $month = '12';
                $year--;
            }
        }

        if (!Receipt_RunningNumber::where('type', $type)->where('year', $year)->where('month', $month)->exists()) {
            Receipt_RunningNumber::create([
                'type' => $type,
                'number' => $number,
                'year' => $year,
                'month' => $month,
            ]);
        }

        $running_number = Receipt_RunningNumber::where('type', $type)->where('year', $year)->where('month', $month)->first();
        $running_number->number++;
        $running_number->save();

        $number = $running_number->number;
        $number = str_pad($number, 3, '0', STR_PAD_LEFT);

        // ใช้ปีจาก submission_date แทนปีปัจจุบัน เพื่อให้ receipt number สอดคล้องกับวันที่ลงทะเบียน
        $yearShort = substr($year, -2);

        if (strlen($mergeArrayTYPE_PREFIX[$type]) > 1) {
            return $mergeArrayTYPE_PREFIX[$type] . '' . $yearShort . '' . $month . '' . $number;
        }

        return '0' . $mergeArrayTYPE_PREFIX[$type] . '' . $yearShort . '' . $month . '' . $number;
    }
}
