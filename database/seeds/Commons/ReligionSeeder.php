<?php

use App\Domains\Commons\Religion\ReligionEloquent;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ReligionEloquent::class, 10)->create();
    }
}
