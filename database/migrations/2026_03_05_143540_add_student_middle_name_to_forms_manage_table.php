<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('forms_manage', function (Blueprint $table) {
      $table
        ->string('student_middle_name')
        ->nullable()
        ->default('Middle Name (English) / ชื่อกลาง (ภาษาอังกฤษ)')
        ->after('student_first_name');
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
      $table->dropColumn('student_middle_name');
    });
  }
};
