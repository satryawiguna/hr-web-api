<?php

use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MaritalStatusEloquent::class, 10)->create();
    }
}
