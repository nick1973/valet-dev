<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id');
            $table->integer('monthly_page_id');
            $table->string('weekly_notes');
            $table->string('monthly_notes');
            $table->tinyInteger('complete');
            $table->integer('actual_cash');
            $table->integer('actual_card');
            $table->integer('actual_not_paid');
            $table->integer('actual_vip');
            $table->integer('actual_total');
            $table->integer('fee_rebate');
            $table->integer('bank_charges');
            $table->integer('reasons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('report_notes');
    }
}
