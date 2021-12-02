<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['group_id' => 1, 'name' => 'Super Admin', 'slug' => 'super-admin', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],
            ['group_id' => 1, 'name' => 'Admin', 'slug' => 'admin', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],

            ['group_id' => 2, 'name' => 'Admin', 'slug' => 'admin', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],
            ['group_id' => 2, 'name' => 'Owner', 'slug' => 'owner', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],
            ['group_id' => 2, 'name' => 'Manager', 'slug' => 'manager', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],
            ['group_id' => 2, 'name' => 'Operator', 'slug' => 'operator', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],
            ['group_id' => 2, 'name' => 'Staff', 'slug' => 'staff', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],

            ['group_id' => 3, 'name' => 'Applicant', 'slug' => 'applicant', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],

            ['group_id' => 4, 'name' => 'Developer', 'slug' => 'developer', 'description' => null, 'is_active' => 1, 'created_by' => 'system'],

            ['group_id' => 5, 'name' => 'Demo', 'slug' => 'demo', 'description' => null, 'is_active' => 1, 'created_by' => 'system']
        ]);
    }
}
