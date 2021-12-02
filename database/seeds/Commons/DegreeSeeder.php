<?php

use App\Domains\Commons\Degree\DegreeEloquent;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DegreeEloquent::class, 10)->create();
    }
}
