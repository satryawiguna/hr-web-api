<?php

use App\Domains\Commons\Office\OfficeEloquent;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OfficeEloquent::class, 10)->create();
    }
}
