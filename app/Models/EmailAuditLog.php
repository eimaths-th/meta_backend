<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model สำหรับบันทึก Audit Log ของ email
 * ใช้ติดตามการเปลี่ยนแปลง email, การส่ง, การส่งซ้ำ
 */
class EmailAuditLog extends Model
{
    use HasFactory;

    protected $table = "email_audit_logs";

    protected $fillable = [
        'receipt_form_id',
        'old_email',
        'new_email',
        'changed_by',
        'changed_by_name',
        'action',
        'ip_address',
        'metadata',
    ];

    /**
     * ความสัมพันธ์กับ ReceiptForm
     */
    public function receiptForm()
    {
        return $this->belongsTo(ReceiptForm::class, 'receipt_form_id');
    }

    /**
     * บันทึก log เมื่อ email ถูกเปลี่ยนแปลง (Admin Edit)
     *
     * @param int $receipt_form_id — ID ของ ReceiptForm
     * @param string|null $old_email — email เดิม
     * @param string|null $new_email — email ใหม่
     * @param string $action — ประเภท: update, store, resend, send
     * @param \Illuminate\Http\Request|null $request — request สำหรับดึง IP
     * @param array $extra_metadata — ข้อมูลเพิ่มเติม
     */
    public static function LogEmailAction(
        int $receipt_form_id,
        ?string $old_email,
        ?string $new_email,
        string $action,
        $request = null,
        array $extra_metadata = []
    ): self {
        // ดึงข้อมูลผู้ใช้ปัจจุบัน (ถ้า login อยู่)
        $current_user = \Illuminate\Support\Facades\Auth::user();
        $changed_by = $current_user ? $current_user->id : null;
        $changed_by_name = $current_user ? ($current_user->name ?? 'Unknown') : 'Public User';

        // ดึง IP Address
        $ip_address = $request ? $request->ip() : request()->ip();

        // สร้าง metadata JSON
        $metadata = json_encode(array_merge([
            'timestamp' => now()->toISOString(),
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
        ], $extra_metadata));

        return self::create([
            'receipt_form_id' => $receipt_form_id,
            'old_email' => $old_email,
            'new_email' => $new_email,
            'changed_by' => $changed_by,
            'changed_by_name' => $changed_by_name,
            'action' => $action,
            'ip_address' => $ip_address,
            'metadata' => $metadata,
        ]);
    }
}
