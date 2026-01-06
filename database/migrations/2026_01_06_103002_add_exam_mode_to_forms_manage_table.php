<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms_manage', function (Blueprint $table) {
            $table->boolean('enable_exam_mode')->default(false)->after('show_footer');
            $table->integer('online_limit')->nullable()->after('enable_exam_mode');
            $table->integer('onsite_limit')->nullable()->after('online_limit');
            $table->integer('online_registered')->default(0)->after('onsite_limit');
            $table->integer('onsite_registered')->default(0)->after('online_registered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms_manage', function (Blueprint $table) {
            $table->dropColumn(['enable_exam_mode', 'online_limit', 'onsite_limit', 'online_registered', 'onsite_registered']);
        });
    }
};
