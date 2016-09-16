<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder
 */
class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Valet1',
                'email' => 'valet1@ctm.uk.com',
                'password' => bcrypt('Valet1'),
            ],
            ['name' => 'Valet2',
                'email' => 'valet2@ctm.uk.com',
                'password' => bcrypt('Valet2'),
            ],
            ['name' => 'Valet3',
                'email' => 'valet3@ctm.uk.com',
                'password' => bcrypt('Valet3'),
            ],
            ['name' => 'admin',
                'email' => 'admin@ctm.uk.com',
                'password' => bcrypt('ADMIN'),
            ]

        ]);

    }
}