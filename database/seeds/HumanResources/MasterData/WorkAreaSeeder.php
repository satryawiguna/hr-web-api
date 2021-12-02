<?php

use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use Illuminate\Database\Seeder;

class WorkAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WorkAreaEloquent::class, 10)->create();
    }
}
