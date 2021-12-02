<?php

use App\Domains\Commons\EmployeeNumberScale\EmployeeNumberScaleEloquent;
use Illuminate\Database\Seeder;

class EmployeeNumberScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EmployeeNumberScaleEloquent::class, 10)->create();
    }
}
