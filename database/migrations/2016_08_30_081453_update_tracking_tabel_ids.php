<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTrackingTabelIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracking', function ($table) {
            $table->string('valet1_ticket_id');
            $table->string('valet2_ticket_id');
            $table->string('valet3_ticket_id');
            $table->string('valet1_ticket_serial_number');
            $table->string('valet2_ticket_serial_number');
            $table->string('valet3_ticket_serial_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracking', function ($table) {
            $table->dropColumn('valet1_ticket_id');
            $table->dropColumn('valet2_ticket_id');
            $table->dropColumn('valet3_ticket_id');
            $table->dropColumn('valet1_ticket_serial_number');
            $table->dropColumn('valet2_ticket_serial_number');
            $table->dropColumn('valet3_ticket_serial_number');
        });
    }
}
