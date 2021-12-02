<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accesses')->insert([
            ['name' => 'ANY', 'slug' => 'any', 'created_by' => 'system'],
            ['name' => 'GET', 'slug' => 'get', 'created_by' => 'system'],
            ['name' => 'POST', 'slug' => 'post', 'created_by' => 'system'],
            ['name' => 'PUT', 'slug' => 'put', 'created_by' => 'system'],
            ['name' => 'DELETE', 'slug' => 'delete', 'created_by' => 'system'],
            ['name' => 'APPROVE', 'slug' => 'approve', 'created_by' => 'system'],
            ['name' => 'REJECT', 'slug' => 'reject', 'created_by' => 'system'],
            ['name' => 'CREATE', 'slug' => 'create', 'created_by' => 'system'],
            ['name' => 'ACTIVE', 'slug' => 'active', 'created_by' => 'system'],
            ['name' => 'AUTHORIZE', 'slug' => 'authorize', 'created_by' => 'system'],
            ['name' => 'UNAUTHORIZE', 'slug' => 'unauthorize', 'created_by' => 'system'],
            ['name' => 'BACKUP', 'slug' => 'backup', 'created_by' => 'system'],
            ['name' => 'RESTORE', 'slug' => 'restore', 'created_by' => 'system'],
            ['name' => 'PRINT', 'slug' => 'print', 'created_by' => 'system'],
        ]);
    }
}
