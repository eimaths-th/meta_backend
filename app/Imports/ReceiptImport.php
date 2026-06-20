<?php

namespace App\Imports;

use App\Models\Receipt;
use App\Models\Receipt_Customer_RunningNumber;
use App\Models\Receipt_RunningNumber;
use App\Models\ReceiptDetail;
use App\Models\ReceiptForm;
use App\Services\ReceiptLineItemResolver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use RuntimeException;

class ReceiptImport implements ToCollection
{
    private $sfield_check = 0;

    public function __construct($sfield)
    {
        $this->sfield_check = $sfield;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $rowNumber => $row) {
                if (!isset($row[0]) || trim((string) $row[0]) === '') {
                    continue;
                }

                $timestamp = strtotime((string) $row[0]);
                if ($timestamp === false) {
                    throw new RuntimeException('Invalid receipt date on import row '.($rowNumber + 1).'.');
                }

                $submissionDate = date('Y-m-d', $timestamp);
                $package = (string) ($row[4] ?? '');
                $description = trim(explode('(', $package)[0]);
                $importForm = new ReceiptForm([
                    'sfield' => $this->sfield_check,
                    'package' => $package,
                ]);
                $importForm->id = 'import row '.($rowNumber + 1);
                $receiptLine = (new ReceiptLineItemResolver())->resolve(
                    $importForm,
                    $description,
                )[0];

                $receipt = Receipt::create([
                    'sfield' => $this->sfield_check,
                    'receipt_number' => Receipt_RunningNumber::generate(
                        $this->sfield_check,
                        $submissionDate,
                    ),
                    'receipt_customer_number' => Receipt_Customer_RunningNumber::generate(
                        $this->sfield_check,
                    ),
                    'submission_date' => $submissionDate,
                    'first_name' => $row[1] ?? null,
                    'last_name' => $row[2] ?? null,
                    'street_address' => $row[6] ?? null,
                    'name_parent' => $row[5] ?? null,
                    'postcode' => $row[7] ?? null,
                    'mobile' => $row[8] ?? null,
                    'package' => $package,
                    'grade' => $row[3] ?? null,
                    'file_att' => $row[9] ?? null,
                    'description' => $description,
                    'description2' => $row[11] ?? null,
                ]);

                ReceiptDetail::create([
                    'receipt_id' => $receipt->id,
                    'description' => $receiptLine['description'],
                    'quantity' => $receiptLine['quantity'],
                    'unitprice' => $receiptLine['unitprice'],
                    'discount' => 0,
                ]);
            }
        });
    }
}
