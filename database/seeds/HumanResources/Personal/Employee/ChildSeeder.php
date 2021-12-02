<?php

use App\Domains\HumanResources\Personal\Employee\Child\ChildEloquent;
use Illuminate\Database\Seeder;

class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ChildEloquent::class, 10)->create();
    }
}
