<?php

use Illuminate\Database\Seeder;

class UserDeveloperPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_id = 9; // Developer Role
        $type    = "WRITE";
        $value   = "ALLOW";

        DB::table('role_permissions')->insert([
            ['role_id' => $role_id, 'permission_id' => 1, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 2, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 3, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 4, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 5, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 6, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 7, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 8, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 9, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 10, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 11, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 12, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 13, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 14, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 15, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 16, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 17, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 18, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 19, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 20, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 21, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 22, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 23, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 24, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 25, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 26, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 27, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 28, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 29, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 30, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 31, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 32, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 33, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 34, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 35, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 36, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 37, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 38, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 39, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 40, 'type' => $type, 'value' => $value],
            ['role_id' => $role_id, 'permission_id' => 41, 'type' => $type, 'value' => $value]
        ]);
    }
}
