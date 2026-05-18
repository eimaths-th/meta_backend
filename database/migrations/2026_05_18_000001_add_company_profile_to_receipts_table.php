<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * เพิ่ม column company_profile ในตาราง receipts
     * ใช้สำหรับเลือก company profile ที่แสดงบนใบเสร็จแต่ละใบ
     * ค่า null = ใช้ค่า default จาก config('receipt.default_profile')
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('company_profile', 50)->nullable()->after('exam_mode')
                ->comment('Company profile key from config/receipt.php (null = default)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('company_profile');
        });
    }
};
