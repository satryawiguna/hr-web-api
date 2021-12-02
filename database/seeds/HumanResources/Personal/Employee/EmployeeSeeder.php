<?php

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EmployeeEloquent::class, 10)->create();
    }
}
