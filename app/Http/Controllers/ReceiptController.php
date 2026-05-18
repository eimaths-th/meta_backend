<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\ReceiptDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
//use Auth;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\ReceiptImport;
use App\Exports\UsersExport;
use App\Models\FormManage;
use App\Models\Receipt_RunningNumber;
use App\Models\Receipt_Customer_RunningNumber;
use App\Models\ReferentCode;
use App\Helpers\LogActivity;

//use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{

    const BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
    const BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    const BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
    const BAHT_TEXT_TWENTY = 'ยี่';
    const BAHT_TEXT_INTEGER = 'ถ้วน';
    const BAHT_TEXT_BAHT = 'บาท';
    const BAHT_TEXT_SATANG = 'สตางค์';
    const BAHT_TEXT_POINT = 'จุด';
    const sfielda = array(
        '0' => 'reward',
        // '1' => null,
        '2' => 'GMEC',
        '3' => null,
        '4' => 'IMOCSEA',
        '5' => 'INFINITE Spelling Bee',
        '6' => 'GELOSEA',
        '7' => 'LIMOC',
        '8' => 'STEM',
        '9' => 'OLPCS',
        '10' => 'ASIAROPE',
        '11' => 'Cambridge',
        '12' => null,
        '13' => 'ISOCSEA',
        '14' => 'IMOCSEA+ISOCSEA',
        '15' => 'Huaxiacup',
        '16' => 'Mathleague',
        '17' => 'test_field',
        '18' => 'mathleague-II',
        '19' => 'Huaxiacup-II',
        '20' => 'Neo science',
        '21' => 'Neo science',
        '22' => 'chai-Final',
        '23' => 'ihcmi',
        '24' => 'isc',
        '25' => 'seacso',
        '26' => 'copernicus',
        '27' => 'coding-olympics',
        '28' => 'imocsea_special',
        '29' => 'stemco_science',
        '30' => 'advance_english_grammar',
        '31' => 'isocsea_imocsea_national_round_2025 ( มา )',
        '32' => 'isocsea_imocsea_national_round_2025 ( ไม่มา )'
    );
    const sfieldas = array(
        '0' => 'IMG Reward',
        // '1' => null,
        '2' => 'G',
        '3' => null,
        '4' => 'J',
        '5' => 'I',
        '6' => 'L',
        '7' => 'M',
        '8' => 'N',
        '9' => 'O',
        '10' => 'P',
        '11' => 'Q',
        '12' => null,
        '13' => 'S',
        '14' => 'T',
        '15' => 'U',
        '16' => 'V',
        '17' => 'Test Field',
        '18' => 'mathleague-II',
        '19' => 'Huaxiacup-II',
        '20' => 'neos',
        '21' => 'neos-2',
        '22' => 'chai-Final',
        '23' => 'ihcmi',
        '24' => 'isc',
        '25' => 'seacso',
        '26' => 'copernicus',
        '27' => 'coding-olympics',
        '28' => 'imocsea_special',
        '29' => 'stemco_science',
        '30' => 'advance_english_grammar',
        '31' => 'isocsea_imocsea_national_round_2025',
        '32' => 'isocsea_imocsea_national_round',
    );
    const thmonth = array(
        "",
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม"
    );
    const enmonth = array(
        "",
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    );

    private function getMergedSfieldMappings(): array
    {
        $sfielda = self::sfielda;
        $sfieldas = self::sfieldas;

        $forms = FormManage::orderBy('sfield', 'asc')->get(['sfield', 'form_name', 'form_route']);

        foreach ($forms as $form) {
            if ($form->sfield === null) {
                continue;
            }

            $key = (string)$form->sfield;
            $formName = trim((string)($form->form_name ?? ''));
            $formRoute = trim((string)($form->form_route ?? ''));

            if ($formName === '' && $formRoute === '') {
                continue;
            }

            if (!array_key_exists($key, $sfielda) || empty($sfielda[$key])) {
                $sfielda[$key] = $formName !== '' ? $formName : $formRoute;
            }

            if (!array_key_exists($key, $sfieldas) || empty($sfieldas[$key])) {
                $sfieldas[$key] = $formRoute !== '' ? $formRoute : $formName;
            }
        }

        return [$sfielda, $sfieldas];
    }

    private function convertDigit($digit)
    {
        switch ($digit) {
            case '0':
                return 'zero';
            case '1':
                return 'one';
            case '2':
                return 'two';
            case '3':
                return 'three';
            case '4':
                return 'four';
            case '5':
                return 'five';
            case '6':
                return 'six';
            case '7':
                return 'seven';
            case '8':
                return 'eight';
            case '9':
                return 'nine';
        }
    } //convertDigit


    /**
     * convert group of number scale.
     *
     * @param integer $index
     * @return string
     */
    private function convertGroup($index)
    {
        switch ($index) {
            case 11:
                return ' decillion';
            case 10:
                return ' nonillion';
            case 9:
                return ' octillion';
            case 8:
                return ' septillion';
            case 7:
                return ' sextillion';
            case 6:
                return ' quintrillion';
            case 5:
                return ' quadrillion';
            case 4:
                return ' trillion';
            case 3:
                return ' billion';
            case 2:
                return ' million';
            case 1:
                return ' thousand';
            case 0:
                return '';
        }
    } // convertGroup

    /**
     * convert the number (and with dot).
     *
     * @param number $num number integer or decimal. negative or positive.
     * @return string translated number to text in Thai language.
     */
    public function convertNumber($num)
    {
        $num = strval($num);

        if (strpos($num, '.') !== false) {
            list($num, $dec) = explode('.', $num);
        } else {
            $dec = 0;
        }

        $output = '';

        if ($num[0] == '-') {
            $output = 'negative ';
            $num = ltrim($num, '-');
        } else if ($num[0] == '+') {
            $output = 'positive ';
            $num = ltrim($num, '+');
        }

        if ($num == '0') {
            $output .= 'zero';
        } else {
            if (strlen($num) > 36) {
                return 'Error!';
            }

            $num = str_pad($num, 36, '0', STR_PAD_LEFT);
            $group = rtrim(chunk_split($num, 3, ' '), ' ');
            $groups = explode(' ', $group);

            $groups2 = array();
            foreach ($groups as $g) {
                $groups2[] = $this->convertThreeDigit($g[0], $g[1], $g[2]);
            } // endforeach;

            for ($z = 0; $z < count($groups2); $z++) {
                if ($groups2[$z] != '') {
                    $output .= $groups2[$z] . $this->convertGroup(11 - $z) . ($z < 11 && !array_search('', array_slice($groups2, $z + 1, -1)) && $groups2[11] != '' && $groups[11][0] == '0' ? ' and ' : ', ');
                }
            } // endfor;

            $output = rtrim($output, ', ');
        } // endif;

        if ($dec > 0) {
            $output .= ' point';
            for ($i = 0; $i < strlen($dec); $i++) {
                $output .= ' ' . $this->convertDigit($dec[$i]);
            } // endfor;

        } // endif;
        else {
            $output .= ' Bath only ';
        }

        return $output;
    } // convertNumber


    /**
     * convert three digit.
     *
     * @param integer $dig1
     * @param integer $dig2
     * @param integer $dig3
     * @return string
     */
    private function convertThreeDigit($dig1, $dig2, $dig3)
    {
        $output = '';

        if ($dig1 == '0' && $dig2 == '0' && $dig3 == '0') {
            return '';
        }

        if ($dig1 != '0') {
            $output .= $this->convertDigit($dig1) . ' hundred';
            if ($dig2 != '0' || $dig3 != '0') {
                $output .= ' and ';
            }
        }

        if ($dig2 != '0') {
            $output .= $this->convertTwoDigit($dig2, $dig3);
        } else if ($dig3 != '0') {
            $output .= $this->convertDigit($dig3);
        }

        return $output;
    } // convertThreeDigit


    /**
     * convert two digits
     *
     * @param integer $dig1
     * @param integer $dig2
     * @return string
     */
    private function convertTwoDigit($dig1, $dig2)
    {
        if ($dig2 == '0') {
            switch ($dig1) {
                case '1':
                    return 'ten';
                case '2':
                    return 'twenty';
                case '3':
                    return 'thirty';
                case '4':
                    return 'forty';
                case '5':
                    return 'fifty';
                case '6':
                    return 'sixty';
                case '7':
                    return 'seventy';
                case '8':
                    return 'eighty';
                case '9':
                    return 'ninety';
            }
        } else if ($dig1 == '1') {
            switch ($dig2) {
                case '1':
                    return 'eleven';
                case '2':
                    return 'twelve';
                case '3':
                    return 'thirteen';
                case '4':
                    return 'fourteen';
                case '5':
                    return 'fifteen';
                case '6':
                    return 'sixteen';
                case '7':
                    return 'seventeen';
                case '8':
                    return 'eighteen';
                case '9':
                    return 'nineteen';
            }
        } else {
            $temp = $this->convertDigit($dig2);
            switch ($dig1) {
                case '2':
                    return "twenty-$temp";
                case '3':
                    return "thirty-$temp";
                case '4':
                    return "forty-$temp";
                case '5':
                    return "fifty-$temp";
                case '6':
                    return "sixty-$temp";
                case '7':
                    return "seventy-$temp";
                case '8':
                    return "eighty-$temp";
                case '9':
                    return "ninety-$temp";
            }
        }
    } // convertTwoDigit

    public function textWatermark($image, $text)
    {

        $imagePath = public_path('receipt_form_images/' . $image);

        if (file_exists($imagePath)) {
            $img = Image::make($imagePath);
        } else {
            $img = null;
        }

        // dd($img);
        if ($img) {
            # code...
            $img->text($text, 610, 670, function ($font) {
                $font->file(public_path('font/amandasignature.ttf'));
                $font->size(60);
                $font->color('#ff0000');
                $font->align('center');
                $font->valign('bottom');
                $font->angle(80);
            });

            $img->save(public_path('receipt_form_watermark_images/' . $image));

            $img->encode('png');
            $type = 'png';
            $new_image = 'data:image/' . $type . ';base64,' . base64_encode($img);

            return  $new_image;
        } else {
            return null;
        }


        //return view('show_watermark', compact('new_image'));
    }

    public function URL_exists($url)
    {
        $headers = get_headers($url);
        return stripos($headers[0], "200 OK") ? true : false;
    }

    public function get_img_url($url)
    {
        //$url = "https://www.jotform.com/uploads/metaknowledge2022/230067598816466/5503526223327192231/receipt_20230124135338.png";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $a = curl_exec($ch); // $a will contain all headers

        $url_return = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // This is what you need, it will return you the last effective URL

        return $url_return;
    }

    /**
     * Convert baht number to Thai text
     * @param double|int $number
     * @param bool $include_unit
     * @param bool $display_zero
     * @return string|null
     */
    public function baht_text($number, $include_unit = true, $display_zero = true)
    {

        if (!is_numeric($number)) {
            return null;
        }

        $log = floor(log($number, 10));
        if ($log > 5) {
            $millions = floor($log / 6);
            $million_value = pow(1000000, $millions);
            $normalised_million = floor($number / $million_value);
            $rest = $number - ($normalised_million * $million_value);
            $millions_text = '';
            for ($i = 0; $i < $millions; $i++) {
                $millions_text .= self::BAHT_TEXT_UNITS[6];
            }
            return $this($normalised_million, false) . $millions_text . $this($rest, true, false);
        }

        $number_str = (string)floor($number);
        $text = '';
        $unit = 0;

        if ($display_zero && $number_str == '0') {
            $text = self::BAHT_TEXT_NUMBERS[0];
        } else for ($i = strlen($number_str) - 1; $i > -1; $i--) {
            $current_number = (int)$number_str[$i];

            $unit_text = '';
            if ($unit == 0 && $i > 0) {
                $previous_number = isset($number_str[$i - 1]) ? (int)$number_str[$i - 1] : 0;
                if ($current_number == 1 && $previous_number > 0) {
                    $unit_text .= self::BAHT_TEXT_ONE_IN_TENTH;
                } else if ($current_number > 0) {
                    $unit_text .= self::BAHT_TEXT_NUMBERS[$current_number];
                }
            } else if ($unit == 1 && $current_number == 2) {
                $unit_text .= self::BAHT_TEXT_TWENTY;
            } else if ($current_number > 0 && ($unit != 1 || $current_number != 1)) {
                $unit_text .= self::BAHT_TEXT_NUMBERS[$current_number];
            }

            if ($current_number > 0) {
                $unit_text .= self::BAHT_TEXT_UNITS[$unit];
            }

            $text = $unit_text . $text;
            $unit++;
        }

        if ($include_unit) {
            $text .= self::BAHT_TEXT_BAHT;

            $satang = explode('.', number_format($number, 2, '.', ''))[1];
            $text .= $satang == 0
                ? self::BAHT_TEXT_INTEGER
                : $this->baht_text($satang, false) . self::BAHT_TEXT_SATANG;
        } else {
            $exploded = explode('.', $number);
            if (isset($exploded[1])) {
                $text .= self::BAHT_TEXT_POINT;
                $decimal = (string)$exploded[1];
                for ($i = 0; $i < strlen($decimal); $i++) {
                    $text .= self::BAHT_TEXT_NUMBERS[$decimal[$i]];
                }
            }
        }

        return $text;
    }

    public function check_permission()
    {
        if (Auth::check()) {
            if (Auth::user()->level == 1 || Auth::user()->level == 3 || Auth::user()->level == 0) {
                return true;
            } else {
                abort(403, 'Unauthorized action 1.');
            }
        } else {
            abort(403, 'Unauthorized action 2.');
            //return Redirect("login")->withSuccess('Please Login');
            //exit();
        }
    }

    public function migrateReceipt($id)
    {
        $receipts = Receipt::select(
            "receipts.id as receipt_id",
            "receipts.type as receipt_type",
            "receipts.submission_date as receipt_submission_date",
            "receipts.receipt_number as receipt_number",
            "receipts.receipt_customer_number as receipt_customer_number",
            "receipts.first_name as receipt_firstname",
            "receipts.middle_name as receipt_middlename",
            "receipts.last_name as receipt_lastname",
            "receipts.name_parent as receipt_parent_name",
            "receipts.mobile as receipt_mobile",
            "receipts.description as receipt_des",
            "receipts.package as package",
            "receipts.contest as contest",
        )
            //->join("students", "students.id", "=", "receipts.student_id")
            //->join("subjects", "subjects.id", "=", "receipts.subject_id")
            //->join("levels", "levels.id", "=", "receipts.level_id")

            ->where('receipts.sfield', $id)
            ->orderBy("receipts.id", "desc")
            ->get();

        foreach ($receipts as $result) {
            //echo $result->receipt_id . "vv";

            if ($result->package) {
                $res = preg_replace("/[^0-9.]/", "", $result->package);
            }



            $price = (int)$res;


            //echo $price . "vv";
            $des = explode("\n", $result->receipt_des);
            $i = 0;
            for ($i = 0; $i <= count($des) - 1; $i++) {
                echo $des[$i] . "vv";
                if ($i == 0) {
                    $qty = 1;
                    $uprice = $price;
                } else {
                    $qty = NULL;
                    $uprice = NULL;
                }
                $level = new ReceiptDetail([
                    'receipt_id' => $result->receipt_id,
                    'description' => $des[$i],
                    'quantity' => $qty,
                    //'unit' => '',
                    'unitprice' => $uprice,
                    //'discount' => $request->get('book'),
                    //'amount' => $request->get('book_old_price'),
                ]);
                $level->save();
            }
            //echo "<br><br>";
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function searchMonthYear($month, $year, $sfield)
    // {
    //     $receipt = Receipt::select(
    //         "receipts.id as receipt_id",
    //         "receipts.type as receipt_type",
    //         "receipts.submission_date as receipt_submission_date",
    //         "receipts.receipt_number as receipt_number",
    //         "receipts.receipt_customer_number as receipt_customer_number",
    //         "receipts.first_name as receipt_firstname",
    //         "receipts.last_name as receipt_lastname",
    //         "receipts.name_parent as receipt_parent_name",
    //         "receipts.mobile as receipt_mobile",
    //     )
    //         ->where('receipts.sfield', $sfield)
    //         ->orderBy("receipts.id", "desc")
    //         ->whereMonth('receipts.submission_date', $month)
    //         ->whereYear('receipts.submission_date', $year)
    //         ->get();

    //     return $receipt;
    // }

    public function index(Request $request)
    {
        //
        // dd($request->all());

        $this->check_permission();
        if ($request->sfield == "") {
            abort(403, 'Please input Field');
        }
        if ($request->ajax()) {
            //sleep(2);

            $receipt = Receipt::select(
                "receipts.id as receipt_id",
                "receipts.type as receipt_type",
                "receipts.exam_mode as exam_mode",
                "receipts.submission_date as receipt_submission_date",
                "receipts.receipt_number as receipt_number",
                "receipts.receipt_customer_number as receipt_customer_number",
                "receipts.first_name as receipt_firstname",
                "receipts.middle_name as receipt_middlename",
                "receipts.last_name as receipt_lastname",
                "receipts.name_parent as receipt_parent_name",
                "receipts.mobile as receipt_mobile",
                "receipts.referent_code as receipt_referent_code",
            )
                //->join("students", "students.id", "=", "receipts.student_id")
                //->join("subjects", "subjects.id", "=", "receipts.subject_id")
                //->join("levels", "levels.id", "=", "receipts.level_id")

                ->where('receipts.sfield', $request->sfield)
                ->orderBy("receipts.id", "desc");
            if ($request->start_date && $request->end_date) {
                # code...
                $receipt->whereBetween('receipts.submission_date', [$request->start_date, $request->end_date]);
            }
            if ($request->referent_code) {
                $receipt->where('receipts.referent_code', $request->referent_code);
            }

            //print_r($levels);
            //exit();
            $receipt = $receipt->get();

            return datatables()->of($receipt)
                ->editColumn('receipt_type', function (Receipt $receipt) {
                    if ($receipt->receipt_type == 2) {
                        $mes = "ใบลดหนี้";
                        $text = "Credit Note";
                    } else {

                        $mes = "ใบกำกับภาษี/ใบเสร็จรับเงิน";
                        $text = "Tax Invoice/Receipt";
                    }
                    return $mes;
                })
                ->addColumn('exam_mode', function ($row) {
                    $mode = $row->exam_mode;
                    if ($mode === 'online') {
                        return '<span class="text-dark"><i class="fas fa-laptop"></i> Online</span>';
                    } elseif ($mode === 'onsite') {
                        return '<span class="text-dark"><i class="fas fa-chalkboard-teacher"></i> Onsite</span>';
                    }
                    return '-';
                })
                ->editColumn('referent_code', function (Receipt $receipt) {
                    // dd($receipt);
                    return $receipt->receipt_referent_code;
                })
                ->editColumn('referent_name', function (Receipt $receipt) {
                    $name = '';

                    $referent_code = ReferentCode::where('referent_code', $receipt->receipt_referent_code)->first();

                    if ($referent_code) {
                        $name = $referent_code->referent_name;
                    }
                    // dd($name,$receipt->referent_code ,$receipt->referent_code);
                    return $name;
                })
                ->editColumn('checkbox', function ($row) {
                    return '<input type="checkbox" id="' . $row->receipt_id . '" class="flat" name="table_records[]" value="' . $row->receipt_id . '" >';
                })
                ->addColumn('action', function ($row) {
                    $html = '<a href="receipts/show/view/' . $row->receipt_id . '" class="btn btn-xs btn-success btn-view" id="ViewData" data-id="' . $row->receipt_id . '"><i class="fa fa-eye"></i> View </a> ';
                    $html .= '<a href="#" class="btn btn-xs btn-warning btn-edit" id="getEditData" data-id="' . $row->receipt_id . '"><i class="fa fa-edit"></i> Edit</a> ';
                    $html .= '<a href="#" class="btn btn-xs btn-info btn-edit" id="getConvData" data-id="' . $row->receipt_id . '"><i class="fa fa-code-compare"></i></i> Credit Note</a> ';
                    //$html .= '<a href="#" data-rowid="' . $row->receipt_id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
                    return $html;
                })
                ->rawColumns(['checkbox', 'action', 'exam_mode'])
                ->toJson();
        }

        //get subject
        //$subject = Subject::orderBy("id", "asc")->get();

        //get student
        //$student = Student::orderBy("name", "asc")->get();
        $referent_codes = ReferentCode::orderBy("id", "asc")->get();

        $sfieldForm = FormManage::where('sfield', $request->sfield)->first();

        // dd(self::sfielda);
        // check key is exist

        $sfielda = self::sfielda;

        if ($sfieldForm) {
            $sfielda = array_replace($sfielda, [
                (string) $sfieldForm->sfield => $sfieldForm->form_name,
            ]);
        }
        // dd($sfielda);



        return view('receipt.index ')
            ->with(['sfielda' =>  $sfielda])
            ->with(['sfield' => $request->sfield])
            ->with(['referent_codes' => $referent_codes]);
    }
    public function index_all(Request $request)
    {
        //
        // dd($request->all());

        $this->check_permission();

        if ($request->ajax()) {
            //sleep(2);

            $receipt = Receipt::select(
                "receipts.id as receipt_id",
                "receipts.type as receipt_type",
                "receipts.submission_date as receipt_submission_date",
                "receipts.receipt_number as receipt_number",
                "receipts.receipt_customer_number as receipt_customer_number",
                "receipts.first_name as receipt_firstname",
                "receipts.middle_name as receipt_middlename",
                "receipts.last_name as receipt_lastname",
                "receipts.name_parent as receipt_parent_name",
                "receipts.mobile as receipt_mobile",
                "receipts.referent_code as receipt_referent_code",
            )
                //->join("students", "students.id", "=", "receipts.student_id")
                //->join("subjects", "subjects.id", "=", "receipts.subject_id")
                //->join("levels", "levels.id", "=", "receipts.level_id")

                ->where('receipts.sfield', $request->sfield)
                ->orderBy("receipts.id", "desc");
            if ($request->start_date && $request->end_date) {
                # code...
                $receipt->whereBetween('receipts.submission_date', [$request->start_date, $request->end_date]);
            }
            if ($request->referent_code) {
                $receipt->where('receipts.referent_code', $request->referent_code);
            }

            //print_r($levels);
            //exit();
            $receipt = $receipt->get();

            return datatables()->of($receipt)
                ->editColumn('receipt_type', function (Receipt $receipt) {
                    if ($receipt->receipt_type == 2) {
                        $mes = "ใบลดหนี้";
                        $text = "Credit Note";
                    } else {

                        $mes = "ใบกำกับภาษี/ใบเสร็จรับเงิน";
                        $text = "Tax Invoice/Receipt";
                    }
                    return $mes;
                })
                ->editColumn('referent_code', function (Receipt $receipt) {
                    // dd($receipt);
                    return $receipt->receipt_referent_code;
                })
                ->editColumn('referent_name', function (Receipt $receipt) {
                    $name = '';

                    $referent_code = ReferentCode::where('referent_code', $receipt->receipt_referent_code)->first();

                    if ($referent_code) {
                        $name = $referent_code->referent_name;
                    }
                    // dd($name,$receipt->referent_code ,$receipt->referent_code);
                    return $name;
                })
                ->editColumn('checkbox', function ($row) {
                    return '<input type="checkbox" id="' . $row->receipt_id . '" class="flat" name="table_records[]" value="' . $row->receipt_id . '" >';
                })
                ->addColumn('action', function ($row) {
                    $html = '<a href="receipts/show/view/' . $row->receipt_id . '" class="btn btn-xs btn-success btn-view" id="ViewData" data-id="' . $row->receipt_id . '"><i class="fa fa-eye"></i> View </a> ';
                    $html .= '<a href="#" class="btn btn-xs btn-warning btn-edit" id="getEditData" data-id="' . $row->receipt_id . '"><i class="fa fa-edit"></i> Edit</a> ';
                    $html .= '<a href="#" class="btn btn-xs btn-info btn-edit" id="getConvData" data-id="' . $row->receipt_id . '"><i class="fa fa-code-compare"></i></i> Credit Note</a> ';
                    //$html .= '<a href="#" data-rowid="' . $row->receipt_id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
                    return $html;
                })->toJson();
        }

        $referent_codes = ReferentCode::orderBy("id", "asc")->get();

        $sfieldForm = FormManage::where('sfield', $request->sfield)->first();
        $formManage = FormManage::orderBy("id", "asc")->get();

        // dd(self::sfielda);
        // check key is exist


        $mergeArray = self::sfielda;

        foreach ($formManage as $form) {
            if (!array_key_exists($form->sfield, $mergeArray)) {
                $mergeArray[$form->sfield] = $form->form_name;
            }
        }

        // dd(self::sfielda,$sfielda);



        return view('receipt.index_all')
            ->with(['sfielda' =>  $mergeArray])
            ->with(['sfield' => $request->sfield])
            ->with(['formManage' => $mergeArray])
            ->with(['referent_codes' => $referent_codes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create
        $rnumber = Receipt_RunningNumber::pre_generate($request->get('sfield'), date("Y-m-d"));
        return response()->json(['rnumber' => $rnumber]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->check_permission();
        $validator =  Validator::make($request->all(), [
            'type' => 'required|string',
            'submission_date' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street_address' => 'required|string',
            //'city' => 'required|string',
            //'province' => 'required|string',
            'postcode' => 'required|string',
            'name_parent' => 'required|string',
            'mobile' => 'required|string',
            'package' => 'required|string',
            // 'file_att' => 'required|string
            'description' => 'required|string',
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $rnumber = Receipt_RunningNumber::generate($request->get('sfield'), $request->get('submission_date'));
        $rcnumber = Receipt_Customer_RunningNumber::generate($request->get('sfield'));
        $request->request->add(['receipt_number' => $rnumber, 'receipt_customer_number' => $rcnumber]);

        $course = new Receipt($request->all());
        $course->save();

        // บันทึก activity log — สร้าง receipt
        LogActivity::modelEvent($course, 'receipt created', null, $course->toArray());

        return response()->json(['success' => 'Receive Add successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function conv(Request $request)
    {
        //
        $this->check_permission();
        $validator =  Validator::make($request->all(), [
            'type' => 'required|string',
            'submission_date' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street_address' => 'required|string',
            'receipt_number' => 'required|string',
            'receipt_customer_number' => 'required|string',
            'postcode' => 'required|string',
            'name_parent' => 'required|string',
            'mobile' => 'required|string',
            //'package' => 'required|string',
            // 'file_att' => 'required|string
            //'description' => 'required|string',
            'grade' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //$rnumber = Receipt_RunningNumber::generate($request->get('sfield'));
        //$rcnumber = Receipt_Customer_RunningNumber::generate($request->get('sfield'));
        //$request->request->add(['receipt_number' => $rnumber, 'receipt_customer_number' => $rcnumber]);

        $conv = new Receipt($request->all());
        $conv->save();
        $rid = $conv->id;


        $rdes  = $request->get('rrdes');
        $rqty  = $request->get('rrqty');
        $runit  = $request->get('rrunit');
        $runitp  = $request->get('rrunitp');
        $rdis  = $request->get('rrdis');

        $rdata = array();
        //ReceiptDetail::where('receipt_id', $id)->delete();
        for ($xx = 0; $xx < count($rdes); $xx++) {
            $rdata = new ReceiptDetail([
                'receipt_id' => $rid,
                'description' => $rdes[$xx],
                'quantity' => $rqty[$xx],
                'unit' => $runit[$xx],
                'unitprice' => $runitp[$xx],
                'discount' => $rdis[$xx],
                //'amount' => $request->get('book_old_price'),
            ]);
            $rdata->save();
        }

        return response()->json(['success' => 'Credit Note Add successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id)
    {
        //
        $this->check_permission();
        $data = Receipt::find($id);
        $field_id = $data->sfield;

        $date_start = date("Y-m-d", strtotime('2025-02-10'));
        $date_submission = date("Y-m-d", strtotime($data->submission_date));
        // dd(
        //     $id,
        //     $data,
        //     $field_id
        // );r

        //print_r($data);
        //exit();
        if ($data->type == 2) {
            $mes = "ใบลดหนี้";
            $text = "Credit Note";
        } else {

            $mes = "ใบกำกับภาษี/ใบเสร็จรับเงิน";
            $text = "Tax Invoice/Receipt";
        }

        if ($type === "view") {
            $viewr = ($date_submission >= $date_start) ? "receipt.view_meta" : "receipt.view";
        } elseif ($type === "print") {
            $viewr = ($date_submission >= $date_start) ? "receipt.print_meta" : "receipt.print";
        }

        if ($data->package) {
            $res = preg_replace("/[^0-9.]/", "", $data->package);
        }


        //price detail
        $receipts_detail = ReceiptDetail::where('receipt_details.receipt_id', $data->id)
            ->orderBy("receipt_details.id", "asc")
            ->get();


        $all_price = 0;
        $dis_total = 0;
        $receipt_detail_arr = array();
        $no = 1;
        $x = 0;
        // dd($receipts_detail);
        foreach ($receipts_detail as $dresult) {
            $price = ($dresult['unitprice'] * $dresult['quantity']) - $dresult['discount'];
            if ($price == 0) {
                $receipt_detail_arr[$x]['no'] = '';
                $receipt_detail_arr[$x]['price'] = '';
                $receipt_detail_arr[$x]['unit'] = '';
                $receipt_detail_arr[$x]['unitprice'] = '';
                $receipt_detail_arr[$x]['quantity'] = '';
                $receipt_detail_arr[$x]['discount'] = '';
            } else {
                $receipt_detail_arr[$x]['no'] = $no;
                $receipt_detail_arr[$x]['price'] = number_format($price, 2);
                $receipt_detail_arr[$x]['unit'] = $dresult['unit'];
                $receipt_detail_arr[$x]['unitprice'] = number_format($dresult['unitprice'], 2);
                $receipt_detail_arr[$x]['quantity'] = $dresult['quantity'];
                $receipt_detail_arr[$x]['discount'] = number_format($dresult['discount'], 2);
            }

            $receipt_detail_arr[$x]['description'] = $dresult['description'];
            $all_price = $all_price + $price;
            $dis_total = $dis_total + $dresult['discount'];
            $no++;
            $x++;
        }

        //print_r($receipt_detail_arr);
        //exit();

        $price_val = number_format($all_price, 2);
        $price_text = $this->baht_text($all_price);
        $price_texten = $this->convertNumber($all_price);
        $vat_price = ($all_price * 100) / 107;
        $vat_total = $all_price - $vat_price;
        $vat_price_val = number_format($vat_price, 2);
        $vat_val = number_format($vat_total, 2);
        $discount_val = number_format($dis_total, 2);


        /* $price = (int)$res;
        $price_val = number_format($price, 2);
        $price_text = $this->baht_text($price);
        $price_texten = $this->convertNumber($price);
        $vat_price = ($price * 100) / 107;
        $vat_total = $price - $vat_price;
        $vat_price_val = number_format($vat_price, 2);
        $vat_val = number_format($vat_total, 2); */
        //exit();

        $file_att = '';

        if ($data->file_att) {
            $file_path = explode("|", $data->file_att);

            foreach ($file_path as $key => $path) {
                # code...
                $ck_url = parse_url($path);
                if ($ck_url['scheme'] == 'https') {
                    $urlf = "https";
                } else {
                    $urlf = "http";
                }
                $arrl = explode($urlf, $path);
                //dd($arrl);
                for ($i = 1; $i <= count($arrl) - 1; $i++) {
                    $urla = $urlf . $arrl[$i];
                    if (strpos($urla, "jotform")) {
                        $retu = $this->get_img_url($urla);
                    } else {
                        //watermark
                        $fileex = explode("/", $urla);

                        $this->textWatermark(end($fileex), 'Receipt Number : ' . $data->receipt_number);

                        $retu = str_replace('receipt_form_images', 'receipt_form_watermark_images', $urla);
                    }
                    //if ($this->URL_exists($retu)) {
                    $file_att .= "<img src=\"" . $retu . "\" height=\"400\">&nbsp;&nbsp;";
                    //}
                }
            }
        }
        // dd(
        //     $fileex,
        //     'path : ',
        //     $file_path,
        //     $retu,
        //     $file_att
        // );

        $app_html = '';
        if ($data->cancle == 1) {
            $app_html = '<div id="background">
            <p id="bg-text"> ยกเลิก ใบเสร็จรับเงิน </p>
            </div>';
        }



        //$des_text = nl2br($data->description);


        // dd($receipt_detail_arr);
        $company = $data->getCompanyInfo();

        return view($viewr)->with(['id' => $id])
            ->with(['data' => $data])
            ->with(['company' => $company])
            ->with(['receipt_detail_arr' => $receipt_detail_arr])
            ->with(['price_val' => $price_val])
            ->with(['mes' => $mes])
            ->with(['text' => $text])
            ->with(['app_html' => $app_html])
            ->with(['price_texten' => $price_texten])
            ->with(['price_text' => $price_text])
            ->with(['discount_val' => $discount_val])
            ->with(['vat_price_val' => $vat_price_val])
            ->with(['vat_val' => $vat_val])->with(['file_att' => $file_att]);
        //->with(['des_text' => $des_text]);
    }

    public function show_day(Request $request)
    {
        // dd($request->all());
        //
        $this->check_permission();
        $validator =  Validator::make($request->all(), [
            'pdsfield' => 'required|string',
            'print_rdate' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json(['errors' => $validator->errors()->all()]);
            return back()->with(['error' => 'Please input print day']);
        }

        $sfield = $request->get('pdsfield');
        $type = $request->get('type');
        $template = $request->get('template');

        $metaCheck = '';

        if (in_array($template, ['meta', 'meta2'])) {
            // If template is 'meta2', set metaCheck = '2'
            $metaCheck = ($template === 'meta2') ? '2' : '';
        }

        if ($type == "view") {
            $viewr = ($template === 'meta' || $template === 'meta2') ? "receipt.viewr_meta" : "receipt.viewr";
        } elseif ($type == "print") {
            $viewr = ($template === 'meta' || $template === 'meta2') ? "receipt.printr_meta" : "receipt.printr";
        }
        // dd($metaCheck, $viewr);
        // if ($type == "view") {
        //     $viewr = "receipt.viewr";
        // } else if ($type == "print") {
        //     $viewr = "receipt.printr";
        // }

        $receipts = Receipt::select(
            "receipts.id as id",
            "receipts.submission_date as receipt_submission_date",
            "receipts.receipt_number as receipt_number",
            "receipts.receipt_customer_number as receipt_customer_number",
            "receipts.first_name as receipt_firstname",
            "receipts.middle_name as receipt_middlename",
            "receipts.last_name as receipt_lastname",
            "receipts.name_parent as receipt_name_parent",
            "receipts.package as receipt_price",
            "receipts.type as receipt_type",
            "receipts.file_att as file_att",
        )
            //->join("students", "students.id", "=", "receipts.student_id")
            //->join("subjects", "subjects.id", "=", "receipts.subject_id")
            //->join("levels", "levels.id", "=", "receipts.level_id")

            ->where([
                ['receipts.sfield', $sfield],
                ['submission_date', $request->get('print_rdate')],
                ['cancle', '!=', 1]
            ])
            /* ->whereNull('cancle') */
            ->orderBy("receipts.receipt_number", "asc")
            ->get();
        //->toArray();
        // print_r($receipts);
        // exit();

        if ($receipts->isEmpty()) {
            return back()->with(['error' => 'ไม่พบข้อมูลใบเสร็จ จากวันที่ท่านเลือก']);
        }

        $i = 0;
        $ret_receipt = array();
        $total_price = 0;
        foreach ($receipts as $result) {
            if ($result->type == 2) {
                $mes = "ใบลดหนี้";
                $text = "Credit Note";
            } else {

                $mes = "ใบกำกับภาษี/ใบเสร็จรับเงิน";
                $text = "Tax Invoice/Receipt";
            }

            if ($result->receipt_price) {
                $res = preg_replace("/[^0-9.]/", "", $result->receipt_price);
            }

            //$ret_receipt[$result->id]['data'] = $receipts;
            $ret_receipt[$result->id]['mes'] = $mes;
            $ret_receipt[$result->id]['text'] = $text;
            $ret_receipt[$result->id]['number'] = $result->receipt_number;
            $ret_receipt[$result->id]['customer_number'] = $result->receipt_customer_number;
            $ret_receipt[$result->id]['first_name'] = $result->receipt_firstname;
            $ret_receipt[$result->id]['middle_name'] = $result->receipt_middlename;
            $ret_receipt[$result->id]['last_name'] = $result->receipt_lastname;
            $ret_receipt[$result->id]['name_parent'] = $result->receipt_name_parent;
            $ret_receipt[$result->id]['submission_date'] = $result->receipt_submission_date;

            //price detail
            $receipts_detail = ReceiptDetail::where('receipt_details.receipt_id', $result->id)
                ->orderBy("receipt_details.id", "asc")
                ->get();


            $all_price = 0;
            $receipt_detail_arr = array();
            $no = 1;
            $x = 0;
            foreach ($receipts_detail as $dresult) {
                $price = (int)($dresult['unitprice'] * $dresult['quantity']) - $dresult['discount'];
                if ($price == 0) {
                    $receipt_detail_arr[$x]['no'] = '';
                    $receipt_detail_arr[$x]['price'] = '';
                    $receipt_detail_arr[$x]['unit'] = '';
                    $receipt_detail_arr[$x]['unitprice'] = '';
                    $receipt_detail_arr[$x]['quantity'] = '';
                    $receipt_detail_arr[$x]['discount'] = '';
                } else {
                    $receipt_detail_arr[$x]['no'] = $no;
                    $receipt_detail_arr[$x]['price'] = number_format($price, 2);
                    $receipt_detail_arr[$x]['unit'] = $dresult['unit'];
                    $receipt_detail_arr[$x]['unitprice'] = number_format($dresult['unitprice'], 2);
                    $receipt_detail_arr[$x]['quantity'] = $dresult['quantity'];
                    $receipt_detail_arr[$x]['discount'] = number_format($dresult['discount'], 2);
                }

                $receipt_detail_arr[$x]['description'] = $dresult['description'];
                $all_price = $all_price + $price;
                $no++;
                $x++;
            }

            //print_r($receipt_detail_arr);
            //exit();

            $price_val = number_format($all_price, 2);
            $price_text = $this->baht_text($all_price);
            $price_texten = $this->convertNumber($all_price);
            $vat_price = ($all_price * 100) / 107;
            $vat_total = $all_price - $vat_price;
            $vat_price_val = number_format($vat_price, 2);
            $vat_val = number_format($vat_total, 2);

            $ret_receipt[$result->id]['price_texten'] = $price_texten;
            $ret_receipt[$result->id]['price_text'] = $price_text;
            $ret_receipt[$result->id]['price_val'] = $price_val;
            $ret_receipt[$result->id]['vat_price_val'] = $vat_price_val;
            $ret_receipt[$result->id]['vat_val'] = $vat_val;
            $ret_receipt[$result->id]['detail'] = $receipt_detail_arr;

            $file_att = '';

            if ($result->file_att) {



                $file_path = explode("|", $result->file_att);

                foreach ($file_path as $key => $path) {
                    # code...
                    $ck_url = parse_url($path);
                    if ($ck_url['scheme'] == 'https') {
                        $urlf = "https";
                    } else {
                        $urlf = "http";
                    }
                    $arrl = explode($urlf, $path);
                    //dd($arrl);
                    for ($i = 1; $i <= count($arrl) - 1; $i++) {
                        $urla = $urlf . $arrl[$i];
                        if (strpos($urla, "jotform")) {
                            $retu = $this->get_img_url($urla);
                        } else {
                            //watermark
                            $fileex = explode("/", $urla);

                            $this->textWatermark(end($fileex), 'Receipt Number : ' . $result->receipt_number);

                            $retu = str_replace('receipt_form_images', 'receipt_form_watermark_images', $urla);
                        }
                        //if ($this->URL_exists($retu)) {
                        $file_att .= "<img src=\"" . $retu . "\" height=\"400\">&nbsp;&nbsp;";
                        //}
                    }
                }
            }
            $ret_receipt[$result->id]['file_att'] = $file_att;
        }

        return view($viewr)->with(['print_date' => $request->get('print_rdate')])
            ->with(['data' => $ret_receipt])
            ->with(['template' => $template])
            ->with(['metaCheck' => $metaCheck])
            ->with(['receipt_detail_arr' => $receipt_detail_arr])
            ->with(['fontsize' => $request->get('fontsize')])
            ->with(['pdsfield' => $sfield]);
        //->with(['price_val' => $price_val])
        //->with(['mes' => $mes])
        //->with(['text' => $text])
        //->with(['price_texten' => $price_texten])
        //->with(['price_text' => $price_text])
        //->with(['vat_price_val' => $vat_price_val])
        //->with(['vat_val' => $vat_val])->with(['file_att' => $file_att]);
        //->with(['des_text' => $des_text]);
    }

    public function print_day(Request $request)
    {
        //

        $template = $request->get('printDaysTemplate');

        // dd($request->all(), $template);
        $this->check_permission();
        $validator =  Validator::make($request->all(), [
            'pdsfield' => 'required|string',
            'fontsize' => 'required|string',
            'print_date' => 'required|string',
            'print_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json(['errors' => $validator->errors()->all()]);
            return back()->with(['error' => 'Please input print day']);
        }

        $type = $request->get('type');

        $metaCheck = '';

        if (in_array($template, ['meta', 'meta2'])) {
            // If template is 'meta2', set metaCheck = '2'
            $metaCheck = ($template === 'meta2') ? '2' : '';
        }
        if ($type == "view") {
            $viewr = "receipt.print_day_view";
        } else if ($type == "print") {
            $viewr = "receipt.print_day_print";
        }

        $sfield = $request->get('pdsfield');

        $a_date = explode("-", $request->get('print_date'));

        $ymcode = (($a_date[0] - 2000) + 43) . $a_date[1];
        $thai_year = $a_date[0] + 543;
        $thai_month = self::thmonth[(int)$a_date[1]];

        $receipts = Receipt::select(
            "receipts.id as receipt_id",
            "receipts.submission_date as receipt_submission_date",
            "receipts.receipt_number as receipt_number",
            "receipts.first_name as receipt_firstname",
            "receipts.middle_name as receipt_middlename",
            "receipts.last_name as receipt_lastname",
            "receipts.package as receipt_price",
            "receipts.type as receipt_type",
            "receipts.cancle as cancle",
        )
            //->join("students", "students.id", "=", "receipts.student_id")
            //->join("subjects", "subjects.id", "=", "receipts.subject_id")
            //->join("levels", "levels.id", "=", "receipts.level_id")

            ->where([['receipts.sfield', $sfield], ['submission_date', $request->get('print_date')]])
            ->orderBy("receipts.receipt_number", "asc")
            ->get();
        //->toArray();
        // print_r($receipts);
        // exit();

        $i = 0;
        $ret_receipt = array();
        $total_price = 0;
        foreach ($receipts as $result) {
            $ret_receipt[$i]['receipt_submission_date'] = $result->receipt_submission_date;
            $ret_receipt[$i]['receipt_number'] = $result->receipt_number;
            $ret_receipt[$i]['receipt_firstname'] = $result->receipt_firstname;
            $ret_receipt[$i]['receipt_lastname'] = $result->receipt_lastname;
            $ret_receipt[$i]['receipt_type'] = $result->receipt_type;
            $ret_receipt[$i]['cancle'] = $result->cancle;

            /* $res = preg_replace("/[^0-9.]/", "", $result->receipt_price);
            $price = (int)$res; */
            //get price from item
            $receipts_detail = ReceiptDetail::where('receipt_details.receipt_id', $result->receipt_id)
                ->orderBy("receipt_details.id", "asc")
                ->get();

            $price = 0;
            $desresult = '';
            foreach ($receipts_detail as $dresult) {
                $rprice = ($dresult['unitprice'] * $dresult['quantity']) - $dresult['discount'];
                $price = $price + $rprice;
                $desresult .= $dresult['description'] . " ";
            }

            $ret_receipt[$i]['receipt_des'] = '';
            if ($ret_receipt[$i]['receipt_type'] == 2) {
                $ret_receipt[$i]['receipt_type'] = "ใบลดหนี้";
                $price = $price * -1;
                $ret_receipt[$i]['receipt_des'] = $desresult;
            } elseif ($ret_receipt[$i]['cancle'] == 1) {
                $ret_receipt[$i]['receipt_type'] = "ยกเลิก";
                $price = $price * -1;
                $ret_receipt[$i]['receipt_des'] = "<font color='red'>( ยกเลิก )</font>";
            }

            $price_val = number_format($price, 2);

            $ret_receipt[$i]['receipt_price'] = $price_val;
            $ret_receipt[$i]['receipt_price_label'] = "บาท";


            if ($ret_receipt[$i]['cancle'] !== 1) {
                $total_price = ($total_price + $price);
            }
            $i++;
        }

        $pagen = 0;
        if ($i < 19) {
            $pagen = 19;
        } elseif ($i > 19 and $i < 38) {
            $pagen = 19;
        }

        if (count($ret_receipt) < $pagen) {
            $start = $i;
            $em = $pagen - count($ret_receipt) + $start;
            for ($x = $start; $x <= $em; $x++) {
                $ret_receipt[$x]['receipt_submission_date'] = "";
                $ret_receipt[$x]['receipt_number'] = "";
                $ret_receipt[$x]['receipt_firstname'] = "";
                $ret_receipt[$x]['receipt_lastname'] = "";
                $ret_receipt[$x]['receipt_price'] = "";
                $ret_receipt[$x]['receipt_des'] = "";
                $ret_receipt[$x]['receipt_price_label'] = "";
                $ret_receipt[$x]['receipt_type'] = "";
            }
        }
        //echo $start;
        //print_r($ret_receipt);
        //exit();

        [$mergedSfielda, $mergedSfieldas] = $this->getMergedSfieldMappings();

        // dd($mergedSfielda, $mergedSfieldas);

        return view($viewr)->with(['sfield' => $sfield])
            ->with(['template' =>  $template])
            ->with(['metaCheck' =>  $metaCheck])
            ->with(['sfieldas' =>  $mergedSfieldas])
            ->with(['sfielda' =>  $mergedSfielda])
            ->with(['ymcode' =>  $ymcode])
            ->with(['thaiyear' =>  $thai_year])
            ->with(['thaimonth' =>  $thai_month])
            ->with(['data' => $ret_receipt])
            ->with(['pdsfield' => $request->get('pdsfield')])
            ->with(['print_date' => $request->get('print_date')])
            ->with(['fontsize' => $request->get('fontsize')])
            ->with(['total_price' => number_format($total_price, 2)])
            ->with(['print_number' =>  $request->get('print_number')])
            ->with(
                ['fprint_number' =>  sprintf("%02d", $request->get('print_number'))]
            );
    }

    public function print_month(Request $request)
    {

        $template = $request->get('printMonthTemplate');

        $this->check_permission();
        $validator =  Validator::make($request->all(), [
            'pmsfield' => 'required|string',
            'print_month' => 'required|string',
            'Pmdescription' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json(['errors' => $validator->errors()->all()]);
            return back()->with(['error' => 'Please input all field ']);
        }

        $type = $request->get('type');

        $metaCheck = '';

        if (in_array($template, ['meta', 'meta2'])) {
            // If template is 'meta2', set metaCheck = '2'
            $metaCheck = ($template === 'meta2') ? '2' : '';
        }
        if ($type == "view") {
            $viewr = "receipt.print_month_view";
        } else if ($type == "print") {
            $viewr = "receipt.print_month_print";
        } else if ($type == "report_view") {
            $viewr = "receipt.report_month_view";
        }

        $sfield = $request->get('pmsfield');

        $a_month = explode("-", $request->get('print_month'));

        $ymcode = (($a_month[0] - 2000) + 43) . $a_month[1];
        $thai_year = $a_month[0] + 543;
        $thai_month = self::thmonth[(int)$a_month[1]];

        $receipts = Receipt::select(
            "receipts.id as receipt_id",
            "receipts.submission_date as receipt_submission_date",
            "receipts.receipt_number as receipt_number",
            "receipts.first_name as receipt_firstname",
            "receipts.middle_name as receipt_middlename",
            "receipts.last_name as receipt_lastname",
            "receipts.package as receipt_price",
            "receipts.type as receipt_type",
            "receipts.cancle as cancle",

        )
            //->join("students", "students.id", "=", "receipts.student_id")
            //->join("subjects", "subjects.id", "=", "receipts.subject_id")
            //->join("levels", "levels.id", "=", "receipts.level_id")
            ->where([['receipts.sfield', $sfield], ['submission_date', 'LIKE', $request->get('print_month') . '%']])
            ->orderBy("receipts.submission_date", "asc")
            ->orderBy("receipts.id", "asc")
            ->get();
        // ->toArray();

        // print_r($receipts);
        // exit();
        $i = 0;
        $ret_receipt = array();
        $total_price = 0;
        $lastdate = "";
        $lastprice = 0;
        $chart_date = "";
        $chart_date_price = "";
        $rtype2 = '';
        foreach ($receipts as $result) {

            //check last date
            if ($result->receipt_submission_date !== $lastdate) {
                $i = 0;
                $lastprice = 0;
                $rtype2 = '';
            }


            $ret_receipt[$result->receipt_submission_date]['receipt_submission_date'] = $result->receipt_submission_date;
            if ($result->receipt_type !== 2) {
                $ret_receipt[$result->receipt_submission_date]['receipt_numberm'][$i] = $result->receipt_number;
            } else {
                $ret_receipt[$result->receipt_submission_date]['receipt_numberm'][$i] = '';
            }
            $ret_receipt[$result->receipt_submission_date]['receipt_number'][$i] = $result->receipt_number;

            $maxdate = max(array_keys($ret_receipt[$result->receipt_submission_date]['receipt_numberm']));
            $ret_receipt[$result->receipt_submission_date]['receipt_numbers'] = $ret_receipt[$result->receipt_submission_date]['receipt_number'][0] . ' - ' . $ret_receipt[$result->receipt_submission_date]['receipt_numberm'][$maxdate];
            $ret_receipt[$result->receipt_submission_date]['receipt_type'][$i] = $result->receipt_type;
            $ret_receipt[$result->receipt_submission_date]['cancle'][$i] = $result->cancle;

            /* $res = preg_replace("/[^0-9.]/", "", $result->receipt_price);
            $price = (int)$res; */
            //get price from item
            $receipts_detail = ReceiptDetail::where('receipt_details.receipt_id', $result->receipt_id)
                ->orderBy("receipt_details.id", "asc")
                ->get();

            $price = 0;
            $desresult = '';

            foreach ($receipts_detail as $dresult) {
                $rprice = ($dresult['unitprice'] * $dresult['quantity']) - $dresult['discount'];
                $price = $price + $rprice;

                /*   if ($result->receipt_type == 2) {

                    $desresult = $dresult['description'] . " ";
                } */
            }

            $price_val = number_format($price, 2);
            if ($result->receipt_type == 2) {
                $price = $price * -1;
                $rtype2 .= $ret_receipt[$result->receipt_submission_date]['receipt_number'][$i] . ' ';
            }

            if ($result->cancle == 1) {
                $price = $price * -1;
                $rtype2 .= "<font color='red'>( ยกเลิก ) " . $ret_receipt[$result->receipt_submission_date]['receipt_number'][$i] . ' </font>';
            }


            $ret_receipt[$result->receipt_submission_date]['description'] = $request->get('Pmdescription') . ' ' . $rtype2;
            $ret_receipt[$result->receipt_submission_date]['receipt_price'] = $price;
            $ret_receipt[$result->receipt_submission_date]['receipt_price_label'] = "บาท";
            if ($result->cancle == 0) {
                $lastprice = $lastprice + $ret_receipt[$result->receipt_submission_date]['receipt_price'];
            }
            $ret_receipt[$result->receipt_submission_date]['last_price'] =  $lastprice;
            $ret_receipt[$result->receipt_submission_date]['total_price'] =  number_format($lastprice, 2);

            $lastdate = $ret_receipt[$result->receipt_submission_date]['receipt_submission_date'];

            //$rtype2='';
            if ($result->cancle == 0) {
                $total_price = ($total_price + $price);
            }
            $i++;
        }

        //dd($ret_receipt[$result->receipt_submission_date]['receipt_numberm']);
        $numrec = count($ret_receipt);
        $pagen = 0;
        if ($numrec < 19) {
            $pagen = 22;
        } elseif ($numrec > 19 and $numrec < 38) {
            $pagen = 22;
        }

        foreach ($ret_receipt as $receipt) {
            $chartd = explode("-", $receipt['receipt_submission_date']);
            $chart_date .= "'" . $chartd[1] . '-' . $chartd[2] . "',";
            $chart_date_price .= $receipt['last_price'] . ",";
        }

        $chart_date = rtrim($chart_date, ',');;
        $chart_date_price = rtrim($chart_date_price, ',');;



        if ($type !== "report_view") {

            if (count($ret_receipt) < $pagen) {
                $start = $i;
                $em = $pagen - count($ret_receipt) + $start;
                for ($x = $start; $x <= $em; $x++) {
                    $ret_receipt[$x]['receipt_submission_date'] = "";
                    $ret_receipt[$x]['receipt_numbers'] = "";
                    $ret_receipt[$x]['total_price'] = "";
                    $ret_receipt[$x]['receipt_firstname'] = "";
                    $ret_receipt[$x]['receipt_lastname'] = "";
                    $ret_receipt[$x]['receipt_price'] = "";
                    $ret_receipt[$x]['receipt_price_label'] = "";
                    $ret_receipt[$x]['description'] = "";
                }
            }
        }

        //print_r($ret_receipt);
        //exit();
        [$mergedSfielda, $mergedSfieldas] = $this->getMergedSfieldMappings();
        return view($viewr)->with(['sfield' => $sfield])->with(['sfielda' =>  $mergedSfielda])
            ->with(['sfieldas' =>  $mergedSfieldas])
            ->with(['ymcode' =>  $ymcode])
            ->with(['template' =>  $template])
            ->with(['metaCheck' =>  $metaCheck])
            ->with(['thaiyear' =>  $thai_year])
            ->with(['thaimonth' =>  $thai_month])
            ->with(['chart_date' =>  $chart_date])
            ->with(['chart_date_price' => $chart_date_price])
            ->with(['data' => $ret_receipt])
            ->with(['fontsize' => $request->get('fontsize')])
            ->with(['pmsfield' => $request->get('pmsfield')])
            ->with(['pmdes' => $request->get('Pmdescription')])
            ->with(['print_month' => $request->get('print_month')])
            ->with(['total_price' => number_format($total_price, 2)]);
        //->with(['print_number' =>  $request->get('print_number')])
        //->with(['fprint_number' =>  sprintf("%02d", $request->get('print_number'))]);
    }


    public function print_field(Request $request)
    {
        [$mergedSfielda, $mergedSfieldas] = $this->getMergedSfieldMappings();

        $template = $request->get('printFieldTemplate');

        $this->check_permission();
        $validator =  Validator::make($request->all(), [
            'pmsfield' => 'required|string',
            'Pmdescription' => 'required|string',
        ]);

        if ($validator->fails()) {
            //return response()->json(['errors' => $validator->errors()->all()]);
            return back()->with(['error' => 'Please input all field ']);
        }

        $type = $request->get('type');
        if (in_array($template, ['meta', 'meta2'])) {
            // If template is 'meta2', set metaCheck = '2'
            $metaCheck = ($template === 'meta2') ? '2' : '';
        }
        if ($type == "view") {
            $viewr = "receipt.print_field_view";
        } else if ($type == "print") {
            $viewr = "receipt.print_field_print";
            // dd($request);
        }

        $sfield = $request->get('pmsfield');
        $month_year = $request->get('print_monthYear');
        list($start_year, $start_month, $end_year, $end_month) = explode('-', str_replace(' ', '', $month_year));
        $receipts = Receipt::select(
            "receipts.id as receipt_id",
            "receipts.submission_date as receipt_submission_date",
            "receipts.receipt_number as receipt_number",
            "receipts.first_name as receipt_firstname",
            "receipts.middle_name as receipt_middlename",
            "receipts.last_name as receipt_lastname",
            "receipts.package as receipt_price",
            "receipts.type as receipt_type",
            "receipts.cancle as cancle",

        )
            //->join("students", "students.id", "=", "receipts.student_id")
            //->join("subjects", "subjects.id", "=", "receipts.subject_id")
            //->join("levels", "levels.id", "=", "receipts.level_id")
            ->where([['receipts.sfield', $sfield]])
            ->whereYear('receipts.submission_date', '>=', $start_year)
            ->whereYear('receipts.submission_date', '<=', $end_year)
            ->whereMonth('receipts.submission_date', '>=', $start_month)
            ->whereMonth('receipts.submission_date', '<=', $end_month)
            ->orderBy("receipts.submission_date", "asc")
            ->get();
        // ->toArray();

        // foreach ($receipts as $key => $receipt) {
        //     # code...
        //     dd($receipt, $request);
        // }
        // dd($receipts, $request);

        // print_r($receipts);
        // exit();
        $i = 0;
        $ret_receipt = array();
        $total_price = 0;
        $lastmonth = "";
        $lastprice = 0;
        $chart_date = "";
        $chart_date_price = "";
        $rtype2 = '';
        foreach ($receipts as $result) {


            $a_month = explode("-", $result->receipt_submission_date);

            $ymcode = (($a_month[0] - 2000) + 43) . $a_month[1];
            $thai_year = $a_month[0] + 543;
            $thai_month = self::thmonth[(int)$a_month[1]];


            //check last date
            if ($ymcode !== $lastmonth) {
                $i = 0;
                $lastprice = 0;
                $rtype2 = '';
            }


            $ret_receipt[$ymcode]['receipt_submission_date'] = $ymcode;
            $ret_receipt[$ymcode]['receipt_submission_month'] = self::enmonth[(int)$a_month[1]];
            $ret_receipt[$ymcode]['field_code'] = $mergedSfieldas[$sfield] . " " . $ymcode;
            $ret_receipt[$ymcode]['receipt_number'][$i] = $result->receipt_number;
            $maxdate = max(array_keys($ret_receipt[$ymcode]['receipt_number']));
            $ret_receipt[$ymcode]['receipt_numbers'] = $ret_receipt[$ymcode]['receipt_number'][0] . ' - ' . $ret_receipt[$ymcode]['receipt_number'][$maxdate];
            $ret_receipt[$ymcode]['receipt_type'][$i] = $result->receipt_type;
            $ret_receipt[$ymcode]['cancle'][$i] = $result->cancle;

            /* $res = preg_replace("/[^0-9.]/", "", $result->receipt_price);
            $price = (int)$res; */
            //get price from item
            $receipts_detail = ReceiptDetail::where('receipt_details.receipt_id', $result->receipt_id)
                ->orderBy("receipt_details.id", "asc")
                ->get();

            $price = 0;
            $desresult = '';

            foreach ($receipts_detail as $dresult) {
                $rprice = ($dresult['unitprice'] * $dresult['quantity']) - $dresult['discount'];
                $price = $price + $rprice;

                /*   if ($result->receipt_type == 2) {

                    $desresult = $dresult['description'] . " ";
                } */
            }

            $price_val = number_format($price, 2);
            if ($result->receipt_type == 2) {
                $price = $price * -1;
                $rtype2 .= $ret_receipt[$ymcode]['receipt_number'][$i] . ' ';
            }
            $rtype3 = '';
            if ($result->cancle == 1) {
                $price = $price * -1;
                $rtype3 .= "<font color='red'>( ยกเลิก ) " . $ret_receipt[$ymcode]['receipt_number'][$i] . ' </font>';
            }



            $ret_receipt[$ymcode]['description'] = $request->get('Pmdescription')  . ' ' . $rtype3;
            $ret_receipt[$ymcode]['receipt_price'] = $price;
            $ret_receipt[$ymcode]['receipt_price_label'] = "บาท";
            if ($result->cancle == 0) {
                $lastprice = $lastprice + $ret_receipt[$ymcode]['receipt_price'];
            }
            $ret_receipt[$ymcode]['last_price'] =  $lastprice;
            $ret_receipt[$ymcode]['total_price'] =  number_format($lastprice, 2);

            $lastmonth = $ret_receipt[$ymcode]['receipt_submission_date'];

            //$rtype2='';
            if ($result->cancle == 0) {
                $total_price = ($total_price + $price);
            }
            $i++;
        }


        //dd($ret_receipt);
        //echo $total_price;
        //exit();


        $numrec = count($ret_receipt);
        $pagen = 0;
        if ($numrec < 19) {
            $pagen = 22;
        } elseif ($numrec > 19 and $numrec < 38) {
            $pagen = 22;
        }




        if ($type !== "report_view") {

            if (count($ret_receipt) < $pagen) {
                $start = $i;
                $em = $pagen - count($ret_receipt) + $start;
                for ($x = $start; $x <= $em; $x++) {
                    $ret_receipt[$x]['receipt_submission_date'] = "";
                    $ret_receipt[$x]['receipt_submission_month'] = "";
                    $ret_receipt[$x]['receipt_numbers'] = "";
                    $ret_receipt[$x]['field_code'] = "";
                    $ret_receipt[$x]['total_price'] = "";
                    $ret_receipt[$x]['receipt_firstname'] = "";
                    $ret_receipt[$x]['receipt_lastname'] = "";
                    $ret_receipt[$x]['receipt_price'] = "";
                    $ret_receipt[$x]['receipt_price_label'] = "";
                    $ret_receipt[$x]['description'] = "";
                }
            }
        }

        //print_r($ret_receipt);
        //exit();
        // dd($total_price);
        if ($total_price > 1) {
            # code...
            return view($viewr)
                ->with(['sfield' => $sfield])
                ->with(['sfielda' =>  $mergedSfielda])
                ->with(['sfieldas' =>  $mergedSfieldas])
                ->with(['data' => $ret_receipt])
                ->with(['template' =>  $template])
                ->with(['metaCheck' =>  $metaCheck])

                ->with(['ymcode' =>  $ymcode])
                ->with(['thaiyear' =>  $thai_year])
                ->with(['thaimonth' =>  $thai_month])
                //->with(['chart_date' =>  $chart_date])
                //->with(['chart_date_price' => $chart_date_price])
                ->with(['fontsize' => $request->get('fontsize')])
                ->with(['pmsfield' => $request->get('pmsfield')])
                ->with(['pmdes' => $request->get('Pmdescription')])
                ->with(['month_year' => $month_year])
                //->with(['print_month' => $request->get('print_month')])
                ->with(['total_price' => number_format($total_price, 2)]);
            //->with(['print_number' =>  $request->get('print_number')])
            //->with(['fprint_number' =>  sprintf("%02d", $request->get('print_number'))]);
        } else {
            # code...

            return view($viewr)
                ->with(['sfield' => $sfield])
                ->with(['sfielda' =>  $mergedSfielda])
                ->with(['sfieldas' =>  $mergedSfieldas])
                ->with(['data' => $ret_receipt])

                ->with(['ymcode' =>  ' '])
                ->with(['thaiyear' =>  ' '])
                ->with(['thaimonth' =>  ' '])
                //->with(['chart_date' =>  $chart_date])
                //->with(['chart_date_price' => $chart_date_price])
                ->with(['fontsize' => $request->get('fontsize')])
                ->with(['pmsfield' => $request->get('pmsfield')])
                ->with(['month_year' => $month_year])
                ->with(['template' =>  $template])
                ->with(['metaCheck' =>  $metaCheck])


                ->with(['pmdes' => $request->get('Pmdescription')])
                //->with(['print_month' => $request->get('print_month')])
                ->with(['total_price' => number_format('0', 2)]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type)
    {
        //
        $this->check_permission();
        $data = Receipt::find($id);



        $receipts_detail = ReceiptDetail::where('receipt_details.receipt_id', $id)
            ->orderBy("receipt_details.id", "asc")
            ->get();

        $x = 1;
        $data_html = '';
        $input_name = '';
        if ($type == 2) {
            $input_name = 'r';
        }
        foreach ($receipts_detail as $dresult) {

            $data_html .= '<tr class="firstTr">
            <td width="10%">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="text" id="rno[]" name="rno[]"
                        class="form-control has-feedback-left" value="' . $x . '">
                        <!--<input name="rid[]"  id="rid[]" type="hidden" value="' . $dresult['id'] . '" />-->
                </div>
            </td>
            <td width="35%">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="text" id="' . $input_name . 'rdes[]" name="' . $input_name . 'rdes[]"
                    class="form-control has-feedback-left" value="' . $dresult['description'] . '">
                </div>
            </td>
            <td width="10%">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="text" id="' . $input_name . 'rqty[]" name="' . $input_name . 'rqty[]"
                    class="form-control has-feedback-left" value="' . $dresult['quantity'] . '">
                </div>
            </td>

            <td width="15%">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="text" id="' . $input_name . 'runit[]" name="' . $input_name . 'runit[]"
                    class="form-control has-feedback-left" value="' . $dresult['unit'] . '">
                </div>
            </td>
            <td width="15%">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="text" id="' . $input_name . 'runitp[]" name="' . $input_name . 'runitp[]"
            class="form-control has-feedback-left" value="' . $dresult['unitprice'] . '">
        </div>
            </td>

            <td width="15%">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="text" id="' . $input_name . 'rdis[]" name="' . $input_name . 'rdis[]"
                    class="form-control has-feedback-left" value="' . $dresult['discount'] . '">
                </div>
            </td>

            <!--<td><button type="button" id="removeRowt"
                    class="btn btn-sm btn-danger btnRemoveg"><i
                        class="fa fa-minus"></i></button></td>-->

        </tr>';
            $x++;
        }

        return response()->json([
            'data' =>  $data,
            'data_html' => $data_html
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->check_permission();
        $validator =  Validator::make($request->all(), [
            'submission_date' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street_address' => 'required|string',
            //'city' => 'required|string',
            //'province' => 'required|string',
            'postcode' => 'required|string',
            'name_parent' => 'required|string',
            'mobile' => 'required|string',
            //'package' => 'required|string',
            //'file_att' => 'required|string',
            //'description' => 'required|string',
            'grade' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //$rid  = $request->get('rid');
        $rdes  = $request->get('rdes');
        $rqty  = $request->get('rqty');
        $runit  = $request->get('runit');
        $runitp  = $request->get('runitp');
        $rdis  = $request->get('rdis');

        $receipt = Receipt::find($id);
        $old_data = $receipt ? $receipt->toArray() : null;

        $receipt->update($request->all());

        $rdata = array();
        ReceiptDetail::where('receipt_id', $id)->delete();
        for ($xx = 0; $xx < count($rdes); $xx++) {
            $rdata = new ReceiptDetail([
                'receipt_id' => $id,
                'description' => $rdes[$xx],
                'quantity' => $rqty[$xx],
                'unit' => $runit[$xx],
                'unitprice' => $runitp[$xx],
                'discount' => $rdis[$xx],
            ]);
            $rdata->save();
        }

        // บันทึก activity log — แก้ไข receipt
        LogActivity::modelEvent($receipt, 'receipt updated', $old_data, $receipt->fresh()->toArray());

        return response()->json(['success' => 'Receipt updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->check_permission();

        // บันทึก activity log ก่อนลบ receipt
        $receipt = Receipt::find($id);
        if ($receipt) {
            LogActivity::modelEvent($receipt, 'receipt deleted', $receipt->toArray(), null);
            $receipt->delete();
        }

        return ['success' => true, 'message' => 'Deleted Successfully'];
    }

    public function destroy_all(Request $request)
    {
        $this->check_permission();
        $arr_del = $request->get('table_records');

        // บันทึก activity log สำหรับการลบทั้งหมด
        foreach ($arr_del as $del_id) {
            $receipt = Receipt::find($del_id);
            if ($receipt) {
                LogActivity::modelEvent($receipt, 'receipt bulk_deleted', $receipt->toArray(), null);
                $receipt->delete();
            }
        }

        return redirect('/receipts')->with('success', 'Deleted Successfully');
    }

    public function importExcel(Request $request)
    {
        if ($request->hasFile('import_file')) {
            //$path = $request->file('import_file')->getRealPath();

            $path = $request->file('import_file');

            //$request->file('file')->store('files')
            Excel::import(new ReceiptImport($request->get('sfield')), $path);
            return redirect()->back()->with('success', 'Import Data Complete');
        } else {
            return back()->with(['error' => 'Please Check your file, Something is wrong there.']);
        }


        return back()->with('error', 'Please Check your file, Something is wrong there.');
    }
}
