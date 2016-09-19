<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_number');
            $table->string('ticket_price');
            $table->string('ticket_name');
            $table->string('ticket_mobile');
            $table->string('booked_in_by');
            $table->string('ticket_driver');
            $table->string('ticket_registration');
            $table->string('existing_customer');
            $table->string('ticket_manufacturer');
            $table->string('ticket_model');
            $table->string('ticket_colour');
            $table->string('ticket_notes');
            $table->string('ticket_key_safe');
            $table->string('ticket_payment');
            $table->string('ticket_status');
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
        Schema::drop('tracking');
    }
}
