<?php

use App\Domains\Commons\ContractType\ContractTypeEloquent;
use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ContractTypeEloquent::class, 10)->create();
    }
}
