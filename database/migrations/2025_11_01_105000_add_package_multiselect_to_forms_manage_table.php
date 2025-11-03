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
            $table->boolean('package_multiselect')->default(false)->after('package');
            $table->integer('package_max_selection')->nullable()->after('package_multiselect');
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
            $table->dropColumn(['package_multiselect', 'package_max_selection']);
        });
    }
};
