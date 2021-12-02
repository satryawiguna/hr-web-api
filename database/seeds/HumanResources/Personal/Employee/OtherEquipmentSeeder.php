<?php

use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentEloquent;
use Illuminate\Database\Seeder;

class OtherEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OtherEquipmentEloquent::class, 10)->create();
    }
}
