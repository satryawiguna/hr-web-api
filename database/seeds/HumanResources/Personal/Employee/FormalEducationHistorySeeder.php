<?php

use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryEloquent;
use Illuminate\Database\Seeder;

class FormalEducationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(FormalEducationHistoryEloquent::class, 10)->create();
    }
}
