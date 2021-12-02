<?php

use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceEloquent;
use Illuminate\Database\Seeder;

class WorkCompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WorkCompetenceEloquent::class, 10)->create();
    }
}
