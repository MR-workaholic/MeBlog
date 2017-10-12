<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructureMerchandisesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('merchandises', function (Blueprint $table) {
      //
      $table->string('content')->after('alt');
      $table->string('price')->after('content');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('merchandises', function (Blueprint $table) {
      //
      $table->dropColumn('price');
      $table->dropColumn('content');
    });
  }
}
