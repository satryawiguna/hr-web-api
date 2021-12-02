<?php

use App\Domains\Commons\Gender\GenderEloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            ['name' => 'Male', 'slug' => 'male', 'is_active' => 1, 'created_by' => 'system'],
            ['name' => 'Female', 'slug' => 'female', 'is_active' => 1, 'created_by' => 'system'],
        ]);
    }
}
