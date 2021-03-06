<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions')->insert([
            ['role_id' => 1, 'permission_id' => 1, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 2, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 3, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 4, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 5, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 6, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 7, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 8, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 9, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 10, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 11, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 12, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 13, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 14, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 15, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 16, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 1, 'permission_id' => 17, 'type' => 'WRITE', 'value' => "ALLOW"],

            ['role_id' => 2, 'permission_id' => 1, 'type' => 'READ', 'value' => "DENY"],
            ['role_id' => 2, 'permission_id' => 2, 'type' => 'READ', 'value' => "DENY"],
            ['role_id' => 2, 'permission_id' => 3, 'type' => 'READ', 'value' => "DENY"],
            ['role_id' => 2, 'permission_id' => 4, 'type' => 'READ', 'value' => "DENY"],
            ['role_id' => 2, 'permission_id' => 5, 'type' => 'READ', 'value' => "DENY"],
            ['role_id' => 2, 'permission_id' => 6, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 7, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 8, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 9, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 10, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 11, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 12, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 13, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 14, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 15, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 16, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 2, 'permission_id' => 17, 'type' => 'WRITE', 'value' => "ALLOW"],

            ['role_id' => 3, 'permission_id' => 18, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 19, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 20, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 21, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 22, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 23, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 24, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 25, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 26, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 27, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 28, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 29, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 30, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 31, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 32, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 33, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 34, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 35, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 36, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 37, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 38, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 39, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 40, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 3, 'permission_id' => 41, 'type' => 'WRITE', 'value' => "ALLOW"],

            ['role_id' => 4, 'permission_id' => 18, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 4, 'permission_id' => 19, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 4, 'permission_id' => 20, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 4, 'permission_id' => 21, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 4, 'permission_id' => 22, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 4, 'permission_id' => 23, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 24, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 25, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 26, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 27, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 28, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 29, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 30, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 31, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 32, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 33, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 34, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 35, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 36, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 37, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 38, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 39, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 40, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 4, 'permission_id' => 41, 'type' => 'WRITE', 'value' => "ALLOW"],

            ['role_id' => 5, 'permission_id' => 18, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 5, 'permission_id' => 19, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 5, 'permission_id' => 20, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 5, 'permission_id' => 21, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 5, 'permission_id' => 22, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 5, 'permission_id' => 23, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 24, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 25, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 26, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 27, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 28, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 29, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 30, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 31, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 32, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 33, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 34, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 35, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 36, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 37, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 38, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 39, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 40, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 5, 'permission_id' => 41, 'type' => 'WRITE', 'value' => "ALLOW"],

            ['role_id' => 6, 'permission_id' => 18, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 6, 'permission_id' => 19, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 6, 'permission_id' => 20, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 6, 'permission_id' => 21, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 6, 'permission_id' => 22, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 6, 'permission_id' => 23, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 24, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 25, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 26, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 27, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 28, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 29, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 30, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 31, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 32, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 33, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 34, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 35, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 36, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 37, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 38, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 39, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 40, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 6, 'permission_id' => 41, 'type' => 'WRITE', 'value' => "ALLOW"],

            ['role_id' => 7, 'permission_id' => 18, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 7, 'permission_id' => 19, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 7, 'permission_id' => 20, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 7, 'permission_id' => 21, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 7, 'permission_id' => 22, 'type' => 'WRITE', 'value' => "DENY"],
            ['role_id' => 7, 'permission_id' => 23, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 24, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 25, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 26, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 27, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 28, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 29, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 30, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 31, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 32, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 33, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 34, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 35, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 36, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 37, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 38, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 39, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 40, 'type' => 'WRITE', 'value' => "ALLOW"],
            ['role_id' => 7, 'permission_id' => 41, 'type' => 'WRITE', 'value' => "ALLOW"],
        ]);
    }
}
