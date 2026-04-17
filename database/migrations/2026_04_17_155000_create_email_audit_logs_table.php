<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * สร้างตาราง email_audit_logs สำหรับบันทึกทุกครั้งที่มีการเปลี่ยนแปลง email
     * หรือมีการส่ง/ส่งซ้ำ email เพื่อตรวจสอบย้อนหลังได้
     */
    public function up()
    {
        Schema::create('email_audit_logs', function (Blueprint $table) {
            $table->id();
            // อ้างอิง record ที่เกี่ยวข้อง
            $table->unsignedBigInteger('receipt_form_id')->nullable()->index();
            // email เดิมและ email ใหม่ (nullable สำหรับกรณี send/resend ที่ไม่ได้เปลี่ยน email)
            $table->string('old_email')->nullable();
            $table->string('new_email')->nullable();
            // ผู้กระทำ (user_id ของ admin หรือ null ถ้าเป็น public form submission)
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->string('changed_by_name')->nullable();
            // ประเภทการกระทำ: store, update, resend, send
            $table->string('action', 50)->index();
            // IP Address ของผู้กระทำ
            $table->string('ip_address', 45)->nullable();
            // ข้อมูลเพิ่มเติม (JSON format)
            $table->text('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * ลบตาราง email_audit_logs
     */
    public function down()
    {
        Schema::dropIfExists('email_audit_logs');
    }
};
