<?php

use App\Domains\HumanResources\MasterData\LetterType\LetterTypeEloquent;
use Illuminate\Database\Seeder;

class LetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(LetterTypeEloquent::class, 10)->create();
    }
}
