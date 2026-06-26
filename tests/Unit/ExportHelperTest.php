<?php

namespace Tests\Unit;

use App\Exports\ExportExcel;
use App\Exports\ExportForm;
use PHPUnit\Framework\TestCase;

class ExportHelperTest extends TestCase
{
    public function test_export_helpers_remove_all_text_between_delimiters(): void
    {
        $export = new ExportForm('17', [1]);

        $this->assertSame(
            'Course  1200 baht',
            $export->delete_all_between('(', ')', 'Course (early bird 1) 1200 baht'),
        );
        $this->assertSame(
            'Course   1200',
            $export->delete_all_between('(', ')', 'Course (a) (b) 1200'),
        );
    }

    public function test_export_helpers_leave_strings_unchanged_when_delimiters_are_missing(): void
    {
        $export = new ExportExcel('17', [1]);

        $this->assertSame('Course 1200 baht', $export->delete_all_between('(', ')', 'Course 1200 baht'));
    }

    public function test_form_and_receipt_exports_share_the_expected_headings(): void
    {
        $expected = [
            'Submission Date',
            'Ref Date',
            'Exam Mode',
            'First Name',
            'Middle Name',
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

        $this->assertSame($expected, (new ExportForm('17', []))->headings());
        $this->assertSame($expected, (new ExportExcel('17', []))->headings());
    }
}
