<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisitorCentreSeeder extends Seeder
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
            ],
            ['name' => 'bvfinance',
                'email' => 'bvfinance@ctm.uk.com',
                'password' => bcrypt('BVfinance'),
            ],
            ['name' => 'ctmfinance',
                'email' => 'ctmfinance@ctm.uk.com',
                'password' => bcrypt('CTMFinance'),
            ],
            ['name' => 'visitorcentre',
                'email' => 'visitorcentre@ctm.uk.com',
                'password' => bcrypt('VisitorCentre'),
            ]
        ]);

    }
}
