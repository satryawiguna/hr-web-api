<?php

use App\Domains\Commons\Company\CompanyEloquent;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CompanyEloquent::class, 10)->create();
    }
}
