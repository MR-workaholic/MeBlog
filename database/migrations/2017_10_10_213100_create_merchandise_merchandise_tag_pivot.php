<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandiseMerchandiseTagPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandise_merchandise_tag_pivot', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->integer('merchandise_id')->unsigned()->index();
            $table->integer('merchandise_tag_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('merchandise_merchandise_tag_pivot');
    }
}
