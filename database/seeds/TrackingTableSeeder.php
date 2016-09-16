<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tracking')->insert([
            'ticket_number' => '000',
            'ticket_status' => 'active'
        ]);
    }
}
