<?php

use Illuminate\Database\Seeder;

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
