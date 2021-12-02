<?php

use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceEloquent;
use Illuminate\Database\Seeder;

class WorkExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WorkExperienceEloquent::class, 10)->create();
    }
}
