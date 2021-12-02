<?php

use App\Domains\Commons\Major\MajorEloquent;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MajorEloquent::class, 10)->create();
    }
}
