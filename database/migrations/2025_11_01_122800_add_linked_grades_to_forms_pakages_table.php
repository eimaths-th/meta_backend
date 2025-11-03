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
        Schema::table('forms_pakages', function (Blueprint $table) {
            $table->json('linked_grades')->nullable()->after('price')->comment('JSON array of grade IDs that this package is linked to. NULL means all grades are allowed.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms_pakages', function (Blueprint $table) {
            $table->dropColumn('linked_grades');
        });
    }
};
