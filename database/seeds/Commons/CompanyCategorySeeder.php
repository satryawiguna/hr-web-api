<?php

use App\Domains\Commons\CompanyCategory\CompanyCategoryEloquent;
use Illuminate\Database\Seeder;

class CompanyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CompanyCategoryEloquent::class, 10)->create();
    }
}
