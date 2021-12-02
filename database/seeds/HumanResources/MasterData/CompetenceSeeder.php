<?php

use App\Domains\HumanResources\MasterData\Competence\CompetenceEloquent;
use Illuminate\Database\Seeder;

class CompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CompetenceEloquent::class, 10)->create();
    }
}
