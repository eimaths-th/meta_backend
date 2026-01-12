<?php

namespace App\Exports;

use App\Models\Receipt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportExcel implements FromCollection, WithHeadings
{

    var $sfield_check = 0;
    var $export_id = array();

    public function  __construct($sfield, $export_id)
    {
        $this->sfield_check = $sfield;
        $wsql = '';
        foreach ($export_id as $arr) {
            $wsql .= "'" . $arr . "',";
        }
        $this->export_id = $export_id;
    }

    public function delete_all_between($beginning, $end, $string)
    {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return $this->delete_all_between($beginning, $end, str_replace($textToDelete, '', $string));
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $receipts = Receipt::select(
            "id",
            "recform_id",
            "submission_date",
            "first_name",
            "last_name",
            "ref_date",
            "exam_mode",
            // "nick_name",
            // "email",
            // "school_name",
            "grade",
            // "birth_date",
            "street_address",
            "postcode",
            "name_parent",
            "mobile",
            "package",
            "contest",
            // DB::raw("CONCAT('" . url('/') . "/receipt_form_images/',photo_att) AS photo"),
            DB::raw("CONCAT('" . url('/') . "/receipt_form_images/',file_att) AS slip"),
            // "news_form"
        )
            ->whereIn('id', $this->export_id)
            ->where([['sfield', $this->sfield_check]])
            ->get();
            // dd($receipts);
        $customResults = $receipts->map(function ($receipt) {
            // return [
            //     "submission_date" => $receipt->submission_date,
            //     "first_name" => $receipt->first_name,
            //     "last_name" => $receipt->last_name,
            //     // "nick_name" => $receipt->nick_name,
            //     // "email" => $receipt->email,
            //     // "school_name" => $receipt->school_name,
            //     "grade" => $receipt->grade,
            //     // "birth_date" => $receipt->birth_date,
            //     "street_address" => $receipt->street_address,
            //     "postcode" => $receipt->postcode,
            //     "name_parent" => $receipt->name_parent,
            //     "mobile" => $receipt->mobile,
            //     "package" => $receipt->package,
            //     "price" => preg_replace("/[^0-9.]/", "", $this->delete_all_between('(', ')', $receipt->package)),
            //     "contest" => $receipt->contest,
            //     // "photo" => $receipt->photo,
            //     "slip" => $receipt->slip,
            //     // "news_form" => $receipt->news_form,
            //     // Add custom properties or modifications here
            // ];
                // dd($receipt->recform->id);
            if ($receipt->recform) {
                $awardValue = null;
                if (!empty($receipt->recform->award)) {
                    $awardData = is_array($receipt->recform->award) ? $receipt->recform->award : json_decode($receipt->recform->award, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($awardData)) {
                        $awardValue = implode(', ', $awardData);
                    } else {
                        $awardValue = $receipt->recform->award;
                    }
                }
                return [
                    "submission_date" => $receipt->submission_date,
                    "ref_date" => $receipt->ref_date ?? null,
                    "exam_mode" => $receipt->exam_mode ? ucfirst($receipt->exam_mode) : '',
                    "first_name" => $receipt->first_name,
                    "last_name" => $receipt->last_name,
                    "nick_name" => $receipt->recform->nick_name,
                    "email" => $receipt->recform->email,
                    "school_name" => $receipt->recform->school_name,
                    "grade" => $receipt->grade,
                    "birth_date" => $receipt->recform->birth_date,
                    "street_address" => $receipt->street_address,
                    "postcode" => $receipt->postcode,
                    "name_parent" => $receipt->name_parent,
                    "mobile" => $receipt->mobile,
                    "package" => $receipt->package,
                    "award" => $awardValue,
                    "street_address2" => $receipt->recform->street_address2,

                    "price" => preg_replace("/[^0-9.]/", "", $this->delete_all_between('(', ')', $receipt->package)),
                    "contest" => $receipt->contest,
                    "photo" => $receipt->recform->photo,
                    "slip" => $receipt->slip,
                    "news_form" => $receipt->recform->news_form,
                    // Add custom properties or modifications here
                ];
            } else {
                $null = ' ';
                return [
                "submission_date" => $receipt->submission_date,
                "ref_date" => $receipt->ref_date ?? null,
                "exam_mode" => $receipt->exam_mode ? ucfirst($receipt->exam_mode) : '',
                "first_name" => $receipt->first_name,
                "last_name" => $receipt->last_name,
                "nick_name" => $null,
                "email" => $null,
                "school_name" => $null,
                "grade" => $receipt->grade,
                "birth_date" => $null,
                "street_address" => $receipt->street_address,
                "postcode" => $receipt->postcode,
                "name_parent" => $receipt->name_parent,
                "mobile" => $receipt->mobile,
                "package" => $receipt->package,
                "award" => $null,
                "street_address2" => $null,
                "price" => preg_replace("/[^0-9.]/", "", $this->delete_all_between('(', ')', $receipt->package)),
                "contest" => $receipt->contest,
                "photo" => $null,
                "slip" => $receipt->slip,
                "news_form" => $null,
                // Add custom properties or modifications here
                ];
            }
        });

        return $customResults;
    }

    public function headings(): array
    {
        return [
            'Submission Date',
            'Ref Date',
            'Exam Mode',
            'First Name',
            'Last Name',
            'Nick Name',
            'Email',
            'School Name',
            'Grade',
            'Birth Date',
            'Street Address',
            'Postcode',
            'Name Parent',
            'Mobile',
            'Package',
            'Award',
            'Follow Up',
            'Price',
            'Contest',
            'Photo',
            'Slip',
            'News From',
        ];
    }
}
