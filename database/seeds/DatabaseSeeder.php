<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
         $this->call(UserTableSeeder::class);
         $this->call(TrackingTableSeeder::class);
         $this->call(VisitorCentreSeeder::class);
         $this->call(TrackingSeedTableSeeder::class);
        Model::reguard();
    }
}
