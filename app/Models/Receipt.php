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
    ];
    public function recform()
    {
        return $this->hasOne(ReceiptForm::class, 'id', 'recform_id');
    }
}
