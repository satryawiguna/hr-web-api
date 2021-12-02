<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_applications')->insert([
            ['user_id' => 1, 'application_id' => 1],
            ['user_id' => 1, 'application_id' => 2],
            ['user_id' => 2, 'application_id' => 1],
            ['user_id' => 2, 'application_id' => 2]
        ]);
    }
}
