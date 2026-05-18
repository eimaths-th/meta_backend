<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table="receipts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'recform_id',
        'submission_date',
        'ref_date',
        'first_name',
        'middle_name',
        'last_name',
        'street_address',
        'street_address2',
        'city',
        'province',
        'postcode',
        'name_parent',
        'mobile',
        'package',
        'file_att',
        'sfield',
        'receipt_number',
        'receipt_customer_number',
        'grade',
        'description',
        'description2',
        'contest',
        'referent_code',
        'exam_mode',
        'company_profile',
    ];

    /**
     * ดึงข้อมูล company profile จาก config/receipt.php
     * ถ้าไม่ได้ระบุ company_profile จะใช้ค่า default
     *
     * @return array
     */
    public function getCompanyInfo(): array
    {
        $profileKey = $this->company_profile ?? config('receipt.default_profile', 'default');

        return config("receipt.profiles.{$profileKey}", config('receipt.profiles.default', []));
    }
    public function recform()
    {
        return $this->hasOne(ReceiptForm::class, 'id', 'recform_id');
    }
}
