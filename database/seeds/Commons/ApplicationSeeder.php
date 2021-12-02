<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applications')->insert([
            ['name' => 'Human Resource', 'slug' => 'human-resource', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],
            ['name' => 'Accounting', 'slug' => 'accounting', 'description' => null, 'is_active' => 1, 'created_by' => 'system']
        ]);
    }
}
