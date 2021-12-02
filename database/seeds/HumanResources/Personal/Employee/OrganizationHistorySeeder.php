<?php

use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryEloquent;
use Illuminate\Database\Seeder;

class OrganizationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OrganizationHistoryEloquent::class, 10)->create();
    }
}
