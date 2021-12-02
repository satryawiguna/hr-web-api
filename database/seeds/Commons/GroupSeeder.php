<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            ['name' => 'System', 'slug' => 'system', 'description' => null, 'created_by' => 'system'],
            ['name' => 'Company', 'slug' => 'company', 'description' => null, 'created_by' => 'system'],
            ['name' => 'Applicant', 'slug' => 'applicant', 'description' => null, 'created_by' => 'system'],
            ['name' => 'Developer', 'slug' => 'developer', 'description' => null, 'created_by' => 'system'],
            ['name' => 'Demo', 'slug' => 'demo', 'description' => null, 'created_by' => 'system']
        ]);
    }
}
