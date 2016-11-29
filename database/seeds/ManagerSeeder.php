<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'manager',
                'email' => 'manager@ctm.uk.com',
                'password' => bcrypt('Manager'),
            ]
        ]);

    }
}
