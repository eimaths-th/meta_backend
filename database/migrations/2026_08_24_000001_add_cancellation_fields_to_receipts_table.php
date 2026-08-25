<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('receipts', 'cancle')) {
            Schema::table('receipts', function (Blueprint $table) {
                // Keep the legacy column name because the existing receipt
                // reports already use it to exclude cancelled amounts.
                $table->boolean('cancle')->default(false)->after('type');
            });
        }

        DB::table('receipts')->whereNull('cancle')->update(['cancle' => false]);

        Schema::table('receipts', function (Blueprint $table) {
            $table->timestamp('cancelled_at')->nullable()->after('cancle');
            $table->unsignedBigInteger('cancelled_by')->nullable()->after('cancelled_at');
            $table->text('cancel_reason')->nullable()->after('cancelled_by');
        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn(['cancelled_at', 'cancelled_by', 'cancel_reason']);
        });
    }
};
