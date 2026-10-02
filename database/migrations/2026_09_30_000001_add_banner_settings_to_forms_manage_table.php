<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms_manage', function (Blueprint $table) {
            $table->json('banner_settings')->nullable()->after('brand');
        });
    }

    public function down(): void
    {
        Schema::table('forms_manage', function (Blueprint $table) {
            $table->dropColumn('banner_settings');
        });
    }
};
