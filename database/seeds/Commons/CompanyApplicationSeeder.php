<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_applications')->insert([
            ['company_id' => 1, 'application_id' => 1],
            ['company_id' => 1, 'application_id' => 2],

            ['company_id' => 2, 'application_id' => 1],
            ['company_id' => 3, 'application_id' => 1],
            ['company_id' => 4, 'application_id' => 1],
            ['company_id' => 5, 'application_id' => 1],
            ['company_id' => 6, 'application_id' => 1],
            ['company_id' => 7, 'application_id' => 1],
            ['company_id' => 8, 'application_id' => 1],
            ['company_id' => 9, 'application_id' => 1],
            ['company_id' => 10, 'application_id' => 1]
        ]);
    }
}
