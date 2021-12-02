<?php

use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryEloquent;
use Illuminate\Database\Seeder;

class NonFormalEducationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(NonFormalEducationHistoryEloquent::class, 10)->create();
    }
}
