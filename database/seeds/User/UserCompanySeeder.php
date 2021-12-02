<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_companies')->insert([
            ['user_id' => 3, 'company_id' => 1],
            ['user_id' => 4, 'company_id' => 1],
            ['user_id' => 5, 'company_id' => 1],
            ['user_id' => 6, 'company_id' => 1],
            ['user_id' => 7, 'company_id' => 1],
            ['user_id' => 8, 'company_id' => 1],
            ['user_id' => 9, 'company_id' => 1]
        ]);
    }
}
