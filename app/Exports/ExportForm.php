<?php

namespace App\Exports;

use App\Models\ReceiptForm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportForm implements FromCollection, WithHeadings
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
        $receipts = ReceiptForm::select(
            "submission_date",
            "ref_date",
            "exam_mode",
            "first_name",
            "last_name",
            "nick_name",
            "email",
            "school_name",
            "grade",
            "birth_date",
            "street_address",
            "postcode",
            "name_parent",
            "mobile",
            "package",
            "contest",
            "award",
            "street_address2",
            DB::raw("CONCAT('" . url('/') . "/receipt_form_images/',photo_att) AS photo"),
            DB::raw("CONCAT('" . url('/') . "/receipt_form_images/',file_att) AS slip"),
            "news_form"
        )
            ->whereIn('id', $this->export_id)
            ->where([['sfield', $this->sfield_check]])
            ->get();

        $customResults = $receipts->map(function ($receipt) {
            $awardValue = null;
            if (!empty($receipt->award)) {
                $awardData = is_array($receipt->award) ? $receipt->award : json_decode($receipt->award, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($awardData)) {
                    $awardValue = implode(', ', $awardData);
                } else {
                    $awardValue = $receipt->award;
                }
            }
            return [
                "submission_date" => $receipt->submission_date,
                "ref_date" => $receipt->ref_date ?? null,
                "exam_mode" => $receipt->exam_mode ? ucfirst($receipt->exam_mode) : '',
                "first_name" => $receipt->first_name,
                "last_name" => $receipt->last_name,
                "nick_name" => $receipt->nick_name,
                "email" => $receipt->email,
                "school_name" => $receipt->school_name,
                "grade" => $receipt->grade,
                "birth_date" => $receipt->birth_date,
                "street_address" => $receipt->street_address,
                "postcode" => $receipt->postcode,
                "name_parent" => $receipt->name_parent,
                "mobile" => $receipt->mobile,
                "package" => $receipt->package,
                "award" => $awardValue,
                "street_address2" => $receipt->street_address2,
                "price" => preg_replace("/[^0-9.]/", "", $this->delete_all_between('(', ')', $receipt->package)),
                "contest" => $receipt->contest,
                "photo" => $receipt->photo,
                "slip" => $receipt->slip,
                "news_form" => $receipt->news_form,
                // Add custom properties or modifications here
            ];
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
