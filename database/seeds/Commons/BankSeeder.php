<?php

use App\Domains\Commons\Bank\BankEloquent;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BankEloquent::class, 10)->create();
    }
}
